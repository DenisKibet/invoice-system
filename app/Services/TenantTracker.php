<?php
namespace App\Services;
use Config\Database;


class TenantTracker
{
    private $tenantId;

    public function setTenantId($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    public function getTenantId()
    {
        return $this->tenantId;
    }

    public function setTenantDatabase()
    {
        try {
            $dbName = $this->getTenantDatabaseName();
            $config = config('Database');
            $config->tenant['database'] = $dbName;

            $dbConnection = Database::connect($config->tenant);

            return $dbConnection; 
        } catch (\Exception $e) {
            log_message('error', "Failed to connect to database for tenant ID: " . $this->tenantId . ". Error: " . $e->getMessage());
            throw new \RuntimeException("Unable to connect to tenant database.");
        }
    }

    // public function getTenantDatabaseName()
    // {
    //     $db = Database::connect();

    //     // Query Agents Table
    //     $query = $db->table('agents')
    //                 ->select('user_id')
    //                 ->where('agent_id', $this->tenantId)
    //                 ->get();
    
    //     $user_id = $query->getRow('user_id');

    //     // Query Super Admin Table
    //     $query = $db->table('super_admin')
    //                 ->select('user_id')
    //                 ->where('user_id', $this->tenantId)
    //                 ->get();

    //     $super_admin = $query->getRow('user_id');
    //     var_dump($super_admin);

        
    //     if ($super_admin) {
    //         return "tenant_{$user_id}_db"; //this is for agent identification, and agent is affiliated to an admin
    //     } elseif ($this->tenantId) {
    //         return "tenant_{$this->tenantId}_db"; // this is for admin identification
    //     } elseif ($user_id) {
    //         return "satechs"; //this is for super admin
    //     } else {
    //         return "satechs"; // default connection
    //     }
        
    // }

    public function getTenantDatabaseName()
{
    $db = Database::connect();

    // Query Agents Table
    $agentQuery = $db->table('agents')
                    ->select('user_id')
                    ->where('agent_id', $this->tenantId)
                    ->get();

    $agentUserId = $agentQuery->getRow('user_id');

    // Query Super Admin Table
    $superAdminQuery = $db->table('super_admin')
                        ->select('user_id')
                        ->where('user_id', $this->tenantId)
                        ->get();

    $superAdminUserId = $superAdminQuery->getRow('user_id');

    if ($superAdminUserId) {
        return "satechs"; // Super admin database
    } elseif ($agentUserId) {
        return "tenant_{$agentUserId}_db"; // Tenant database for agent
    } elseif ($this->tenantId) {
        return "tenant_{$this->tenantId}_db"; // Tenant database for admin
    } else {
        return "satechs"; // Default to super admin database
    }
}
    
}