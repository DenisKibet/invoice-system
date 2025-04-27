<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Invoice System - Reset Password</title>
    <?php include 'css.php' ?>
    <!-- Include Font Awesome if not already included -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 500px;
        }
        .password-feedback {
            font-size: 0.8em;
            margin-top: 5px;
        }
        .password-input-wrapper {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body id="page-top">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Reset Your Password</h1>
                            </div>
                            <form id="passwordResetForm" class="user">
                                <input type="hidden" name="token" value="<?= $token ?>">
                                <div class="form-group mb-3 password-input-wrapper">
                                    <div class="position-relative">
                                        <input type="password" class="form-control form-control-user" id="new_password" name="new_password" placeholder="New Password" required>
                                        <i class="fas fa-eye password-toggle" id="toggle-new-password"></i>
                                    </div>
                                    <div id="password-feedback" class="password-feedback"></div>
                                </div>
                                <div class="form-group mb-3 password-input-wrapper">
                                    <div class="position-relative">
                                        <input type="password" class="form-control form-control-user" id="confirm_password" name="confirm_password" placeholder="Confirm New Password" required>
                                        <i class="fas fa-eye password-toggle" id="toggle-confirm-password"></i>
                                    </div>
                                    <div id="confirm-feedback" class="password-feedback"></div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block" id="submit-btn">
                                    Set New Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php' ?>
    <script>
        $(document).ready(function() {
            var $newPassword = $('#new_password');
            var $confirmPassword = $('#confirm_password');
            var $passwordFeedback = $('#password-feedback');
            var $confirmFeedback = $('#confirm-feedback');
            var $submitBtn = $('#submit-btn');

            function validatePassword(password) {
                var minLength = 8;
                var hasUpperCase = /[A-Z]/.test(password);
                var hasLowerCase = /[a-z]/.test(password);
                var hasNumbers = /\d/.test(password);
                var hasNonalphas = /\W/.test(password);
                
                if (password.length < minLength) {
                    return "Password must be at least " + minLength + " characters long.";
                } else if (!(hasUpperCase && hasLowerCase && hasNumbers && hasNonalphas)) {
                    return "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
                }
                return "";
            }

            function checkPasswordMatch() {
                var newPass = $newPassword.val();
                var confirmPass = $confirmPassword.val();
                
                var validationMessage = validatePassword(newPass);
                $passwordFeedback.text(validationMessage);
                $passwordFeedback.css('color', validationMessage ? 'red' : 'green');
                
                if (confirmPass.length > 0) {
                    if (newPass !== confirmPass) {
                        $confirmFeedback.text("Passwords do not match");
                        $confirmFeedback.css('color', 'red');
                        $submitBtn.prop('disabled', true);
                    } else {
                        $confirmFeedback.text("Passwords match");
                        $confirmFeedback.css('color', 'green');
                        $submitBtn.prop('disabled', validationMessage !== "");
                    }
                } else {
                    $confirmFeedback.text("");
                    $submitBtn.prop('disabled', validationMessage !== "");
                }
            }

            $newPassword.on('input', checkPasswordMatch);
            $confirmPassword.on('input', checkPasswordMatch);

            // Password visibility toggle
            $('.password-toggle').click(function() {
                var passwordField = $(this).siblings('input');
                var fieldType = passwordField.attr('type');
                
                if (fieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            $('#passwordResetForm').submit(function(e) {
                e.preventDefault();

                if ($newPassword.val() !== $confirmPassword.val()) {
                    alert('Passwords do not match');
                    return;
                }

                var validationMessage = validatePassword($newPassword.val());
                if (validationMessage) {
                    alert(validationMessage);
                    return;
                }

                $.ajax({
                    url: '/set-new-password',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        console.log(response);
                        
                        if (response.success) {                            
                            alert(response.message);
                            window.location.href = '/login';
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while updating the password. Please try again.');
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>