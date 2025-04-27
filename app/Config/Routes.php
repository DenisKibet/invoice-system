<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// app/Config/Routes.php

// Public home route
$routes->get('/', 'Auth\WelcomeController::index'); // Landing page
// navbar routes
$routes->get('pricing', 'Auth\WelcomeController::pricing');
$routes->get('resouces', 'Auth\WelcomeController::resouces');
$routes->get('features', 'Auth\WelcomeController::features');
// other informational pages
$routes->get('privacy-policy', 'Auth\WelcomeController::privacyPolicy');
$routes->get('terms-of-service', 'Auth\WelcomeController::termsOfService');
$routes->get('cookies-policy', 'Auth\WelcomeController::cookiesPolicy');
$routes->get('press-media', 'Auth\WelcomeController::pressAndMedia');
$routes->get('about-us', 'Auth\WelcomeController::aboutUs');
$routes->get('contact-us', 'Auth\WelcomeController::contactUs');
$routes->post('contact-us-now', 'Auth\WelcomeController::contactUsNow'); // contact us by sending us an email
$routes->get('documenation', 'Auth\WelcomeController::documenation'); // documentation page
// Newsletter routes
$routes->post('newsletter/subscribe', 'Auth\WelcomeController::newLetterSubscription'); // new letter subscription
$routes->get('newsletter/verify/(:any)', 'Newsletter::verify/$1');
$routes->get('newsletter/unsubscribe/(:any)', 'Newsletter::unsubscribe/$1');

$routes->get('register', 'Auth\RegisterController::register', ['as' => 'register']);
$routes->post('register', 'Auth\RegisterController::attemptRegister');
$routes->get('login', 'Auth\LoginController::login', ['as' => 'login']);
$routes->post('login', 'Auth\LoginController::attemptLogin');
$routes->get('logout', 'Auth\LoginController::logout'); //logout

// Protected routes
service('auth')->routes($routes, ['except' => ['register', 'login', 'logout']]);
$routes->get('profile', 'Auth\ProfileController::profile');

// $routes->get('home/addCompanyLater', 'Home::addCompanyLater');
$routes->get('/dashboard', 'Home::dashboard');
#========================================================
	#SIDE BAR TABLE
#========================================================

// creates-page 
$routes->get('/NewInvoice', 'Home::AddNewInvoice');
$routes->post('/savenewclient', 'Home::SaveNewLlient');
$routes->post('/invoiceListauto', 'Home::UserListAuto');
$routes->post('/invoiceItemauto', 'Home::ItemDescriptionListAuto');
$routes->post('/saveInvoice', 'Home::SaveInvoice');
$routes->post('/send-invoice-at-creation', 'Home::SendInvoiceAtCreation');
$routes->post('/send-estimate-at-preview', 'Home::SendEstimateAtPreview');
$routes->post('/send-estimate-at-creation', 'Home::SendEstimateAtCreation');
//View single invoice
// $routes->post('/getsingleinvoice', 'Home::GetSingleInvoice');
$routes->get('/getsingleinvoice', 'Home::GetSingleInvoice');
$routes->get('/preview-at-create-new-invoice', 'Home::InvoicePreviewAtCreate');
$routes->get('/preview', 'Home::InvoicePreview');
// estimate
$routes->get('/estimate-preview', 'Home::EstimatePreview');
$routes->get('/estimate-to-invoice-preview', 'Home::EstimateToInvoiCePreview');
$routes->get('/preview-at-create-new-estimate', 'Home::EstimatePreviewAtCreate');

// conert estimate to invoice page
$routes->get('/estimate-invoice-preview', 'Home::EstimateInvoicePreview');


$routes->get('/addpayment', 'Home::AddPayment');
$routes->get('/editpayment', 'Home::EditPayment');
$routes->post('/updatepayment', 'Home::UpdatePayment');
$routes->get('InvoiceSavepayment', 'Home::InvoiceSavepayment');
$routes->get('NEWCRM/Home/SendInvoice', 'Home::SendInvoice');
$routes->get('sendPaymentReminder', 'Home::SendPaymentReminder');

$routes->get('update-invoice', 'Home::UpdateInvoice');
$routes->get('load_transaction_detailsnew', 'Home::LoadTransactionDetails');
$routes->post('/deleteinvoice', 'Home::DeleteInvoice');
//View agent for that invoice
$routes->get('agentsingleinvoice', 'Home::AgentSingleInvoice');

//  PRINTING INVOICE
$routes->post('/preview-printinvoice/(:num)', 'Home::PreviewPrintinvoice/$1');
$routes->get('/print-invoice/(:num)', 'Home::PrintInvoice/$1');

// PRINTING ESTIMATE
$routes->post('preview-printestimate/(:num)', 'Home::PreviewPrintEstimate/$1');
$routes->get('print-estimate/(:num)', 'Home::PrintEstimate/$1');
// PRINTING ESTIMATE TO INVOICE
$routes->post('estimate-to-invoice-preview-print/(:num)', 'Home::EstimateTOInvoicePrintPeview/$1');
$routes->get('/print-estimate-as-invoice/(:num)', 'Home::PrintEstimateAsInvoice/$1');

$routes->get('/setComment', 'Home::SetComment');
$routes->post('/saveComment', 'Home::UpdateComment');

$routes->get('/setUpTerms', 'Home::SetUpTerms');
$routes->post('/updatedterms', 'Home::UpdatedTerms');

$routes->get('/setUpInvoiceComment', 'Home::SetUpInvoiceComment');
$routes->post('/save-invoice-statement', 'Home::UpdateInvoiceComment');

// After signup
$routes->get('/companyDetails', 'Home::SetCompanyDetails');
$routes->post('/save_company_details', 'Home::SaveCompany');
$routes->get('/companyList', 'Home::CompanyList'); 
$routes->post('/viewcompany', 'Home::ViewCompany'); 
$routes->post('/updateCompany', 'Home::UpdateCompany'); 
$routes->post('/deletecomapany', 'Home::DeleteComapany'); 

$routes->get('/financials', 'Home::Financials');

// items
$routes->get('/creatItem', 'Home::CreatItem');
$routes->post('/saveitem', 'Home::SaveItem'); 	
// bulk processing
$routes->post('/upload-items', 'Home::uploadItems'); 	
$routes->get('/download-template', 'Home::downloadTemplate'); 	


$routes->post('/saveNewItem', 'Home::SaveNewItem');// save new item at invoice creation
$routes->get('/ItemList', 'Home::ItemList');
$routes->get('/getsingleitem', 'Home::GetSingleItem');
$routes->post('/updateItem', 'Home::UpdateItem');
$routes->post('/updatesingleitem', 'Home::UpdateSingleItem');
$routes->post('/deleteSingleItem', 'Home::DeleteSingleItem');

//payment
$routes->get('/paymentInstruction', 'Home::PaymentInstruction');
$routes->post('/savePaymentIstructions', 'Home::SavePaymentIstructions');

// ESTIMATES
$routes->get('/CreateQuotation', 'Home::CreateQuotation'); // change quote to estimate
$routes->post('/saveEstimates', 'Home::SaveEstimate');
$routes->post('/update-estimate', 'Home::UpdateEstimate');
$routes->post('/getsinglestimate', 'Home::GetSingleEstimate');
$routes->get('/getsinglestimate', 'Home::GetSingleEstimate'); // For the same but get
$routes->get('/quoteList', 'Home::QuoteList'); // change to estimatelist
$routes->get('/convert-to-invoice', 'Home::ConvertToInvoice');
$routes->post('/save-estimate-as-invoice', 'Home::SaveEstimateAsInvoice');
$routes->post('/deleteestimate', 'Home::DeleteEstimate');

// inovices
$routes->get('/InvoiceList', 'Home::InvoiceList');

//clients
$routes->get('/CreateClient', 'Home::CreateClient'); 
$routes->post('/save_client', 'Home::SaveClient'); 
$routes->get('/clientList', 'Home::ClientList');
$routes->post('/getSingleClient', 'Home::GetSingleClient');
$routes->post('/updateClientDetails', 'Home::UpdateClientDetails');
$routes->post('/saveUpdatedClientDetails', 'Home::SaveUpdatedClientDetails');
$routes->post('/deleteclient', 'Home::DeleteClient');

// Users/Agents
$routes->get('create-agent', 'Home::CreateAgent');
$routes->post('save-agent', 'Home::SaveAgent');

//Staff
$routes->get('/stafflist', 'Home::Stafflist');
$routes->post('/view-staff-details', 'Home::GetStaffDetails');
$routes->post('/delete-staff', 'Home::deleteStaff');

// reset passsword
$routes->post('resetUserPassword', 'UserController::ResetUserPassword');
$routes->get('reset-password/(:segment)', 'UserController::HandlePasswordReset/$1');
$routes->get('set-new-password', 'UserController::SetNewPassword');
$routes->post('set-new-password', 'UserController::setNewPassword');

// expenses
// $routes->get('/expenseList', 'Home::expenseList');

// reports
$routes->get('/reportlist', 'Home::reportlist');
$routes->get('/get_client_details', 'Home::GetClientDetails');
$routes->get('/reportlistsearch', 'Home::reportlistsearch');
$routes->get('/reportlistgenerate', 'Home::reportlistgenerate');
$routes->get('/InvoiceListunpaid', 'Home::invoice_listunpaid');
$routes->get('/printinvoice', 'Home::PrintInvoice');

// generte pdf // invoice
$routes->get('pdf-view', 'Home::GeneratePdf'); 
$routes->get('generatePdf', 'Home::GeneratePdf');

// generate pdf // estimate
// $routes->get('estimate-pdf-view-', 'Home::generateEstimatePdf'); 
$routes->get('estimate-pdf-view', 'Home::GenerateEstimatePdf'); 


$routes->get('Logout', 'Home::Logout');
// $routes->get('emailtest', 'Home::emailtest');

//payment stuff
$routes->get('expiry-alert-modol', 'Home::ShowExpiryModol');
$routes->get('plans-list', 'Home::PurchaseList');
$routes->get('plan-payment', 'Home::PlanPayment');
$routes->post('initiate-plan-payment', 'Home::InitiatePlanPayment');
$routes->post('initiate-plan-payment-from-dashboard', 'Home::InitiatePlanPayment');
$routes->get('plan-payment/(:segment)', 'Home::PlanPayment/$1');
$routes->post('process-payment', 'Home::ProcessPayment');
$routes->get('payment-success', 'Home::success');

// Learning stripe
// $routes->get('payment/create-checkout-session', 'PaymentController::createCheckoutSession');
// $routes->get('payment/success', 'PaymentController::success');
// $routes->get('payment/cancel', 'PaymentController::cancel');
// $routes->get('payment/webhook', 'PaymentController::handleWebhook');
// $routes->post('payment/webhook', 'PaymentController::handleWebhook');
// $routes->post('payment/webhook', 'WebhookController::handleWebhook', ['filter' => 'webhook']);
// $routes->post('process-payment', 'Home::processPayment');

// payment erroen
$routes->get('payment-error', 'Home::paymentError');

// Social login: Google login
$routes->get('google/login', 'GoogleLoginController::login');
$routes->get('google/callback', 'GoogleLoginController::callback');

// ============================================//
			// Super_Admin Controller
// ============================================//

$routes->get('super-admin-dashboard', 'Auth\SuperAdminController::index');
$routes->post('view-tenant-details', 'Auth\SuperAdminController::viewTenantDetails');
$routes->post('edit-tenant-details', 'Auth\SuperAdminController::editTenantDetails');
$routes->post('save-updated-tenant-details', 'Auth\SuperAdminController::updateTenantDetails');
$routes->post('delete-tenant-details', 'Auth\SuperAdminController::deleteTenantDetails');

$routes->get('super-admin-tenants', 'Auth\SuperAdminController::tenants');
$routes->get('get-tenant-emails', 'Auth\SuperAdminController::getEmails'); // get emails
$routes->get('get-all-email-per=tenant', 'Auth\SuperAdminController::getEmailsPerTenant'); // get tenats specific emails

$routes->get('super-admin-invoices', 'Auth\SuperAdminController::invoices');
$routes->post('super-admin-invoices/view', 'Auth\SuperAdminController::viewInvoice');
$routes->post('super-admin-invoices/download', 'Auth\SuperAdminController::downloadInvoice');
$routes->post('super-admin-invoices/delete', 'Auth\SuperAdminController::deleteInvoice');

$routes->get('super-admin-users', 'Auth\SuperAdminController::users');
$routes->post('super-admin-users/get-user-details', 'Auth\SuperAdminController::getUserDetails');
$routes->post('super-admin-users/delete-user', 'Auth\SuperAdminController::deleteUser');

$routes->get('super-admin-settings', 'Auth\SuperAdminController::settings');
$routes->get('super-admin-reports', 'Auth\SuperAdminController::reports');
$routes->get('clear-cache', 'Auth\SuperAdminController::clear_cache'); //clear-cache
$routes->get('download-logs', 'Auth\SuperAdminController::downloadSystemLogs'); //download system logs