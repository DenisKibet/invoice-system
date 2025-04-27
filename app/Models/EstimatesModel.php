<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseConnection;

class EstimatesModel extends Model
{
    protected $table            = 'estimates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'estimate_no','client_name', 'email','status', 'comment', 'payment_instruction', 'invoice_date', 
        'terms', 'due_date', 'subtotal', 'discount', 'total', 'paid', 
        'method', 'balance', 'netprice', 'profit_loss', 'username'
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
    // Estimates methods

    public function getEstimatesSummaryPerMonth($year, $month)
    {
        // Convert month to two digits with leading zero if needed
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        
        // Formulate the date in the format 'YYYY-MM'
        $date = "$year-$month";
    
        // Construct the query
        $builder = $this->db->table('estimates');
        $builder->select('COUNT(*) as total_estimates, COALESCE(SUM(total), 0) as total_amount');
        $builder->where("DATE_FORMAT(invoice_date, '%Y-%m') =", $date);
        
        $query = $builder->get();
    
        if ($query === false) {
            log_message('error', 'Query failed: ' . $this->db->error()['message']);
            return [
                'total_estimates' => 0,
                'total_amount' => '0.00'
            ];
        }
        
        $result = $query->getRow();
    
        return [
            'total_estimates' => (int)$result->total_estimates,
            'total_amount' => number_format($result->total_amount, 2, '.', '')
        ];
    }


    public function getEstimateSummary()
    {
        $builder = $this->db->table('estimates');
        $builder->select('COUNT(*) as count, COALESCE(SUM(total), 0) as total_amount');
        $query = $builder->get();
        $result = $query->getRow();
    
        return [
            'count' => (int)$result->count,
            'total_amount' => number_format((float)$result->total_amount, 2, '.', '')
        ];
    }
    
    public function getLastId()
    {
        $builder = $this->db->table('estimates');
        $builder->select('id');
        $builder->orderBy('id', 'DESC');
        $result = $builder->get()->getFirstRow();

        return $result ? $result->id : null;
    }
    

}
