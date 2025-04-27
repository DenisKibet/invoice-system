<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Shield\Models\UserIdentityModel;
use CodeIgniter\Shield\Models\LoginModel;
// for auth

use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Entities\User;

class ProfileController extends BaseController
{
    protected $loginModel;
    protected $authModel;


    public function __construct()
    {
        $this->loginModel = new LoginModel(); 
        $this->authLogin = new UserIdentityModel(); 
        helper(['session']); 

    }


    public function profile() {
        
        $user_id = auth()->id();
        $userObject = new UserModel();
        $userData = $userObject->findById($user_id);

        if (!$userData) {
            return $this->respondNotFound('User not found');
        }

        $responseData = [
            "message"   => "Profile information of ".$userData->username,
            "status"    => true,
            'username'  => $userData->username,
            'user_id'   => $userData->id,
            'email'     => $userData->email,
        ];

        $data['responseData']= $responseData;
        return view('NEWCRM/profile', $data);

    // return $this->response->setJSON($responseData);
    }

}
