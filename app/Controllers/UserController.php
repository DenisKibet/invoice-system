<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Authentication\Passwords;

class UserController extends ResourceController
{
    protected $modelName = 'CodeIgniter\Shield\Models\UserModel';

    public function ResetUserPassword()
    {
        // Ensure the request is via POST
        if (!$this->request->is('post')) {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method Not Allowed']);
        }

        // Get the user ID from the POST data
        $userId = $this->request->getPost('userId');

        if (!$userId) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'User ID is required']);
        }
        
        // Find the user
        $userModel = new UserModel();
        $user = $userModel->findById($userId);
        
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
        }
        
        // Generate a new random token
        $resetToken = bin2hex(random_bytes(16));
        $hashedToken = password_hash($resetToken, PASSWORD_BCRYPT);

        $db = \Config\Database::connect('default');
        $builder = $db->table('auth_identities');

        $builder->insert([
            'user_id'    => $userId,
            'type'       => 'reset_token',  
            'name'       => 'password_reset',
            'secret'     => $resetToken,  // Store the plain token
            'secret2'    => $hashedToken, // Store the hashed token
            'expires'    => date('Y-m-d H:i:s', strtotime('+1 hour')),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        // Generate the reset link
        $resetLink = site_url("reset-password/{$resetToken}");

        // Send email to the user with the reset link
        $email = \Config\Services::email();
        $email->setTo($user->email);
        $email->setSubject('Reset Your Password');
        // Create an HTML message with a button
        $htmlMessage = "
        <html>
        <body>
            <p>Click the following button to reset your password:</p>
            <p>
                <a href='{$resetLink}' style='background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;'>
                    Reset Password
                </a>
            </p>
            <p>This link will expire in 1 hour.</p>
        </body>
        </html>
        ";

        $email->setMessage($htmlMessage);
        $email->setMailType('html');
        
        if ($email->send()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Password reset link sent successfully']);
        } else {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to send password reset email']);
        }
    }

    public function HandlePasswordReset($token)
    {
        // Check if the token is valid and has not expired
        $db = \Config\Database::connect('default');
        $builder = $db->table('auth_identities');

        $tokenData = $builder->where('secret', $token) // Look for the plain token
                             ->where('expires >', date('Y-m-d H:i:s')) // Ensure token has not expired
                             ->where('type', 'reset_token') // Only check for reset tokens
                             ->get()
                             ->getRow();

        if (!$tokenData) {
            // Token is invalid or expired
            return redirect()->to('/login')->with('error', 'Invalid or expired reset token');
        }

        // If the token is valid, render the password reset form
        return view('NEWCRM/reset_password_form', ['token' => $token]);
    }

    public function SetNewPassword()
    {
        // Get the reset token and new password from the request
        $token = $this->request->getPost('token');
        $newPassword = $this->request->getPost('new_password');

        // Validate input
        if (empty($newPassword)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Password is required']);
        }

        // Check if the token is valid and has not expired
        $db = \Config\Database::connect('default');
        $builder = $db->table('auth_identities');
        
        // Look up the token directly (it's no longer hashed in the database)
        $tokenData = $builder->where('type', 'reset_token')
                             ->where('secret', $token)
                             ->where('expires >', date('Y-m-d H:i:s'))
                             ->get()
                             ->getRow();

        if (!$tokenData) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid or expired reset token']);
        }

        // Verify the token against the stored hash
        if (!password_verify($token, $tokenData->secret2)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid reset token']);
        }

        // Find the user
        $userModel = new UserModel();
        $user = $userModel->find($tokenData->user_id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
        }

        // Update the user's password in auth_identities table
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $builder->where('user_id', $tokenData->user_id)
                ->where('type', 'email_password')
                ->update(['secret2' => $hashedPassword]);

        // Clear the reset token data
        // $builder->where('user_id', $tokenData->user_id)
        //         ->where('type', 'reset_token')
        //         ->delete();

        // Return success message
        return $this->response->setJSON(['success' => true, 'message' => 'Password updated successfully, Use your new password to login']);
    }
}