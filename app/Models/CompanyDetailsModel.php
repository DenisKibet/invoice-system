<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseConnection;

class CompanyDetailsModel extends Model
{
    protected $table      = 'companies';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'object';

    protected $allowedFields = [
        'company_name',
        'registration_no', 
        'mobile_no',
        'additional_no',
        'email',
        'street',
        'city',
        'country',
        'post_code',
        'website',
        'logo_path', 
        'user_id',
        'username',
    ];

    protected $useSoftDeletes = false;
    protected $protectFields  = false;

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules    = [
        'company_name'   => 'required',
        'email'         => 'required|valid_email'
    ];

    protected $validationMessages = [
        'email' => [
            'valid_email' => 'Please enter a valid email address.'
        ]
    ];

    protected $skipValidation     = false;
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


    function companyPresent() {
        $builder = $this->db->table('companies');

        $query = $builder->get();

        return $query->getNumRows() > 0;
    }

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

      // Add a method to handle logo upload
      public function uploadLogo($companyId, $file)
      {
          if ($file->isValid() && !$file->hasMoved()) {
              $newName = $file->getRandomName();
              $file->move(ROOTPATH . 'public/uploads/logos', $newName);
              $logoPath = 'uploads/logos/' . $newName;
  
              // Update the company record with the new logo path
              $this->update($companyId, ['logo_path' => $logoPath]);
  
              return $logoPath;
          }
  
          return null;
      }
  
      // Add a method to get company details including the logo path
      public function getCompanyDetails($companyId)
      {
          return $this->find($companyId);
      }
  
      // Add a method to update company details
      public function updateCompanyDetails($companyId, $data)
      {
          return $this->update($companyId, $data);
      }
}



