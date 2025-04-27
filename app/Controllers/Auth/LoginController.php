<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Config\Database;


class LoginController extends BaseController
{
    public function login()
    {
        // Check if user is already logged in
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('NEWCRM/welcome_login');
    }

    public function attemptLogin()
    {
        $request = service('request');
        $db = Database::connect();
        $session = session();

        // Check if user is already logged in
        if ($session->get('logged_in')) {
            return redirect()->to('/dashboard')->with('message', 'You are already logged in.');
        }

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $credentials = [
            "email"    => $this->request->getVar("email"),
            "password" => $this->request->getVar('password'),
        ];

        try {
            $db->transStart();

            $loginAttempt = auth()->attempt($credentials);

            if (!$loginAttempt->isOk()) {
                throw new \Exception('Invalid login details');
            }

            $userId = auth()->id();

            $userObject = new UserModel();
            $userData = $userObject->findById($userId);

            if (!$userData) {
                throw new \Exception('User data not found');
            }

            $token = $userData->generateAccessToken("thisismysecretekey");
            $auth_token = $token->raw_token;

            // Query agent
            $agentModel = new \App\Models\AgentModel(); 
            $isAgent = $agentModel->where('agent_id', $userId)->countAllResults() > 0;
            $userRole = $isAgent ? 'agent' : 'admin';

            $query = $db->table('agents')
                        ->select('user_id')
                        ->where('agent_id', $userId)
                        ->get();

            $user_id = $query->getRow('user_id');
            $tenantDb = $user_id ? "tenant_{$user_id}_db" : "tenant_{$userId}_db"; 

            //  Query superadmin 
            $superAdminModel = new \App\Models\SuperAdminModel(); 
            $isSuperAdmin = $superAdminModel->where('user_id', $userId)->countAllResults() > 0;
            // End of SuperAdmin Query
            $sessionData = [
                'username'   => $userData->username,
                'user_role'  => $userRole,
                'user_id'    => $userId,
                'tenant_id'  => $userId,
                'tenant_db'  => $tenantDb,
                'logged_in'  => true,
                'auth_token' => $auth_token,
            ];

            // Clear any existing session data
            // $session->destroy();

            // Start a new session
            // $session->start();

            // Set the new session data
            $session->set($sessionData);

            // Update last login time in the main database
            // $db->table('users')->where('id', $userId)->update(['last_lo/gin' => date('Y-m-d H:i:s')]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Database transaction failed');
            }

            if ($isSuperAdmin){
                return redirect()->to('/super-admin-dashboard')->with('message', 'loginSuccess');
            } else {
                return redirect()->to('/dashboard')->with('message', 'loginSuccess');
            }
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Login failed: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'An error occurred during login. Please try again.');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login')->with('message', 'You have been logged out successfully.');
    }

    public function checkSession()
    {
        $session = session();
        if ($session->get('logged_in')) {
            return $this->response->setJSON(['loggedIn' => true]);
        } else {
            return $this->response->setJSON(['loggedIn' => false]);
        }
    }
}
