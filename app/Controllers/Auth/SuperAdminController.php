<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CompanyList;
use App\Models\SuperAdminModel;

// for stripe
use Stripe\Stripe;
use App\Models\SystemRentPaymentModel;
use App\Models\SystemSubscriptionModel;


class SuperAdminController extends BaseController
{
    protected $superAdminModel;
    protected $companyListModel;
    protected $userModel;

    public function __construct()
    {   
        $this->superAdminModel = new SuperAdminModel();

    }

    public function index()
    {
       // Get tenants
        $data['tenants'] = $this->superAdminModel->getTenants();
        // var_dump( $data['tenants']);
        // Get tenant count
        $data['tenantCount'] = $this->superAdminModel->countTenants();
        // Get total system users
        $data['totalSystemUsers'] = $this->superAdminModel->getTotalUsersExcludingSuperAdmins();
        // Get total invoices
        $data['totalInvoices'] = $this->superAdminModel->getTotalInvoiceCount();
        // Get total revenue    
        $data['totalRevenue'] = $this->superAdminModel->getTotalPaidAmount();
        // Get total invoice count per Tenant
        $data['totalInvoiceCountPerCompany'] = $this->superAdminModel->getTotalInvoiceCountPerCompany();        
        // Get total user count per company
        $data['totalUsersCountPerCompany'] = $this->superAdminModel->getTotalUsersCountPerCompany();        
        // Get status for each company
        $data['EachCompanyCurrentStatus'] = $this->superAdminModel->getEachCompanyCurrentStatus();   
        
        return view('NEWCRM/super_admin_dashboard', $data);
    }

    public function viewTenantDetails()
    {
        $tenantId = $this->request->getPost('id');
        $tenantDatabase = $this->request->getPost('database');
        $tenantDetails = $this->request->getPost('tenantDetails');
        
        // Fetch subscription details
        $subscriptionDetails = $this->superAdminModel->viewTenatDetails($tenantId);

        // Create response array from tenantDetails
        $response = [
            'tenant_id' => $tenantId,
            'company_name' => $tenantDetails[0] ?? null,
            'admin_username' => $tenantDetails[1] ?? null,
            'database_name' => $tenantDetails[2] ?? null,
            'total_users' => $tenantDetails[3] ?? null,
            'total_invoices' => $tenantDetails[4] ?? null,
            'subscription_status' => $tenantDetails[5] ?? null,
            
            // Include subscription details
            'subscriptions' => $subscriptionDetails ?? []
        ];

        return $this->response->setJSON($response);
    }
        
    public function editTenantDetails()
    {
        $tenantId = $this->request->getPost('id');
        $tenantDatabase = $this->request->getPost('database');
        $tenantDetails = $this->request->getPost('tenantDetails');

        // Create response array from tenantDetails
        $response = [
            'tenant_id' => $tenantId,
            'company_name' => $tenantDetails[0] ?? null,
            'admin_username' => $tenantDetails[1] ?? null,
            'database_name' => $tenantDetails[2] ?? null,
            'total_users' => $tenantDetails[3] ?? null,
            'total_invoices' => $tenantDetails[4] ?? null,
            'subscription_status' => $tenantDetails[5] ?? null,
        ];

        return $this->response->setJSON($response);
    }


    public function updateTenantDetails()
    {
        // Validate input
        $validationRules = [
            'subscription_status' => 'required|in_list[active,pending,inactive,suspended,cancelled,expired,archived]',
            // Add more validation rules as needed
        ];
    
        if (!$this->validate($validationRules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $this->validator->getErrors()
            ])->setStatusCode(400);
        }
    
        // Retrieve tenant details from the request
        $tenantDetails = [
            'subscription_status' => $this->request->getPost('subscription_status'),
            'tenant_id' => $this->request->getPost('tenant_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        // return $this->response->setJSON(['message'=> $tenantDetails]);
    
        try {
            $systemSubscriptionModel = new SystemSubscriptionModel();
            
            // Attempt to save or update tenant details
            $result = $systemSubscriptionModel->where('company_id',$tenantDetails['tenant_id']);
            if($result){
               $updated =  $systemSubscriptionModel->update($result->id,$tenantDetails);
            }
    
            if ($updated) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Tenant details saved successfully',
                    'data' => $tenantDetails
                ])->setStatusCode(200);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to save tenant details'
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An unexpected error occurred'
            ])->setStatusCode(500);
        }
    }

    public function deleteTenantDetails()
    {
        $tenantId = $this->request->getPost('id');
        $tenantDatabase = $this->request->getPost('database');
        
        $result = $this->superAdminModel->deletetenant($tenantId, $tenantDatabase);
        
        if ($result) {
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Tenant database deleted successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Failed to delete tenant database'
            ])->setStatusCode(500);
        }
    }
   
    public function tenants() 
    {
        $data['tenantsList'] = $this->superAdminModel->getTenants();
        $data['allCompanyDetails'] = $this->superAdminModel->getCompanyDetails();
        $data['eachCompanyCurrentStatus'] = $this->superAdminModel->getEachCompanyCurrentStatus();        //not used method in the view file
        $data['totalUsersCountPerCompany'] = $this->superAdminModel->getTotalUsersCountPerCompany();        // Not used method in the view file
        return view('NEWCRM/super_admin_tenants', $data);
    } 

    public function getEmails()
    {
        $companyId = $this->request->getGet('companyId');
        $tenantDatabase = $this->request->getGet('tenantDatabase');
    
        if (!$companyId || !$tenantDatabase) {
            return $this->response->setJSON(['message' => 'Missing parameters'], 400);
        }
    
        $data['getTenantsEmails'] = $this->superAdminModel->getTenantsEmails($companyId, $tenantDatabase);     
    
        return $this->response->setJSON($data);
    }

    public function getEmailsPerTenant()
    {
        $tenants = 'Tenant emails from server';
        return $this->response->setJSON(['message'=> $tenants]);
    }

    public function  invoices() 
    {
        // Get tenants
        $data['tenants'] = $this->superAdminModel->getTenants();
        // Get total invoices
        $data['totalInvoices'] = $this->superAdminModel->getTotalInvoiceCount();
        // get toat amount of fully paid invoice cpount
        $data['totalPaidInvoiceCount'] = $this->superAdminModel->getTotalPaidInvoiceCount();
        // Get total overdue invoice count
        $data['totalOverdueInvoice'] = $this->superAdminModel->getTotalOverdueInvoice();
        // Get Partially pait invoice
        $data['totalPartiallyPaidInvoice'] = $this->superAdminModel->getTotalPartiallyPaidInvoice();
        //  Get details for each invoice in the entire system 
        $data['singleInvoiceDetails'] = $this->superAdminModel->getSingleInvoiceDetails();
        // var_dump($data['singleInvoiceDetails']);
        
        return view('NEWCRM/super_admin_invoices', $data);
    }

    public function viewInvoice()
    {
         // Input validation
         $invoiceNumber = $this->request->getPost('invoice_number');
         $databaseName = $this->request->getPost('database_name');
 
         // Enhanced input validation
         if (!$invoiceNumber || !$databaseName) {
             return $this->response->setStatusCode(400)->setJSON([
                 'status' => 'error',
                 'message' => 'Invalid invoice or database information'
             ]);
         }

         try {
            // Configure the tenant database
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $databaseName;

            // Connect to the tenant's database
            $tenantDB = \Config\Database::connect($dbConfig, true);

            // Query to find the invoice
            $invoice = $tenantDB->table('invoices')
                ->where('invoice_no', $invoiceNumber)
                ->get()
                ->getFirstRow();

            // Check if invoice exists
            if (!$invoice) {
                $tenantDB->close();
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 'error',
                    'message' => 'Invoice not found'
                ]);
            }

            // Fetch related data
            $data = [
                'invoice' => $invoice,
                'client' => $tenantDB->table('clients')
                    ->where('EmailAddress', $invoice->email)
                    ->get()
                    ->getFirstRow(),
                'itemlist' => $tenantDB->table('invoice_items')
                    ->where('invoice_id', $invoice->id)
                    ->get()
                    ->getResult(),
                'company' => $tenantDB->table('companies')
                    ->get()
                    ->getFirstRow()
            ];

            return view('NEWCRM/super_admin_view_invoice', $data);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'An unexpected error occurred'
            ]);
        }
    }

    public function downloadInvoice()
    {
        // Input validation
        $invoiceNumber = $this->request->getPost('invoice_number');
        $databaseName = $this->request->getPost('database_name');

        // Enhanced input validation
        if (!$invoiceNumber || !$databaseName) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Invalid invoice or database information'
            ]);
        }

        try {
            // Configure the tenant database
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $databaseName;

            // Connect to the tenant's database
            $tenantDB = \Config\Database::connect($dbConfig, true);

            // Query to find the invoice
            $invoice = $tenantDB->table('invoices')
                ->where('invoice_no', $invoiceNumber)
                ->get()
                ->getFirstRow();

            // Check if invoice exists
            if (!$invoice) {
                $tenantDB->close();
                return $this->response->setStatusCode(404)->setJSON([
                    'status' => 'error',
                    'message' => 'Invoice not found'
                ]);
            }

            // Fetch related data
            $data = [
                'invoice' => $invoice,
                'client' => $tenantDB->table('clients')
                    ->where('EmailAddress', $invoice->email)
                    ->get()
                    ->getFirstRow(),
                'itemlist' => $tenantDB->table('invoice_items')
                    ->where('invoice_id', $invoice->id)
                    ->get()
                    ->getResult(),
                'company' => $tenantDB->table('companies')
                    ->get()
                    ->getFirstRow()
            ];

            // Generate filename
            $filename = $invoice->invoice_no . "_" . $invoice->invoice_date . '.pdf';

            // PDF Generation
            $options = new \Dompdf\Options();
            $options->set('chroot', realpath(''));
            $dompdf = new \Dompdf\Dompdf($options);

            // Load view for PDF
            $html = view('NewCRM/preview_print', $data);
            $dompdf->loadHtml($html);

            // PDF configuration
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->set_option('margin-top', '0');
            $dompdf->set_option('margin-bottom', '0');
            $dompdf->set_option('margin-left', '0');
            $dompdf->set_option('margin-right', '0');
            $dompdf->render();

            // PDF Metadata
            $dompdf->add_info("Title", "Invoice_" . $invoice->invoice_no);
            $dompdf->add_info("Author", config('App')->pdfAuthor ?? "SaTechs");
            $dompdf->add_info("Subject", "Invoice System");
            $dompdf->add_info("Keywords", "Billing, Invoice");
            $dompdf->add_info("Creator", "SaTechs Invoice System");

            // Page numbering
            $canvas = $dompdf->getCanvas();
            $font = $dompdf->getFontMetrics()->get_font("Helvetica", "bold");
            $canvas->page_text(37, 820, "{PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0, 0, 0));

            // Generate PDF content
            $pdfContent = $dompdf->output();

            // Close the database connection
            $tenantDB->close();

            // Return PDF
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
                ->setBody($pdfContent);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'An unexpected error occurred'
            ]);
        }
    }

    public function deleteInvoice()
    {
        $invoiceNumber = $this->request->getPost('invoice_number');
        $databaseName = $this->request->getPost('database_name');
    
        // Validate input
        if (!$invoiceNumber || !$databaseName) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid invoice number or database name'
            ])->setStatusCode(400);
        }
    
        try {
            // Configure the tenant database
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $databaseName;

            // Connect to the tenant's database
            $tenantDB = \Config\Database::connect($dbConfig, true);
  
            // Start database transaction
            $tenantDB->transStart();
    
            // Attempt to delete the invoice
            $result = $tenantDB->table('invoices')
                ->where('invoice_no', $invoiceNumber)
                ->delete();
    
            // Check if deletion was successful
            if ($result) {
                // Commit the transaction
                $tenantDB->transComplete();
    
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => "Invoice {$invoiceNumber} deleted successfully"
                ]);
            } else {
                // Rollback the transaction
                $tenantDB->transRollback();
    
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => "Failed to delete invoice {$invoiceNumber}"
                ])->setStatusCode(404);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'details' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    public function  users() 
    {
        // Get tenants
        $data['tenants'] = $this->superAdminModel->getTenants();
        // Get counts
         $data['tenantCount'] = $this->superAdminModel->countTenants();
         // Get total system users
        $data['totalSystemUsers'] = $this->superAdminModel->getTotalUsersExcludingSuperAdmins();
        // Get total new users this month
        $data['newUsersForCurrentMonth'] = $this->superAdminModel->getNewUsersForCurrentMonth();
        // get total; currently active users
        $data['isUserActive'] = $this->superAdminModel->getActiveUsers();
        // Get userlist
        $data['userList'] = $this->superAdminModel->getUserList();
        // get user's active status
        $data['getActiveUsersForEveryUser'] = $this->superAdminModel->getActiveUsersForEveryUser();        
        
        return view('NEWCRM/super_admin_users', $data);
    }
    public function getUserDetails()
    {
        $userID = $this->request->getPost('user_id');
        $databaseName = $this->request->getPost('tenant_db');

        if (!$userID || !$databaseName) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid input parameters'
                ]);
        }

        try {
            $db = \Config\Database::connect('default');
            $user = $db->table('users')
                ->where('id', $userID)
                ->get()
                ->getFirstRow();

            if (!$user) {
                return $this->response->setStatusCode(404)
                    ->setJSON([
                        'status' => 'error', 
                        'message' => 'User not found'
                    ]);
            }

            $data = [
                'user' => $user,
                'tenant_db' => $databaseName,
                'tenant' => $this->request->getPost('tenant'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role'),
            ];
    

            return view('NEWCRM/super_admin_edit_user', $data);
            // return $this->response->setJSON(['message' => $data]);

        } catch (\Exception $e) {            
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Internal server error'
                ]);
        }
    }

    public function deleteUser()
    {
        $userID = $this->request->getPost('user_id');
        $databaseName = $this->request->getPost('tenant_db');
    
        if (!$userID || !$databaseName) {
            return $this->response->setStatusCode(400)
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid input parameters'
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

    public function reports()
    { 
        $data['lastMonthRevenue'] = $this->superAdminModel->getLastMonthIncome(date('Y'));
        $data['lastMonthBalance'] = $this->superAdminModel->getLastMonthBalance(date('Y'));

        $data['yearlyRevenue'] = $this->superAdminModel->getYearlyRevenue();
        $data['currentlyActiveTenants'] = $this->superAdminModel->getCurrentlyActiveTenants();
        $data['plansSummery'] = $this->superAdminModel->getPlansSummery();
        //  Prepare data fro line graph
        $dataFromDatabasefordisplay = $this->superAdminModel->getDataForLineGraph();

        $allMonths = [
			'January', 'February', 'March', 'April', 'May', 'June',
			'July', 'August', 'September', 'October', 'November', 'December'
		];

        $monthlyData = array_fill_keys($allMonths, 0);

		foreach ($dataFromDatabasefordisplay as $row) {
			$month = $row->month;
			$count = $row->count;
			$total = $row->total_amount;

			$monthlyData[$month] = $total;
		} 

		$data['displayDataForLineGraph'] = json_encode($monthlyData);
        
        // Prepare data for pie chart
        $data['pieChartData'] = $this->superAdminModel->getDataForPieChart();
        // Prepare data for Doughnut
        $data['doughnutData'] = $this->superAdminModel->getDataForDoughnut();
        // Prepare data fro the reprt table
        $data['subscriptionDataForTable'] = $this->superAdminModel->getSubscriptionDataForTable();

        return view('NEWCRM/super_admin_reports', $data);
    }

    public function settings()
    {
        $system_status = $this->superAdminModel->get_memory_usage();
        
        // Prepare data for the view
        $data = [
            'memory' => $system_status['memory'],
            'cpu' => $system_status['cpu'],
            'storage' => $system_status['storage']
        ];
        
        
        return view('NEWCRM/super_admin_settings', $data);
    }

    // OTHER MEDHOS NONE SPECIFIC TO A PARTICULAR PAGE

    /**
     * Clear application cache comprehensively
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function clear_cache()
    {
        // Method 1: Clear entire cache
        $cache = \Config\Services::cache();
        $cache->clean();

        // Method 2: Clear view cache
        $this->clear_view_cache();

        // Method 3: Clear system temp files
        $this->clear_temp_files();

        // Method 4: Clear framework cache directories
        $this->clear_framework_cache();

        // Optional: Log the cache clearing action
        log_message('info', 'Cache cleared by user');

        // Redirect back with success message
        return redirect()->back()->with('success', 'Cache cleared successfully');
    }

    /**
     * Clear view cache specifically
     */
    private function clear_view_cache()
    {
        $viewPath = WRITEPATH . 'cache/';
        
        if (is_dir($viewPath)) {
            $files = glob($viewPath . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    /**
     * Clear temporary system files
     */
    private function clear_temp_files()
    {
        $tempPath = WRITEPATH . 'temp/';
        
        if (is_dir($tempPath)) {
            $files = glob($tempPath . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }

    /**
     * Clear framework-specific cache directories
     */
    private function clear_framework_cache()
    {
        $cachePaths = [
            WRITEPATH . 'cache/',
            WRITEPATH . 'debugbar/',
            WRITEPATH . 'logs/',
            WRITEPATH . 'session/'
        ];

        foreach ($cachePaths as $path) {
            if (is_dir($path)) {
                $files = glob($path . '*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        @unlink($file);
                    }
                }
            }
        }
    }

    /**
     * Alternative method using CodeIgniter's cache service
     */
    public function alternative_cache_clear()
    {
        try {
            // Clear specific cache
            $cache = \Config\Services::cache();
            
            // Delete all cache items
            $cache->clean();

            // You can also delete specific cache items
            // $cache->delete('cache_key');

            return redirect()->back()->with('success', 'Cache cleared successfully');
        } catch (\Exception $e) {
            log_message('error', 'Cache clearing failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to clear cache');
        }
    }

    /**
     * DOWNLOAD SYSTEM LOGS
     */

     public function downloadSystemLogs()
     {
         // Path to the log directory
         $logPath = WRITEPATH . 'logs/';
         
         // Get the most recent log file
         $files = glob($logPath . '*.log');
         
         // Sort files by modification time, most recent first
         usort($files, function($a, $b) {
             return filemtime($b) - filemtime($a);
        });
     
         // Check if any log files exist
         if (empty($files)) {
             return $this->response->setStatusCode(404)
                                   ->setBody('No log files found');
         }
     
         // Get the most recent log file
         $logFile = $files[0];
         $fileName = basename($logFile);
         
     
         // Check file exists and is readable
         if (!file_exists($logFile) || !is_readable($logFile)) {
                 return $this->response->setStatusCode(403)
                                       ->setBody('Unable to read log file');
         }
            
          // Get file size
         $fileSize = filesize($logFile);
         
          // Send download headers
          return $this->response
              ->setHeader('Content-Type', 'text/plain')
              ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
              ->setHeader('Content-Length', $fileSize)
              ->setHeader('Cache-Control', 'no-cache')
              ->setContentType('text/plain')
              ->download($logFile);

        //  var_dump($fileSize);
     }

}
