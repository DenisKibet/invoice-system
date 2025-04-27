<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice System - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <?php include'css.php'?>
    <style>
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

        /* Media queries */
        @media (max-width: 767.98px) {
            body {
                /* background-color: #ffffff !important; */
            }
            .card {
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body class="h-100 d-flex flex-column" style="background-color: #00A7FF;">
    <?php include 'welcome_topbar.php'; ?>
    
    <div class="flex-grow-1 d-flex align-items-center py-3 py-md-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-12 col-md-6 col-lg-5 mb-4 mb-md-0">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <h3 class="card-title text-center mb-4">Log in</h3>
                            
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

                            <form action="<?= url_to('login') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="loginEmail" name="email" placeholder="name@example.com" value="<?= htmlspecialchars(old('email')) ?>" required>
                                    <label for="loginEmail">Email address</label>
                                </div>
                                <div class="form-floating mb-3 position-relative">
                                    <input name="password" type="password" class="form-control" id="loginPassword" inputmode="text" autocomplete="current-password" placeholder="Password" required>
                                    <label for="loginPassword">Password</label>
                                    <i class="bi bi-eye-slash password-toggle" id="passwordToggle"></i>
                                </div>
                                <div class="mb-3">
                                    <a href="<?= url_to('magic-link') ?>" class="text-decoration-none">Forgot password?</a>
                                </div>
                                <button type="submit" class="btn btn-dark w-100 align-item-center" id="loginUser">Log in</button>
                            </form>
                            
                            <div class="mt-4 text-center">
                                <p class="mb-2">or continue with:</p>
                                <div class="d-flex justify-content-center">
                                    <a href="<?= site_url('google/login') ?>" class="btn btn-outline-dark rounded-circle p-2 mx-2">
                                        <img src="<?= base_url('assets/images/google-icon.png') ?>" alt="Google Icon" width="24" height="24">
                                    </a>
                                    <a href="#" class="btn btn-outline-dark rounded-circle p-2 mx-2">
                                        <img src="<?= base_url('assets/images/apple-logo.png') ?>" alt="Apple Logo" width="24" height="24">
                                    </a>
                                </div>
                            </div>
                            <div class="redirect d-flex d-flex align-items-center justify-content-center mt-2">
                                Don't have an account? <a href="<?= url_to('register') ?>" class="text-decoration-none pl-2"> Sign Up</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 d-none d-md-block">
                    <img src="<?= base_url('assets/images/login_img.png') ?>" alt="Login Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
    <?php include 'welcome_footer.php'?>
    <?php include 'js.php'?>
    
    <script>
        $(document).ready(function() {
            const $passwordInput = $('#loginPassword');
            const $passwordToggle = $('#passwordToggle');

            $passwordToggle.on('click', function() {
                const type = $passwordInput.attr('type') === 'password' ? 'text' : 'password';
                $passwordInput.attr('type', type);
                $(this).toggleClass('bi-eye bi-eye-slash');
            });
        });
    </script>
</body>
</html>