<?php

namespace App\Controllers;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options; // for seting the titel of the pdf
use App\Models\ClientModel;
use App\Models\ItemModel;
use App\Models\CompanyDetailsModel;
use App\Models\CompanyList;
use App\Models\UsersModel;
use App\Models\CommentModel;
use App\Models\PaymentModel;
use App\Models\TermsModel;
use App\Models\AuthIdenties;
use App\Models\InvoiceModel;
use App\Models\InvoiceItemsModel;
use App\Models\PaymentInvoiceModel;
use App\Models\Autocomplete;
use App\Models\EstimatesModel;
use App\Models\EstimatesItemsModel;
use App\Models\AgentModel;
use CodeIgniter\Shield\Models\UserModel;
use App\Entities\User;
// for stripe
use Stripe\Stripe;
use App\Models\SystemRentPaymentModel;
use App\Models\SystemSubscriptionModel;
// date and time test
use CodeIgniter\I18n\Time;


class Home extends BaseController
{
	// for invoice and estimates
	protected $InvoiceModel;
	protected $Autocomplete;
	protected $EstimatesModel;
	// for determine active subscription
	protected $SystemSubscriptionModel;

    public function __construct()
    {
		
        helper(['custom']);
		$this->InvoiceModel = new InvoiceModel();
		$this->Autocomplete = new Autocomplete();
		$this->EstimatesModel = new EstimatesModel();
		$this->CompanyDetailsModel = new CompanyDetailsModel();
		$this->SystemSubscriptionModel = new SystemSubscriptionModel;
    }

    public function dashboard()
	{
		$data['message'] = session()->getFlashdata('message');

		$hasReachedFreeLimit = $this->InvoiceModel->hasReachedFreeLimit();
		$data['hasReachedFreeLimit'] = $hasReachedFreeLimit;
		$companyId = session()->get('tenant_id');
		$isSubscriptionActive = $this->SystemSubscriptionModel->isSubscriptionActive($companyId);
		$data['isSubscriptionActive'] = $isSubscriptionActive;

		$session = session();
		$session->set('has_reached_free_limit', $hasReachedFreeLimit);
		$session->set('is_subscription_active', $isSubscriptionActive);
		
		$currentYear = date('Y');
		$currentMonth = date('m');
		$clientModel =new ClientModel();
		$data['totalClients'] = $clientModel->countAll();
		$data['recentClients'] = $clientModel->orderBY('id','DESC')->fIndAll(3);
		$invoiceModel = new InvoiceModel();
		$data['totalInvoices'] = $invoiceModel->countAll();
		$allClient= $invoiceModel->orderBy('id', 'DESC')->findAll();
		$data['listClient'] = array_slice($allClient, 0, 3);
		// var_dump($data['listClient']);

		//overview
		$data['invoiceSummary'] = $this->InvoiceModel->getInvoicesSummary();
		// added methods
		$data['getPaidInvoicesSummary'] = $this->InvoiceModel->getPaidInvoicesSummary();
		$data['partiallySummary'] = $this->InvoiceModel->getPartiallyPaidInvoicesSummary();
		// end of new
		$data['positiveBalanceInvoices'] = $this->InvoiceModel->getPositiveBalanceInvoicesSummary();
		$data['overdueInvoices'] = $this->InvoiceModel->getOverdueInvoicesSummary();
		$estimatesModel = new EstimatesModel();
		$data['estimateSummary'] = $this->EstimatesModel->getEstimateSummary();
		$data['invoicesFromEstimates'] = $this->InvoiceModel->getInvoicesFromEstimatesSummary();
		
		// Today's sales
		$data['todaySales'] = $this->InvoiceModel->getTodaySalesSummary();
		// Current month
		$currentYear = date('Y');
		$currentMonth = date('n');
		$currentMonthName = date('F');
		$data['currentMonth'] = $currentMonthName;
		$data['monthlyInvoiceSummary'] = $this->InvoiceModel->getMonthlySalesSummary($currentYear, $currentMonth);
		
		$data['monthlyEstimatesSummary'] = $this->EstimatesModel->getEstimatesSummaryPerMonth($currentYear, $currentMonth);

		return view("NEWCRM/dashboard", $data);
	}


	#========================================================
	# SIDE BAR TABLES 
	#========================================================

	public function ItemDescriptionListAuto(){
		$searchTerm = $this->request->getVar('search');

		$itemModel = new ItemModel();
		// $invoiceItemsModel = new InvoiceItemsModel();

		$items = $itemModel->like('item_description', $searchTerm)->findAll();

		$data = [];
		foreach ($items as $item) {
			// $total_price = $item->quanity * $item->r
			$data[] = [
				'value' 	=> $item->id,      
				'label' 	=> $item->item_description, 
				'rate'		=> $item->rate,
				'cost_price'=> $item->cost
			];
		}
		// Return JSON response
		return $this->response->setJSON($data);

	}
	
	public function CreateQuotation()
	{
		$commentModel = new CommentModel();
		$data['comments'] = $commentModel->select('*')->where('id', 1)->get()->getResult();

		$paymentModel = new PaymentModel();
		$data['payments'] = $paymentModel->select('*')->where('id', 1)->get()->getResult();

		$termsModel = new TermsModel();
		$data['terms'] = $termsModel->select('*')->where('id',1)->get()->getResult();

		$data['username'] =  session()->get('username'); 

		$invoiceModel = new InvoiceModel();
		$data['invoices'] = $invoiceModel->select('*')->where('id',26)->get()->getResult();

		$invoiceItemsModel = new InvoiceItemsModel();
		$data['items'] = $invoiceItemsModel->findAll();

		$companyDetailsModel = new CompanyDetailsModel();
		$data['company'] = $companyDetailsModel->first();


		$estimatesModel = new EstimatesModel();
		$username = session()->get('username');

		$currentYear = date('Y');
		$lastId = $estimatesModel->getLastId();
		$lastId++;
		$estimate_number = 'EST'.'-'.sprintf('%03d', $lastId);

		$data['estimate_no'] = $estimate_number;

		return view("NEWCRM/add_estimates", $data);
	}

	public function SaveEstimate()
	{
		$estimatesModel = new EstimatesModel();
		$estimatesItemsModel = new EstimatesItemsModel();
		$itemsTotal = $this->request->getPost('totalitems');
		
		$username = session()->get('username');
		$status = 'Unsent';

		$formdata = [
			'estimate_no'			=> $this->request->getPost('estimate_no'),
			'client_name'			=> $this->request->getPost('cname'),
			'email'					=> $this->request->getPost('invoiceemail'),
			'status'				=> $status,
			'invoice_date'			=> $this->request->getPost('invoicedate'),
			'terms'					=> $this->request->getPost('terms'),
			'due_date'				=> $this->request->getPost('duedate'),
			'subtotal'				=> $this->request->getPost('subtotal'),
			'discount'				=> $this->request->getPost('discount'),
			'total'					=> $this->request->getPost('total'),
			'paid'					=> $this->request->getPost('paid'),
			'payment_method'		=> $this->request->getPost('method'),
			'balance'				=> $this->request->getPost('balance'),
			'netprice'				=> $this->request->getPost('netprice'),
			'profit_loss'			=> $this->request->getPost('profit'),
			'comment'				=> $this->request->getPost('comment'),
			'payment_instruction'	=> $this->request->getPost('payment_instruction'),
			'username' 				=> $username
		];

		$result = $estimatesModel->insert($formdata);
        $user_id = $estimatesModel->getInsertID();
		
		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata = [
				'itemname'=> $this->request->getPost('itemname')[$i],
				'quantity'=> $this->request->getPost('quantity')[$i],
				'price'=> $this->request->getPost('price')[$i],
				'totalprice'=> $this->request->getPost('totalprice')[$i],
				'costprice'=> $this->request->getPost('costprice')[$i],
				'username' => $username,
				'invoice_id' => $user_id
			];

			$itemRes = $estimatesItemsModel->insert($itemdata);
		}

		
	}

	public function UpdateEstimate()
	{
		$estimateModel = new EstimatesModel();
		$estimateItemsModel = new EstimatesItemsModel();
		$estimateId = $this->request->getPost('estimateId');
		$username = session()->get('username');
		$status = 'Unsent';
		
		$updateData = [
			'estimate_no'			=> $this->request->getPost('estimate_no'),
			'client_name'			=> $this->request->getPost('cname'),
			'email'					=> $this->request->getPost('email'),
			'status'				=> $status,
			'invoice_date'			=> $this->request->getPost('invoicedate'),
			'subtotal'				=> $this->request->getPost('subtotal'),
			'discount'				=> $this->request->getPost('discount'),
			'total'					=> $this->request->getPost('total'),
			'netprice'				=> $this->request->getPost('netprice'),
			'profit_loss'			=> $this->request->getPost('profitDisplay'),
			'comment'				=> $this->request->getPost('comment'),
			'username' 				=> $username
		];
		
		$itemsTotal = $this->request->getPost('totalitems');
		$deletedItems = $estimateItemsModel->where('invoice_id', $estimateId)->delete();
		if($deletedItems) {
			for ($i = 0; $i < $itemsTotal; $i++) {
				$estimateItemData = [
					'itemname'=> $this->request->getPost('itemdescription')[$i],
					'quantity'=> $this->request->getPost('quantity')[$i],
					'price'=> $this->request->getPost('price')[$i],
					'totalprice'=> $this->request->getPost('totalprice')[$i],
					'costprice'=> $this->request->getPost('costprice')[$i],
					'username' => session()->get('username'),
					'invoice_id' => $estimateId,
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$itemRes = $estimateItemsModel->insert($estimateItemData);
			}
		}
		// Update the estimate with the new data
		$result = $estimateModel->update($estimateId, $updateData);
		
		if ($result) {
			// return $this->response->setJSON(['message'=>$items]);
			return $this->response->setJSON(['success' => true, 'message'  => 'Estimated Updated succefully']);
		} else {
			return $this->response->setJSON(['success' => false, 'message' => 'Failed to update estimate']);
		}
	}

	public function QuoteList()
	{
		$data['id'] = isset($params['id']) ? $params['id'] : null;
		
		$estimatesModel = new EstimatesModel();
		$estimatesItemsModel = new EstimatesItemsModel();
		$usersModel = new UsersModel();
		$invoiceModel = new InvoiceModel();

		$data['estimates'] = $estimatesModel->orderBy('id','DESC')->findAll();
		$data['items'] = $estimatesItemsModel->findAll();		
		$estimates_status = $invoiceModel->where('from_estimates', 1)->findAll();

			// Getting user that belong to that company
			$AuthIdenties = new AuthIdenties();
			$tenantDb = session()->get('tenant_db');
			$parts = explode('_', $tenantDb);
			$identifier = $parts[1];
	
			$db = \Config\Database::connect();
	
			$company = $db->table('companylists')
				->where('tenant_database_name', $tenantDb)
				->get()
				->getRow();
	
			if (!$company) {
				return view('NEWCRM/error', ['message' => 'Company not found']);
			}
			
			$agentBuilder = $db->table('agents');
			$agentBuilder->select('agents.agent_id as id, agents.agent_username as username, agents.agent_mobile, agents.address, users.created_at, users.updated_at, "Agent" as user_type, auth_identities.secret as email')
				->join('users', 'users.id = agents.user_id')
				->join('auth_identities', 'auth_identities.user_id = agents.user_id')
				->where('agents.user_id', $identifier)
				->where('auth_identities.type', 'email_password');
			
			$agents = $agentBuilder->get()->getResult();
			$userBuilder = $db->table('users');
			$userBuilder->select('users.id, users.username, users.created_at, users.updated_at, auth_identities.secret as email, NULL as agent_mobile, NULL as address, "Admin" as user_type')
				->join('auth_identities', 'users.id = auth_identities.user_id')
				->where('users.id', $identifier);
	
			$user = $userBuilder->get()->getRow();
	
	
			$allUsers = array_merge($agents, [$user]);
	
			$uniqueUsers = [];
			foreach ($allUsers as $user) {
				$key = $user->id . '_' . $user->user_type;
				$uniqueUsers[$key] = $user;
			}
	
			$uniqueUsers = array_values($uniqueUsers);
			$data['users'] = $uniqueUsers;

		return view('NEWCRM/estimateList', $data);
	}

	public function GetSingleEstimate()
	{
		// Retrieve estimate ID from GET request
		$estimateId = $this->request->getGet('id');

		// Load models
		$estimatesModel = new EstimatesModel();
		$estimatesItemsModel = new EstimatesItemsModel();
		$clientModel = new ClientModel();

		// Fetch estimate details by ID
		$estimates = $estimatesModel->find($estimateId);

		// Check if the estimate exists
		if (!$estimates) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Estimate not found',
			]);
		}

		// Get the email associated with the estimate
		$email = $estimates->email;

		// Fetch the first client with the given email
		$client = $clientModel->where('EmailAddress', $email)->first();

		// Check if client is found
		if (!$client) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Client not found for this email',
			]);
		}

		// Fetch all estimate items for this estimate ID
		$items = $estimatesItemsModel->where('invoice_id', $estimateId)->findAll();

		// Prepare data to send to the view
		$data = [
			'estimateId' => $estimateId,
			'success' => true,
			'client' => $client,
			'estimates' => $estimates,
			'itemlist' => $items,
		];

		// Load the view with the data
		return view("NEWCRM/getsinglestimate", $data);
	}

	public function DeleteEstimate()
	{
		if ($this->request->getMethod() === 'post') {
			$invoiceId = $this->request->getPost('id');

			$estimatesModel = new EstimatesModel();
			$estimatesItemsModel = new EstimatesItemsModel();

			// Attempt to delete related invoice items first
			$deletedItems = $estimatesItemsModel->where('invoice_id', $invoiceId)->delete();

			if ($deletedItems) {
				$deleted = $estimatesModel->delete($invoiceId);

				if ($deleted) {
					return $this->response->setJSON(['success' => true, 'message' => 'Invoice deleted successfully']);
				} else {
					return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete invoice']);
				}
			} else {
				return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete invoice items']);
			}
		} else {
			return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method']);
		}
	}

	public function ConvertToInvoice()
	{
		$data = [];
		// $dataFromJS = $this->request->getGet();

		if ($this->request->getMethod() === 'get') {
			// Get the invoice ID from the POST request
			$estimateId = $this->request->getGet('id');

			// Load the models
			$estimatesModel = new EstimatesModel();
			$estimatesItemsModel = new EstimatesItemsModel();
			$clientModel = new ClientModel();

			// Find the invoice using the invoice ID
			$estimates = $estimatesModel->find($estimateId);
			
			if ($estimates) {
			$email = $estimates->email;
			
				$client = $clientModel->where('EmailAddress', $email)->first();

				$items = $estimatesItemsModel->where('invoice_id', $estimateId)->findAll();

				// Prepare the response data
				$data['invoiceId'] = $estimateId;
				$data['success'] = true;
				$data['client'] = $client;
				$data['estimates'] = $estimates;
				$data['itemlist'] = $items;

				// other data required fo that invoice
				$commentModel = new CommentModel();
				// $data['comments'] = $commentModel->select('*')->where('id', 1)->get()->getResult();
				$data['comments'] = $commentModel->find(1);
				
				$paymentModel = new PaymentModel();
				$data['payments'] = $paymentModel->select('*')->where('id', 1)->get()->getResult();
				// $data['payments'] = $paymentModel->find(1);
				// var_dump($data['payments']);


				$termsModel = new TermsModel();
				$data['terms'] = $termsModel->select('*')->where('id',1)->get()->getResult();

				$invoiceModel = new InvoiceModel();
				$currentYear = date('Y');
				$lastId = $invoiceModel->getLastId();
				$lastId++;
				// $invoice_number = 'INV'.sprintf('%03d', $lastId);
				$invoice_number = 'INV'.'-'.sprintf('%03d', $lastId);
				$data['invoice_no'] = $invoice_number;

				// var_dump($data['payments']);
				
				return view('NEWCRM/estimate_to_invoice', $data);
			} else {
				$data['success'] = false;
				$data['message'] = 'Invoice not found';
			}
		} else {
			$data['success'] = false;
			$data['message'] = 'Invalid request method';
		}
	}



	public function ConvertToInvoice123()
{
    // Return early if not a GET request
    if ($this->request->getMethod() !== 'get') {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }

    $estimateId = $this->request->getGet('id');
    if (!$estimateId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No estimate ID provided'
        ]);
    }

    $data = [];

    try {
        // Initialize models
        $estimatesModel = new EstimatesModel();
        $estimatesItemsModel = new EstimatesItemsModel();
        $clientModel = new ClientModel();
        $commentModel = new CommentModel();
        $paymentModel = new PaymentModel();
        $termsModel = new TermsModel();
        $invoiceModel = new InvoiceModel();

        // Get estimate data
        $estimates = $estimatesModel->find($estimateId);
        if (!$estimates) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Estimate not found'
            ]);
        }

        // Use caching service for static data
        $cache = \Config\Services::cache();
        $cacheKey = 'static_invoice_data_' . $estimateId;

        if (!$staticData = $cache->get($cacheKey)) {
            // Retrieve static data and store in cache for 1 hour
            $staticData = [
                'comments' => $commentModel->find(1), // Replace 1 with actual logic if needed
                'payments' => $paymentModel->find(1), // Replace 1 with actual logic if needed
                'terms' => $termsModel->find(1)       // Replace 1 with actual logic if needed
            ];
            $cache->save($cacheKey, $staticData, 3600); // Cache for 1 hour
        }

        // Prepare data to pass to the view
        $client = $clientModel->where('EmailAddress', $estimates->email)->first();
        $itemList = $estimatesItemsModel->where('invoice_id', $estimateId)->findAll();
		$currentYear = date('Y');
        $invoiceNo = 'INV'.'-'.$currentYear.'-'.sprintf('%03d', $invoiceModel->getLastId() + 1);

        $data = [
            'success' => true,
            'invoiceId' => $estimateId,
            'client' => $client,
            'estimates' => $estimates,
            'itemlist' => $itemList,
            'comments' => $staticData['comments'],
            'payments' => $staticData['payments'],
            'terms' => $staticData['terms'],
            'invoice_no' => $invoiceNo
        ];

        return view('NEWCRM/estimate_to_invoice', $data);

    } catch (\Exception $e) {
        log_message('error', 'Error in ConvertToInvoice: ' . $e->getMessage());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'An error occurred while processing your request'
        ]);
    }
}



	
	public function SaveEstimateAsInvoice()
	{
		// Initialize models
		$invoiceModel = new InvoiceModel();
		$invoiceItemsModel = new InvoiceItemsModel();
		$itemsTotal = (int) $this->request->getPost('totalitems');
		$username = session()->get('username');
		$status = 'Unsent';

		// Gather form data with checks
		$formData = [
			'invoice_no' => $this->request->getPost('invoice_no'),
			'client_name' => $this->request->getPost('cname'),
			'email' => $this->request->getPost('invoiceemail'),
			'status'=> $status,
			'invoice_date' => $this->request->getPost('invoicedate'),
			'terms' => $this->request->getPost('terms'),
			'due_date' => $this->request->getPost('duedate'),
			'subtotal' => $this->request->getPost('subtotal'),
			'discount' => $this->request->getPost('discount'),
			'total' => $this->request->getPost('total'),
			'paid' => $this->request->getPost('paid'),
			'method' => $this->request->getPost('method'),
			'balance' => $this->request->getPost('balance'),
			'netprice' => $this->request->getPost('netprice'),
			'profit_loss' => $this->request->getPost('profitDisplay'),
			'comment' => $this->request->getPost('comment'),
			'payment_instruction' => $this->request->getPost('payment_instruction'),
			'from_estimates' => 1,
			'username' => $username,
		];

		$estimateId = $this->request->getPost('estimateId');

		$estimateUpdate = [
			'status'=> 'Invoiced',
		];
		$estimatesModel = new EstimatesModel();
		
		// Begin transaction
		$db = \Config\Database::connect();
		$db->transBegin();
		
		try {
			// Insert the invoice data
			$invoiceModel->insert($formData);
			$invoiceId = $invoiceModel->getInsertID();
			$estimatesModel->update($estimateId, $estimateUpdate);

			// Save invoice items data
			for ($i = 0; $i < $itemsTotal; $i++) {
				$itemData = [
					'itemname' => $this->request->getPost('itemdescription')[$i],
					'quantity' => $this->request->getPost('quantity')[$i],
					'price' => $this->request->getPost('price')[$i],
					'totalprice' => $this->request->getPost('totalprice')[$i],
					'costprice' => $this->request->getPost('costprice')[$i],
					'from_estimates' => 1,
					'username' => $username,
					'invoice_id' => $invoiceId,
				];
				$invoiceItemsModel->insert($itemData);
			}

			// Commit transaction
			$db->transCommit();

			// Return the invoice ID as JSON response
			echo json_encode(['success' => true, 'invoiceId' => $invoiceId]);
		} catch (\Exception $e) {
			// Rollback transaction if an error occurs
			$db->transRollback();

			// Log the error
			log_message('error', 'Error saving invoice: ' . $e->getMessage());

			// Return error as JSON response

			echo json_encode(['success' => false, 'message' => 'An error occurred while saving the invoice.'.$estimateId]);
		}
	}

	// public function add_itenarary()
	// {
	// 	return view('NEWCRM\add_itenarary');
	// }

	public function AddNewInvoice()
	{
		// $companyDetailsModel = new CompanyDetailsModel();
		// $companyDetails = $companyDetailsModel->first();
		// var_dump($companyDetails);

		$commentModel = new CommentModel();
		$data['comments'] = $commentModel->select('*')->where('id', 1)->get()->getResult();

		$paymentModel = new PaymentModel();
		$data['payments'] = $paymentModel->select('*')->where('id', 1)->get()->getResult();

		$termsModel = new TermsModel();
		$data['terms'] = $termsModel->select('*')->where('id',1)->get()->getResult();

		$data['username'] = session()->get('username');

		$invoiceModel = new InvoiceModel();

		$invoiceItemsModel = new InvoiceItemsModel();
		$data['items'] = $invoiceItemsModel->findAll();

		// invoice no  generation
		$currentYear = date('Y');
		$lastId = $invoiceModel->getLastId();
		$lastId++;
		$invoice_number = 'INV'.'-'.sprintf('%03d', $lastId);
		$data['invoice_no'] = $invoice_number;
		
		// sending company
		$companyDetailsModel = new CompanyDetailsModel();
		$data['company'] = $companyDetailsModel->first();

		return view('NEWCRM\create_new_invoice', $data);
	}

	public function SaveNewLlient()
	{
		$clientModel = new ClientModel();
		$username = session()->get('username');

		$formData = [	
			'ClientName'=>$this->request->getPost('name'),
			'MobileNumber'=>$this->request->getPost('mobile_no'),
			'EmailAddress'=>$this->request->getPost('email'),
			'address'=>$this->request->getPost('bill_to'),
			'username' => $username
		];

		$result = $clientModel->insert($formData);
	}

	// START OF SAVING INVOICE
	public function SaveInvoice()
	{
		$invoiceModel = new InvoiceModel();
		$invoiceItems = new InvoiceItemsModel();
		$itemsTotal = $this->request->getPost('totalitems');
		
		$username = session()->get('username');
		$status = 'Unsent';
		// $invoiceDate = $this->request->getPost('invoicedate');


		$formdata = [
			'invoice_no'=> $this->request->getPost('invoice_no'),
			'client_name'=> $this->request->getPost('cname'),
			'email'=> $this->request->getPost('invoiceemail'),
			'status'=> $status,
			'invoice_date'=> $this->request->getPost('invoicedate'),
			'terms'=> $this->request->getPost('terms'),
			'due_date'=> $this->request->getPost('duedate'),
			'subtotal'=> $this->request->getPost('subtotal'),
			'discount'=> $this->request->getPost('discount'),
			'total'=> $this->request->getPost('total'),
			'paid'=> $this->request->getPost('paid'),
			'method'=> $this->request->getPost('method'),
			'balance'=> $this->request->getPost('balance'),
			'netprice'=> $this->request->getPost('netprice'),
			'items_total' => $itemsTotal,
			'profit_loss'=> $this->request->getPost('profit'),
			'comment'=> $this->request->getPost('comment'),
			'payment_instruction'=> $this->request->getPost('payment_instruction'),
			'deposit_amount'=> $this->request->getPost('saveDepositeRequest'),
			'payment_reminder'=> $this->request->getPost('paymentReminder'),
			'recurring_invoice'=> $this->request->getPost('recurringInvoicePreview'),
			'username' => $username,
		];

		$result = $invoiceModel->insert($formdata);
        $invoiceId = $invoiceModel->getInsertID();
		
		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata = [
				'itemname'=> $this->request->getPost('itemname')[$i],
				'quantity'=> $this->request->getPost('quantity')[$i],
				'price'=> $this->request->getPost('price')[$i],
				'totalprice'=> $this->request->getPost('totalprice')[$i],
				'costprice'=> $this->request->getPost('costprice')[$i],
				'username' => $username,
				'invoice_id' => $invoiceId
			];

			$itemRes = $invoiceItems->insert($itemdata);
		}
	}
	// END OF SAVING INVOICE

	// Send invoice at creation including savind it 
	public function SendInvoiceAtCreation()
	{
		$invoiceModel = new InvoiceModel();
		$invoiceItems = new InvoiceItemsModel();
		$itemsTotal = $this->request->getPost('totalitems');
		
		$username = session()->get('username');
		$status = 'Sent';

		$formdata = [
			'invoice_no'=> $this->request->getPost('invoice_no'),
			'client_name'=> $this->request->getPost('cname'),
			'email'=> $this->request->getPost('invoiceemail'),
			'status'=> $status,
			'invoice_date'=> $this->request->getPost('invoicedate'),
			'terms'=> $this->request->getPost('terms'),
			'due_date'=> $this->request->getPost('duedate'),
			'subtotal'=> $this->request->getPost('subtotal'),
			'discount'=> $this->request->getPost('discount'),
			'total'=> $this->request->getPost('total'),
			'paid'=> $this->request->getPost('paid'),
			'method'=> $this->request->getPost('method'),
			'balance'=> $this->request->getPost('balance'),
			'netprice'=> $this->request->getPost('netprice'),
			'items_total' => $itemsTotal,
			'profit_loss'=> $this->request->getPost('profit'),
			'comment'=> $this->request->getPost('comment'),
			'payment_instruction'=> $this->request->getPost('payment_instruction'),
			'deposit_amount'=> $this->request->getPost('saveDepositeRequest'),
			'payment_reminder'=> $this->request->getPost('paymentReminder'),
			'recurring_invoice'=> $this->request->getPost('recurringInvoicePreview'),
			'username' => $username,
		];

		$result = $invoiceModel->insert($formdata);
        $user_id = $invoiceModel->getInsertID();
		
		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata = [
				'itemname'=> $this->request->getPost('itemname')[$i],
				'quantity'=> $this->request->getPost('quantity')[$i],
				'price'=> $this->request->getPost('price')[$i],
				'totalprice'=> $this->request->getPost('totalprice')[$i],
				'costprice'=> $this->request->getPost('costprice')[$i],
				'username' => $username,
				'invoice_id' => $user_id
			];

			$itemRes = $invoiceItems->insert($itemdata);
		}
		
		// DETAILS TO POPULATE THE INVOICE SENT
		// $data = $formdata; 
		// sending company
		$companyDetailsModel = new CompanyDetailsModel();
		$companyDetails = $companyDetailsModel->first();
		$data['company'] = $companyDetails;
		
		// Fallback to a default email address if company details are not found
		$companyEmail = $companyDetails ? $companyDetails->email : 'default@example.com';
		$companyName = $companyDetails ? $companyDetails->company_name : 'Default Company';
		
		//Invoice details to be sent.
		$invoiceId = $this->request->getPost('invoiceid');
		$data['invoice_no']  = $this->request->getPost('invoice_no');
		$data['clientname']  = $this->request->getPost('cname');
		$data['clientmobile']  = $this->request->getPost('mobile');
		$data['email'] = $this->request->getPost('invoiceemail');
		$data['address'] = $this->request->getPost('bill_to');
		$data['invoice_date']  = $this->request->getPost('invoicedate');
		$data['invoice_term']  = $this->request->getPost('terms');
		$data['due_date']  = $this->request->getPost('duedate');
		$data['subtotal']  = $this->request->getPost('subtotal');
		$data['discount']  = $this->request->getPost('discount');
		$data['total']  = $this->request->getPost('total');
		$data['paid']  = $this->request->getPost('paid');
		$data['balance']  = $this->request->getPost('balance');
		$data['comments'] = $this->request->getPost('comment');
		$data['payments_instruction'] = $this->request->getPost('payment_instruction');

		// return $this->response->setJSON(['message' => $data['clientname']]);

		// received data fron invoice - ITEM SECTION
		$data['itemdata'] = [];
		for ($i = 0; $i < $itemsTotal; $i++) {
			$data['itemdata'][] = [
				'itemname' => $this->request->getPost('itemname')[$i],
				'quantity' => $this->request->getPost('quantity')[$i],
				'price' => $this->request->getPost('price')[$i],
				'totalprice' => $this->request->getPost('totalprice')[$i],
				'costprice' => $this->request->getPost('costprice')[$i],
			];
		}
		
		// email subject and body
		$emailSubject = $this->request->getPost('InvoiceSubject');
		$userMessage = $this->request->getPost('userMessage');
		$emailBody = '
		<!DOCTYPE html>
		<html>
		<head>
			<style>
				body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
				.container { max-width: 600px; margin: 0 auto; padding: 20px; }
				.header { margin-bottom: 20px; }
				.footer { margin-top: 30px; font-size: 0.9em; color: #666; }
				.important { color: #e74c3c; }
				.details { margin: 20px 0; }
			</style>
		</head>
		<body>
			<div class="container">
				<div class="header">
					<h2>Dear ' . htmlspecialchars($data['clientname']) . ',</h2>
				</div>
				
				<div class="content">
					<p>Please find attached your invoice with the following details:</p>
					
					<div class="details">
						<p><strong>Invoice Number:</strong> ' . htmlspecialchars($data['invoice_no']) . '</p>
						<p><strong>Due Date:</strong> ' . htmlspecialchars($data['due_date']) . '</p>
					</div>
					
					' . (!empty($userMessage) ? '<div class="message">' . nl2br(htmlspecialchars($userMessage)) . '</div>' : '') . '
					
					<p>Please ensure payment is made by the due date to avoid any delays.</p>
					
					<p>If you have any questions or concerns, please don\'t hesitate to contact us.</p>
				</div>
				
				<div class="footer">
					<p>Best regards,<br>
					' . htmlspecialchars($companyName) . '</p>
				</div>
			</div>
		</body>
		</html>';

		$options = new Options();
		$options->set('chroot', realpath(''));
		$dompdf = new Dompdf($options);
		$html = view('NEWCRM/sendinvoice', $data);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		$dompdf->add_info("Title", "Invoice_" . $data['invoice_no']);
		$dompdf->add_info("Author", "Steve Arnold");
		$dompdf->add_info("Subject", "Invoice System");
		$dompdf->add_info("Keywords", "Billing, Invoice");

		$canvas = $dompdf->getCanvas();
		$font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
		$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));   

		helper('inflector');

		$pdfDirectory = $_SERVER["DOCUMENT_ROOT"].'/uploads/';
		if (!is_dir($pdfDirectory)) {
			mkdir($pdfDirectory, 0755, true);
		}

		$pdfFileName = $pdfDirectory . 'invoice_' . $data['invoice_no']. '.pdf';
		file_put_contents($pdfFileName, $dompdf->output());

		if (file_exists($pdfFileName) && is_readable($pdfFileName)) {
			$email = \Config\Services::email();
			$email->setFrom($companyEmail, $companyName);
			$email->setTo($data['email']);
			$email->setSubject($emailSubject); 
			$email->setMessage($emailBody);
			$email->attach($pdfFileName);

			if ($email->send()) {
				unlink($pdfFileName);
				return $this->response->setJSON(['status' => 'success', 'message' => 'Invoice saved and sent successfully.']);
			} else {
				return $this->response->setJSON(['status' => 'error', 'message' => 'Invoice saved but email sending failed.', 'debug' => $email->printDebugger(['headers', 'subject', 'body'])]);
			}
		} else {
			return $this->response->setJSON(['status' => 'error', 'message' => 'Invoice saved but PDF generation failed.']);
		}
	}

	public function SendEstimateAtCreation() 
	{
		$invoiceModel = new EstimatesModel();
		$invoiceItems = new EstimatesItemsModel();
		$itemsTotal = $this->request->getPost('totalitems');

		$username = session()->get('username');
		$status = 'Sent';

		$formdata = [
			'estimate_no'=> $this->request->getPost('estimate_no'),
			'client_name'=> $this->request->getPost('cname'),
			'email'=> $this->request->getPost('invoiceemail'),
			'status'=> $status,
			'invoice_date'=> $this->request->getPost('invoicedate'),
			'subtotal'=> $this->request->getPost('subtotal'),
			'discount'=> $this->request->getPost('discount'),
			'total'=> $this->request->getPost('total'),
			'netprice'=> $this->request->getPost('netprice'),
			'items_total' => $itemsTotal,
			'profit_loss'=> $this->request->getPost('profit'),
			'comment'=> $this->request->getPost('comment'),
			'username' => $username,
		];
		// return $this->response->setJSON(["meesage" => $formdata]);

		$result = $invoiceModel->insert($formdata);
        $user_id = $invoiceModel->getInsertID();

		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata = [
				'itemname'=> $this->request->getPost('itemname')[$i],
				'quantity'=> $this->request->getPost('quantity')[$i],
				'price'=> $this->request->getPost('price')[$i],
				'totalprice'=> $this->request->getPost('totalprice')[$i],
				'costprice'=> $this->request->getPost('costprice')[$i],
				'username' => $username,
				'invoice_id' => $user_id
			];

			$itemRes = $invoiceItems->insert($itemdata);
		}

		// DETAILS TO POPULATE THE INVOICE SENT
		// $data = $formdata; 
		// sending company
		$companyDetailsModel = new CompanyDetailsModel();
		$companyDetails = $companyDetailsModel->first();
		$data['company'] = $companyDetails;
		
		// Fallback to a default email address if company details are not found
		$companyEmail = $companyDetails ? $companyDetails->email : 'default@example.com';
		$companyName = $companyDetails ? $companyDetails->company_name : 'Default Company';
		
		//Invoice details to be sent.
		$invoiceId = $this->request->getPost('estimateid');
		$data['estimate_no']  = $this->request->getPost('estimate_no');
		$data['clientname']  = $this->request->getPost('cname');
		$data['invoice_date']  = $this->request->getPost('invoicedate');
		$data['invoice_term']  = $this->request->getPost('terms');
		$data['due_date']  = $this->request->getPost('duedate');
		$data['bill_to'] = $this->request->getPost('invoiceemail');
		$data['subtotal']  = $this->request->getPost('subtotal');
		$data['discount']  = $this->request->getPost('discount');
		$data['total']  = $this->request->getPost('total');
		$data['paid']  = $this->request->getPost('paid');
		$data['balance']  = $this->request->getPost('balance');
		$data['comments'] = $this->request->getPost('comment');
		$data['payments_instruction'] = $this->request->getPost('payment_instruction');

		//received data fron invoice - ITEM SECTION
		$data['itemdata'] = [];
		for ($i = 0; $i < $itemsTotal; $i++) {
			$data['itemdata'][] = [
				'itemname' => $this->request->getPost('itemname')[$i],
				'quantity' => $this->request->getPost('quantity')[$i],
				'price' => $this->request->getPost('price')[$i],
				'totalprice' => $this->request->getPost('totalprice')[$i],
				'costprice' => $this->request->getPost('costprice')[$i],
			];
		}

		// email subject and body
		$emailSubject = $this->request->getPost('InvoiceSubject');
		$userMessage = $this->request->getPost('userMessage');
		// $emailBody = '<h3>Dear ' . $data['clientname'] . ',</h3><br> Please find the attached estimate. Open for further consultations. <br><br>' .$userMessage;
		$emailBody = '
		<!DOCTYPE html>
		<html>
		<head>
			<style>
				body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
				.container { max-width: 600px; margin: 0 auto; padding: 20px; }
				.header { margin-bottom: 20px; }
				.footer { margin-top: 30px; font-size: 0.9em; color: #666; }
				.important { color: #e74c3c; }
				.details { 
					margin: 20px 0; 
					background: #f8f9fa;
					padding: 15px;
					border-radius: 5px;
				}
				.message {
					margin: 20px 0;
					padding: 15px;
					background: #f8f9fa;
					border-radius: 5px;
				}
			</style>
		</head>
		<body>
			<div class="container">
				<div class="header">
					<h2>Dear ' . htmlspecialchars($data['clientname']) . ',</h2>
				</div>
				
				<div class="content">
					<p>Please find attached your estimate with the following details:</p>
					
					<div class="details">
						<p><strong>Estimate Number:</strong> ' . htmlspecialchars($data['estimate_no']) . '</p>
						<p><strong>Date:</strong> ' . htmlspecialchars($data['invoice_date']) . '</p>
						' . (!empty($data['due_date']) ? '<p><strong>Valid Until:</strong> ' . htmlspecialchars($data['due_date']) . '</p>' : '') . '
						' . (!empty($data['subtotal']) ? '<p><strong>Subtotal:</strong> ' . htmlspecialchars($data['subtotal']) . '</p>' : '') . '
						' . (!empty($data['total']) ? '<p><strong>Total Amount:</strong> ' . htmlspecialchars($data['total']) . '</p>' : '') . '
					</div>
					
					' . (!empty($userMessage) ? '<div class="message">' . nl2br(htmlspecialchars($userMessage)) . '</div>' : '') . '
					
					' . (!empty($data['payments_instruction']) ? '
					<div class="details">
						<p><strong>Payment Instructions:</strong></p>
						' . nl2br(htmlspecialchars($data['payments_instruction'])) . '
					</div>' : '') . '

					' . (!empty($data['comments']) ? '
					<div class="details">
						<p><strong>Additional Notes:</strong></p>
						' . nl2br(htmlspecialchars($data['comments'])) . '
					</div>' : '') . '
					
					<p>If you have any questions about this estimate or would like to discuss it further, please don\'t hesitate to contact us.</p>
				</div>
				
				<div class="footer">
					<p>Best regards,<br>
					' . htmlspecialchars($companyName) . '</p>
				</div>
			</div>
		</body>
		</html>';


		$options = new Options();
		$options->set('chroot', realpath(''));
		$dompdf = new Dompdf($options);
		$html = view('NEWCRM/sendestimate', $data);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->set_option('margin-top', '0');
		$dompdf->set_option('margin-bottom', '0');
		$dompdf->set_option('margin-left', '0');
		$dompdf->set_option('margin-right', '0');
		$dompdf->render();

		$dompdf->getCanvas()->get_cpdf()->setEncryption(null, 'password', ['print']);

		$dompdf->add_info("Title", "Estimate_" . $data['estimate_no']);
		$dompdf->add_info("Author", "Steve Arnold");
		$dompdf->add_info("Subject", "Invoice System");
		$dompdf->add_info("Keywords", "Billing, Invoice");
		$dompdf->add_info("Creator", "SaTechs Invoice System");

		$canvas = $dompdf->getCanvas();
		$font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
		$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));   

		helper('inflector');

		$pdfDirectory = $_SERVER["DOCUMENT_ROOT"].'/uploads/';
		if (!is_dir($pdfDirectory)) {
			mkdir($pdfDirectory, 0755, true);
		}

		$pdfFileName = $pdfDirectory . 'Estimate_' . $data['estimate_no']. '.pdf';
		file_put_contents($pdfFileName, $dompdf->output());

		if (file_exists($pdfFileName) && is_readable($pdfFileName)) {
			$email = \Config\Services::email();
			$email->setFrom($companyEmail, $companyName);
			$email->setTo($data['bill_to']);
			$email->setSubject($emailSubject); 
			$email->setMessage($emailBody);
			$email->attach($pdfFileName);

			if ($email->send()) {
				unlink($pdfFileName);
				return $this->response->setJSON(['status' => 'success', 'message' => 'Invoice saved and sent successfully.']);
			} else {
				return $this->response->setJSON(['status' => 'error', 'message' => 'Invoice saved but email sending failed.', 'debug' => $email->printDebugger(['headers', 'subject', 'body'])]);
			}
		} else {
			return $this->response->setJSON(['status' => 'error', 'message' => 'Invoice saved but PDF generation failed.']);
		}

		// return $this->response->setJSON(['message'=> $data['itemdata']]);
	}

	// SEND ESTIMATE AT PREVIEW
	public function SendEstimateAtPreview ()
	{
		// sending company
		$companyDetailsModel = new CompanyDetailsModel();
		$companyDetails = $companyDetailsModel->first();
		$data['company'] = $companyDetails;
		
		// Fallback to a default email address if company details are not found
		$companyEmail = $companyDetails ? $companyDetails->email : 'default@example.com';
		$companyName = $companyDetails ? $companyDetails->company_name : 'Default Company';
		
		$estimateId = $this->request->getPost('estimateId');
		$data['estimate_no']  = $this->request->getPost('estimate_no');
		$data['clientname']  = $this->request->getPost('cname');
		$data['clientmobile']  = $this->request->getPost('mobile');
		$data['email']  = $this->request->getPost('email');
		$data['address']  = $this->request->getPost('bill_to');
		$data['invoice_date']  = $this->request->getPost('invoicedate');
		// $data['invoice_term']  = $this->request->getPost('terms');
		// $data['due_date']  = $this->request->getPost('duedate');
		// $data['bill_to'] = $this->request->getPost('email');
		$data['subtotal']  = $this->request->getPost('subtotal');
		$data['discount']  = $this->request->getPost('discount');
		$data['total']  = $this->request->getPost('total');
		// $data['paid']  = $this->request->getPost('paid');
		// $data['balance']  = $this->request->getPost('balance');
		$data['comments'] = $this->request->getPost('comment');
		// $data['payments_instruction'] = $this->request->getPost('payment');
		
		$itemsTotal  = $this->request->getPost('totalitems');
		$data['totalItems'] = $itemsTotal;
		

		$itemdata = [];  // Initialize the array to hold all item data

		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname'=> $this->request->getPost('itemdescription')[$i],
				'quantity'=> $this->request->getPost('quantity')[$i],
				'price'=> $this->request->getPost('price')[$i],
				'totalprice'=> $this->request->getPost('totalprice')[$i],
				'costprice'=> $this->request->getPost('costprice')[$i],
			];
		}

		$data['itemdata'] = $itemdata;
		
		$options = new Options();
		$options ->set('chroot', realpath('') );
		$dompdf = new Dompdf($options);
		// $dompdf->set_option('isRemoteEnabled', true); // for loading file 
		$html = view('NEWCRM/sendestimate', $data);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->set_option('margin-top', '0');
		$dompdf->set_option('margin-bottom', '0');
		$dompdf->set_option('margin-left', '0');
		$dompdf->set_option('margin-right', '0');
		$dompdf->render();
		
		$dompdf->getCanvas()->get_cpdf()->setEncryption(null, 'password', ['print']);

		$dompdf->add_info("Title", "Estimate_" . $data['estimate_no']);
		$dompdf->add_info("Author", config('App')->pdfAuthor ?? "SaTechs");
		$dompdf->add_info("Subject", "Invoice System");
		$dompdf->add_info("Keywords", "Billing, Invoice");
		$dompdf->add_info("Creator", "SaTechs Invoice System");
		
		$dompdf->add_info("Title", "Invoice_" .$data['estimate_no']);
		$dompdf->add_info("Author", "Steve Arnold");
		$dompdf->add_info("Subject", "Invoice System");
		$dompdf->add_info("Keywords", "Billing, Invoice");

		$canvas = $dompdf->getCanvas();
		$font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
		$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0)); 
		
		
		// CI4 inflector
		helper('inflector');
		
		// Ensure the directory exists
		$pdfDirectory = $_SERVER["DOCUMENT_ROOT"].'/uploads/';
		if (!is_dir($pdfDirectory)) {
			mkdir($pdfDirectory, 0755, true);
		}
		
		$pdfFileName = $pdfDirectory . 'Estimate' . $data['estimate_no']. '.pdf';
		file_put_contents($pdfFileName, $dompdf->output());
		
		if (file_exists($pdfFileName) && is_readable($pdfFileName)) {
			$email = \Config\Services::email();
			$email->setFrom($companyEmail, $companyName);
			$email->setTo($data['email']);
			$email->setSubject('Estimate for ' .$data['estimate_no']);
			$email->setMessage('<h3> Dear '  . $data['clientname'] . ',</h3><br> Please find the attached estimate. Open for further consultations.');
			$email->attach($pdfFileName);
		
			if ($email->send()) {
			// Update invoice status
			// $estimateModel = new EstimatesModel();
			// $estimateModel->update($estimateId, ['status' => 'sent']);
			unlink($pdfFileName);
			return $this->response->setJSON(['status' => 'success', 'message' => 'Estimate sent successfully.']);
		} else {
				return $this->response->setJSON(['status' => 'error', 'message' => 'Estimate email sending failed.', 'debug' => $email->printDebugger(['headers', 'subject', 'body'])]);
			}
		} else {
			return $this->response->setJSON(['status' => 'error', 'message' => 'Estimate PDF generation failed.']);
		}	
			// return $this->response->setJSON(['message' => $pdfFileName]);
	}
	public function GetSingleInvoice()
	{
			// Get the invoice ID from the GET request
			$invoiceId = $this->request->getGet('id');

			// Load the models
			$invoiceModel = new InvoiceModel();
			$invoiceItemsModel = new InvoiceItemsModel();
			$clientModel = new ClientModel();

		// Fetch estimate details by ID
			$invoice = $invoiceModel->find($invoiceId);

			if (!$invoice) {
				return $this->response->setJSON([
					'success' => false,
					'message' => 'Invoice not found',
				]);
			}
			// Get the email associated with the estimate
			$email = $invoice->email;

			// Fetch the first client with the given email
			$client = $clientModel->where('EmailAddress', $email)->findAll();

			// Check if client is found
			if (!$client) {
				return $this->response->setJSON([
					'success' => false,
					'message' => 'Client not found for this email',
				]);
			}

			// Fetch all invoice items for this estimate ID
			$items = $invoiceItemsModel->where('invoice_id', $invoiceId)->findAll();

			// Prepare the response data
			$data['invoiceId'] = $invoiceId;
			$data['success'] = true;
			$data['client'] = $client;
			$data['invoice'] = $invoice;
			$data['itemlist'] = $items;

		return view('NEWCRM/getsingleinvoice', $data);
	}
	public function InvoicePreviewAtCreate()
	{
			// Send the form data from view to preview as an array
			$formData = $this->request->getGet(); 
			$data['formData'] = $formData;
			
			// Received data from invoice - ITEM SECTION
			$itemsTotal = intval($this->request->getGet('totalitems') ?? 0);
			$itemdata = [];  // Initialize the array to hold all item data
			
			for ($i = 0; $i < $itemsTotal; $i++) {
				$itemdata[] = [
					'itemname' => $this->request->getGet('itemname')[$i] ?? '',
					'quantity' => $this->request->getGet('quantity')[$i] ?? 0,
					'price' => $this->request->getGet('price')[$i] ?? 0,
					'totalprice' => $this->request->getGet('totalprice')[$i] ?? 0,
					'costprice' => $this->request->getGet('costprice')[$i] ?? 0,
				];
			}

			
			$data['itemdata'] = $itemdata;
			
			// Fetch Company Data
			$companyDetailsModel = new CompanyDetailsModel();
			$company = $companyDetailsModel->first();
			$data['company'] = $company;
			
			// For debugging
			// return $this->response->setJSON(['message' => $data['formData']]);
			// return view('NEWCRM/invoicepdfview', $data);

			 // Render the view and capture the HTML
			 $html = view('NEWCRM/invoicepdfview', $data);

			  // Return the HTML as JSON
			  return $this->response->setJSON([
				'success' => true,
				'html' => $html
			]);
	}

	public function EstimatePreviewAtCreate()
	{
		// Send the form data from view to preview as an array
		$formData = $this->request->getGet(); 
		$data['formData'] = $formData;
		
		// Received data from invoice - ITEM SECTION
		$itemsTotal = intval($this->request->getGet('totalitems') ?? 0);
		$itemdata = [];  // Initialize the array to hold all item data
		
		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname' => $this->request->getGet('itemname')[$i] ?? '',
				'quantity' => $this->request->getGet('quantity')[$i] ?? 0,
				'price' => $this->request->getGet('price')[$i] ?? 0,
				'totalprice' => $this->request->getGet('totalprice')[$i] ?? 0,
				'costprice' => $this->request->getGet('costprice')[$i] ?? 0,
			];
		}

		
		$data['itemdata'] = $itemdata;
		
		// Fetch Company Data
		$companyDetailsModel = new CompanyDetailsModel();
		$company = $companyDetailsModel->first();
		$data['company'] = $company;
		
		// For debugging
		// return $this->response->setJSON(['message' => $data['itemdata']]);
		// return view('NEWCRM/invoicepdfview', $data);

		// Render the view and capture the HTML
		$html = view('NEWCRM/estimatepdfview', $data);

		// Return the HTML as JSON
		return $this->response->setJSON([
			'success' => true,
			'html' => $html
		]);
	}

	public function InvoicePreview()
	{
		// Send the from data from view to preview as an array
        $formData = $this->request->getGet(); 
		$invoiceId = $formData['invoiceid'] ?? null;
		$data['formData'] = $formData;

		//received data fron invoice - ITEM SECTION
		$itemsTotal = $this->request->getGet('totalitems');
		$itemdata = [];  // Initialize the array to hold all item data

		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname'=> $this->request->getGet('itemdescription')[$i],
				'quantity'=> $this->request->getGet('quantity')[$i],
				'price'=> $this->request->getGet('price')[$i],
				'totalprice'=> $this->request->getGet('totalprice')[$i],
				'costprice'=> $this->request->getGet('costprice')[$i],
			];
		}

		$data['itemdata'] = $itemdata;

		// Fetch Company Data
		$companyDetailsModel = new CompanyDetailsModel();
		$company = $companyDetailsModel->first();
		$data['company'] = $company;

		return view('NEWCRM/preview', $data);
	}

	// PREVIEW ESTIMATE FOLLOWINF BEST PRACTICES
	public function EstimatePreview() 
	{
		$formData = $this->request->getGet(); 
		$estimateId = $formData['estimateId'] ?? null;
		$data['formData'] = $formData;

		//received data fron Estimate - ITEM SECTION
		$itemsTotal = $this->request->getGet('totalitems');
		$itemdata = [];  // Initialize the array to hold all item data

		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname'=> $this->request->getGet('itemdescription')[$i],
				'quantity'=> $this->request->getGet('quantity')[$i],
				'price'=> $this->request->getGet('price')[$i],
				'totalprice'=> $this->request->getGet('totalprice')[$i],
				'costprice'=> $this->request->getGet('costprice')[$i],
			];
		}

		$data['itemdata'] = $itemdata;

		// Fetch Company Data
		$companyDetailsModel = new CompanyDetailsModel();
		$company = $companyDetailsModel->first();
		$data['company'] = $company;
		return view('NEWCRM/estimate_preview', $data);
	}

	// CONVERT ESTIMATE TO INVOICE PAGE
	public function EstimateInvoicePreview() 
	{
		$formData = $this->request->getGet(); 
		$estimateId = $formData['estimateId'] ?? null;
		$data['formData'] = $formData;

		//received data fron Estimate - ITEM SECTION
		$itemsTotal = $this->request->getGet('totalitems');
		$itemdata = [];  // Initialize the array to hold all item data

		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname'=> $this->request->getGet('itemdescription')[$i],
				'quantity'=> $this->request->getGet('quantity')[$i],
				'price'=> $this->request->getGet('price')[$i],
				'totalprice'=> $this->request->getGet('totalprice')[$i],
				'costprice'=> $this->request->getGet('costprice')[$i],
			];
		}

		$data['itemdata'] = $itemdata;

		// Fetch Company Data
		$companyDetailsModel = new CompanyDetailsModel();
		$company = $companyDetailsModel->first();
		$data['company'] = $company;
		return view('NEWCRM/estimate_invoice_preview', $data);
	}


	//View estimate-to invoice preview
	public function EstimateToInvoiCePreview() 
	{
		$formData = $this->request->getGet(); 
		$estimateId = $formData['estimateId'] ?? null;
		$data['formData'] = $formData;

		//received data fron Estimate - ITEM SECTION
		$itemsTotal = $this->request->getGet('totalitems');
		$itemdata = [];  // Initialize the array to hold all item data

		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname'=> $this->request->getGet('itemdescription')[$i],
				'quantity'=> $this->request->getGet('quantity')[$i],
				'price'=> $this->request->getGet('price')[$i],
				'totalprice'=> $this->request->getGet('totalprice')[$i],
				'costprice'=> $this->request->getGet('costprice')[$i],
			];
		}

		$data['itemdata'] = $itemdata;
		
		// Fetch Company Data
		$companyDetailsModel = new CompanyDetailsModel();
		$company = $companyDetailsModel->first();
		$data['company'] = $company;
		// var_dump($data['itemdata']);
		return view('NEWCRM/estimate_preview', $data);
	}

	//PRINT ESTIMATE USING SECURE BEST PRACTISE
	public function PreviewPrintEstimate($estimateId)
	{
		// Validate the invoice ID
		if (!is_numeric($estimateId)) {
			return $this->response->setJSON(['success' => false, 'message' => 'Invalid invoice ID']);
		}   

		// Fetch invoice details
		$estimateModel = new EstimatesModel();
		$estimateItemsModel = new EstimatesItemsModel();
		
		// Get all form data
		$request = $this->request;
		// Prepare data for update
		$updateData = [
			'invoice_no' => $request->getPost('invoice_no'),
			'client_name' => $request->getPost('cname'),
			'email' => $request->getPost('email'),
			'bill_to' => $request->getPost('bill_to'),
			'comment' => $request->getPost('comment'),
			'payment_instruction' => $request->getPost('payment'),
			'terms' => $request->getPost('terms'),
			'due_date' => $request->getPost('duedate'),
			'subtotal' => $this->InvoiceModel->formatCurrency($request->getPost('subtotal')),
			'discount' => $request->getPost('discount'),
			'total' => $this->InvoiceModel->formatCurrency($request->getPost('total')),
			'balance' => $this->InvoiceModel->formatCurrency($request->getPost('balance')),
			'netprice' => $request->getPost('netprice'),
			'profit_loss' => $request->getPost('profitDisplay'),
			'payment_reminder' => $request->getPost('paymentReminder'),
			'items_total' => $request->getPost('totalitems'),
			'username' => session()->get('username'), // Assuming username is stored in session
			// 'paid' => $request->getPost('paid'),
		];

		
		// Handle item updates
		$itemsTotal = $request->getPost('totalitems') ?? 0;
		$deletedItems = $estimateItemsModel->where('invoice_id', $estimateId)->delete();
		if($deletedItems) {
			for ($i = 0; $i < $itemsTotal; $i++) {
				$estimateItemData = [
					'itemname'=> $this->request->getPost('itemdescription')[$i],
					'quantity'=> $this->request->getPost('quantity')[$i],
					'price'=> $this->request->getPost('price')[$i],
					'totalprice'=> $this->request->getPost('totalprice')[$i],
					'costprice'=> $this->request->getPost('costprice')[$i],
					'username' => session()->get('username'),
					'invoice_id' => $estimateId,
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$itemRes = $estimateItemsModel->insert($estimateItemData);
			}
		}
		// Update the estimate with the new data
		$result = $estimateModel->update($estimateId, $updateData);
		
		if ($result) {
			// return $this->response->setJSON(['message'=>$items]);
			return $this->response->setJSON(['success' => true]);
		} else {
			return $this->response->setJSON(['success' => false, 'message' => 'Failed to update estimate']);
		}
	}

	public function PrintEstimate($estimateId)
	{
		try {
			// Fetch all necessary data
			$estimateModel = new EstimatesModel();
			$estimateItemsModel = new EstimatesItemsModel();
			$clientModel = new ClientModel();
			$companyDetailsModel = new CompanyDetailsModel();

			$data['estimate'] = $estimateModel->find($estimateId);
			if (!$data['estimate']) {
				log_message('error', "Estimate not found: $estimateId");
				return $this->response->setStatusCode(404)->setJSON(['error' => 'Estimate not found']);
			}
			$data['client'] = $clientModel->where('EmailAddress', $data['estimate']->email)->first();
			$data['itemlist'] = $estimateItemsModel->where('invoice_id', $estimateId)->findAll();
			$data['company'] = $companyDetailsModel->first();

			$filename = $data['estimate']->estimate_no . "_" . $data['estimate']->invoice_date . '.pdf';
			
			$options = new Options();
			$options->set('chroot', realpath(''));
			$dompdf = new Dompdf($options);
			$html = view('NewCRM/print_estimate', $data);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->set_option('margin-top', '0');
			$dompdf->set_option('margin-bottom', '0');
			$dompdf->set_option('margin-left', '0');
			$dompdf->set_option('margin-right', '0');
			$dompdf->render();
			
			$dompdf->getCanvas()->get_cpdf()->setEncryption(null, 'password', ['print']);
			
			$dompdf->add_info("Title", "Estimate_" . $data['estimate']->estimate_no);
			$dompdf->add_info("Author", config('App')->pdfAuthor ?? "SaTechs");
			$dompdf->add_info("Subject", "Invoice System");
			$dompdf->add_info("Keywords", "Billing, Invoice");
			$dompdf->add_info("Creator", "SaTechs Invoice System");
			
			$canvas = $dompdf->getCanvas();
			$font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
			$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));   
			
			$pdfContent = $dompdf->output();
			log_message('info', "PDF generated for estimate: $estimateId");
			
			return $this->response->setHeader('Content-Type', 'application/pdf')
								->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
								->setBody($pdfContent);
		} catch (\Exception $e) {
			log_message('error', "Error generating PDF for estimate $estimateId: " . $e->getMessage());
			return $this->response->setStatusCode(500)->setJSON(['error' => 'Error generating PDF']);
		} finally {
			// Cleanup
			if (isset($dompdf)) {
				// Dompdf doesn't have a clear() method, so we'll just unset the variable
				unset($dompdf);
			}
			// If you're using a lot of memory, you might want to manually trigger garbage collection
			// Uncomment the next line if you're dealing with memory issues
			// gc_collect_cycles();
		}
	}
	
	public function EstimateTOInvoicePrintPeview($estimateId)
	{
		// Validate the invoice ID
		if (!is_numeric($estimateId)) {
			return $this->response->setJSON(['success' => false, 'message' => 'Invalid invoice ID']);
		}   

		// Fetch invoice details
		$estimateModel = new EstimatesModel();
		$estimateItemsModel = new EstimatesItemsModel();
		
		// Get all form data
		$request = $this->request;
		$name12 = $this->request->getPost('cname');
		// Prepare data for update
		$updateData = [
			'invoice_no' => $request->getPost('invoice_no'),
			'client_name' => $request->getPost('cname'),
			'email' => $request->getPost('invoiceemail'),
			'bill_to' => $request->getPost('bill_to'),
			'comment' => $request->getPost('comment'),
			'payment_instruction' => $request->getPost('payment'),
			'terms' => $request->getPost('terms'),
			'due_date' => $request->getPost('duedate'),
			'subtotal' => $this->InvoiceModel->formatCurrency($request->getPost('subtotal')),
			'discount' => $request->getPost('discount'),
			'total' => $this->InvoiceModel->formatCurrency($request->getPost('total')),
			'balance' => $this->InvoiceModel->formatCurrency($request->getPost('balance')),
			'netprice' => $request->getPost('netprice'),
			'profit_loss' => $request->getPost('profitDisplay'),
			'payment_reminder' => $request->getPost('paymentReminder'),
			'items_total' => $request->getPost('totalitems'),
			'username' => session()->get('username'), // Assuming username is stored in session
			// 'paid' => $request->getPost('paid'),
		];

		
		// Handle item updates
		$itemsTotal = $request->getPost('totalitems') ?? 0;
		$deletedItems = $estimateItemsModel->where('invoice_id', $estimateId)->delete();
		$items = [];
		if($deletedItems) {
			for ($i = 0; $i < $itemsTotal; $i++) {
				$estimateItemData = [
					'itemname'=> $this->request->getPost('itemdescription')[$i],
					'quantity'=> $this->request->getPost('quantity')[$i],
					'price'=> $this->request->getPost('price')[$i],
					'totalprice'=> $this->request->getPost('totalprice')[$i],
					'costprice'=> $this->request->getPost('costprice')[$i],
					'username' => session()->get('username'),
					'invoice_id' => $estimateId,
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$itemRes = $estimateItemsModel->insert($estimateItemData);

			}
		}
		// Update the invoice with the new data
		$result = $estimateModel->update($estimateId, $updateData);
		
		if ($result) {
			// return $this->response->setJSON(['message'=>$items]);
			return $this->response->setJSON(['success' => true]);
		} else {
			return $this->response->setJSON(['success' => false, 'message' => 'Failed to update invoice']);
		}
	}

	public function PrintEstimateAsInvoice($estimateId)
	{
		try {
			// Fetch all necessary data
			$estimateModel = new EstimatesModel();
			$estimateItemsModel = new EstimatesItemsModel();
			$clientModel = new ClientModel();
			$companyDetailsModel = new CompanyDetailsModel();

			$data['estimate'] = $estimateModel->find($estimateId);
			if (!$data['estimate']) {
				log_message('error', "Estimate not found: $estimateId");
				return $this->response->setStatusCode(404)->setJSON(['error' => 'Estimate not found']);
			}
			$data['client'] = $clientModel->where('EmailAddress', $data['estimate']->email)->first();
			$data['itemlist'] = $estimateItemsModel->where('invoice_id', $estimateId)->findAll();
			$data['company'] = $companyDetailsModel->first();

			$filename = $data['estimate']->estimate_no . "_" . $data['estimate']->invoice_date . '.pdf';
			
			$options = new Options();
			$options->set('chroot', realpath(''));
			$dompdf = new Dompdf($options);
			$html = view('NewCRM/estimate_to_invoice_preview', $data);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->set_option('margin-top', '0');
			$dompdf->set_option('margin-bottom', '0');
			$dompdf->set_option('margin-left', '0');
			$dompdf->set_option('margin-right', '0');
			$dompdf->render();
			
			$dompdf->getCanvas()->get_cpdf()->setEncryption(null, 'password', ['print']);
			
			$dompdf->add_info("Title", "Estimate_" . $data['estimate']->estimate_no);
			$dompdf->add_info("Author", config('App')->pdfAuthor ?? "SaTechs");
			$dompdf->add_info("Subject", "Invoice System");
			$dompdf->add_info("Keywords", "Billing, Invoice");
			$dompdf->add_info("Creator", "SaTechs Invoice System");
			
			$canvas = $dompdf->getCanvas();
			$font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
			$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));   
			
			$pdfContent = $dompdf->output();
			log_message('info', "PDF generated for estimate: $estimateId");
			
			return $this->response->setHeader('Content-Type', 'application/pdf')
								->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
								->setBody($pdfContent);
		} catch (\Exception $e) {
			log_message('error', "Error generating PDF for estimate $estimateId: " . $e->getMessage());
			return $this->response->setStatusCode(500)->setJSON(['error' => 'Error generating PDF']);
		} finally {
			// Cleanup
			if (isset($dompdf)) {
				// Dompdf doesn't have a clear() method, so we'll just unset the variable
				unset($dompdf);
			}
			// If you're using a lot of memory, you might want to manually trigger garbage collection
			// Uncomment the next line if you're dealing with memory issues
			// gc_collect_cycles();
		}
	}

	public function DeleteInvoice()
	{
		if ($this->request->getMethod() === 'post') {
			$invoiceId = $this->request->getPost('id');

			$invoiceModel = new InvoiceModel();
			$InvoiceItemsModel = new InvoiceItemsModel();

			// Attempset to delete related invoice items first
			$deletedItems = $InvoiceItemsModel->where('invoice_id', $invoiceId)->delete();

			if ($deletedItems) {
				$deleted = $invoiceModel->delete($invoiceId);

				if ($deleted) {
					return $this->response->setJSON(['success' => true, 'message' => 'Invoice deleted successfully']);
				} else {
					return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete invoice']);
				}
			} else {
				return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete invoice items']);
			}
		} else {
			return $this->response->setJSON(['success' => false, 'message' => 'Invalid request method']);
		}
	}

	function AddPayment()
    {
		$username = session()->get('username');
        $data['invoiceid'] = $this->request->getGet('invoiceid');
		// return $this->response->setJSON(['message' =>$data['invoiceid'] ]);

        return view('NEWCRM/add_payment', $data);
    }

	public function InvoiceSavepayment()
	{
		$amount = $this->request->getVar('amountpaid');
		$invoiceid = $this->request->getVar('invoiceid');
		$paymentdate = $this->request->getVar('paymentdate');
		$paymentdate = date('Y-m-d', strtotime(str_replace('/', '-', $paymentdate)));
		$method = $this->request->getVar('method');
		$details = $this->request->getVar('details');
	
		$paymentitems = [
			'invoiceid' => $invoiceid,
			'paymentdate' => $paymentdate,
			'amount' => $amount,
			'method' => $method,
			'details' => $details,
			'user_id' => session()->get('user_id'),
		];
	
		$paymentInvoiceModel = new PaymentInvoiceModel();
		$paymentInvoiceModel->insert($paymentitems);
		// var_dump($paymentInvoiceModel);
	
		$invoiceModel = new InvoiceModel();
		$invoice = $invoiceModel->find($invoiceid);

		if (!$invoice) {
			echo ("Invalid Id");
			return;
		}
	
		// Extract balance and paid amount from the invoice
		$balance = $invoice->balance;
		$paid = $invoice->paid;
	
		// Remove currency symbol if present in the balance
		$balance = str_replace('£', '', $balance);
	
		// Calculate new paid amount and balance
		$newpaid = $paid + $amount;
		$newbalance = $balance - $amount;
	
		// Update the invoice with new paid amount and balance
		$updatedInvoice = [
			'balance' => $newbalance,
			'paid' => $newpaid
		];
		$invoiceModel->update($invoiceid, $updatedInvoice);
	}

	// load modify model
	public function EditPayment()
	{
		$paymentid = $this->request->getGet('paymentid');
		$paymentInvoiceModel = new PaymentInvoiceModel();
		$payment = $paymentInvoiceModel->find($paymentid);

		if ($payment) {
			$data = [
				'payment' => $payment
			];
			return view('NEWCRM/edit_transaction_payment_form', $data);
		} else {
			return 'Payment not found';
		}
	}
	// Update the modified transaction history
	public function UpdatePayment()
	{
		$paymentModel = new PaymentInvoiceModel();
		$invoiceModel = new InvoiceModel();
		
		$paymentId = $this->request->getPost('paymentId');
		$invoiceId = $this->request->getPost('invoiceId');
	
		// Find the payment data that is being modified
		$paymentData = $paymentModel->find($paymentId);
	
		if (!$paymentData) {
			return $this->response->setJSON(['message' => false, 'error' => 'Payment not found']);
		}
	
		$oldAmount = $paymentData->amount;
	
		// Find invoice data related to that payment
		$paymentInvoiceData = $invoiceModel->find($invoiceId);
	
		if (!$paymentInvoiceData) {
			return $this->response->setJSON(['message' => false, 'error' => 'Invoice not found']);
		}
	
		$amountAlreadyPaid = $paymentInvoiceData->paid;
		$invoiceTotalAmount = $paymentInvoiceData->total;
	
		$newAmount = $this->request->getPost('amount');
		$intermediateAmount = $amountAlreadyPaid - $oldAmount;
		$finalInvoiceAmountPaid = $intermediateAmount + $newAmount;
	
		$newBalance = $invoiceTotalAmount - $finalInvoiceAmountPaid;
		
		$invoiceUpdateResult = $invoiceModel->update($invoiceId, [
			'paid' => $finalInvoiceAmountPaid,
			'balance' => $newBalance
		]);
	
		$data = [
			'amount' => $newAmount,
			'method' => $this->request->getPost('method'),
			'details' => $this->request->getPost('details'),
			'user_id' => session()->get('user_id'),
		];
	
		$paymentUpdateResult = $paymentModel->update($paymentId, $data);
	
		// Log the payment edit
		$logger = service('logger');
		$logMessage = sprintf(
			'Payment edited - PaymentID: %d, InvoiceID: %d, OldAmount: %.2f, NewAmount: %.2f, UserID: %d, UserName: %s',
			$paymentId,
			$invoiceId,
			$oldAmount,
			$newAmount,
			session()->get('user_id'),
			session()->get('user_name') // Assuming you store user's name in session
		);
		$logger->info($logMessage);
	
		if ($invoiceUpdateResult && $paymentUpdateResult) {
			return $this->response->setJSON(['message' => true, 'newBalance' => $newBalance]);
		} else {
			return $this->response->setJSON(['message' => false, 'error' => 'Failed to update payment or invoice']);
		}
	}

	//send invoice
	public function SendInvoice()
	{
		$data['username'] =  session()->get('username');

		// sending company
		$companyDetailsModel = new CompanyDetailsModel();
		$companyDetails = $companyDetailsModel->first();
		$data['company'] = $companyDetails;

		// Fallback to a default email address if company details are not found
		$companyEmail = $companyDetails ? $companyDetails->email : 'default@example.com';
		$companyName = $companyDetails ? $companyDetails->company_name : 'Default Company';
	
		//Invoice details to be sent.
		$invoiceId = $this->request->getGet('invoiceid');
		$data['invoice_no']  = $this->request->getGet('invoice_no');
		$data['clientname']  = $this->request->getGet('cname');
		$data['clientmobile']  = $this->request->getGet('mobile');
		$data['email'] = $this->request->getGet('email');
		$data['address'] = $this->request->getGet('bill_to');
		$data['invoice_date']  = $this->request->getGet('invoicedate');
		$data['invoice_term']  = $this->request->getGet('terms');
		$data['due_date']  = $this->request->getGet('duedate');
		$data['subtotal']  = $this->request->getGet('subtotal');
		$data['discount']  = $this->request->getGet('discount');
		$data['total']  = $this->request->getGet('total');
		$data['paid']  = $this->request->getGet('paid');
		$data['balance']  = $this->request->getGet('balance');
		$data['comments'] = $this->request->getGet('comment');
		$data['payments_instruction'] = $this->request->getGet('payment');

		//received data fron invoice - ITEM SECTION
		$itemsTotal  = $this->request->getGet('totalitems');
		$data['totalItems'] = $itemsTotal;


		$itemdata = [];  // Initialize the array to hold all item data

		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname'=> $this->request->getGet('itemdescription')[$i],
				'quantity'=> $this->request->getGet('quantity')[$i],
				'price'=> $this->request->getGet('price')[$i],
				'totalprice'=> $this->request->getGet('totalprice')[$i],
				'costprice'=> $this->request->getGet('costprice')[$i],
			];
		}

		$data['itemdata'] = $itemdata;

		$options = new Options();
		$options ->set('chroot', realpath('') );
		$dompdf = new Dompdf($options);
		// $dompdf->set_option('isRemoteEnabled', true); // for loading file 
		$html = view('NEWCRM/sendinvoice', $data);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		// $dompdf->getCanvas()->get_cpdf()->setEncryption(null, 'password', ['print']);
		$dompdf->add_info("Title", "Invoice_" .$data['invoice_no']);
		$dompdf->add_info("Author", "Steve Arnold");
		$dompdf->add_info("Subject", "Invoice System");
		$dompdf->add_info("Keywords", "Billing, Invoice");

		$canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
		$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));   
		

		// CI4 inflector
		helper('inflector');

		// Ensure the directory exists
		$pdfDirectory = $_SERVER["DOCUMENT_ROOT"].'/uploads/';
		if (!is_dir($pdfDirectory)) {
			mkdir($pdfDirectory, 0755, true);
		}

		$pdfFileName = $pdfDirectory . 'invoice_' . $data['invoice_no']. '.pdf';
		file_put_contents($pdfFileName, $dompdf->output());

		if (file_exists($pdfFileName) && is_readable($pdfFileName)) {
			$email = \Config\Services::email();
			$email->setFrom($companyEmail, $companyName);
			$email->setTo($data['email']);
			$email->setSubject('Invoice for ' .$data['invoice_no']);
			$email->setMessage('<h3> Dear ' . $data['clientname'] . ',</h3><br>Please find the attached invoice that is due on: ' . $data['due_date'] . '.');
			$email->attach($pdfFileName);

			if ($email->send()) {
				//  Update invoice invoice status
				$invoiceModel = new InvoiceModel();
				$invoiceModel->update($invoiceId, ['status' => 'sent']);
				unlink($pdfFileName);
				return $this->response->setJSON(['status' => 'success', 'message' => 'Invoice sent successfully.']);
			} else {
				return $this->response->setJSON(['status' => 'error', 'message' => 'Invoice email sending failed.', 'debug' => $email->printDebugger(['headers', 'subject', 'body'])]);
			}
		} else {
			return $this->response->setJSON(['status' => 'error', 'message' => 'Estimate t PDF generation failed.']);
		}
	}

	//SEND PAYMENT REMINDER
	public function SendPaymentReminder()
	{
		$invoiceModel = new InvoiceModel();
		$invoiceItemsModel = new InvoiceItemsModel();
		$recurringInvoices = $invoiceModel->getExactCreatedTimeFoRecurringInvoice();

		foreach ($recurringInvoices as $invoice) {
			$dueDate = $invoice->due_date;
			$createdAt = $invoice->created_at;
			$toEmail = $invoice->email;
			$clientName = $invoice->client_name;
			$invoiceNo = $invoice->invoice_no;

			$dueDateTime = DateTime::createFromFormat('d/m/Y H:i:s', $dueDate . ' 00:00:00');
			$createdDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $createdAt);
			$dueDateTime->setTime((int)$createdDateTime->format('H'), (int)$createdDateTime->format('i'), (int)$createdDateTime->format('s'));
			$exactDueDateTime = $dueDateTime->format('Y-m-d H:i:s');

			// Calculate the difference in days between now and the due date
			$now = new DateTime();
            $interval = $now->diff($dueDateTime);

            // Send email if 7 days before the due date or after the due date
            if (($interval->days <= 7 && $interval->invert == 0) || $interval->invert == 1) {
                $this->sendEmail($toEmail, $clientName, $invoiceNo, $interval->days);
            }
			// var_dump($exactDueDateTime);
		}
		
	}

	private function sendEmail($toEmail, $clientName, $invoiceNo, $daysLeft)
	{
		$email = \Config\Services::email();

		$email->setFrom('satechs.solutions@gmail.com', 'SaTechs Solutions');
		$email->setTo($toEmail);

		if ($daysLeft > 0) {
			$subject = "Reminder: $daysLeft Days Left to Due Date for Invoice $invoiceNo.";
			$message = "<h3> Dear  $clientName, </h3><br>  This is a reminder that there are $daysLeft days left until your invoice is due. Please find the attached invoice.";
		} else {
			$subject = "Reminder: Invoice $invoiceNo Past Due Date.";
			$message = "<h3> Dear $clientName, </h3><br> This is a reminder that your invoice is past due. Please find the attached invoice.";
		}


		$email->setSubject($subject);
		$email->setMessage($message);

		if ($email->send()) {
			echo 'Email successfully sent';
		} else {
			echo $email->printDebugger(['headers']);
		}
	}	
	
	// update invoice
	public function UpdateInvoice()
	{
		// Load the models
		$invoiceModel = new InvoiceModel();
		$invoiceItemsModel = new InvoiceItemsModel();

		$itemsTotal = $this->request->getGet('totalitems');
		$username =  session()->get('username');
		$invoiceid = $this->request->getGet('invoiceid');

		$invoice = $invoiceModel->find($invoiceid);
		$invoice_no = $invoice->invoice_no;

		// Get data from the GET request
		
		$clientname = $this->request->getGet('cname');
		$mobileno = $this->request->getGet('mobile');
		$emailadd = $this->request->getGet('email');
		$billto = $this->request->getGet('bill_to');
		$comment = $this->request->getGet('comment');
		$payment = $this->request->getGet('payment');
		$invoicedate = $this->request->getGet('invoicedate');
		$terms = $this->request->getGet('terms');
		$duedate = $this->request->getGet('duedate');
		$subtotal = $this->InvoiceModel->formatCurrency($this->request->getGet('subtotal'));
		$discount = $this->request->getGet('discount');
		$total = $this->InvoiceModel->formatCurrency($this->request->getGet('total'));
		$paid = !empty($this->request->getGet('paid')) ? $this->request->getGet('paid') : 0;
		$balance = $this->InvoiceModel->formatCurrency($this->request->getGet('balance'));
		$netprice = $this->request->getGet('netprice');
		$profit_loss = $this->request->getGet('profitDisplay');
		$payment_reminder = $this->request->getGet('paymentReminder');
		$username = session()->get('username');
		$items_total = $this->request->getGet('totalitems');
		

		// Prepare data for updating the invoice
		$invoiceData = [
			'client_name' => $clientname,
			'mobile' => $mobileno,
			'email' => $emailadd,
			'bill_to' => $billto,
			'comment' => $comment,
			'payment_instruction' => $payment,
			'terms' => $terms,
			'due_date' => $duedate,
			'subtotal' => $subtotal,
			'discount' => $discount,
			'total' => $this->InvoiceModel->formatCurrency( $total),
			'paid' => $paid,
			'balance' => $this->InvoiceModel->formatCurrency($balance),
			'netprice' => $netprice,
			'items_total' => $items_total,
			'profit_loss' => $profit_loss,
			'payment_reminder' => $payment_reminder,
			'username' => $username,
			'updated_at' => date('Y-m-d H:i:s'),
		];
		// return $this->response->setJSON(['message'=> $invoiceData]);
		// return $this->response->setJSON(['message'=> $billto]);

		// start debugg
		$db = \Config\Database::connect('tenant');
		$db->transBegin();

		try{
			$invoiceModel->update($invoiceid, $invoiceData);

			$invoiceItemsModel->where('invoice_id',$invoiceid)->delete();

			// delete items and then insert
			$deletedItems = $invoiceItemsModel->where('invoice_id', $invoiceid)->delete();
			if($deletedItems) {
				for ($i = 0; $i < $itemsTotal; $i++) {
					$invoiceItemData = [
						'itemname'=> $this->request->getGet('itemdescription')[$i],
						'quantity'=> $this->request->getGet('quantity')[$i],
						'price'=> $this->request->getGet('price')[$i],
						'totalprice'=> $this->request->getGet('totalprice')[$i],
						'costprice'=> $this->request->getGet('costprice')[$i],
						'username' => $username,
						'invoice_id' => $invoiceid,
						'updated_at' => date('Y-m-d H:i:s'),
				];
				$itemRes = $invoiceItemsModel->insert($invoiceItemData);
				}
			}

			$db->transCommit();

			return $this->response->setJSON(['success' => true, 'message' => 'Invoice ' . $invoice_no . ' updated successfully.']);

		} catch(\Exception $e) {
			$db->transRollback();
			
			log_message('error', 'Error saving invoice: ' . $e->getMessage());
			
			// Return error as JSON response
			
			echo json_encode(['success' => false, 'message' => 'An error occurred while saving the invoice.'.$invoice_no]);
		}
	}


	// preview section
	public function LoadTransactionDetails()
	{
		$invoiceid = $_GET['invoiceid'];
		
		$invoiceModel = new InvoiceModel();
		$transactions = $invoiceModel->find($invoiceid);

		$paymentInvoiceModel = new PaymentInvoiceModel();
		$transactionHistory = $paymentInvoiceModel->where('invoiceid', $invoiceid)->findAll();

		$data['transactions'] = $transactions;
		$data['transactionHistory'] = $transactionHistory;

		return view('NEWCRM/transactiondetails', $data);
	}

	// view agent for that invoice
	public function AgentSingleInvoice()
	{
		$invoiceId = $this->request->getget('id');
		$invoiceModel = new InvoiceModel();
		$invoiceItemsModel = new InvoiceItemsModel();
		$clientModel = new ClientModel();

		$invoice = $invoiceModel->find($invoiceId);
		
		$email = $invoice->email;
		$client = $clientModel->where('EmailAddress',$email)->findAll();
		
		$items = $invoiceItemsModel->where('invoice_id', $invoiceId)->findAll();
		
		if ($invoice) {
			$data['invoiceId'] = $invoiceId;
			$data['success'] = true;
			$data['client'] = $client;
			$data['invoice'] = $invoice;
			$data['itemlist'] = $items;
		} else {
			redirect('/NewInvoice');
		}		

        return view('NewCRM/agentsingleinvoice', $data );

	}

	//PRINT INVOICE USING SECURE BEST PRACTISE
	public function PreviewPrintinvoice($invoiceId)
	{
		// Validate the invoice ID
		if (!is_numeric($invoiceId)) {
			return $this->response->setJSON(['success' => false, 'message' => 'Invalid invoice ID']);
		}   

		// Fetch invoice details
		$invoiceModel = new InvoiceModel();
		$invoiceItemsModel = new InvoiceItemsModel();
		
		// Get all form data
		$request = $this->request;
		// Prepare data for update
		$updateData = [
			'invoice_no' => $request->getPost('invoice_no'),
			'client_name' => $request->getPost('cname'),
			'email' => $request->getPost('email'),
			'bill_to' => $request->getPost('bill_to'),
			'comment' => $request->getPost('comment'),
			'payment_instruction' => $request->getPost('payment'),
			'terms' => $request->getPost('terms'),
			'due_date' => $request->getPost('duedate'),
			'subtotal' => $this->InvoiceModel->formatCurrency($request->getPost('subtotal')),
			'discount' => $request->getPost('discount'),
			'total' => $this->InvoiceModel->formatCurrency($request->getPost('total')),
			'balance' => $this->InvoiceModel->formatCurrency($request->getPost('balance')),
			'netprice' => $request->getPost('netprice'),
			'profit_loss' => $request->getPost('profitDisplay'),
			'payment_reminder' => $request->getPost('paymentReminder'),
			'items_total' => $request->getPost('totalitems'),
			'username' => session()->get('username'), // Assuming username is stored in session
			// 'paid' => $request->getPost('paid'),
		];

		
		// Handle item updates
		$itemsTotal = $request->getPost('totalitems') ?? 0;
		$deletedItems = $invoiceItemsModel->where('invoice_id', $invoiceId)->delete();
		// $items = [];
		if($deletedItems) {
			for ($i = 0; $i < $itemsTotal; $i++) {
				$invoiceItemData = [
					'itemname'=> $this->request->getPost('itemdescription')[$i],
					'quantity'=> $this->request->getPost('quantity')[$i],
					'price'=> $this->request->getPost('price')[$i],
					'totalprice'=> $this->request->getPost('totalprice')[$i],
					'costprice'=> $this->request->getPost('costprice')[$i],
					'username' => session()->get('username'),
					'invoice_id' => $invoiceId,
					'updated_at' => date('Y-m-d H:i:s'),
				];
				$itemRes = $invoiceItemsModel->insert($invoiceItemData);
			}
		}
		// Update the invoice with the new data
		$result = $invoiceModel->update($invoiceId, $updateData);
		
		if ($result) {
			// return $this->response->setJSON(['message'=>$items]);
			return $this->response->setJSON(['success' => true]);
		} else {
			return $this->response->setJSON(['success' => false, 'message' => 'Failed to update invoice']);
		}
	}

	public function PrintInvoice($invoiceId)
	{
		try {
			// Fetch all necessary data
			$invoiceModel = new InvoiceModel();
			$invoiceItemsModel = new InvoiceItemsModel();
			$clientModel = new ClientModel();
			$companyDetailsModel = new CompanyDetailsModel();
	
			$data['invoice'] = $invoiceModel->find($invoiceId);
			if (!$data['invoice']) {
				return $this->response->setStatusCode(404)->setJSON(['error' => 'Invoice not found']);
			}
	
			$data['client'] = $clientModel->where('EmailAddress', $data['invoice']->email)->first();
			$data['itemlist'] = $invoiceItemsModel->where('invoice_id', $invoiceId)->findAll();
			$data['company'] = $companyDetailsModel->first();
	
			$filename = $data['invoice']->invoice_no . "_" . $data['invoice']->invoice_date . '.pdf';
	
			$options = new Options();
			$options->set('chroot', realpath(''));
			$dompdf = new Dompdf($options);
			$html = view('NewCRM/preview_print', $data);
			$dompdf->loadHtml($html);
			$dompdf->setPaper('A4', 'portrait');
			$dompdf->set_option('margin-top', '0');
			$dompdf->set_option('margin-bottom', '0');
			$dompdf->set_option('margin-left', '0');
			$dompdf->set_option('margin-right', '0');
			$dompdf->render();
	
			$dompdf->getCanvas()->get_cpdf()->setEncryption(null, 'password', ['print']);
			
			$dompdf->add_info("Title", "Invoice_" . $data['invoice']->invoice_no);
			$dompdf->add_info("Author", config('App')->pdfAuthor ?? "SaTechs");
			$dompdf->add_info("Subject", "Invoice System");
			$dompdf->add_info("Keywords", "Billing, Invoice");
			$dompdf->add_info("Creator", "SaTechs Invoice System");
			
			$canvas = $dompdf->getCanvas();
			$font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
			$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));   
			
			$pdfContent = $dompdf->output();
			
			return $this->response->setHeader('Content-Type', 'application/pdf')
								->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
								->setBody($pdfContent);
	
		} catch (\Exception $e) {
			log_message('error', "Error generating PDF for invoice $invoiceId: " . $e->getMessage());
			return $this->response->setStatusCode(500)->setJSON(['error' => 'Error generating PDF']);
		} finally {
			// Cleanup
			if (isset($dompdf)) {
				unset($dompdf);
			}
		}
	}

	//comments
	public function SetComment()	
	{
		$commentModel = new CommentModel();
		$data['comments'] = $commentModel->select('*')->where('id', 1)->get()->getResult();

		return view('NEWCRM/comment', $data);
	}

	public function UpdateComment()
	{
		$username 		  = session()->get('username');;
		$newComment 	  = $this->request->getPost('comment');
		$commentModel 	  = new commentModel();
		$existingComment  = $commentModel->first();

		if (!empty($existingComment)) {
			$data = [
				'comment'		=> $newComment,
				'username'		=> $username,
				'updated_at'	=> date('Y-m-d H:i:s'),
			];
	
			if ($commentModel->update($existingComment['id'], $data)) {
				return $this->response->setJSON(['success' => true]);
			} else {
				return $this->response->setJSON(['success' => false, 'error' => 'Failed to update Comment']);
			}
		} else {
			$data = [
				'comment'   	=> $newComment,
				'username'  	=> $username,
				'created_at' 	=> date('Y-m-d H:i:s'),
			];

			if ($commentModel->insert($data)) {
				return $this->response->setJSON(['success' => true]);
			} else {
				return $this->response->setJSON(['success' => false, 'error' => 'Failed to create new comment']);
			} 
		}
	}


	// terms 
	public function SetUpTerms() 
	{
		return view("NEWCRM/add_Terms");
	}

	public function UpdatedTerms()
	{
		$newTerms 		= $this->request->getPost('terms');
		$sanitizedNewTerms = strtolower($newTerms);
		$username 		= session()->get('username');
		$termsModel 	= new TermsModel();
		$existingTerms  = $termsModel->first();
		// return $this->response->setJSON(['success' =>$sanitizedNewTerms ]);
	
		if (!empty($existingTerms)) {
			$data =[
				'terms'			=> $sanitizedNewTerms,
				'username'		=> $username,
				'updated_at'	=> date('Y-m-d H:i:s'),
			];

			if ($termsModel->update($existingTerms['id'], $data)) {
				return $this->response->setJSON(['success' => true]);
			} else {
				return $this->response->setJSON(['success' => false, 'error' => 'Failed to update terms']);
			}
		} else {
			$data = [
				'terms' 	 	=> $sanitizedNewTerms,
				'username'    	=> $username,
				'created_at' 	=> date('Y-m-d H:i:s'),
			];
	
			if ($termsModel->insert($data)) {
				return $this->response->setJSON(['success' => true]);
			} else {
				return $this->response->setJSON(['success' => false, 'error' => 'Failed to create new terms']);
			}
		}
	}
	
	public function SetUpInvoiceComment()
	{
		$termsModel = new TermsModel();
		$data['terms'] = $termsModel->select('*')->where('id', 1)->get()->getResult();

		return view("NEWCRM/add_invoice_statement", $data);
	}

	public function UpdateInvoiceComment()
	{
		$username 		  = session()->get('username');;
		$newComment 	  = $this->request->getPost('comment');

		return $this->response->setJSON(['message' => $newComment]);



		// $commentModel 	  = new commentModel();
		// $existingComment  = $commentModel->first();

	// 	if (!empty($existingComment)) {
	// 		$data = [
	// 			'comment'		=> $newComment,
	// 			'username'		=> $username,
	// 			'updated_at'	=> date('Y-m-d H:i:s'),
	// 		];
	
	// 		if ($commentModel->update($existingComment['id'], $data)) {
	// 			return $this->response->setJSON(['success' => true]);
	// 		} else {
	// 			return $this->response->setJSON(['success' => false, 'error' => 'Failed to update Comment']);
	// 		}
	// 	} else {
	// 		$data = [
	// 			'comment'   	=> $newComment,
	// 			'username'  	=> $username,
	// 			'created_at' 	=> date('Y-m-d H:i:s'),
	// 		];

	// 		if ($commentModel->insert($data)) {
	// 			return $this->response->setJSON(['success' => true]);
	// 		} else {
	// 			return $this->response->setJSON(['success' => false, 'error' => 'Failed to create new comment']);
	// 		} 
	// 	} 
	}

	//payment instruction
	public function PaymentInstruction()
	{
		$paymentModel = new PaymentModel();
		$data['payments'] = $paymentModel->select('*')->where('id', 1)->get()->getResult();

		return view('NEWCRM/add_payment_instructions',$data );
	}


	public function SavePaymentIstructions()
	{		
		$username 				 = session()->get('username');
		$payment_instruction	 = $this->request->getPost('payment_instruction');
		$paymentModel 			 = new PaymentModel();
		$existingPayment 		 = $paymentModel->first();
	 
		 if (!empty($existingPayment)) {
			 $data = [
				'payment_instruction'   => $payment_instruction,
				'username'				=> $username,
				'updated_at'			=> date('Y-m-d H:i:s'),
			 ];
	 
			 if ($paymentModel->update($existingPayment['id'], $data)) {
				 return $this->response->setJSON(['success' => true]);
			 } else {
				 return $this->response->setJSON(['success' => false, 'error' => 'Failed to update payment instruction']);
			 }
		 } else {
			 $data = [
				'payment_instruction' 	=> $payment_instruction,
				'username'    			=> $username,
				'created_at' 			=> date('Y-m-d H:i:s'),
			 ];
	 
			 if ($paymentModel->insert($data)) {
				 return $this->response->setJSON(['success' => true]);
			 } else {
				 return $this->response->setJSON(['success' => false, 'error' => 'Failed to save payment instruction']);
			 }
		 }
	
		
	}
	
	//company details 
	public function SetCompanyDetails() 
	{
		return view("NEWCRM/add_Company_Details");
	}

	public function SaveCompany()
	{
		$companyDetailsModel = new CompanyDetailsModel();

		// Get the logged in user's details
		$userId = session()->get('user_id');
		$username = session()->get('username');

		if (!$userId || !$username) {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'User session not found'
			]);
		}

		$data = [
			'company_name' => $this->request->getPost('CompanytName'),   
			'registration_no' => $this->request->getPost('registration_no') ?? '-',  
			'mobile_no' => $this->request->getPost('MobileNumber'),      
			'additional_no' => $this->request->getPost('MobileNumber2'), 
			'email' => $this->request->getPost('email'),               
			'website' => $this->request->getPost('website') ?? '-',   
			'street' => $this->request->getPost('Street'),             
			'city' => $this->request->getPost('city'),                 
			'country' => $this->request->getPost('country'),           
			'post_code' => $this->request->getPost('post_code'),       
			'user_id' => $userId,                                      
			'username' => $username                                    
		];

		try {
			// Validate required fields
			$requiredFields = ['company_name', 'email', 'user_id', 'username'];
			foreach ($requiredFields as $field) {
				if (empty($data[$field])) {
					return $this->response->setJSON([
						'success' => false,
						'message' => "The {$field} field is required.",
						'data' => $data
					]);
				}
			}

			// // Handle logo upload if present
			// $logo = $this->request->getFile('logo');
			// if ($logo && $logo->isValid() && !$logo->hasMoved()) {
			// 	$newName = $logo->getRandomName();
			// 	$uploadPath = ROOTPATH . 'public/uploads/logos';
				
			// 	// Create directory if it doesn't exist
			// 	if (!file_exists($uploadPath)) {
			// 		mkdir($uploadPath, 0777, true);
			// 	}
				
			// 	$logo->move($uploadPath, $newName);
			// 	$data['logo_path'] = 'uploads/logos/' . $newName;
			// }

			// Handle logo upload
			$logo = $this->request->getFile('logo');
			if ($logo && $logo->isValid() && !$logo->hasMoved()) {
				$newName = $logo->getRandomName();
				$logo->move(ROOTPATH . 'public/uploads/logos', $newName);
				$data['logo_path'] = 'uploads/logos/' . $newName;
			}


			$result = $companyDetailsModel->insert($data);
			
			if ($result) {
				return $this->response->setJSON([
					'success' => true, 
					'message' => 'Company details saved successfully',
					'id' => $result
				]);
			} else {
				$errors = $companyDetailsModel->errors();
				return $this->response->setJSON([
					'success' => false, 
					'message' => 'Failed to save company details',
					'errors' => $errors,
					'data' => $data
				]);
			}
		} catch (\Exception $e) {
			log_message('error', 'Error saving company: ' . $e->getMessage());
			return $this->response->setJSON([
				'success' => false, 
				'message' => 'Error: ' . $e->getMessage(),
				'data' => $data
			]);
		}
	}

	// public function SaveCompany()
	// {
	// 	$companyDetailsModel = new CompanyDetailsModel();

	// 	$data = [
	// 		'company_name' => $this->request->getPost('companyName'),
	// 		'mobile_no' => $this->request->getPost('mobile'),
	// 		'additional_no' => $this->request->getPost('additionalMobile'),
	// 		'email' => $this->request->getPost('email'),
	// 		'website' => $this->request->getPost('website'),
	// 		'post_code' => $this->request->getPost('post_code'),
	// 		'street' => $this->request->getPost('street'),
	// 		'city' => $this->request->getPost('city'),
	// 		'country' => $this->request->getPost('country')
	// 	];
		
	// 	// // Handle logo upload
	// 	// $logo = $this->request->getFile('logo');
	// 	// if ($logo && $logo->isValid() && !$logo->hasMoved()) {
	// 	// 	$newName = $logo->getRandomName();
	// 	// 	$logo->move(ROOTPATH . 'public/uploads/logos', $newName);
	// 	// 	$data['logo_path'] = 'uploads/logos/' . $newName;
	// 	// }
	// 	// return $this->response->setJSON(['message' => $data]);

	// 	$result = $companyDetailsModel->insert($data);

	// 	if ($result) {
	// 		return $this->response->setJSON(['success' => true, 'message' => 'Company details saved successfully']);
	// 	} else {
	// 		return $this->response->setJSON(['success' => false, 'message' => 'Failed to save company details']);
	// 	}
	// }


	// notice

	public function NewNotice()
	{
		return view('NEWCRM/newNotice');
	}


	// items
	public function CreatItem()
	{
		return view('NEWCRM/add_item');
	}

	public function SaveItem()
	{
		$username 	= session()->get('username');
		$itemModel 	= new ItemModel();
		$itemName 	= $this->request->getPost('Item_description');

	
		$formData = [
			'item_description' 	=> $itemName,
			'rate' 				=> $this->request->getPost('rate'),
			'cost' 				=> $this->request->getPost('cost'),
			'enable_taxes' 		=> $this->request->getPost('enable_taxes'),
			'tax_rate' 			=> $this->request->getPost('taxRate'),
			'username'			=> $username,
			'created_at' 		=> date('Y-m-d H:i:s'),
		];
		
        if ($itemModel->insert($formData)) {
			return $this->response->setJSON([
                'success' => true,
                'message' => "$itemName saved successfully.",
            ]);
        } else {
			return $this->response->setJSON([
				'success' => false,
				'message' => "Failed to save $itemName."
			]);
        }
	}
	public function uploadItems()
{
    // try {
        // Verify PhpSpreadsheet is available
        // if (!class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
        //     require_once ROOTPATH . 'vendor/autoload.php';
        // }

        $file = $this->request->getFile('bulk_file');
        return $this->response->setStatusCode(400)->setJSON(['message' => $file]);

        
    //     if (!$file || !$file->isValid()) {
    //         return $this->response->setStatusCode(400)->setJSON([
    //             'success' => false,
    //             'message' => 'No valid file uploaded'
    //         ]);
    //     }

    //     if ($file->getExtension() !== 'xlsx') {
    //         return $this->response->setStatusCode(400)->setJSON([
    //             'success' => false,
    //             'message' => 'Please upload an Excel (.xlsx) file'
    //         ]);
    //     }

    //     $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getTempName());
    //     $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    //     $expectedHeaders = [
    //         'A' => 'Item Description*', 
    //         'B' => 'Cost Price',
    //         'C' => 'Selling Price*', 
    //         'D' => 'Tax Rate (%)'
    //     ];

    //     foreach ($expectedHeaders as $col => $header) {
    //         if (!isset($data[1][$col]) || trim($data[1][$col]) !== $header) {
    //             return $this->response->setStatusCode(400)->setJSON([
    //                 'success' => false,
    //                 'message' => "Invalid format: Missing or incorrect column {$col}"
    //             ]);
    //         }
    //     }

    //     $items = [];
    //     $username = session()->get('username'); 

    //     foreach ($data as $rowNum => $row) {
    //         if ($rowNum === 1) continue;
            
    //         if (!isset($row['A']) || !isset($row['C'])) continue;
            
    //         $items[] = [
    //             'item_description' => trim($row['A']),
    //             'cost' => (float)trim($row['B'] ?? 0),
    //             'rate' => (float)trim($row['C']),
    //             'tax_rate' => (float)trim($row['D'] ?? 0),
    //             'enable_taxes' => !empty(trim($row['D'] ?? '')) ? 1 : 0,
    //             'username' => $username,
    //             'created_at' => date('Y-m-d H:i:s')
    //         ];
    //     }

    //     if (empty($items)) {
    //         return $this->response->setStatusCode(400)->setJSON([
    //             'success' => false,
    //             'message' => 'No valid data found in file'
    //         ]);
    //     }

    //     $itemModel = new ItemModel();
    //     $itemModel->insertBatch($items);

    //     return $this->response->setJSON([
    //         'success' => true,
    //         'message' => count($items) . ' items uploaded successfully'
    //     ]);

    // } catch (\Exception $e) {
    //     log_message('error', $e->getMessage());
    //     return $this->response->setStatusCode(500)->setJSON([
    //         'success' => false,
    //         'message' => 'Upload failed: ' . $e->getMessage()
    //     ]);
    // }
}

	public function downloadTemplate(): \CodeIgniter\HTTP\ResponseInterface 
	{
	try {
		ini_set('memory_limit', '256M');
		
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Set headers
		$headers = [
			'A1' => 'Item Description*',
			'B1' => 'Cost Price',
			'C1' => 'Selling Price*', 
			'D1' => 'Tax Rate (%)'
		];

		foreach ($headers as $cell => $value) {
			$sheet->setCellValue($cell, $value);
		}

		// Style headers
		$sheet->getStyle('A1:D1')->applyFromArray([
			'font' => ['bold' => true],
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['rgb' => 'F2EFE8']
			],
			'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
		]);

		// Sample data
		$sampleData = [
			'A2' => 'Sample Item Name',
			'B2' => '100.00',
			'C2' => '150.00', 
			'D2' => '10'
		];

		foreach ($sampleData as $cell => $value) {
			$sheet->setCellValue($cell, $value);
		}

		// Column widths 
		$widths = ['A' => 30, 'B' => 15, 'C' => 15, 'D' => 15];
		foreach ($widths as $col => $width) {
			$sheet->getColumnDimension($col)->setWidth($width);
		}

		// Generate file
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$filename = 'item_import_template_' . date('Y-m-d') . '.xlsx';
		
		if (ob_get_contents()) ob_end_clean();
		
		// Set headers
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
		exit();

	} catch (\Exception $e) {
		log_message('error', 'Template download failed: ' . $e->getMessage());
		return $this->response->setStatusCode(500)
			->setJSON([
				'success' => false,
				'message' => 'Failed to generate template',
				'error' => ENVIRONMENT === 'development' ? $e->getMessage() : null 
			]);
	}
	}


	// save item during creation of the of invoice if not in db
	public function SaveNewItem() 
	{
		$username 	= session()->get('username');
		$itemModel 	= new ItemModel();
		$itemName 	= $this->request->getPost('Item_description');

	
		$formData = [
			'item_description' 	=> $itemName,
			'rate' 				=> $this->request->getPost('rate'),
			'cost' 				=> $this->request->getPost('cost'),
			// 'category' 			=> $this->request->getPost('category'),
			// 'enable_taxes' 		=> $this->request->getPost('enable_taxes'),
			// 'tax_rate' 			=> $this->request->getPost('taxRate'),
			'username'			=> $username,
			'created_at' 		=> date('Y-m-d H:i:s'),
		];

	
		if ($itemModel->insert($formData)) {
			return $this->response->setJSON([
                // 'success' => true,
                'message' => "$itemName saved successfully.",
            ]);
        } else {
			return $this->response->setJSON([
				// 'success' => false,
				'message' => "Failed to save $itemName."
			]);
        }
		// echo  json_encode($formData);
	}
	
	
	public function ItemList()
	{
		$itemModel 		= new ItemModel();
		$data['items'] 	= $itemModel->findAll();
		return view('NEWCRM/itemList', $data);
	}
	
	public function GetSingleItem()
	{
		$id 		= $this->request->getGet('itemId');
		$itemModel 	= new ItemModel();
		$item 		= $itemModel->find($id);

		$content = view("NEWCRM/getsingleitem" , ['item' => $item]);

		// Return the view file content as a response
		return $this->response->setBody($content);
	}

	public function UpdateItem()
	{

		$id 		= $this->request->getPost('itemId');
		$itemModel 	= new ItemModel();
		$item 		= $itemModel->find($id);

		$content = view("NEWCRM/updateItems" , ['item' => $item]);

		// Return the view file content as a response
		return $this->response->setBody($content);


	}

	public function UpdateSingleItem()
	{
		$itemId 	= $this->request->getPost('itemId');
		$itemModel 	= new ItemModel();
		$item 		= $itemModel->find($itemId);
		$itemName 	= $item->item_description; 

		$item_description 	= $this->request->getPost('Item_description');
		$rate 				= $this->request->getPost('rate');
		$cost 				= $this->request->getPost('cost');
		$category 			= $this->request->getPost('category');
		$enable_taxes 		= $this->request->getPost('enable_taxes');

		$itemData=[
			'item_description'  => $item_description,
			'rate'  			=> $rate,
			'cost' 				=> $cost,
			'enable_taxes' 		=> $enable_taxes,
			'updated_at'		=> date('Y-m-d H:i:s'),
		];
		
		$transactionCommited = $itemModel->update($itemId, $itemData);

		if ($transactionCommited) {
			return $this->response->setJSON(['success' => true, 'message' => $itemName . ' updated successfully.']);
		}else{
			echo json_encode(['success' => false, 'message' => 'An error occurred while updating '.$itemName]);
		}
	}

	public function DeleteSingleItem()
	{
		$itemId = $this->request->getPost('itemId');
		$itemModel = new ItemModel();	
		$item = $itemModel->find($itemId);
				
		if ($item) {
			$itemName = $item->item_description; 

			if ($itemModel->delete($itemId)) {
				return $this->response->setJSON([
					'success' => true,
					'message' => "$itemName deleted successfully."
				]);
			} else {
				return $this->response->setJSON([
					'success' => false,
					'message' => "Failed to delete $itemName."
				]);
			}
		}
	}



	// public function createProject()
	// {
	// 	return view('NEWCRM/add_project');
	// }

	public function createExpense()
	{
		return view('NEWCRM/add_expense');
	}

	// // notice page
	// public function allNotice()
	// {
	// 	return view('NEWCRM/allNotice');
	// }



	// itinerary
	public function CompanyList()
	{
		$companyDetailsModel = new CompanyDetailsModel();
		$data['companies'] = $companyDetailsModel->findAll();
		return view('NEWCRM/companyList', $data);
	}

	public function ViewCompany()
	{
            $companyId = $this->request->getPost('id');
            $companyDetailsModel = new CompanyDetailsModel();
            $company = $companyDetailsModel->find($companyId);

			$content = view("NEWCRM/viewcompany" , ['company' => $company]);
			return $this->response->setBody($content);
	}

	public function UpdateCompany()
{
    $companyDetailsModel = new CompanyDetailsModel();
    $CompanyListModel = new CompanyList();
    $companyId = $this->request->getPost('companyId');

    $companyData = [
        'company_name'    => $this->request->getPost('CompanytName'),
        'registration_no' => $this->request->getPost('registration_no'),
        'mobile_no'       => $this->request->getPost('MobileNumber'),
        'additional_no'   => $this->request->getPost('MobileNumber2'),
        'email'           => $this->request->getPost('email'),
        'website'         => $this->request->getPost('website'),
        'street'          => $this->request->getPost('Street'),             
        'city'            => $this->request->getPost('city'),                 
        'country'         => $this->request->getPost('country'),           
        'post_code'       => $this->request->getPost('post_code'),
        'username'        => session()->get('username'),
        'updated_at'      => date('Y-m-d H:i:s')
    ];

    // Handle logo upload
    $logo = $this->request->getFile('logo');
    if ($logo && $logo->isValid() && !$logo->hasMoved()) {
        $newName = $logo->getRandomName();
        $logo->move(ROOTPATH . 'public/uploads/logos', $newName);
        $companyData['logo_path'] = 'uploads/logos/' . $newName;

        // Delete old logo if exists
        $company = $companyDetailsModel->find($companyId);
        if ($company && !empty($company->logo_path)) {
            $oldLogoPath = ROOTPATH . 'public/' . $company->logo_path;
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
        }
    }

    try {
        // Find the existing company to get the current name for logging
        $company = $companyDetailsModel->find($companyId);
        $company_name = $company ? $company->company_name : 'Company';

        // Start a database transaction to ensure both updates happen or neither
        $db = \Config\Database::connect();
        $db->transStart();

        // Update company details in tenant-specific database
        $tenantUpdateResult = $companyDetailsModel->update($companyId, $companyData);

		// Connect to the main database explicitly
		$mainDb = \Config\Database::connect('default');

		// Prepare main database update data 
		$companyListData = [ 
			'tenant_company_name' => $companyData['company_name'], 
		]; 

		// Find the record in the main database first
		$mainDbQuery = $mainDb->table('companylists')
			->where('user_id', session()->get('tenant_id'));

		$mainDbRecord = $mainDbQuery->get();

		if ($mainDbRecord && $mainDbRecord->getNumRows() > 0) {
			// Get the first row
			$mainDbRecord = $mainDbRecord->getFirstRow();

			// Update existing record in the main database
			$mainDbUpdateResult = $mainDb->table('companylists')
				->where('id', $mainDbRecord->id)
				->update($companyListData);
		} else {
			// Handle case where no record is found
			$mainDbUpdateResult = false;
		} 

        // If both updates are successful, commit the transaction
        if ($tenantUpdateResult && $mainDbUpdateResult) {
            $db->transCommit();

            return $this->response->setJSON([
                'success' => true,
                'message' => "$company_name details updated successfully in all databases.",
                'data'    => $companyListData
            ]);
        } else {
            // If either update fails, roll back the transaction
            $db->transRollback();

            return $this->response->setJSON([
                'success' => false,
                'message' => "Failed to update $company_name in one or more databases.",
            ]);
        }
    } catch (\Exception $e) {
        // Ensure transaction is rolled back in case of any exception
        if (isset($db) && $db->transStatus() === false) {
            $db->transRollback();
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => "Failed to update $company_name. Error: " . $e->getMessage(),
        ]);
    }
}
	public function DeleteComapany()
	{
		$companyDetailsModel = new CompanyDetailsModel();

		$companyId = $this->request->getPost('id');
		
		$company = $companyDetailsModel->find($companyId);

		if ($company) {
			$companyName = $company->company_name; 

			if ($companyDetailsModel->delete($companyId)) {
				return $this->response->setJSON([
					'success' => true,
					'message' => "$companyName deleted successfully."
				]);
			} else {
				return $this->response->setJSON([
					'success' => false,
					'message' => "Failed to delete $companyName."
				]);
			}
		}

	}

	// invoices
	public function InvoiceList()
	{	
		$data['id'] = isset($params['id']) ? $params['id'] : null;
		
		$invoiceModel = new InvoiceModel();
		$invoiceItemsModel = new InvoiceItemsModel();
		$clientModel = new ClientModel();
		

		$invoiceId = $formData['invoiceid'] ?? null;
		$invoice = $invoiceModel->find($invoiceId);
		// $email = $invoice[0]->email;
		$clients = $clientModel->findAll();

		$data['invoices'] = $invoiceModel->orderBy('id','DESC')->findAll();
		$data['clients'] = $clients;
		$data['items'] = $invoiceItemsModel->findAll();

		$clientNames = array_column($clients, 'ClientName');

		return view('NEWCRM/InvoiceList', $data);
	}

	//financials
	public function Financials()
	{
		$username = session()->get('username');
		$invoiceModel = new InvoiceModel();
		$invoiceItemsModel = new InvoiceItemsModel();
		$clientModel = new ClientModel();
		$authIdenties = new AuthIdenties();
		$usersModel = new UsersModel();
		
		$invoiceId = $formData['invoiceid'] ?? null;
		$invoice = $invoiceModel->find($invoiceId);
		$clients = $clientModel->findAll();

		$data['invoices'] = $invoiceModel->orderBy('id','DESC')->findAll();
		$data['clients'] = $clients;
		$data['items'] = $invoiceItemsModel->findAll();

		$clientNames = array_column($clients, 'ClientName');


		// Getting user that belong to that company
		$AuthIdenties = new AuthIdenties();
		$tenantDb = session()->get('tenant_db');
		$parts = explode('_', $tenantDb);
		$identifier = $parts[1];

		$db = \Config\Database::connect();

		$company = $db->table('companylists')
			->where('tenant_database_name', $tenantDb)
			->get()
			->getRow();

		if (!$company) {
			return view('NEWCRM/error', ['message' => 'Company not found']);
		}
		
		$agentBuilder = $db->table('agents');
		$agentBuilder->select('agents.agent_id as id, agents.agent_username as username, agents.agent_mobile, agents.address, users.created_at, users.updated_at, "Agent" as user_type, auth_identities.secret as email')
			->join('users', 'users.id = agents.user_id')
			->join('auth_identities', 'auth_identities.user_id = agents.user_id')
			->where('agents.user_id', $identifier)
			->where('auth_identities.type', 'email_password');
		
		$agents = $agentBuilder->get()->getResult();
		$userBuilder = $db->table('users');
		$userBuilder->select('users.id, users.username, users.created_at, users.updated_at, auth_identities.secret as email, NULL as agent_mobile, NULL as address, "Admin" as user_type')
			->join('auth_identities', 'users.id = auth_identities.user_id')
			->where('users.id', $identifier);

		$user = $userBuilder->get()->getRow();


		$allUsers = array_merge($agents, [$user]);

		$uniqueUsers = [];
		foreach ($allUsers as $user) {
			$key = $user->id . '_' . $user->user_type;
			$uniqueUsers[$key] = $user;
		}

		$uniqueUsers = array_values($uniqueUsers);
		$data['users'] = $uniqueUsers;

		return view('NEWCRM/finacials', $data);
	}

	//create pages
	public function CreateClient()
	{
	
		return view('NEWCRM\add_client');
	}

	public function SaveClient()
	{
		$clientModel 	= new ClientModel();
		$username 		= session()->get('username');
		$email 			= $this->request->getPost('email');
		$existingClient = $clientModel->where('EmailAddress', $email)->first();
	
		if ($existingClient !== null) {
			// Email already exists, return a response indicating failure
			return $this->response->setJSON(['success' => false, 'message' => 'Email already exists']);
		} else {
			$data = [
				'ClientName' 		=> $this->request->getPost('fname'),
				'MobileNumber'	  	=> $this->request->getPost('ph_no'),
				'EmailAddress' 		=> $this->request->getPost('email'),
				'ad_email' 			=> $this->request->getPost('ad_email'),
				'l_no' 				=> $this->request->getPost('l_no'),
				'e_no' 				=> $this->request->getPost('e_no'),
				'address' 			=> $this->request->getPost('address'),
				'ad_address' 		=> $this->request->getPost('ad_address'),
				'username' 			=> $username,
				'created_at' 		=> date('Y-m-d H:i:s'),
			];

			$result = $clientModel->insert($data);

			if ($result) {
				return $this->response->setJSON(['success' => true, 'mesage'=> 'Client saved successfully']);
			} else {
				return $this->response->setJSON(['success' => false, 'message' => 'An error has occured while saving client, please try again later']);
			}
		}
    
	}

	public function UserListAuto()
	{
		$searchTerm = $this->request->getVar('search');

		$clientModel = new ClientModel();

		$users = $clientModel->like('ClientName', $searchTerm)->findAll();

		$data = [];
		foreach ($users as $user) {
			$data[] = [
				'value' 	=> $user->id,        // Use object syntax to access property
				'label' 	=> $user->ClientName, // Use object syntax to access property
				'mobile'	=> $user->MobileNumber,
				'email' 	=> $user->EmailAddress,
				'bill_to' 	=>$user->address
			];
		}
		// Return JSON response
		return $this->response->setJSON($data);
	}

	public function ClientList()
    {
        $clientModel = new ClientModel();
        $data['clients'] = $clientModel->findAll(); 
        return view('NEWCRM/clientList', $data);
    }

	public function GetSingleClient()
	{
		$clientId = $this->request->getPost('clientId');
		$clientModel = new ClientModel();
		$client = $clientModel->find($clientId);
		$content = view("NEWCRM/getsingleclient" , ['client' => $client]);

		// Return the view file content as a response
		return $this->response->setBody($content);
	}

	public function UpdateClientDetails()
	{
		$clientId = $this->request->getPost('clientId');
		$clientModel = new ClientModel();
		$client = $clientModel->find($clientId);
		// var_dump($client);

		$content = view("NEWCRM/updatesingleclient" , ['client' => $client]);

		// Return the view file content as a response
		return $this->response->setBody($content);
	}

	public function SaveUpdatedClientDetails()
	{
		$clientId 		= $this->request->getPost('clientId');
		$clientModel 	= new ClientModel();
		$client 		= $clientModel->find($clientId);

		$clientName 		= $this->request->getPost('ClientName');
		$mobileNumber 		= $this->request->getPost('MobileNumber');
		$emailAddress 		= $this->request->getPost('EmailAddress');
		$additionalEmail 	= $this->request->getPost('ad_email');
		$landlineNumber 	= $this->request->getPost('l_no');
		$emergencyNumber 	= $this->request->getPost('e_no');
		$address 			= $this->request->getPost('address');
		$additionalAdress 	= $this->request->getPost('ad_address');


		$clientData = [
			'ClientName' 	=> $clientName,
			'MobileNumber' 	=> $mobileNumber,
			'EmailAddress' 	=> $emailAddress,
			'ad_email' 		=> $additionalEmail,
			'l_no' 			=> $landlineNumber,
			'e_no' 			=> $emergencyNumber,
			'address' 		=> $address,
			'ad_address' 	=> $additionalAdress,
			'updated_at' 	=> date('Y-m-d H:i:s'),
		];

		if ($client) {
			$client_Name = $client->ClientName;
			if ($clientModel->update($clientId, $clientData)) {
				return $this->response->setJSON([
					'success' => true,
					'message' => "$client_Name Details Updated succesfully."
				]);
			} else {
				return $this->response->setJSON([
					'success' => false,
					'message' => "An error occurred while updating $client_Name."
				]);
			}
		}
	}

	public function DeleteClient()
	{
		$clientId = $this->request->GetPost('clientId');
		$clientModel = new ClientModel();
		$client = $clientModel->find($clientId);

		if ($client) {
			$client_Name = $client->ClientName;
			if ($clientModel->delete($clientId)) {
				return $this->response->setJSON([
					'success' => true,
					'message' => "$client_Name Deleted succesfully."
				]);
			} else {
				return $this->response->setJSON([
					'success' => false,
					'message' => "Failed to delete $client_Name."
				]);
			}
		}
		echo json_encode($client);

	}

	// Users_Agent
	public function CreateAgent()
	{
		return view('NEWCRM/add_agent');
	
	}

	public function SaveAgent()
	{
		// Validate input before saving the user/Agent
		$validation = \Config\Services::validation();
		$rules = [
            'agentName'    => 'required|min_length[3]',
            'emailAddress'       => 'required|valid_email|is_unique[auth_identities.secret]',
            'password'    => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
			return $this->response->setJSON(['error' => $validation->getErrors()])->setStatusCode(400);
        }

		// Save user/Agennt after validating input
		$userModel = new UserModel();
		$userEntity = new User([
			'username' => $this->request->getPost('agentName'),
			'email' => $this->request->getPost('emailAddress'),
			'password' => $this->request->getPost('password'),
		]);
		
		$result = $userModel->save($userEntity);
		$lastid = $userModel->getInsertID();
			
		if ($result) {
			$agentModel = new AgentModel();
			$agentData = [
				'agent_username' => $this->request->getPost('agentName'),
				'agent_mobile' => $this->request->getPost('mobileNumber'),
				'emergency_number' => $this->request->getPost('mobileNumber'),
				'email' => $this->request->getPost('emailAddress'),
				'address' => $this->request->getPost('address'),
				'user_id' => session()->get('user_id'),
				'agent_id' => $lastid,
			];
			$agentModel->insert($agentData);

			return $this->response->setJSON(['message' => 'Agent created successfully']);
		} else {
			return $this->response->setJSON(['message' => 'Failed to save Agent']);
		}
	}
	
	// admins
	public function Stafflist()
	{
		$AuthIdenties = new AuthIdenties();
		$tenantDb = session()->get('tenant_db');
		$parts = explode('_', $tenantDb);
		$identifier = $parts[1];

		$db = \Config\Database::connect();

		$company = $db->table('companylists')
			->where('tenant_database_name', $tenantDb)
			->get()
			->getRow();

		if (!$company) {
			return view('NEWCRM/error', ['message' => 'Company not found']);
		}

		$agentBuilder = $db->table('agents');
		$agentBuilder->select('agents.agent_id as id, agents.agent_username as username, agents.agent_mobile, agents.address, users.created_at, users.updated_at, "Agent" as user_type, auth_identities.secret as email')
			->join('users', 'users.id = agents.agent_id')
			->join('auth_identities', 'auth_identities.user_id = agents.agent_id')
			->where('agents.user_id', $identifier)
			->where('auth_identities.type', 'email_password');
		
		$agents = $agentBuilder->get()->getResult();
		// var_dump($agents);


		$userBuilder = $db->table('users');
		$userBuilder->select('users.id, users.username, users.created_at, users.updated_at, auth_identities.secret as email, NULL as agent_mobile, NULL as address, "Admin" as user_type')
			->join('auth_identities', 'users.id = auth_identities.user_id')
			->where('users.id', $identifier);

		$user = $userBuilder->get()->getRow();
		// var_dump($user);


		$allUsers = array_merge($agents, [$user]);

		$uniqueUsers = [];
		foreach ($allUsers as $user) {
			$key = $user->id . '_' . $user->user_type;
			$uniqueUsers[$key] = $user;
		}

		$uniqueUsers = array_values($uniqueUsers);
		// var_dump($uniqueUsers);
		$data = [
			'company' => $company,
			'users' => $uniqueUsers,
			'authIdentities' => $AuthIdenties->findAll()
		];

		return view('NEWCRM/stafflist', $data);
	}

	// Get staff invoice
	public function GetStaffDetails()
	{
		$userId = $this->request->getPost('userId');
		$db = \Config\Database::connect("default");
		$userBuilder = $db->table('users');
		$userBuilder->select('users.id, users.username, users.created_at, users.updated_at, auth_identities.secret as email,')
			->join('auth_identities', 'users.id = auth_identities.user_id')
			->where('users.id', $userId)
			->limit(1);

		$user = $userBuilder->get()->getRowArray();

		if (!$user) {
			return $this->response->setJSON(['error' => 'User not found']);
		}

		// Load the view and pass the user data
		$content = view("NEWCRM/view_staff_details", ['userDetails' => $user]);

		// Return the view content
		return $this->response->setBody($content);
	}
	
	public function deleteStaff()
	{
		$userID = $this->request->getPost('id');

		if (!$userID ) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid user id'
                ]);
        }

		try {
            $db = \Config\Database::connect('default');
    
            $deletedUser = $db->table('users')
                              ->where('id', $userID)
                              ->delete();
    
            if ($deletedUser) {
                return $this->response->setJSON([
                    'status' => 'success', 
                    'message' => 'User deleted successfully'
                ])->setStatusCode(200);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete user'
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An unexpected error occurred while deleting user'
            ])->setStatusCode(500);
        }
	}

	public function reportlist()
	{

		$data['lastMonthRevenue'] =  $this->InvoiceModel->getLastMonthIncomeReport(date('Y'));
		$data['lastMonthExpenditure'] =  $this->InvoiceModel->getLastMonthExpenditureReport(date('Y'));
		$data['lastMonthBalanceReport'] =  $this->InvoiceModel->getLastMonthBalanceReport(date('Y'));
		// expenditure report section
		$data['money_in'] =  $this->InvoiceModel->getMoneyOutForCurrentMonth(); 
		$data['money_out'] =  $this->InvoiceModel->getMoneyInForCurrentMonth(); 
		$data['totalPaidFoCurrentMonth'] =  $this->InvoiceModel->getTotalPaidForCurrentMonth();
		$data['totalBalancesFoCurrentMonth'] =  $this->InvoiceModel->getTotalBalanceForCurrentMonth();

		$data['yearGroups'] = $this->InvoiceModel->getyears();
		$data['totalbalance'] = $this->InvoiceModel->getbalance();
		$data['totalamount'] = $this->InvoiceModel->gettotalyear(date('Y')); 
		$totalamount = str_replace(',', '', $data['totalamount']); 
		$totalNumberOfActiveMonths= $this->InvoiceModel->getActiveMonths(date('Y')); 
		// $data['average'] = number_format((floatval($totalamount / $totalNumberOfActiveMonths)),2);

		if ($totalNumberOfActiveMonths > 0) {
			$data['average'] = number_format((floatval($totalamount / $totalNumberOfActiveMonths)), 2);
		} else {
			$data['average'] = number_format(0.00, 2); 
		}

		$data['balancecust'] = $this->InvoiceModel->getbalancecust();
		$data['totalinvoicesyear'] = $this->InvoiceModel->gettotalinvoices(date('Y'));
		$dataFromDatabaseforchart = $this->InvoiceModel->getDataForChart(date('Y'));
		
		$allMonths = [
			'January', 'February', 'March', 'April', 'May', 'June',
			'July', 'August', 'September', 'October', 'November', 'December'
		];
		$monthlyData = array_fill_keys($allMonths, 0);

		foreach ($dataFromDatabaseforchart as $row) {
			$month = $row->month;
			$count = $row->count;

			$monthlyData[$month] = $count;
		}

		$data['chartData'] = json_encode($monthlyData);

		$dataFromDatabasefordisplay = $this->InvoiceModel->getDataFordisplay();
		$monthlyData2 = array_fill_keys($allMonths, 0);

		foreach ($dataFromDatabasefordisplay as $row) {
			$month = $row->month;
			$count = $row->count;
			$total = $row->total_amount;

			$monthlyData2[$month] = $total;
		}

		$data['displaydata'] = json_encode($monthlyData2); 
		//==================================================================//
		
		$getMonthlyReport = $this->InvoiceModel->getMonthlyReport(date('Y'));   // now working here 

		// Initialize an array with all months set to 0
		$formattedData = [
			'January' => 0,
			'February' => 0,
			'March' => 0,
			'April' => 0,
			'May' => 0,
			'June' => 0,
			'July' => 0,
			'August' => 0,
			'September' => 0,
			'October' => 0,
			'November' => 0,
			'December' => 0
		];
	
		// Iterate through the monthly report data
		foreach ($getMonthlyReport as $record) {
			// Use the month name as the key and set the corresponding values
			$formattedData[$record->month] = [
				'No of Invoices' => $record->invoice_count,
				'Moeny In' => $record->money_in,
				'Money Out' => $record->money_out,
				'Total Profit' => $record->profit,
				'Total Amount' => $record->money_in - $record->money_out
			];
		}
	
		$data['displaydata1'] = json_encode($formattedData);

		//===========================================================================//
		


		$dataFromDatabaseforpiechart = $this->InvoiceModel->getDataForpiechart();        
            $clientdata = array();
            foreach ($dataFromDatabaseforpiechart as $row) {
                $client_name = $row->client_name;
                $total = $row->total_amount;

                $clientdata[$client_name] = $total;
            }

        $data['chartDatapie'] = json_encode($clientdata);

		$dataFromDatabaseforpiechartstaff = $this->InvoiceModel->getDataForpiechartstaff();           
		$staffdata = array();
		foreach ($dataFromDatabaseforpiechartstaff as $row) {
			$username = $row->username;
			$total = $row->count;
	
			$staffdata[$username] = $total;
		}
		$data['chartDatapiestaff'] = json_encode($staffdata);


		return view('NEWCRM/reportlist', $data);

	}
	function GetClientDetails()
    {
        $id = $_GET['clientid'];
		// echo $id;
        $clientdets = $this->Autocomplete->getclientdetailsid($id);
        foreach ($clientdets as $clients) {
            $data['full_name'] = $clients->ClientName;
            $data['email_address'] = $clients->EmailAddress;
            $data['additional_email'] = $clients->ad_email;
            $data['landline_number'] = $clients->l_no;
            $data['emergency_number'] = $clients->e_no;
            $data['phone_number'] = $clients->MobileNumber;
            $data['address'] = $clients->address;
            $data['additional_address'] = $clients->ad_address;
        }
        $invoices = $this->Autocomplete->getclientinvoices($data['email_address']);
        $data['invoices'] = $invoices;

        return view('NEWCRM/get_client_details', $data);
    }


	function invoice_listunpaid()
    {
            $data['invoices'] = $this->InvoiceModel->selectinvoices('Unpaid');
            $data['title'] = 'Unpaid';
            return view ('NEWCRM/list_invoices', $data);
      
    }
	function reportlistgenerate ()
	{
		$reportType = $_GET['reportType'];
        $year = $_GET['year'];
		$data['reportlist'] = $this->InvoiceModel->getreports($reportType,$year);
		$data['yearGroups'] = $this->InvoiceModel->getyears();
		$data['allMonths'] = [
			'January', 'February', 'March', 'April', 'May', 'June',
			'July', 'August', 'September', 'October', 'November', 'December'
		 ];


		if ($reportType == 'salesByClient'){
            return view('NEWCRM/reportgenerateclient', $data);    
        }
        if ($reportType == 'salesByDate'){
            return view('NEWCRM/reportgeneratedate', $data);    
        }
        if ($reportType == 'salesByStaff'){
            return view('NEWCRM/reportgeneratedstaff', $data);    
        } 
	}
	function reportlistsearch()
    {
        $selectedyear = $_GET['year'];

		$data['yearGroups'] = $this->InvoiceModel->getyears();
		$data['yearselected'] = $selectedyear;
		$data['totalbalance'] = $this->InvoiceModel->getbalance($selectedyear);
		$data['totalamount'] = $this->InvoiceModel->gettotalyear($selectedyear);
		$totalamount = str_replace(',', '', $data['totalamount']);
		// $data['average'] = number_format((floatval($totalamount / 12)),2);  // calculate average independed of number of active months

		$totalNumberOfActiveMonths= $this->InvoiceModel->getActiveMonths(date('Y')); 
		// Calculate average based on number of active months
		if ($totalNumberOfActiveMonths > 0) {
			$data['average'] = number_format((floatval($totalamount / $totalNumberOfActiveMonths)), 2);
		} else {
			$data['average'] = number_format(0.00, 2); 
		}

		$data['balancecust'] = $this->InvoiceModel->getbalancecust($selectedyear);
		$data['totalinvoicesyear'] = $this->InvoiceModel->gettotalinvoices($selectedyear);
		$dataFromDatabaseforchart = $this->InvoiceModel->getDataForChart($selectedyear);
		// Initialize an array with all months and set their initial count to zero
		$allMonths = [
			'January', 'February', 'March', 'April', 'May', 'June',
			'July', 'August', 'September', 'October', 'November', 'December'
		];
		$monthlyData = array_fill_keys($allMonths, 0);

		foreach ($dataFromDatabaseforchart as $row) {
			$month = $row->month;
			$count = $row->count;

			$monthlyData[$month] = $count;
		}

		$data['chartData'] = json_encode($monthlyData);
		//==================================================================//
		
		$getMonthlyReport = $this->InvoiceModel->getMonthlyReport($selectedyear);   // now working here 

		// Initialize an array with all months set to 0
		$formattedData = [
			'January' => 0,
			'February' => 0,
			'March' => 0,
			'April' => 0,
			'May' => 0,
			'June' => 0,
			'July' => 0,
			'August' => 0,
			'September' => 0,
			'October' => 0,
			'November' => 0,
			'December' => 0
		];
	
		// Iterate through the monthly report data
		foreach ($getMonthlyReport as $record) {
			// Use the month name as the key and set the corresponding values
			$formattedData[$record->month] = [
				'No of Invoices' => $record->invoice_count,
				'Moeny In' => $record->money_in,
				'Money Out' => $record->money_out,
				'Total Profit' => $record->profit,
				'Total Amount' => $record->money_in - $record->money_out
			];
		}
	
		$data['displaydata1'] = json_encode($formattedData);

		//===========================================================================//
		




		$dataFromDatabasefordisplay = $this->InvoiceModel->getDataFordisplay($selectedyear);
		$monthlyData2 = array_fill_keys($allMonths, 0);

		foreach ($dataFromDatabasefordisplay as $row) {
			$month = $row->month;
			$count = $row->count;
			$total = $row->total_amount;

			$monthlyData2[$month] = $total;
		}

		$data['displaydata'] = json_encode($monthlyData2);



		$dataFromDatabaseforpiechart = $this->InvoiceModel->getDataForpiechart($selectedyear);
		$clientdata = array();
		foreach ($dataFromDatabaseforpiechart as $row) {
			$client_name = $row->client_name;
			$total = $row->total_amount;

			$clientdata[$client_name] = $total;
		}

		$data['chartDatapie'] = json_encode($clientdata);
		$dataFromDatabaseforpiechartstaff = $this->InvoiceModel->getDataForpiechartstaff($selectedyear);
		$staffdata = array();
		foreach ($dataFromDatabaseforpiechartstaff as $row) {
			$username = $row->username;
			$total = $row->count;

			$staffdata[$username] = $total;
		}

		$data['chartDatapiestaff'] = json_encode($staffdata);

		return view('NEWCRM/reportlistsearch', $data);
        // } else {
        //     redirect("/Home");
        // }
    }
	public function GeneratePdf()
	{
		// Send the form data from view to preview as an array
		$formData = $this->request->getGet(); 
		$data['formData'] = $formData;

		$data['username'] = session()->get('username');

		// invoice no generation
		$invoiceModel = new InvoiceModel();
		$currentYear = date('Y');
		$lastId = $invoiceModel->getLastId();
		$lastId++;
		$invoice_number = 'INV'.'-'.sprintf('%03d', $lastId);
		$data['invoice_no'] = $invoice_number;

		// sending company
		$companyDetailsModel = new CompanyDetailsModel();
		$data['company'] = $companyDetailsModel->first();

		// received data from invoice - ITEM SECTION
		$itemsTotal = $this->request->getGet('totalitems');
		$data['totalItems'] = $itemsTotal;

		$itemdata = [];  // Initialize the array to hold all item data
		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname' => $this->request->getGet('itemname')[$i],
				'quantity' => $this->request->getGet('quantity')[$i],
				'price' => $this->request->getGet('price')[$i],
				'totalprice' => $this->request->getGet('totalprice')[$i],
				'costprice' => $this->request->getGet('costprice')[$i],
			];
		}
		$data['itemdata'] = $itemdata;

		// return $this->response->setJSON([
		// 	'message' => $data['formData']
		// ]);

		// Dompdf options and rendering
		$options = new Options();
		$options->set('chroot', realpath(''));
		$dompdf = new Dompdf($options);
		$html = view('NEWCRM/invoicepdf', $data);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		// Add metadata and page text
		$dompdf->add_info("Title", "Invoice" . $invoice_number);
		$dompdf->add_info("Author", "Steve Arnold");
		$dompdf->add_info("Subject", "Invoice System");
		$dompdf->add_info("Keywords", "Billing, Invoice");

		$canvas = $dompdf->getCanvas();
		$font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
		$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));

		// Output PDF content
		$pdfContent = $dompdf->output();

		// Calculate PDF size in bytes
		$pdfSizeBytes = strlen($pdfContent);  // Get the size of the PDF in bytes

		// Optionally, convert size to KB or MB for readability
		$pdfSizeKB = $pdfSizeBytes / 1024;  // Convert to KB
		$pdfSizeMB = $pdfSizeKB / 1024;     // Convert to MB (if needed)

		// Encode PDF content to base64
		$base64EncodedPdf = base64_encode($pdfContent); 

		return $this->response->setJSON([
			'pdfData' => $base64EncodedPdf, 
			'filename' => $invoice_number . ".pdf",
			'size_in_bytes' => $pdfSizeBytes,  // PDF size in bytes
			'size_in_kb' => round($pdfSizeKB, 2),  // PDF size in KB, rounded to 2 decimals
			'size_in_mb' => round($pdfSizeMB, 2)   // PDF size in MB, rounded to 2 decimals
		]);
	}
	public function GenerateEstimatePdf()
	{
		// Send the form data from view to preview as an array
		$formData = $this->request->getGet(); 
		$data['formData'] = $formData;


		$data['username'] =  session()->get('username');

		
		// Estimate number generation
		$estimatesModel = new EstimatesModel();
		$currentYear = date('Y');
		$lastId = $estimatesModel->getLastId();
		$lastId++;
		$estimate_number = 'EST'.'-'.sprintf('%03d', $lastId);
		$data['estimate_no'] = $estimate_number;
		
		// Company details
		$companyDetailsModel = new CompanyDetailsModel();
		$data['company'] = $companyDetailsModel->first();

		// Item data processing
		$itemsTotal = $this->request->getGet('totalitems');
		$data['totalItems'] = $itemsTotal;

		$itemdata = [];
		for ($i = 0; $i < $itemsTotal; $i++) {
			$itemdata[] = [
				'itemname' => $this->request->getGet('itemname')[$i],
				'quantity' => $this->request->getGet('quantity')[$i],
				'price' => $this->request->getGet('price')[$i],
				'totalprice' => $this->request->getGet('totalprice')[$i],
				'costprice' => $this->request->getGet('costprice')[$i],
			];
		}
		$data['itemdata'] = $itemdata;

		// PDF generation using Dompdf
		$options = new Options();
		$options->set('chroot', realpath(''));
		$dompdf = new Dompdf($options);
		$html = view('NEWCRM/estimatepdf', $data);
		$dompdf->loadHtml($html);
		$dompdf->setPaper('A4', 'portrait');
		$dompdf->render();

		// Set PDF metadata
		$dompdf->add_info("Title", "Estimate_" . $estimate_number);
		$dompdf->add_info("Author", "Steve Arnold");
		$dompdf->add_info("Subject", "Invoice System");
		$dompdf->add_info("Keywords", "Billing, Invoice");

		// Add page numbering
		$canvas = $dompdf->getCanvas();
		$font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
		$canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));

		// Output PDF content
		$pdfContent = $dompdf->output();

		// Calculate PDF size in bytes
		$pdfSizeBytes = strlen($pdfContent);  // Get the size of the PDF in bytes

		// Optionally, convert size to KB or MB for readability
		$pdfSizeKB = $pdfSizeBytes / 1024;  // Convert to KB
		$pdfSizeMB = $pdfSizeKB / 1024;     // Convert to MB (if needed)

		// Encode PDF content to base64
		$base64EncodedPdf = base64_encode($pdfContent); 
	
		// Return JSON response with PDF data and filename
		return $this->response->setJSON([
			'pdfData' => $base64EncodedPdf, 
			'filename' =>  $estimate_number . ".pdf",
			'size_in_bytes' => $pdfSizeBytes,  // PDF size in bytes
			'size_in_kb' => round($pdfSizeKB, 2),  // PDF size in KB, rounded to 2 decimals
			'size_in_mb' => round($pdfSizeMB, 2)   // PDF size in MB, rounded to 2 decimals
		]);
	}

	// PURCHASES AND PAYMENT AT INITIAL RENTING
	// function ShowExpiryModol()
	// {
	// 	return view('NEWCRM/plan_expiry_alert');
	// }
	function PurchaseList() 
	{
		return view('NEWCRM/plan_lists');
	}

	public function InitiatePlanPayment()
	{
		$json = $this->request->getJSON(true);
		
		// Validate the received data
		$validation = \Config\Services::validation();
		$validation->setRules([
			'planName' => 'required',
			'duration' => 'required',
			'price' => 'required|numeric'
		]);
	
		if (!$validation->run($json)) {
			return $this->response->setJSON(['error' => $validation->getErrors()])->setStatusCode(400);
		}
	
		// Generate a unique token for this payment session
		$paymentToken = bin2hex(random_bytes(16));
	
		// Store the plan details in the session
		session()->set('pendingPayment', [
			'token' => $paymentToken,
			'planName' => $json['planName'],
			'duration' => $json['duration'],
			'price' => $json['price']
		]);
	
		// Return the URL for the payment page
		return $this->response->setJSON([
			'paymentUrl' => site_url("plan-payment/{$paymentToken}")
		]);
	}
	public function PlanPayment($token)
	{
		$pendingPayment = session('pendingPayment');
	
		if (!$pendingPayment || $pendingPayment['token'] !== $token) {
			return redirect()->to('/plans-list')->with('message', 'Your payment session has expired. Please select a plan again.');
		}
	
		$companymodel = new CompanyDetailsModel();
		$data = [
			'company' => $companymodel->first(),
			'plan' => $pendingPayment['planName'],
			'duration' => $pendingPayment['duration'],
			'price' => $pendingPayment['price']
		];
	
		return view('NEWCRM/plan_payment', $data);
	}

	public function ProcessPayment()
    {
		Stripe::setApiKey(getEnv('STRIPE_SECRET_KEY'));
    
        $pendingPayment = session('pendingPayment');
        
        if (!$pendingPayment) {
            return $this->response->setJSON(['error' => 'No pending payment found'])->setStatusCode(400);
        }
    
        $token = $this->request->getPost('stripeToken');
        $companyName = $this->request->getPost('companyName');
        $companyEmail = $this->request->getPost('companyEmail');
		$totalAmountDue = $this->request->getPost('totalAmountDue'); 
		$amount = $totalAmountDue * 100; 
        $currency = 'gbp';
		// var_dump($token);
    
        try {
            // Create a customer in Stripe
            $customer = \Stripe\Customer::create([
                'email' => $companyEmail,
                'source' => $token,
                'name' => $companyName,
            ]);
    
            // Create a charge
            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => $currency,
                'description' => "Payment for {$pendingPayment['planName']} plan ({$pendingPayment['duration']})",
                'customer' => $customer->id,
            ]);
			// Tenant Id from session
			$tenant_id = session()->get('tenant_id');

			// 	SAVING PAYMENT DATA IN THE DB
			$paymentModel = new SystemRentPaymentModel();
			$systemSubscriptionModel = new SystemSubscriptionModel();

			$db = \Config\Database::connect();
			$db->transStart();

			$builder = $db->table('companylists');
			$tenantID = $builder->select('id')
								->where('user_id', $tenant_id)
								->get()
								->getRow();

			// Create payment record
			$paymentData = [
				'company_id' => $tenantID->id,
				'user_id' => session()->get('user_id'), 
				'amount' => $amount / 100, // Convert back to pounds
				'currency' => $currency,
				'payment_method' => 'stripe',
				'transaction_id' => $charge->id,
				'status' => 'completed'
			];
			$paymentId = $paymentModel->insert($paymentData);

			// Update or create subscription
			$subscriptionData = [
				'company_id' => $tenantID->id,
				'user_id' => session()->get('user_id'), 
				'plan_name' => $pendingPayment['planName'], 
				'subscription_duration' => $pendingPayment['duration'],
				'subscription_status' => 'active',
				'start_date' => date('Y-m-d'),
				'end_date' => $this->calculateEndDate($pendingPayment['duration']),
				'payment_id' => $paymentId
			];

			// Check for existing subscription
			$existingSubscription = $systemSubscriptionModel
				->where('company_id', $tenantID->id)
				->first();

			if ($existingSubscription) {
				$systemSubscriptionModel->update($existingSubscription->id, $subscriptionData);
			} else {
				$systemSubscriptionModel->insert($subscriptionData);
			}

			// Commit the transaction
			$db->transComplete();
	
			if ($db->transStatus() === false) {
				// Transaction failed
				throw new \Exception('Failed to update database');
			}
			// END OF SAVING PAYMENT AND SUBSCRIPTION DATA

    
            // Clear the pending payment from the session
            session()->remove('pendingPayment');
    
            $response = [
                'status' => 'success',
                'message' => 'Payment processed successfully.',
                'charge_id' => $charge->id,
                'amount' => $charge->amount / 100, // Convert back to pounds
                'currency' => $charge->currency,
                'payment_method' => $charge->payment_method
            ];
    
            return redirect()->to('payment-success')->with('payment_details', $response);
    
        } catch(\Stripe\Exception\CardException $e) {
            // The card has been declined
            $response = [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        } catch (\Exception $e) {
            $response = [
                'status' => 'error',
                'message' => 'An error occurred while processing your payment.'
            ];
        }
    
        // If there's an error, redirect to an error page
        return redirect()->to('payment-error')->with('error_details', $response);
    }

	private function calculateEndDate($duration)
    {
        $startDate = new DateTime();
        if ($duration === 'monthly') {
            $endDate = $startDate->add(new \DateInterval('P1M'));
        } else { // yearly
            $endDate = $startDate->add(new \DateInterval('P1Y'));
        }
        return $endDate->format('Y-m-d');
    }

	public function success()
    {
		return redirect()->to('dashboard');
    }

    public function cancel()
    {
        return redirect()->to('plans-list');
    }

	public function paymentError()
	{
		// Retrieve the error details from the session
		$errorDetails = session('error_details');
		
		// Clear the error details from the session
		session()->remove('error_details');
		
		// Load the error view and pass the error details
		return view('error/payment_error', ['errorDetails' => $errorDetails]);
	}



	// HANDLE WEBHOOK
	public function handleWebhook()
	{
		Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

		$payload = $this->request->getBody();
		$sig_header = $this->request->getHeaderLine('Stripe-Signature');
		$event = null;

		try {
			$event = \Stripe\Webhook::constructEvent(
				$payload, $sig_header, getenv('STRIPE_WEBHOOK_SECRET')
			);
		} catch(\UnexpectedValueException $e) {
			error_log('Invalid payload: ' . $e->getMessage());
			return $this->response->setStatusCode(400);
		} catch(\Stripe\Exception\SignatureVerificationException $e) {
			error_log('Invalid signature: ' . $e->getMessage());
			return $this->response->setStatusCode(400);
		}

		// Handle the event
		switch ($event->type) {
			case 'payment_intent.succeeded':
				$this->handlePaymentIntentSucceeded($event->data->object);
				break;
			case 'payment_intent.payment_failed':
				$this->handlePaymentIntentFailed($event->data->object);
				break;
			case 'charge.succeeded':
				$this->handleChargeSucceeded($event->data->object);
				break;
			case 'charge.failed':
				$this->handleChargeFailed($event->data->object);
				break;
			case 'customer.subscription.created':
			case 'customer.subscription.updated':
			case 'customer.subscription.deleted':
				$this->handleSubscriptionEvent($event->type, $event->data->object);
				break;
			default:
				error_log('Received unhandled event type ' . $event->type);
				break;
		}
		
		return $this->response->setStatusCode(200);
	}


	private function sendEmailNotification($subject, $message)
    {
        $email = \Config\Services::email();
        $email->setFrom('satechs .solution@gmail.com', 'SATECHS');
        $email->setTo('stevearnold9e@gmail.com'); // Replace with the company's email address
        $email->setSubject($subject);
        $email->setMessage($message);

        if ($email->send()) {
            log_message('info', 'Email sent: ' . $subject);
        } else {
            log_message('error', 'Failed to send email: ' . $subject);
        }
	}
    
    private function handlePaymentIntentSucceeded($paymentIntent)
    {
        // Log the successful payment intent
        log_message('info', 'Payment Intent Succeeded: ' . $paymentIntent->id);
        
        // Update your database or perform any necessary actions
        $paymentModel = new SystemRentPaymentModel();
        $paymentModel->updatePaymentStatus($paymentIntent->id, 'completed');
    }
    
    private function handlePaymentIntentFailed($paymentIntent)
    {
        // Log the failed payment intent
        log_message('error', 'Payment Intent Failed: ' . $paymentIntent->id);
        
        // Update your database or notify the user
        $paymentModel = new SystemRentPaymentModel();
        $paymentModel->updatePaymentStatus($paymentIntent->id, 'failed');
    }
    
    private function handleChargeSucceeded($charge)
    {
        // Log the successful charge
        log_message('info', 'Charge Succeeded: ' . $charge->id);
        
        // Update your database or perform any necessary actions
        $paymentModel = new SystemRentPaymentModel();
        $paymentModel->updateChargeStatus($charge->id, 'completed');
    }
    
    private function handleChargeFailed($charge)
    {
        // Log the failed charge
        log_message('error', 'Charge Failed: ' . $charge->id);
        
        // Update your database or notify the user
        $paymentModel = new SystemRentPaymentModel();
        $paymentModel->updateChargeStatus($charge->id, 'failed');
    }
    
	// Update subscriptions if payment success
	private function handleSubscriptionEvent($eventType, $subscription)
    {
        // Log the subscription event
        log_message('info', 'Subscription Event: ' . $eventType . ' - ' . $subscription->id);
        
        // Update your database based on the event type
        $subscriptionModel = new SystemSubscriptionModel();
        switch ($eventType) {
            case 'customer.subscription.created':
                $subscriptionModel->createSubscription($subscription);
                break;
            case 'customer.subscription.updated':
                $subscriptionModel->updateSubscription($subscription);
                break;
            case 'customer.subscription.deleted':
                $subscriptionModel->deleteSubscription($subscription->id);
                break;
        }
    }

	// google login test
	public function googleLogin()
    {
        echo 'test';
        // $authUrl = $this->googleClient->createAuthUrl();
        // return redirect()->to($authUrl);
    }
}

	


	

	
	
