<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;
use App\Services\TenantService;  
use App\Models\CompanyList; 
use Config\Database;

class RegisterController extends BaseController
{
    public function register()
    {
        return view('NEWCRM/welcome_message');
    }

    public function attemptRegister()
    {
        $rules = [
            'companyname' => 'required|min_length[3]',
            'username'    => 'required|min_length[3]',
            'email'       => 'required|valid_email|is_unique[auth_identities.secret]',
            'password'    => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $request = service('request');
        $db = Database::connect();
        $session = session();

        $db->transStart();           


        try {
            $userModel = new UserModel();
            $userEntity = new User([
                'username' => $this->request->getVar('username'),
                'email'    => $this->request->getVar('email'),
                'password' => $this->request->getVar('password'),
            ]);

            if (!$userModel->save($userEntity)) {
                throw new \RuntimeException('Failed to save user.');
            }

            $userId = $userModel->getInsertID();

            $companyname = $this->request->getVar('companyname');
            $sanitizeCompanyName = preg_replace('/[^a-zA-Z0-9_]/', '', $companyname);
            $tenant_database_name = 'tenant_' . $userId . '_db';

            $companydetails = [
                'tenant_company_name' => $companyname,
                'tenant_database_name' => $tenant_database_name,
                'user_id'             => $userId,
                'username'            => $this->request->getVar('username')
            ];
            $companyDetailsModel = new CompanyList();
            if (!$companyDetailsModel->insert($companydetails)) {
                throw new \RuntimeException('Failed to save company details.');
            }

            $tenantService = new TenantService();
            $result = $tenantService->createTenantDatabase($tenant_database_name);

            if ($result !== true) {
                throw new \RuntimeException('Failed to create tenant database.');
            }

            // Set up session data
            $userData = $userModel->findById($userId);
            
            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaction failed.');
            }

            $db->transCommit();

            return redirect()->to('/dashboard')->with('message', 'Registration successful! Welcome to the dashboard.');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Registration failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
        }
    }
}