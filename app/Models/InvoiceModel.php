<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseConnection;

class InvoiceModel extends Model
{
    protected $table            = 'invoices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'invoice_no','client_name', 'email','status', 'comment', 'payment_instruction', 'invoice_date', 
        'terms', 'due_date', 'subtotal', 'discount', 'total', 'paid', 'payment_method', 'balance', 'netprice', 
        'profit_loss','items_total','from_estimates','deposit_amount', 'payment_reminder','recurring_invoice','username'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
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

     // Constructor
     public function __construct()
     {
        parent::__construct();

        // Initialize tenant tracker
        $tenantTracker = service('tenantTracker');
        $tenantId = session()->get('tenant_id');

        if ($tenantId) {
            $tenantTracker->setTenantId($tenantId);
            $dbConnection = $tenantTracker->setTenantDatabase(); // No parameter needed here
            $this->setDB($dbConnection);
        }
     }
 
     // Set database connection
     public function setDB(BaseConnection $db)
    {
    $this->db = $db;
    }

    //  Invoice methods
    public function getyears()
    {
        $builder = $this->db->table('invoices');
    
        $builder->select('YEAR(created_at) AS year');
        $query = $builder->get();
        $result = $query->getResult();
        $yearGroups = [];
    
        foreach ($result as $row) {
            $year = $row->year;
    
            if (!isset($yearGroups[$year])) {
                $yearGroups[$year] = [];
            }
    
            $yearGroups[$year][] = $row;
        }
    
        return $yearGroups;
    }
    



     function getbalance($year = "")
    {
        $totalBalance = 0.0;
        
        $builder = $this->db->table('invoices');
        $builder->select('balance');
        $builder->where('total IS NOT NULL');
        
        if (!empty($year)) {
            $builder->where("YEAR(created_at)", $year);
        }
        
        $query = $builder->get();
        
        if ($query->getResult()) {
            foreach ($query->getResult() as $row) {
                $balance = str_replace('£', '', $row->balance);
                $balance = floatval($balance);
                $totalBalance += $balance;
            }
        }
        
        return number_format($totalBalance, 2);
    }


     function gettotalyear($year)
    {
        $totalAmount = 0.0;

        $builder = $this->db->table('invoices');
        $builder->select('total');
        $builder->where("YEAR(created_at)", $year);
        $builder->where('total IS NOT NULL');
        
        $query = $builder->get();

        if ($query->getResult()) {
            foreach ($query->getResult() as $row) {
                $total = str_replace('£', '', $row->total);
                $total = floatval($total);
                $totalAmount += $total;
            }
        }

        return number_format($totalAmount, 2);
    }

    function getActiveMonths($year = "") {
        $builder = $this->db->table('invoices');
        $builder->select('DISTINCT MONTH(created_at) as month');
        
        if (!empty($year)) {
            $builder->where("YEAR(created_at)", $year);
        }
        
        $query = $builder->get();
        
        return $query->getNumRows();
    }

     function getbalancecust($year = "")
    {
        $builder = $this->db->table('invoices');
        $builder->select('*');

        if (!empty($year)) {
            $builder->where("YEAR(created_at)", $year);
        }

        $builder->where('balance !=', '0.00');
        $builder->where('balance !=', '0');
        $builder->where('balance !=', '£0');
        $builder->orderBy('id', 'DESC');
        $builder->limit(5);

        return $builder->get()->getResult();
    }

    function gettotalinvoices($year = "") 
    {
        $builder = $this->db->table('invoices');
        $builder->select('COUNT(*) as count, SUM(total) as total_amount');
        
        // Add year filter if year is provided
        if (!empty($year)) {
            $builder->where('YEAR(created_at)', $year);  
        }
        
        $query = $builder->get();
        $result = $query->getRow();

        return [
            'count' => (int)$result->count,
            'total_amount' => number_format((float)$result->total_amount, 2, '.', '')
        ];
    }

    public function getInvoicesSummary()
    {
        $builder = $this->db->table('invoices');
        $builder->select('COUNT(*) as count, COALESCE(SUM(total), 0) as total_amount');
        $query = $builder->get();
        $result = $query->getRow();
    
        return [
            'count' => (int)$result->count,
            'total_amount' => number_format((float)$result->total_amount, 2, '.', '')
        ];
    }

    // ================================================================================================================================================
    // NEWLY ADDED METHODS

    public function getLastMonthIncomeReport($selectedYear)
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
        $builder = $this->db->table('invoices');
        $builder->select('SUM(total) as total_revenue')
                ->where('YEAR(created_at)', $yearForPreviousMonth)
                ->where('MONTH(created_at)', $previousMonth);
        
        $query = $builder->get();
        $prevMonthResult = $query->getRow();
        $previousMonthRevenue = (float) $prevMonthResult->total_revenue;
    
        // Build query to get revenue for the current month
        $currentMonthBuilder = $this->db->table('invoices');
        $currentMonthBuilder->select('SUM(total) as total_revenue')
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

    public function getLastMonthExpenditureReport($selectedYear)
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
        $builder = $this->db->table('invoices');
        $builder->select('SUM(netprice) as total_revenue')
                ->where('YEAR(created_at)', $yearForPreviousMonth)
                ->where('MONTH(created_at)', $previousMonth);
        
        $query = $builder->get();
        $prevMonthResult = $query->getRow();
        $previousMonthRevenue = (float) $prevMonthResult->total_revenue;
    
        // Build query to get revenue for the current month
        $currentMonthBuilder = $this->db->table('invoices');
        $currentMonthBuilder->select('SUM(netprice) as total_revenue')
                           ->where('YEAR(created_at)', $selectedYear)
                           ->where('MONTH(created_at)', $currentMonth);
        
        $currentQuery = $currentMonthBuilder->get();
        $currentMonthResult = $currentQuery->getRow();
        $currentMonthRevenue = (float) $currentMonthResult->total_revenue;
    
        $expenditureReport = [
            'year' => $selectedYear,
            'previous_month_revenue' => $previousMonthRevenue,
            'previous_month' => $previousMonth,
            'previous_month_year' => $yearForPreviousMonth,
            'current_month_revenue' => $currentMonthRevenue,
            'current_month' => $currentMonth,
            'current_year' => $selectedYear
        ];
        
        return $expenditureReport;
    }

    public function getLastMonthBalanceReport($selectedYear)
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
        $closingBuilder = $this->db->table('invoices');
        $closingBuilder->select('SUM(total) as total_amount')
                      ->where("created_at <= ", "$yearForPreviousMonth-$previousMonth-31 23:59:59");
        
        $closingQuery = $closingBuilder->get();
        $closingResult = $closingQuery->getRow();
        $closingBalance = (float) $closingResult->total_amount;
    
        // Get opening balance (all transactions up to current date)
        $openingBuilder = $this->db->table('invoices');
        $openingBuilder->select('SUM(total) as total_amount')
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


    // =======================================================================================================================
    function getMoneyOutForCurrentMonth()
    {
        // Get the first and last day of the current month
        $firstDayOfMonth = date('Y-m-01');
        $lastDayOfMonth = date('Y-m-t');
    
        // Build the query to get the total for the current month
        $builder = $this->db->table('invoices');
        $builder->selectSum('total');
        $builder->where('STR_TO_DATE(invoice_date, "%d/%m/%Y") >=', $firstDayOfMonth);
        $builder->where('STR_TO_DATE(invoice_date, "%d/%m/%Y") <=', $lastDayOfMonth);
    
        // Execute the query and get the result
        $query = $builder->get();
        $result = $query->getRow();
    
        return $result ? $result->total : 0.00; // Return total or 0 if result is NULL
    }
    
    function getMoneyInForCurrentMonth()
    {
         // Get the first and last day of the current month
         $firstDayOfMonth = date('Y-m-01');
         $lastDayOfMonth = date('Y-m-t');

         // Build the query to get the netprice for the current month
        $builder = $this->db->table('invoices');
        $builder->selectSum('netprice');
        $builder->where('STR_TO_DATE(invoice_date, "%d/%m/%Y") >=', $firstDayOfMonth);
        $builder->where('STR_TO_DATE(invoice_date, "%d/%m/%Y") <=', $lastDayOfMonth);
    
        // Execute the query and get the result
        $query = $builder->get();
        $result = $query->getRow();

        return $result ? $result->netprice : 0.00; // Return total or 0 if result is NULL

    }

    function getLargestPaymentForCurrentMonth()
    {
        // Get the first and last day of the current month
        $firstDayOfMonth = date('Y-m-01');
        $lastDayOfMonth = date('Y-m-t');

        // Build the query to get the netprice for the current month
        $builder = $this->db->table('invoices');
        $builder->select('netprice');

    }

    function getTotalPaidForCurrentMonth()
    {
         // Get the first and last day of the current month
         $firstDayOfMonth = date('Y-m-01');
         $lastDayOfMonth = date('Y-m-t');

         // Build the query to get the paid for the current month
        $builder = $this->db->table('invoices');
        $builder->selectSum('paid');
        $builder->where('STR_TO_DATE(invoice_date, "%d/%m/%Y") >=', $firstDayOfMonth);
        $builder->where('STR_TO_DATE(invoice_date, "%d/%m/%Y") <=', $lastDayOfMonth);
    
        // Execute the query and get the result
        $query = $builder->get();
        $result = $query->getRow();

        return $result ? $result->paid : 0.00; // Return total or 0 if result is NULL

    }

    function getTotalBalanceForCurrentMonth()
    {
         // Get the first and last day of the current month
         $firstDayOfMonth = date('Y-m-01');
         $lastDayOfMonth = date('Y-m-t');

         // Build the query to get the paid for the current month
        $builder = $this->db->table('invoices');
        $builder->selectSum('balance');
        $builder->where('STR_TO_DATE(invoice_date, "%d/%m/%Y") >=', $firstDayOfMonth);
        $builder->where('STR_TO_DATE(invoice_date, "%d/%m/%Y") <=', $lastDayOfMonth);
    
        // Execute the query and get the result
        $query = $builder->get();
        $result = $query->getRow();

        return $result ? $result->balance : 0.00; // Return total or 0 if result is NULL

    }


     function getDataForChart($year = "")
    {
        $builder = $this->db->table('invoices');
        $builder->select('YEAR(created_at) AS year, MONTHNAME(created_at) AS month, COUNT(*) AS count');

        if (!empty($year)) {
            $builder->where("YEAR(created_at)", $year);
        }

        $builder->groupBy('year, month');
        $builder->orderBy('id', 'DESC');

        return $builder->get()->getResult();
    }

     function getDataFordisplay($year = "")
    {
        $builder = $this->db->table('invoices');
        $builder->select('YEAR(created_at) AS year, MONTHNAME(created_at) AS month, COUNT(*) AS count');
        $builder->select("DATE_FORMAT(created_at, '%M') AS month_name", false);
        $builder->select("SUM(CAST(REPLACE(total, '£', '') AS DECIMAL(10,2))) AS total_amount", false);

        if (!empty($year)) {
            $builder->where("YEAR(created_at)", $year);
        }

        $builder->groupBy('year, month');
        $builder->orderBy('id', 'DESC');

        return $builder->get()->getResult();
    }

    function getMonthlyReport($year = "")
    {
        $builder = $this->db->table('invoices');
        $builder->select('YEAR(created_at) AS year, MONTHNAME(created_at) AS month, COUNT(*) AS invoice_count');
        $builder->select("DATE_FORMAT(created_at, '%M') AS month_name", false);
        $builder->select("SUM(CAST(REPLACE(total, '£', '') AS DECIMAL(10,2))) AS money_in", false);
        $builder->select("SUM(CAST(REPLACE(netprice, '£', '') AS DECIMAL(10,2))) AS money_out", false);
        $builder->select("SUM(CAST(REPLACE(profit_loss, '£', '') AS DECIMAL(10,2))) AS profit", false);

        if (!empty($year)) {
            $builder->where("YEAR(created_at)", $year);
        }

        $builder->groupBy('year, month');
        $builder->orderBy('id', 'DESC');

        return $builder->get()->getResult();
    }


    // much work still
    public function getDataForpiechart($year = "")
    {
        $currentYear = date('Y');
        $builder = $this->db->table('invoices');
        $builder->select('client_name');
        $builder->select("SUM(CAST(REPLACE(total, '£', '') AS DECIMAL(10,2))) AS total_amount", false);
    
        $builder->groupBy('client_name');
    
        if (!empty($year)) {
            $builder->where("YEAR(created_at)", $year);
        } else {
            $builder->where("YEAR(created_at)", $currentYear);
        }
    
        $builder->orderBy('id', 'DESC');
    
        return $builder->get()->getResult();
    }
    

     function getDataForpiechartstaff($year = "")
    {
        $builder = $this->db->table('invoices');
        $builder->select('username, COUNT(*) AS count');

        if (!empty($year)) {
            $builder->where("YEAR(created_at)", $year);
        }

        $builder->groupBy('username');
        $builder->orderBy('id', 'DESC');

        return $builder->get()->getResult();
    }

    public function getreports($reportType, $year)
    {
        $builder = $this->db->table('invoices');

        $builder->select('*, COUNT(*) AS count, MONTHNAME(created_at) AS month');
        $builder->select('SUM(
                REPLACE(total, "£", "") 
                ) AS cumulative_total, 
                SUM(
                REPLACE(subtotal, "£", "") 
                ) AS cumulative_sub_total, 
                SUM(
                REPLACE(paid, "£", "") 
                ) AS cumulative_paid, 
                SUM(
                REPLACE(balance, "£", "") 
                ) AS cumulative_balance'
        );
        $builder->where("YEAR(created_at) = '$year'");

        if ($reportType == 'salesByClient') {
            $builder->select('email');
            $builder->groupBy('email');
        }
        if ($reportType == 'salesByDate') {
            $builder->select('YEAR(created_at) AS year, MONTHNAME(created_at) AS month');
            $builder->groupBy('year, month');
        }
        if ($reportType == 'salesByStaff') {
            $builder->select('username');
            $builder->groupBy('username');
        }

        $builder->orderBy('id', 'DESC');

        $query = $builder->get();

        return $query->getResult();
    }

    public function selectinvoices($condition)
    {
        $builder = $this->db->table('invoices');

        $builder->select('*');
        
        if ($condition == "Unpaid") {
            $builder->where('balance !=', '0.00');
            $builder->where('balance !=', '0');
            $builder->where('balance !=', '£0');
        } elseif ($condition == "Paid") {
            $builder->where('balance', '0.00');
            $builder->orWhere('balance', '0');
            $builder->orWhere('balance', '£0');
        } elseif ($condition == "Incomplete") {
            $builder->where('agentstatus', 'incomplete');
        } elseif ($condition == "Complete") {
            $builder->where('agentstatus', 'complete');
        }

        $builder->orderBy('id', 'DESC');

        $query = $builder->get();
        return $query->getResult();
    }

    public function getLastId()
    {
        $builder = $this->db->table($this->table);
        $builder->select('id');
        $builder->orderBy('id', 'DESC');
        $result = $builder->get()->getFirstRow();

        return $result ? $result->id : null;
    }

    public function getTodaySalesSummary()
    {
        $totalAmount = 0.0;
        $currentDate = date('Y-m-d');
    
        $builder = $this->db->table('invoices');
        $builder->select('total');
        $builder->where('DATE(created_at)', $currentDate);
        $builder->where('total IS NOT NULL');
    
        $query = $builder->get();
        $results = $query->getResult();
        $invoiceCount = count($results);
    
        if ($results) {
            foreach ($results as $row) {
                $total = str_replace('£', '', $row->total);
                $total = floatval($total);
                $totalAmount += $total;
            }
        }
    
        return [
            'total' => number_format($totalAmount, 2),
            'count' => $invoiceCount
        ];
    }
    public function getMonthlySalesSummary($year, $month)
    {
        $builder = $this->db->table('invoices');
        $builder->select('COUNT(*) as count, COALESCE(SUM(CAST(REPLACE(total, "£", "") AS DECIMAL(10,2))), 0) as total_amount');
        $builder->where('YEAR(created_at)', $year);
        $builder->where('MONTH(created_at)', $month);
        $builder->where('total IS NOT NULL');
    
        $query = $builder->get();
        $result = $query->getRow();
    
        return [
            'count' => (int)$result->count,
            'total_amount' => number_format((float)$result->total_amount, 2, '.', '')
        ];
    }
        function getTotalEstimatesPerMonth($year, $month)
    {
        $builder = $this->db->table('estimates');
        $builder->select('id'); 
        $builder->where("YEAR(created_at)", $year);
        $builder->where("MONTH(created_at)", $month);

        $query = $builder->get();

        $totalEstimates = $query->getNumRows();

        return $totalEstimates;
    }

    
    public function getPositiveBalanceInvoicesSummary()
{
    $builder = $this->db->table('invoices');
    $builder->select('COUNT(*) as count, COALESCE(SUM(balance), 0) as total_balance');
    $builder->where('balance >', 0);
    $builder->where('paid =', 0);
    $query = $builder->get();
    $result = $query->getRow();

    return [
        'count' => (int)$result->count,
        'total_balance' => number_format((float)$result->total_balance, 2, '.', '')
    ];
}

public function getPaidInvoicesSummary()
{
    $builder = $this->db->table('invoices');
    $builder->select('COUNT(*) as count, COALESCE(SUM(paid), 0) as total_paid');
    $builder->where('balance', 0);
    $query = $builder->get();
    $result = $query->getRow();

    return [
        'count' => (int)$result->count,
        'total_paid' => number_format((float)$result->total_paid, 2, '.', '')
    ];
}

public function getPartiallyPaidInvoicesSummary()
{
    $builder = $this->db->table('invoices');
    $builder->select('COUNT(*) as count, COALESCE(SUM(paid), 0) as total_paid, COALESCE(SUM(balance), 0) as total_balance');
    $builder->where('balance >', 0);
    $builder->where('paid >', 0);
    $query = $builder->get();
    $result = $query->getRow();

    return [
        'count' => (int)$result->count,
        'total_paid' => number_format((float)$result->total_paid, 2, '.', ''),
        'total_balance' => number_format((float)$result->total_balance, 2, '.', '')
    ];
}

public function getOverdueInvoicesSummary()
{
    $currentDate = date('Y-m-d');

    $builder = $this->db->table('invoices');
    $builder->select('COUNT(*) as count, COALESCE(SUM(total), 0) as total_amount');
    $builder->where('STR_TO_DATE(due_date, "%d/%m/%Y") <', $currentDate);
    $builder->where('balance >', 0);

    $query = $builder->get();
    $result = $query->getRow();

    return [
        'count' => (int)$result->count,
        'total_amount' => number_format((float)$result->total_amount, 2, '.', '')
    ];
}
    

    public function formatCurrency($value)
    {
        $value = str_replace('£ ', '', $value); 
        return  $value; 
    }
    
    public function getInvoicesFromEstimatesSummary()
    {
        $builder = $this->db->table('invoices');
        $builder->select('COUNT(*) as count, COALESCE(SUM(total), 0) as total_amount');
        $builder->where('from_estimates', 1);
    
        $query = $builder->get();
        $result = $query->getRow();
    
        return [
            'count' => (int)$result->count,
            'total_amount' => number_format((float)$result->total_amount, 2, '.', '')
        ];
    }


     public function getAllUsers()
    {
        return $this->findAll();
    }

    public function getAllUsersWithInitials()
    {
        $users = $this->findAll();
        
        $initials = [];
        $initialsCount = [];
        
        foreach ($users as $user) {
            // Extract the first two characters of the username and convert to uppercase
            $initial = strtoupper(substr($user->username, 0, 2));
            
            // Check if the initial already exists, if so, increment count and append count to the initial
            if (isset($initialsCount[$initial])) {
                $count = $initialsCount[$initial] + 1;
                $initial .= $count;
                $initialsCount[$initial] = $count;
            } else {
                $initialsCount[$initial] = 1;
            }
            
            $initials[] = $initial;
        }

        return $initials;
    }
      
    public function getDueDateForRecurringInvoice()
    {
        $builder = $this->db->table('invoices');
        $builder->select('due_date'); // Select the 'due_date' field
        $builder->where('payment_reminder', 'on');
        
        $query = $builder->get();
        return $query->getResult();
    }
    public function getExactCreatedTimeFoRecurringInvoice()
    {
        $builder = $this->db->table('invoices');
        $builder->select('email, client_name,invoice_no, due_date, created_at'); // Select the 'due_date' and 'created_at' fields
        $builder->where('payment_reminder', 'on');
        
        $query = $builder->get();
        return $query->getResult();
    }

    // Company paymnent method for their plans
    public function freePlanLimit()
    {
        $builder = $this->db->table('invoices');
        $builder->where('status', 'sent');
        return $builder->countAllResults();
    }
    public function hasReachedFreeLimit()
    {
        $count = $this->freePlanLimit();
        return $count >= 10;
    }
}


