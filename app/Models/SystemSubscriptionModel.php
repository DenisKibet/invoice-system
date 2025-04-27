<?php

namespace App\Models;

use CodeIgniter\Model;

class SystemSubscriptionModel extends Model
{
    protected $table            = 'system_subscriptions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'company_id', 
        'user_id', 
        'plan_name',
        'subscription_duration', 
        'subscription_status', 
        'start_date', 
        'end_date',
        'payment_id' ,
        'created_at', 
        'updated_at'];
    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        // 'company_id' => 'required|integer|is_natural_no_zero',
        // 'user_id' => 'required|integer|is_natural_no_zero',
        // 'subscription_duration' => 'required|in_list[monthly,yearly]',
        // 'status' => 'required|in_list[active,inactive,cancelled,expired]',
        // 'start_date' => 'required|valid_date',
        // 'end_date' => 'permit_empty|valid_date',
    ];
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

    public function isSubscriptionActive($companyId)
    {
        $currentDate = date('Y-m-d');
        $subscription = $this->where('company_id', $companyId)
                            ->where('subscription_status', 'active')
                            ->where('end_date >=', $currentDate)
                            ->first();
        return $subscription !== null;
    }   
}
