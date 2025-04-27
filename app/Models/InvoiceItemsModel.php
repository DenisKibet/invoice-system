<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseConnection;

class InvoiceItemsModel extends Model
{
    protected $table            = 'invoice_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'itemname', 'quantity', 'price', 'totalprice', 'costprice','from_estimates', 'username', 'invoice_id'
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
}
