<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice System - Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <?php include 'css.php' ?>
    <style>
        body {
            background-color: #00A7FF;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .btn-dark {
            border-radius: 5px;
        }
        .social-icon {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #dee2e6;
            border-radius: 50%;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        .social-icon:hover {
            background-color: #f8f9fa;
        }
        /* floating labels */
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            opacity: .65;
            transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
        }
        .form-floating > .form-control:not(:placeholder-shown) {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
        .form-floating > label {
            padding: 1rem 0.75rem;
        }

        /* toggle password visibility */
        .password-toggle {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 10;
        }
        /* media queries */
        @media (max-width: 767.98px) {
            body {
                background-color: #ffffff !important;
            }
            .card {
                box-shadow: none !important;
            }
            /* .container {
                padding-left: 15px;
                padding-right: 15px; */
            /* } */
        }
    </style>
</head>

<body class="h-100 d-flex flex-column" style="background-color: #00A7FF;">
    <?php include 'welcome_topbar.php'?>
    
    <div class="flex-grow-1 d-flex align-items-center py-3 py-md-5">
        <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-md-6 mb-4 mb-md-0">
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">Sign Up</h3>
                        
                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                        <?php elseif (session('errors') !== null) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php if (is_array(session('errors'))) : ?>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <?= $error ?>
                                        <br>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= session('errors') ?>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <form action="<?= url_to('register') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Enter company name" value="<?= old('companyname') ?>" required>
                                <label for="companyname">Company Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter full name" value="<?= old('username') ?>" required>
                                <label for="username">Full Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?= old('email') ?>" required>
                                <label for="email">Email address</label>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control" name="password" id="signUpPassword" placeholder="Password" required>
                                <label for="signUpPassword">Password</label>
                                <i class="bi bi-eye-slash password-toggle" id="passwordToggle"></i>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" style="border:1px solid #666;" id="agreementCheckbox" required>
                                <label class="form-check-label" style="font-weight: 500;" for="agreementCheckbox">
                                    By continuing, you agree to the <a href="terms-of-service" class="new-page-link" data-url="terms-of-service">Terms of Service</a> & 
                                    <a href="privacy-policy" class="new-page-link" data-url="privacy-policy">Privacy Policy</a>
                                </label>                            </div>
                            <button type="submit" class="btn btn-dark w-100" id="submitNewForm">Try It Free</button> 
                        </form>
                        
                        <div class="mt-4 text-center">
                            <p class="mb-2">or continue with:</p>
                            <div class="d-flex justify-content-center">
                                <a href="<?= site_url('google/login') ?>" class="social-icon">
                                    <img src="<?= base_url('assets/images/google-icon.png') ?>" alt="Google Icon" width="20" height="20">
                                </a>
                                <a href="#" class="social-icon">
                                    <img src="<?= base_url('assets/images/apple-logo.png') ?>" alt="Apple Logo" width="20" height="20">
                                </a>
                            </div>
                        </div>
                        <div class="redirect d-flex d-flex align-items-center justify-content-center mt-2">
                            Already have an account? <a href="<?= url_to('login') ?>" class="text-decoration-none pl-2"> Login</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-block">
                <img src="<?= base_url('assets/images/login_img.png') ?>" alt="Sign Up Image" class="img-fluid">
            </div>
        </div>
    </div>
    </div>
    <?php include 'welcome_footer.php'?>                  
    <?php include 'js.php' ?>
      <script>
        $(document).ready(function() {
            const $passwordInput = $('#signUpPassword');
            const $passwordToggle = $('#passwordToggle');

            $passwordToggle.on('click', function() {
                const type = $passwordInput.attr('type') === 'password' ? 'text' : 'password';
                $passwordInput.attr('type', type);
                $(this).toggleClass('bi-eye bi-eye-slash');
            });
        });
        // Open terms of service and privacy policy in a new page
        $('.new-page-link').on('click', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                window.open(url, '_blank');
            });
    </script>
</body>
</html>