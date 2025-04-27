<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\BaseConnection;


class Autocomplete extends Model
{
  protected $table = 'clients'; // Adjust this according to your table name
  // protected $table = 'invoice_details';

  public function getclientdetailsid($id)
  {
    return $this->where('EmailAddress', $id)
                ->get()
                ->getResult();
  }

  public function getClientDetailsByEmail($email)
  {
    return $this->where('email_address', $email)
                ->orderBy('id', 'DESC')
                ->get()
                ->getResult();
  }
  
  public function getClientInvoices($email)
    {   
        $builder = $this->db->table('invoices');
        $query = $builder->where('email', $email)
                        ->orderBy('id', 'DESC')
                        ->get();

        if ($query->getNumRows() > 0) {
            return $query->getResult();
        } else {
            return false;
        }
    }
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