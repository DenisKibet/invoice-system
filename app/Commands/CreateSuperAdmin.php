<?php

// namespace App\Commands;

// use CodeIgniter\CLI\BaseCommand;
// use CodeIgniter\CLI\CLI;
// use CodeIgniter\Shield\Models\UserModel;
// use CodeIgniter\Shield\Entities\User;
// use CodeIgniter\Shield\Authorization\Groups;

// class CreateSuperAdmin extends BaseCommand
// {
//     protected $group       = 'Auth';
//     protected $name        = 'auth:create-super-admin';
//     protected $description = 'Creates a new super admin user';

//     public function run(array $params)
//     {
//         $userModel = new UserModel();
//         $groups = new Groups();

//         $name = CLI::prompt('Name', null, 'required|min_length[3]');
//         $email = CLI::prompt('Email', null, 'required|valid_email');
//         $password = CLI::prompt('Password', null, 'required|min_length[8]');

//         $adminUser = new User([
//             'username' => $name,
//             'email'    => $email,
//             'password' => $password,
//             'active'   => 1,
//             'is_super_admin' =>1,
//         ]);

//         try {
//             $userModel->db->transStart();

//             if ($userModel->save($adminUser)) {
//                 $userId = $userModel->getInsertID();
//                 $adminUser = $userModel->findById($userId);

//                 CLI::write("User created successfully with ID: $userId", 'green');

//             } else {
//                 CLI::error('Failed to create user: ' . print_r($userModel->errors(), true));
//                 $userModel->db->transRollback();
//                 return;
//             }

//             $userModel->db->transComplete();

//             if ($userModel->db->transStatus() === false) {
//                 CLI::error('Transaction failed. Changes have been rolled back.');
//             } else {
//                 CLI::write('Super admin user created and added to group successfully!', 'green');
//             }
//         } catch (\Exception $e) {
//             $userModel->db->transRollback();
//             CLI::error('An error occurred: ' . $e->getMessage());
//             CLI::write('Error details: ' . $e->getTraceAsString(), 'yellow');
//         }
//     }
// }


namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Authorization\Groups;
use App\Models\SuperAdminModel;

class CreateSuperAdmin extends BaseCommand
{
    protected $group       = 'Auth';
    protected $name        = 'auth:create-super-admin';
    protected $description = 'Creates a new super admin user';

    public function run(array $params)
    {
        $userModel = new UserModel();
        $superAdminModel = new SuperAdminModel();
        $groups = new Groups();

        $name = CLI::prompt('Name', null, 'required|min_length[3]');
        $email = CLI::prompt('Email', null, 'required|valid_email');
        $password = CLI::prompt('Password', null, 'required|min_length[8]');

        $adminUser = new User([
            'username' => $name,
            'email'    => $email,
            'password' => $password,
            'active'   => 1,
            'is_super_admin' =>1,
        ]);

        try {
            $userModel->db->transStart();

            if ($userModel->save($adminUser)) {
                $userId = $userModel->getInsertID();
                $adminUser = $userModel->findById($userId);

                CLI::write("User created successfully with ID: $userId", 'green');

                // Add super admin details
                $superAdminDetails = [
                    'super_admin_username' => $name,
                    'user_id' => $userId,
                ];

                if ($superAdminModel->insert($superAdminDetails)) {
                    CLI::write('Super admin details saved successfully', 'green');
                } else {
                    CLI::error('Failed to save super admin details: ' . print_r($superAdminModel->errors(), true));
                    $userModel->db->transRollback();
                    return;
                }

                // Add user to 'superadmin' group
                // $superadminGroup = 'superadmin';
                // if (!$groups->getGroup($superadminGroup)) {
                //     $groups->createGroup($superadminGroup, 'Super Administrator Group');
                //     CLI::write("Created 'superadmin' group", 'green');
                // } else {
                //     CLI::write("'superadmin' group already exists", 'yellow');
                // }

                // if ($adminUser->addGroup($superadminGroup)) {
                //     CLI::write('User added to superadmin group successfully', 'green');
                // } else {
                //     CLI::error('Failed to add user to superadmin group');
                //     $userModel->db->transRollback();
                //     return;
                // }
            } else {
                CLI::error('Failed to create user: ' . print_r($userModel->errors(), true));
                $userModel->db->transRollback();
                return;
            }

            $userModel->db->transComplete();

            if ($userModel->db->transStatus() === false) {
                CLI::error('Transaction failed. Changes have been rolled back.');
            } else {
                CLI::write('Super admin user created, added to group, and details saved successfully!', 'green');
            }
        } catch (\Exception $e) {
            $userModel->db->transRollback();
            CLI::error('An error occurred: ' . $e->getMessage());
            CLI::write('Error details: ' . $e->getTraceAsString(), 'yellow');
        }
    }
}