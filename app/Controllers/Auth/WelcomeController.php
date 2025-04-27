<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WelcomeController extends BaseController
{
    public function index()
    {
        return view('NEWCRM/welcome_message');
    }
    
    public function pricing()
    {
        return view('NEWCRM/welcome_pricing');
    }

    public function resouces()
    {
        return view('NEWCRM/welcome_resouces');
    }

    public function features()
    {
        return view('NEWCRM/welcome_features');
    }

    public function privacyPolicy()
    {
        return view('NEWCRM/welcome_privacy-policy');
    }

    public function termsOfService()
    {
        return view('NEWCRM/welcome_terms_of_service');
    }

    public function cookiesPolicy()
    {
        return view('NEWCRM/welcome_cookies_policy');

    }
    public function aboutUs()
    {
        return view('NEWCRM/welcome_about_us');
    }

    public function contactUs()
    {
        return view('NEWCRM/welcome_contact_us');
    }

    public function documenation()
    {
        return view('NEWCRM/welcome_documentation');
    }

    public function pressAndMedia()
    {
        return view('NEWCRM/welcome_press_media');
    }
    
    public function contactUsNow()
    {
        // Check if request is AJAX
        $isAjax = $this->request->isAJAX();
        
        // Validate required fields
        $rules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Name is required',
                    'min_length' => 'Name must be at least 3 characters long',
                    'max_length' => 'Name cannot exceed 100 characters'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|max_length[100]',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'max_length' => 'Email cannot exceed 100 characters'
                ]
            ],
            'subject' => [
                'rules' => 'required|min_length[5]|max_length[200]',
                'errors' => [
                    'required' => 'Subject is required',
                    'min_length' => 'Subject must be at least 5 characters long',
                    'max_length' => 'Subject cannot exceed 200 characters'
                ]
            ],
            'message' => [
                'rules' => 'required|min_length[10]|max_length[2000]',
                'errors' => [
                    'required' => 'Message is required',
                    'min_length' => 'Message must be at least 10 characters long',
                    'max_length' => 'Message cannot exceed 2000 characters'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $response = [
                'status' => false,
                'errors' => $this->validator->getErrors(),
                'message' => 'Validation failed'
            ];
            
            return ($isAjax) 
                ? $this->response->setJSON($response)
                : redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get validated data
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'subject' => $this->request->getVar('subject'),
            'message' => $this->request->getVar('message'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        // return $this->response->setJSON(['message' => $data]);

        try {
            // Initialize Email service
            $email = \Config\Services::email();

            // Email configuration
            $emailConfig = [
                'mailType' => 'html'
            ];
            $email->initialize($emailConfig);

            // Prepare email content
            $emailContent = "
            <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #1a1a1a; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; margin-bottom: 20px;'>New Contact Form Submission</h2>
                
                <div style='background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;'>
                    <p style='margin: 10px 0;'><strong style='color: #1a1a1a; min-width: 100px; display: inline-block;'>Name:</strong> {$data['name']}</p>
                    <p style='margin: 10px 0;'><strong style='color: #1a1a1a; min-width: 100px; display: inline-block;'>Email:</strong> {$data['email']}</p>
                    <p style='margin: 10px 0;'><strong style='color: #1a1a1a; min-width: 100px; display: inline-block;'>Subject:</strong> {$data['subject']}</p>
                </div>
            
                <div style='margin-top: 20px;'>
                    <strong style='color: #1a1a1a; display: block; margin-bottom: 10px;'>Message:</strong>
                    <div style='background: #ffffff; padding: 15px; border-left: 3px solid #0d6efd; margin-bottom: 20px;'>
                        {$data['message']}
                    </div>
                </div>
            
                <p style='color: #666; font-size: 12px; margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;'>
                    Sent at: {$data['created_at']}
                </p>
            </div>";        

            // Set email parameters
            $email->setFrom($data['email'], $data['name']);
            $email->setTo('satechs.solutions@gmail.com'); // Replace with your company email
            $email->setSubject('New Contact Form Submission: ' . $data['subject']);
            $email->setMessage($emailContent);

            // Send email
            if ($email->send()) {
                // Optional: Save to database
                // $contactModel = new \App\Models\ContactModel(); // You'll need to create this model
                // $contactModel->insert($data);

                $response = [
                    'status' => true,
                    'message' => 'Thank you for contacting us. We will get back to you soon!'
                ];

                // Send auto-reply to user
                $email->clear();
                $email->setFrom('satechs.solutions@gmail.com', 'SaTech Solutions PLC');
                $email->setTo($data['email']);
                $email->setSubject('Thank you for contacting us');
                $email->setMessage("
                    <div style='font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto;'>
                        <h2 style='color: #1a1a1a; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; margin-bottom: 20px;'>Thank You for Contacting Us</h2>
                        
                        <p>Dear {$data['name']},</p>
                        
                        <p>We have received your message and appreciate you taking the time to write to us. Our team will review your message and get back to you as soon as possible.</p>
                        
                        <div style='background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;'>
                            <p style='margin: 0;'><strong>Subject:</strong> {$data['subject']}</p>
                        </div>
                        
                        <p>Best regards,<br>
                        SaTech Solutions PLC</p>
                        
                        <p style='color: #666; font-size: 12px; margin-top: 20px; padding-top: 10px; border-top: 1px solid #eee;'>
                            This is an automated response to your inquiry. Please do not reply to this email.
                        </p>
                    </div>
                ");
                $email->send();

            } else {
                $response = [
                    'status' => false,
                    'message' => 'Sorry, we could not send your message. Please try again later.'
                ];
            }

        } catch (\Exception $e) {
            log_message('error', 'Contact form error: ' . $e->getMessage());
            $response = [
                'status' => false,
                'message' => 'An error occurred. Please try again later.'
            ];
        }

        // Return response based on request type
        return ($isAjax)
            ? $this->response->setJSON($response)
            : redirect()->back()->with('message', $response['message']);
    }

    // SUBSCRIBE TO OUR NEWS LETTERS
    public function newLetterSubscription()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Invalid request method');
        }

        // Set validation rules
        $rules = [
            'email' => [
                'label' => 'Email',
                // 'rules' => 'required|valid_email|is_unique[newsletter_subscribers.email]',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please enter your email address',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'This email is already subscribed to our newsletter'
                ]
            ]
        ];

        // Run validation
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validation->getErrors(),
                'message' => 'Validation failed'
            ]);
        }

        // Get sanitized email
        $email = filter_var($this->request->getPost('email'), FILTER_SANITIZE_EMAIL);

        try {
            // Prepare data for insertion
            $data = [
                'email' => $email,
                'status' => 'pending',
                'verification_token' => bin2hex(random_bytes(32)),
                'subscription_date' => date('Y-m-d H:i:s'),
                'ip_address' => $this->request->getIPAddress(),
                'user_agent' => $this->request->getUserAgent()->getAgentString()
            ];

            // return $this->response->setJSON($data);
            // Save subscriber
            // $this->subscriberModel->insert($data);

            // Send verification email
            $this->sendVerificationEmail($email, $data['verification_token']);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Thank you for subscribing! Please check your email to confirm your subscription.'
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Newsletter Subscription] Error: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => false,
                'message' => 'An unexpected error occurred. Please try again later.'
            ])->setStatusCode(500);
        }
    }

    // protected function sendVerificationEmail($email, $token)
    // {
    //     $message = '<!DOCTYPE html>
    //     <html>
    //     <head>
    //         <meta charset="UTF-8">
    //         <meta name="viewport" content="width=device-width, initial-scale=1.0">
    //         <title>Confirm Your Newsletter Subscription</title>
    //         <style>
    //             body {
    //                 font-family: Arial, sans-serif;
    //                 line-height: 1.6;
    //                 color: #333333;
    //                 max-width: 600px;
    //                 margin: 0 auto;
    //                 padding: 20px;
    //             }
    //             .button {
    //                 display: inline-block;
    //                 padding: 12px 24px;
    //                 background-color: #0d6efd;
    //                 color: white;
    //                 text-decoration: none;
    //                 border-radius: 4px;
    //                 margin: 20px 0;
    //             }
    //             .footer {
    //                 margin-top: 30px;
    //                 padding-top: 20px;
    //                 border-top: 1px solid #eee;
    //                 font-size: 12px;
    //                 color: #666;
    //             }
    //         </style>
    //     </head>
    //     <body>
    //         <h2>Confirm Your Newsletter Subscription</h2>
            
    //         <p>Thank you for subscribing to our newsletter! To complete your subscription, please click the button below:</p>
            
    //         <a href="' . $verificationUrl . '" class="button">Confirm Subscription</a>
            
    //         <p>If the button doesn\'t work, you can copy and paste this link into your browser:</p>
    //         <p>' . $verificationUrl . '</p>
            
    //         <div class="footer">
    //             <p>If you didn\'t request this subscription, you can safely ignore this email or <a href="' . $unsubscribeUrl . '">click here to unsubscribe</a>.</p>
    //             <p>This email was sent by [Your Company Name]<br>
    //             [Your Company Address]</p>
    //         </div>
    //     </body>
    //     </html>';
    //     $email = \Config\Services::email();

    //     $email->setFrom('noreply@satechs.solutions.com', 'SaTechs Solutions');
    //     $email->setTo($email);
    //     $email->setSubject('Confirm Your Newsletter Subscription');

    //     $message = $message [
    //         'verificationUrl' => site_url("newsletter/verify/{$token}"),
    //         'unsubscribeUrl' => site_url("newsletter/unsubscribe/{$token}")
    //     ];

    //     $email->setMessage($message);
    //     $email->send();
    // }

    protected function sendVerificationEmail($emailAddress, $token)
{
    // Generate URLs first
    $verificationUrl = site_url("newsletter/verify/{$token}");
    $unsubscribeUrl = site_url("newsletter/unsubscribe/{$token}");
    
    // HTML email template
    $message = '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Confirm Your Newsletter Subscription</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                color: #333333;
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f9f9f9;
            }
            .container {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .button {
                display: inline-block;
                padding: 12px 24px;
                background-color: #0d6efd;
                color: white !important;
                text-decoration: none;
                border-radius: 4px;
                margin: 20px 0;
                font-weight: bold;
            }
            .footer {
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #eee;
                font-size: 12px;
                color: #666;
            }
            .link {
                word-break: break-all;
                color: #0d6efd;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>Confirm Your Newsletter Subscription</h2>
            
            <p>Thank you for subscribing to our newsletter! To complete your subscription, please click the button below:</p>
            
            <a href="' . $verificationUrl . '" class="button">Confirm Subscription</a>
            
            <p>If the button doesn\'t work, you can copy and paste this link into your browser:</p>
            <p class="link">' . $verificationUrl . '</p>
            
            <div class="footer">
                <p>If you didn\'t request this subscription, you can safely ignore this email or <a href="' . $unsubscribeUrl . '">click here to unsubscribe</a>.</p>
                <p>This email was sent by SaTechs Solutions<br>
                © ' . date('Y') . ' SaTechs Solutions. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>';

    try {
        $email = \Config\Services::email();

        // Email configuration
        $email->setFrom('noreply@satechs.solutions.com', 'SaTechs Solutions')
              ->setTo($emailAddress)
              ->setSubject('Confirm Your Newsletter Subscription')
              ->setMessage($message)
              ->setMailType('html'); // Explicitly set HTML mail type

        // Send email and check result
        if (!$email->send()) {
            log_message('error', 'Failed to send verification email to: ' . $emailAddress . '. Error: ' . $email->printDebugger(['headers']));
            return false;
        }

        return true;
    } catch (\Exception $e) {
        log_message('error', 'Exception while sending verification email: ' . $e->getMessage());
        return false;
    }
}
    public function verify($token)
    {
        $subscriber = $this->subscriberModel->where('verification_token', $token)
                                          ->where('status', 'pending')
                                          ->first();

        if (!$subscriber) {
            return redirect()->to('/')->with('error', 'Invalid or expired verification link.');
        }

        $this->subscriberModel->update($subscriber['id'], [
            'status' => 'active',
            'verification_token' => null,
            'verified_date' => date('Y-m-d H:m:s')
        ]);

        return redirect()->to('/')->with('success', 'Thank you! Your newsletter subscription has been confirmed.');
    }

    public function unsubscribe($token)
    {
        $subscriber = $this->subscriberModel->where('verification_token', $token)
                                          ->orWhere('unsubscribe_token', $token)
                                          ->first();

        if (!$subscriber) {
            return redirect()->to('/')->with('error', 'Invalid unsubscribe link.');
        }

        $this->subscriberModel->update($subscriber['id'], [
            'status' => 'unsubscribed',
            'unsubscribe_date' => Time::now()
        ]);

        return redirect()->to('/')->with('success', 'You have been successfully unsubscribed from our newsletter.');
    }
}
