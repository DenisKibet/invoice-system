<?php

namespace App\Models;

use CodeIgniter\Model;

class SuperAdminModel extends Model
{
    protected $table            = 'super_admin';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['super_admin_username', 'user_id' ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    protected $tenantAllowableFields = ['id','tenant_company_name', 'tenant_database_name', 'user_id', 'username'];

    // ==========================================================================================================
    //                                       SUPER-ADMIN DASHBOARD METHODS
    // ==========================================================================================================

    public function getTenants()
    {
        $builder = $this->db->table('companylists');

        // Select the allowed fields and get the results
        $builder->select($this->tenantAllowableFields);
        $query = $builder->get();

        // Return result set as an array of objects
        return $query->getResult();
    }

    public function countTenants()
    {
        $builder = $this->db->table('companylists');

        return $builder->countAllResults();
    }
    
    // GET TOTAL INVOICE ACROOS ALL THE TENANTS
    public function getTotalInvoiceCount()
    {
        $totalInvoices = 0;
    
        // Get all tenants from the companylists table
        $tenants = $this->getTenants();
    
        // Loop through each tenant
        foreach ($tenants as $tenant) {
            // Load the tenant configuration and set the database name dynamically
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;
    
            // Connect to the tenant's specific database using the modified tenant configuration
            $tenantDB = \Config\Database::connect($dbConfig, true);
    
            // Count all invoices in the tenant's invoices table
            $builder = $tenantDB->table('invoices');
            $invoiceCount = $builder->countAllResults(); // Get total number of rows in the 'invoices' table
    
            // Add the result to the total invoices count
            $totalInvoices += $invoiceCount;
    
            // Close the tenant DB connection to free up resources
            $tenantDB->close();
        }
    
        // Return the total invoices across all tenants
        return $totalInvoices;
    }

    public function getTotalPaidAmount()
    {
        $totalPaidAmount = 0;

        // Get all tenants from the companylists table
        $tenants = $this->getTenants();

        // Loop through each tenant
        foreach ($tenants as $tenant) {
            // Load the tenant configuration and set the database name dynamically
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;

            // Connect to the tenant's specific database using the modified tenant configuration
            $tenantDB = \Config\Database::connect($dbConfig, true);

            // Sum the 'paid' column in the tenant's invoices table
            $builder = $tenantDB->table('invoices');
            $paidAmount = $builder->selectSum('paid')->get()->getRow()->paid; // Sum of 'paid' column

            // Add the result to the total paid amount
            $totalPaidAmount += $paidAmount;

            // Close the tenant DB connection to free up resources
            $tenantDB->close();
        }

        // Return the total paid amount across all tenants
        return $totalPaidAmount;
    }
    
    public function getTotalUsersExcludingSuperAdmins()
    {
        // Build the query to count users excluding those in the super_admin table
        $builder = $this->db->table('users');
        
        $builder->select('users.username, users.id')
            ->join('super_admin', 'users.id = super_admin.user_id', 'left')
            ->where('super_admin.user_id IS NULL'); // Exclude users in super_admin table

        // Use countAllResults() to get the count of rows matching the condition
        $totalUsers = $builder->countAllResults();

        return $totalUsers;
    }

    // GET TOTAL INVOICE COUNT PER COMPANY
    public function getTotalInvoiceCountPerCompany()
    {
        $invoiceCounts = [];
        $tenants = $this->getTenants();
        
        foreach ($tenants as $tenant) {
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;
        
            $tenantDB = \Config\Database::connect($dbConfig, true);
            
            $builder = $tenantDB->table('invoices');
            $invoiceCount = $builder->countAllResults();
            
            // Use tenant_database_name as the key
            $invoiceCounts[$tenant->tenant_database_name] = $invoiceCount;
        
            $tenantDB->close();
        }
        
        return $invoiceCounts;
    }

    // GET TOTAL USERS PER COMPANY
    public function getTotalUsersCountPerCompany()
    {
        // Initialize an array to hold the user counts per company
        $userCounts = [];

        // Get tenants data from getTenants methods
        $tenants = $this->getTenants();

        // Loop through the company data
        foreach ($tenants as $tenant) {            // Initialize the user count for this company
            $userCount = 0;

            // Get the total count of users with the same user ID as the company or any IDs in the agents table
            $userBuilder = $this->db->table('users');
            $userBuilder->select('COUNT(*) as user_count')
                ->where('users.id', $tenant->user_id)
                ->orWhereIn('users.id', function ($query) use ($tenant) {
                    $query->select('agents.agent_id')
                        ->from('agents')
                        ->where('agents.user_id', $tenant->user_id);
                });
            $userCount = $userBuilder->get()->getRow()->user_count;

            // Add the user count to the array
            $userCounts[] = (object)[
                'tenant_company_name' => $tenant->tenant_company_name,
                'total_users' => $userCount
            ];
        }

        // Return the user counts per company
        return $userCounts;
    }

    // GET TOTAL USERS PER COMPANY
    public function getEachCompanyCurrentStatus()
    {
        // Get all tenants from the companylists table
        $tenants = $this->getTenants();

        $companyStatus = [];

        foreach ($tenants as $tenant) {
            // Get the latest subscription
            $latestSubscription = $this->db->table('system_subscriptions')
                ->where('company_id', $tenant->id)
                ->orderBy('id', 'DESC')  // Use orderBy with 'DESC'
                ->get()
                ->getFirstRow();

            // Get the latest payment
            $latestPayment = $this->db->table('system_rent_subscriptions_payment')
                ->where('company_id', $tenant->id)
                ->orderBy('id', 'DESC')  // Use orderBy with 'DESC'
                ->get()
                ->getFirstRow();

            // Default status
            $subscriptionStatus = $latestSubscription->subscription_status ?? 'N/A';
            $paymentStatus = $latestPayment->status ?? 'N/A';

            // Connect to tenant's database
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;
            $tenantDB = \Config\Database::connect($dbConfig, true);

            // Count invoices in the tenant's invoices table
            $invoiceCount = $tenantDB->table('invoices')->countAllResults();

            // Check subscription status and invoice count
            if ($subscriptionStatus !== 'active') {
                $subscriptionStatus = ($invoiceCount < 0) ? 'active' : 'pending';
            }

            // Store the status per company
            $companyStatus[$tenant->tenant_company_name] = [
                'subscription_status' => $subscriptionStatus,
                'payment_status' => $paymentStatus,
                'invoice_count' => $invoiceCount,
            ];

            // Close the tenant DB connection to free up resources
            $tenantDB->close();
        }

        return $companyStatus;
    }

    public function viewTenatDetails($tenantId)
    {
        $builder = $this->db->table('system_subscriptions');
        $tenantSubscriptionDetails = $builder->select('*')
                ->join('system_rent_subscriptions_payment', 'payment_id = system_rent_subscriptions_payment.id', 'left')
                ->where('system_subscriptions.company_id', $tenantId)
                ->get()
                ->getResult();
    
        return $tenantSubscriptionDetails;
    }

     public function deletetenant($tenantId, $tenantDatabase)
     {
        //  Get admin Id 
        $adminID =  explode("_", $tenantDatabase)[1];

        try {
             // Drop the database
             $db = \Config\Database::connect();
             $sql = "DROP DATABASE IF EXISTS `{$tenantDatabase}`";
             $db->query($sql);

             $builder = $this->db->table('companylists');

             $builder->select('*')
                     ->where('tenant_database_name',$tenantDatabase)
                     ->delete();

            // Step 1: Delete agents where user_id matches adminID
            $agentIDs = $this->db->table('agents')
            ->select('agent_id')
            ->where('user_id', $adminID)
            ->get()
            ->getResultArray();

            // Extract agent IDs
            $agentIDsArray = array_column($agentIDs, 'agent_id');

            // Step 2: Delete users where id matches the fetched agent IDs
            if (!empty($agentIDsArray)) {
            $this->db->table('users')
            ->whereIn('id', $agentIDsArray)
            ->delete();
            }

            // Step 3: Delete the admin user from the users table
            $this->db->table('users')
            ->where('id', $adminID)
            ->delete();

            // NB there other user details in the aduth identities tables is deleted automacally
             return true;
         } catch (\Exception $e) {
             log_message('error', 'Tenant database deletion failed: ' . $e->getMessage());
             return false;
         }
     }

    // ================================================================================================
    //                                     TENANT SECTION METHODS
    // ================================================================================================

    public function getCompanyDetails()
    {
        $tenants = $this->getTenants();
        $allCompanyDetails = []; 
       
    
        foreach ($tenants as $tenant) {
            // Conncet to main db a get the start and end dates for the subdcription
            $builder= $this->db->table(' system_subscriptions');
            $subscriptionDates = $builder->select('start_date, end_date')
                                         ->where('company_id', $tenant->id)
                                         ->get()
                                         ->getResult();

                                         
            // Commect to tenant specific by looping through 
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;
    
            $tenantDB = \Config\Database::connect($dbConfig, true);
    
            $builder = $tenantDB->table('companies');
            $companyDetails = $builder->get()->getResult();
    
            // Append tenant ID as a prefix to company ID
            foreach ($companyDetails as $company) {
                $company->global_id = $tenant->id . '-' . $company->id;
            }
    
            $allCompanyDetails[$tenant->id] = [
                'companies'         => $companyDetails,
                'subscriptiondates' => $subscriptionDates
            ];
            $tenantDB->close();
        }
        return $allCompanyDetails;
    }
    

    function getTenantsEmails($companyId , $tenantDatabase ) 
    {
        $result = [];
    
        // Get admin email
        $builder = $this->db->table('auth_identities');
        $adminEmail = $builder->select('secret as email')
                              ->where('user_id', $companyId)
                              ->where('auth_identities.type', 'email_password')
                              ->get()
                              ->getResult();
    
        $result['adminEmail'] = $adminEmail;
    
        // Get users' emails
        $builder = $this->db->table('agents');
        $usersEmails = $builder->select('agent_id as id, secret as email')
                               ->where('agents.user_id', $companyId)
                               ->join('auth_identities', "agents.agent_id = auth_identities.user_id AND auth_identities.type = 'email_password'")
                               ->get()
                               ->getResult();
    
        $result['usersEmails'] = $usersEmails;
    
        // Connect to tenant database
        $dbConfig = config('Database')->tenant;
        $dbConfig['database'] = $tenantDatabase;
    
        try {
            $tenantDB = \Config\Database::connect($dbConfig, true);
    
            // Get company email
            $builder = $tenantDB->table('companies');
            $companyEmail = $builder->select('email')->get()->getResult();
            $result['companyEmail'] = $companyEmail;
    
            // Get clients' emails
            $builder = $tenantDB->table('clients');
            $clientEmail = $builder->select('EmailAddress as email')->get()->getResult();
            $result['clientEmail'] = $clientEmail;
    
        } catch (\Exception $e) {
            // Handle connection error or query error
            $result['error'] = $e->getMessage();
        }
    
        return $result;
    }
    
//     ====================================================================================================
//                                             INVOICE SECTION METHOD
//     ====================================================================================================

    public function getTotalPaidInvoiceCount()
    {
        $totalPaidCount = 0;
        $totalPaidAmount = 0;

        $tenants = $this->getTenants();
        
        foreach ($tenants as $tenant) {
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;
            
            $tenantDB = \Config\Database::connect($dbConfig, true);

            $builder = $tenantDB->table('invoices');
            $builder->select('COUNT(*) as count, COALESCE(SUM(paid), 0) as total_paid');
            $builder->where('balance', 0);
            $query = $builder->get();
            $result = $query->getRow();

            // Accumulate counts and totals from each tenant
            $totalPaidCount += (int)$result->count;
            $totalPaidAmount += (float)$result->total_paid;

            $tenantDB->close();
        }

        // Return the total count and formatted total paid amount
        return [
            'count' => $totalPaidCount,
            'total_paid' => number_format($totalPaidAmount, 2, '.', '')
        ];
    }

    public function getTotalOverdueInvoice()
    {
        $totalOverdueCount = 0;
        $totalOverdueAmount = 0;
    
        $tenants = $this->getTenants();
        $currentDate = date('Y-m-d');
    
        foreach ($tenants as $tenant) {
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;
    
            // Connect to the tenant's database
            $tenantDB = \Config\Database::connect($dbConfig, true);
    
            // Ensure we're querying on the tenant's database
            $builder = $tenantDB->table('invoices');
            $builder->select('COUNT(*) as count, COALESCE(SUM(total), 0) as total_amount');
            $builder->where('STR_TO_DATE(due_date, "%d/%m/%Y") <', $currentDate);
            $builder->where('balance >', 0);
            $query = $builder->get();
            $result = $query->getRow();
    
            // Accumulate counts and totals from each tenant
            $totalOverdueCount += (int)$result->count;
            $totalOverdueAmount += (float)$result->total_amount;
    
            // Close the tenant DB connection
            $tenantDB->close();
        }
    
        // Return the total overdue count and formatted overdue amount across all tenants
        return [
            'count' => $totalOverdueCount,
            'total_amount' => number_format($totalOverdueAmount, 2, '.', '')
        ];
    }
    
    public function getTotalPartiallyPaidInvoice()
    {
        $totalPartiallyPaidCount = 0;
        $totalPartiallyPaidAmount = 0;
    
        $tenants = $this->getTenants();
        $currentDate = date('Y-m-d');
    
        foreach ($tenants as $tenant) {
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;
    
            // Connect to the tenant's database
            $tenantDB = \Config\Database::connect($dbConfig, true);
    
            // Ensure we're querying on the tenant's database
            $builder = $tenantDB->table('invoices');
            $builder->select('COUNT(*) as count, COALESCE(SUM(paid), 0) as total_paid, COALESCE(SUM(balance), 0) as total_balance');
            $builder->where('balance >', 0);
            $builder->where('paid >', 0);
            $query = $builder->get();
            $result = $query->getRow();
    
            // Accumulate counts and totals from each tenant
            $totalPartiallyPaidCount += (int)$result->count;
            $totalPartiallyPaidAmount += (float)$result->total_balance;
    
            // Close the tenant DB connection
            $tenantDB->close();
        }
    
        // Return the total overdue count and formatted overdue amount across all tenants
        return [
            'count' => $totalPartiallyPaidCount,
            'total_amount' => number_format($totalPartiallyPaidAmount, 2, '.', '')
        ];
    }

    public function getSingleInvoiceDetails()
    {
        $invoicesByCompany = [];
        $tenants = $this->getTenants();

        foreach ($tenants as $tenant) {
            // Configure the tenant database
            $dbConfig = config('Database')->tenant;
            $dbConfig['database'] = $tenant->tenant_database_name;

            // Connect to the tenant's database
            $tenantDB = \Config\Database::connect($dbConfig, true);

            // Query to fetch invoice details
            $builder = $tenantDB->table('invoices');
            $builder->select([
                'invoices.invoice_no',
                'invoices.invoice_date',
                'invoices.due_date',
                'invoices.total',
                'invoices.created_at',
            ]);
            
            // Store results with company identification
            $results = $builder->get()->getResult();
            
            $invoicesByCompany[$tenant->tenant_database_name] = [
                'company_name' => $tenant->tenant_company_name,
                'invoices' => $results
            ];

            $tenantDB->close();
        }

        return $invoicesByCompany;
    }
    
    /**
     *  USESRS SECTION METHODS
     */

     public function getNewUsersForCurrentMonth()
     {

         $builder = $this->db->table('users');
        
         $builder->select('users.username, users.id')
             ->join('super_admin', 'users.id = super_admin.user_id', 'left')
             ->where('super_admin.user_id IS NULL') // Exclude users in super_admin table
             ->where('MONTH(users.created_at)', date('m')) // Filter by current month
             ->where('YEAR(users.created_at)', date('Y')); // Filter by current year

 
         $totalUsers = $builder->countAllResults();
 
         return $totalUsers;
         
     }

    //  get Active usesr
    public function getActiveUsers($inactivityThreshold = 10)
    {
        $builder = $this->db->table('users');
        $currentTime = time();

        $activeUsers = $builder->where('last_active >=', date('Y-m-d H:i:s', $currentTime - ($inactivityThreshold * 60)))
            ->countAllResults();
    
        return $activeUsers;
    }

    public function getUserList()
    {
        $tenants = $this->getTenants();
        $results = [];
        $userByCompany = [];
        
        foreach ($tenants as $tenant) {
            $userBuilder = $this->db->table('users');
            $userBuilder->select('users.*, auth_identities.secret as email, agents.agent_id')
                ->join('auth_identities', "users.id = auth_identities.user_id AND auth_identities.type = 'email_password'", 'left')
                ->join('agents', 'users.id = agents.agent_id', 'left')
                ->where('users.id', $tenant->user_id)
                ->orWhereIn('users.id', function ($query) use ($tenant) {
                    $query->select('agents.agent_id')
                        ->from('agents')
                        ->where('agents.user_id', $tenant->user_id);
                });
                
            $users = $userBuilder->get()->getResult();
            
            // Assign roles based on agent_id
            foreach ($users as $user) {
                $user->role = $user->agent_id ? 'Agent' : 'Admin';
                unset($user->agent_id); // Remove the agent_id from the result
            }
            
            $results = array_merge($results, $users);
            $userByCompany[$tenant->tenant_database_name] = [
                'company_name' => $tenant->tenant_company_name,
                'users'        => $users

            ];
        }
        
        return $userByCompany;
    }

    public function getActiveUsersForEveryUser($inactivityThreshold = 10)
    {
        $builder = $this->db->table('users');
        $currentTime = time();

        $activeUsers = $builder->where('last_active >=', date('Y-m-d H:i:s', $currentTime - ($inactivityThreshold * 60)))
            ->countAllResults();
    
        return $activeUsers;
    }

     
    /**
     *  SETTINGS SECTION METHODS
     */

    /**
     * Get comprehensive system status
     * 
     * @return array Detailed system status information
     */
    public function get_memory_usage()
    {
        // Memory usage calculation
        $current_memory = memory_get_usage();
        $memory_limit = ini_get('memory_limit');
        $memory_limit_bytes = $this->convert_memory_to_bytes($memory_limit);
        
        // Calculate memory usage percentage
        $memory_percentage = round(($current_memory / $memory_limit_bytes) * 100, 2);
        
        // Determine memory status
        $memory_status = $this->get_status($memory_percentage);
        
        // Convert to more readable formats
        $current_memory_mb = round($current_memory / 1024 / 1024, 2);
        $peak_memory_mb = round(memory_get_peak_usage() / 1024 / 1024, 2);
        
        // Simulate CPU and Storage usage for complete system status
        return [
            'memory' => [
                'percentage' => $memory_percentage,
                'current_mb' => $current_memory_mb,
                'peak_mb' => $peak_memory_mb,
                'limit' => $memory_limit,
                'status' => $memory_status
            ],
            'cpu' => [
                'percentage' => $this->simulate_cpu_usage(),
                'status' => $this->get_status($this->simulate_cpu_usage())
            ],
            'storage' => [
                'percentage' => $this->simulate_storage_usage(),
                'status' => $this->get_status($this->simulate_storage_usage())
            ]
        ];
    }

    /**
     * Simulate CPU usage (for demonstration)
     * 
     * @return float Simulated CPU usage percentage
     */
    private function simulate_cpu_usage()
    {
        // Simulate CPU usage between 20-60%
        return rand(20, 60);
    }

    /**
     * Simulate storage usage (for demonstration)
     * 
     * @return float Simulated storage usage percentage
     */
    private function simulate_storage_usage()
    {
        // Simulate storage usage between 40-80%
        return rand(40, 80);
    }

    /**
     * Convert memory limit string to bytes
     * 
     * @param string $memory_limit Memory limit string
     * @return int Memory limit in bytes
     */
    private function convert_memory_to_bytes($memory_limit)
    {
        $memory_limit = trim($memory_limit);
        $last = strtolower($memory_limit[strlen($memory_limit)-1]);
        $numeric_value = (int)$memory_limit;
        
        switch($last) {
            case 'g':
                $numeric_value *= 1024 * 1024 * 1024;
                break;
            case 'm':
                $numeric_value *= 1024 * 1024;
                break;
            case 'k':
                $numeric_value *= 1024;
                break;
        }
        
        return $numeric_value;
    }

    /**
     * Determine status based on usage percentage
     * 
     * @param float $percentage Usage percentage
     * @return array Status details
     */
    private function get_status($percentage)
    {
        if ($percentage < 50) {
            return [
                'status' => 'low',
                'class' => 'text-success',
                'bar_class' => 'bg-success'
            ];
        } elseif ($percentage < 75) {
            return [
                'status' => 'medium',
                'class' => 'text-warning',
                'bar_class' => 'bg-warning'
            ];
        } else {
            return [
                'status' => 'high',
                'class' => 'text-danger',
                'bar_class' => 'bg-danger'
            ];
        }
    }


      
    /**
     *  REPORST SECTION METHODS
     */
    public function getYears()
    {
        $tenants = $this->getTenants();
        $allYears = [];
        
        foreach ($tenants as $tenant) {
            try {
                // Load the tenant configuration and set the database name dynamically
                $dbConfig = config('Database')->tenant;
                $dbConfig['database'] = $tenant->tenant_database_name;
        
                // Connect to the tenant's specific database
                $tenantDB = \Config\Database::connect($dbConfig, true);
                
                // Build and execute query for distinct years
                $builder = $tenantDB->table('invoices');
                $builder->select('DISTINCT YEAR(created_at) as year')
                       ->orderBy('year', 'DESC');
                
                $query = $builder->get();
                $years = array_map(function($row) {
                    return $row->year;
                }, $query->getResult());
                
                // Merge years from this tenant with existing years
                $allYears = array_merge($allYears, $years);
                
                // Close the tenant DB connection
                $tenantDB->close();
                
            } catch (\Exception $e) {
                log_message('error', 'Failed to get years for tenant ' . $tenant->tenant_database_name . ': ' . $e->getMessage());
                continue; // Skip to next tenant if there's an error
            }
        }
        
        // Remove duplicates and sort in descending order
        $allYears = array_unique($allYears);
        rsort($allYears);
        
        return $allYears;
    }
    
    public function getYearlyRevenue(int $selectedYear = null)
    {
        // If no year is selected, use the current year
        $selectedYear = $selectedYear ?? date('Y');
        $currentMonth = date('m');
    
        // Initialize variables to track total revenue
        $totalYearlyRevenue = 0;
        $previousMonthRevenue = 0;
    
        // Build query to get revenue for the selected year
        $builder = $this->db->table('system_rent_subscriptions_payment');
        $builder->select('SUM(amount) as total_revenue')
                ->where('YEAR(created_at)', $selectedYear);
        $query = $builder->get();
        $result = $query->getRow();
        $totalYearlyRevenue = (float) $result->total_revenue;
    
        // Build query to get revenue for the previous month
        $builder = $this->db->table('system_rent_subscriptions_payment');
        $builder->select('SUM(amount) as total_revenue')
                ->where('YEAR(created_at)', $selectedYear)
                ->where('MONTH(created_at)', $currentMonth - 1);
        $query = $builder->get();
        $prevMonthResult = $query->getRow();
        $previousMonthRevenue = (float) $prevMonthResult->total_revenue;
    
        // Prepare comprehensive revenue report
        $revenueReport = [
            'year' => $selectedYear,
            'total_revenue' => $totalYearlyRevenue,
            'previous_month_revenue' => $previousMonthRevenue,
        ];
    
        return $revenueReport;
    }
    
    // THE METHOD ONLY ACCOUNTED FOR PAID SUBSCRIPTIONS ONLY
    public function getCurrentlyActiveTenants(int $selectedYear = null)
    {
        
        // If no year is selected, use the current year
        $selectedYear = $selectedYear ?? date('Y');
        $currentMonth = date('m');
        $currentDate = date('Y-m-d');

        // Initialize variables to track total revenue
        $totalYearlyRevenue = 0;
        $previousMonthRevenue = 0;

        // Query to count active subscriptions (with end_date in the future)
        $builder = $this->db->table('system_subscriptions');
        $builder->select('COUNT(*) as active_subscriptions')
                ->where('YEAR(created_at)', $selectedYear)
                ->where('end_date >', $currentDate);
        $query = $builder->get();
        $result = $query->getRow(); // Retrieve the first result as an object

        // Check if a result is returned and extract the count
        $activeSubscriptions = $result->active_subscriptions ?? 0;


        
        // Query to count active subscriptions for previous month (with end_date in the future)
        $builder = $this->db->table('system_subscriptions');
        $builder->select('COUNT(*) as active_subscriptions')
                ->where('YEAR(created_at)', $selectedYear)
                ->where('MONTH(created_at)', $currentMonth - 1)
                ->where('end_date >', $currentDate);
        $query = $builder->get();
        $result = $query->getRow(); // Retrieve the first result as an object
        $previousMonthActiveSubscriptions = $result->active_subscriptions ?? 0;



        // Output for debugging
        // var_dump($previousMonthActiveSubscriptions);

        $activeSubscriptionReport = [
            'total_current_active' => $activeSubscriptions,
            'total_active_subscription_as_at_lastmonth' => $previousMonthActiveSubscriptions,
        ];

        return $activeSubscriptionReport;

    }


    public function getPlansSummery()
    {
            // If no year is selected, use the current year
            $selectedYear = $selectedYear ?? date('Y');
            $currentDate = date('Y-m-d');
            $monthlyPlanType = 'monthly';
            $yearlyPlanType = 'yearly';

            // Get total monthly subscription
            $builder = $this->db->table('system_subscriptions');
            $builder->select('COUNT(*) as monthly_subscriptions')
                    ->where('YEAR(created_at)', $selectedYear)
                    ->where('subscription_duration', $monthlyPlanType)
                    ->where('end_date >', $currentDate);
            $query = $builder->get();
            $result = $query->getRow(); // Retrieve the first result as an object
            $monthlySubscriptionCount = $result->monthly_subscriptions ?? 0;
            
            
            
            // Get total Yearly subscription
            $builder = $this->db->table('system_subscriptions');
            $builder->select('COUNT(*) as yearly_subscriptions')
                    ->where('YEAR(created_at)', $selectedYear)
                    ->where('subscription_duration', $yearlyPlanType)
                    ->where('end_date >', $currentDate);
            $query = $builder->get();
            $result = $query->getRow(); // Retrieve the first result as an object
            $yearlySubscriptionCount = $result->yearly_subscriptions ?? 0;
            
            // Get total subscription (weather monthly or yearly)
            $builder = $this->db->table('system_subscriptions');
            $builder->select('COUNT(*) as total_subscriptions')
                    ->where('YEAR(created_at)', $selectedYear)
                    // ->where('subscription_duration', $yearlyPlanType)
                    ->where('end_date >', $currentDate);
            $query = $builder->get();
            $result = $query->getRow(); // Retrieve the first result as an object
            $SubscriptionCount = $result->total_subscriptions ?? 0;
            

            $subscriptionSummery = [
                'subcription_count' => $SubscriptionCount,
                'monthly_subscription_count' => $monthlySubscriptionCount,
                'yearly_subscription_count' => $yearlySubscriptionCount,
            ];

            return $subscriptionSummery;
            
    }

    public function getDataForLineGraph(int $selectedYear = null)
    {
        $selectedYear = $selectedYear ?? date('Y');

        $builder = $this->db->table('system_rent_subscriptions_payment');
        $builder->select('YEAR(created_at) AS year, MONTHNAME(created_at) AS month, COUNT(*) AS count');
        $builder->select("DATE_FORMAT(created_at, '%M') AS month_name", false);
        $builder->select("SUM(CAST(REPLACE(amount, '£', '') AS DECIMAL(10,2))) AS total_amount", false);

        if (!empty($selectedYear)) {
            $builder->where("YEAR(created_at)", $selectedYear);
        }
        
        $builder->groupBy('year, month');
        $builder->orderBy('id', 'DESC');
        
        $result = $builder->get()->getResult();

        return $result;
    }
    
    function getDataForPieChart(int $selectedYear = null)
    {
        $selectedYear = $selectedYear ?? date('Y');
     
        $builder = $this->db->table('system_subscriptions');
    
        $builder->select('plan_name, subscription_duration, COUNT(*) AS count');
        $builder->where("YEAR(created_at)", $selectedYear);
        $builder->groupBy('plan_name, subscription_duration');
    
        $results = $builder->get()->getResult();
    
        // Organize data for pie chart
        $planData = [
            'Monthly Basic' => 0,
            'Monthly Shopify' => 0,
            'Monthly Advance' => 0,
            'Yearly Basic' => 0,
            'Yearly Shopify' => 0,
            'Yearly Advance' => 0
        ];
    
        foreach ($results as $row) {
            $key = ucfirst(strtolower(trim($row->subscription_duration))) . ' ' . ucfirst(strtolower(trim($row->plan_name)));
            if (array_key_exists($key, $planData)) {
                $planData[$key] = $row->count;
            }
        }
        
    
        return $planData;
    }

    public function getDataForBarChart(int $selectedYear = null)

    {
       
        $selectedYear = $selectedYear ?? date('Y');
     
        // $builder = $this->db->table('system_subscriptions');
    
        // $builder->select('plan_name, subscription_duration, COUNT(*) AS count');
        // $builder->where("YEAR(created_at)", $selectedYear);
        // $builder->groupBy('plan_name, subscription_duration');
    
        // $results = $builder->get()->getResult();
    
        // // Organize data for pie chart
        // $planData = [
        //     'Monthly Basic' => 0,
        //     'Monthly Shopify' => 0,
        //     'Monthly Advance' => 0,
        //     'Yearly Basic' => 0,
        //     'Yearly Shopify' => 0,
        //     'Yearly Advance' => 0
        // ];
    
        // foreach ($results as $row) {
        //     $key = ucfirst(strtolower(trim($row->subscription_duration))) . ' ' . ucfirst(strtolower(trim($row->plan_name)));
        //     if (array_key_exists($key, $planData)) {
        //         $planData[$key] = $row->count;
        //     }
        // }
        
        // return $planData;
    }

    public function getDataForDoughnut(int $selectedYear = null)
    {
        $selectedYear = $selectedYear ?? date('Y');
     
        $builder = $this->db->table('system_subscriptions');
    
        $builder->select('end_date, COUNT(*) AS count');
        $builder->where("YEAR(created_at)", $selectedYear);
    
        $results = $builder->get()->getResult();
    
        // Organize data for doughnut chart
        $planData = [
            'Active' => 0,
            'Expiring Soon' => 0,
            'Cancelled' => 0
        ];
    
        $currentDate = new \DateTime();
    
        foreach ($results as $result) {
            $endDate = new \DateTime($result->end_date);
            $dateDiff = $currentDate->diff($endDate);
    
            if ($dateDiff->invert) {
                // Subscription has already ended (Cancelled)
                $planData['Cancelled'] += $result->count;
            } elseif ($dateDiff->days <= 7) {
                // Subscription is expiring soon (within 7 days)
                $planData['Expiring Soon'] += $result->count;
            } else {
                // Subscription is active
                $planData['Active'] += $result->count;
            }
        }
    
        return $planData;
    }

    public function getSubscriptionDataForTable()
    {
        $builder = $this->db->table(' system_subscriptions');

        $builder->select('plan_name, subscription_duration, start_date, end_date, subscription_status, amount, tenant_company_name')
                ->join('system_rent_subscriptions_payment', 'system_subscriptions.payment_id = system_rent_subscriptions_payment.id', 'left')
                ->join('companylists', 'system_subscriptions.payment_id = companylists.id', 'left'); 

        $subscriptionDetails = $builder->get()->getResult();

        return $subscriptionDetails;
    }

    public function getLastMonthIncome($selectedYear)
    {
        // If no year is selected, use the current year
        $selectedYear = $selectedYear ?? date('Y');
        $currentMonth = date('m');
        
        // Calculate the previous month and year
        if ($currentMonth == 1) {
            // If current month is January, previous month is December of last year
            $previousMonth = 12;
            $yearForPreviousMonth = $selectedYear - 1;
        } else {
            $previousMonth = $currentMonth - 1;
            $yearForPreviousMonth = $selectedYear;
        }
    
        // Build query to get revenue for the previous month
        $builder = $this->db->table('system_rent_subscriptions_payment');
        $builder->select('SUM(amount) as total_revenue')
                ->where('YEAR(created_at)', $yearForPreviousMonth)
                ->where('MONTH(created_at)', $previousMonth);
        
        $query = $builder->get();
        $prevMonthResult = $query->getRow();
        $previousMonthRevenue = (float) $prevMonthResult->total_revenue;
    
        // Build query to get revenue for the current month
        $currentMonthBuilder = $this->db->table('system_rent_subscriptions_payment');
        $currentMonthBuilder->select('SUM(amount) as total_revenue')
                           ->where('YEAR(created_at)', $selectedYear)
                           ->where('MONTH(created_at)', $currentMonth);
        
        $currentQuery = $currentMonthBuilder->get();
        $currentMonthResult = $currentQuery->getRow();
        $currentMonthRevenue = (float) $currentMonthResult->total_revenue;
    
        $revenueReport = [
            'year' => $selectedYear,
            'previous_month_revenue' => $previousMonthRevenue,
            'previous_month' => $previousMonth,
            'previous_month_year' => $yearForPreviousMonth,
            'current_month_revenue' => $currentMonthRevenue,
            'current_month' => $currentMonth,
            'current_year' => $selectedYear
        ];
        
        return $revenueReport;
    }

    public function getLastMonthBalance($selectedYear)
    {
        // If no year is selected, use the current year
        $selectedYear = $selectedYear ?? date('Y');
        $currentMonth = date('m');
        
        // Calculate the previous month and year
        if ($currentMonth == 1) {
            $previousMonth = 12;
            $yearForPreviousMonth = $selectedYear - 1;
        } else {
            $previousMonth = $currentMonth - 1;
            $yearForPreviousMonth = $selectedYear;
        }
    
        // Get closing balance (all transactions up to end of last month)
        $closingBuilder = $this->db->table('system_rent_subscriptions_payment');
        $closingBuilder->select('SUM(amount) as total_amount')
                      ->where("created_at <= ", "$yearForPreviousMonth-$previousMonth-31 23:59:59");
        
        $closingQuery = $closingBuilder->get();
        $closingResult = $closingQuery->getRow();
        $closingBalance = (float) $closingResult->total_amount;
    
        // Get opening balance (all transactions up to current date)
        $openingBuilder = $this->db->table('system_rent_subscriptions_payment');
        $openingBuilder->select('SUM(amount) as total_amount')
                      ->where("created_at <= ", date('Y-m-d H:i:s'));
        
        $openingQuery = $openingBuilder->get();
        $openingResult = $openingQuery->getRow();
        $openingBalance = (float) $openingResult->total_amount;
    
        $balanceReport = [
            'year' => $selectedYear,
            'closing_balance' => $closingBalance,
            'closing_month' => $previousMonth,
            'closing_year' => $yearForPreviousMonth,
            'opening_balance' => $openingBalance,
            'current_month' => $currentMonth,
            'current_year' => $selectedYear
        ];
        
        return $balanceReport;
    }

   
}
