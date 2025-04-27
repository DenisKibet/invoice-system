<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use App\Services\TenantTracker;
use CodeIgniter\Database\Exceptions\DatabaseException;

class TenantFilter implements FilterInterface
{
    protected $tenantTracker;

    public function __construct()
    {
        $this->tenantTracker = Services::tenantTracker();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        $tenantId = session()->get('tenant_id');
        
        if (!$tenantId) {
            log_message('warning', 'No tenant_id found in session');
            return Services::response()->setStatusCode(400)->setBody('Invalid tenant');
        }

        try {
            $this->tenantTracker->setTenantId($tenantId);
            $currentDb = db_connect()->getDatabase();
            $tenantDbName = $this->tenantTracker->getTenantDatabaseName();

            if ($currentDb !== $tenantDbName) {
                $this->tenantTracker->setTenantDatabase();
            }
        } catch (DatabaseException $e) {
            log_message('error', 'Failed to switch to tenant database: ' . $e->getMessage());
            return Services::response()->setStatusCode(500)->setBody('Database connection error');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optionally, you could add logging or cleanup here
        // For example:
        // log_message('info', 'Request processed for tenant: ' . session()->get('tenant_id'));
    }
}