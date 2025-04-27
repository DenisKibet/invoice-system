<?php

namespace App\Controllers;
require_once APPPATH . 'Libraries/vendor/autoload.php'; // Add this line

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Google\Client;
use Google\Service\Oauth2;
use CodeIgniter\Controller;

class GoogleLoginController extends BaseController
{
    private $googleClient;

    public function __construct()
    {
        $this->googleClient = new \Google_Client();
        $this->googleClient->setClientId('781653121962-l32sqs78che48eaf6tcsppc6abk3o5sq.apps.googleusercontent.com');
        $this->googleClient->setClientSecret('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');
        $this->googleClient->setRedirectUri('http://localhost:8080/index.php/google/callback');
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function login()
    {
        // echo 'test';
        $authUrl = $this->googleClient->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function callback()
    {
        $code = $this->request->getVar('code');

        if ($code) {
            $this->googleClient->authenticate($code);
            $accessToken = $this->googleClient->getAccessToken();
            $oauth2 = new Oauth2($this->googleClient);

            $userInfo = $oauth2->userinfo->get();
            $email = $userInfo->email;
            $name = $userInfo->name;
           
            session()->set('user_info', $userInfo);

            // Save user info to your database and log the user in

            return redirect()->to('/dashboard'); // Redirect to your desired page
        }

        return redirect()->to('/login'); // Redirect back to login if something went wrong
    }
}
