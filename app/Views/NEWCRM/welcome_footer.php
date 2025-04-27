<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Footer</title>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"> -->
    <!-- for sweet alert -->
    <!-- ?php include 'css.php'?> -->
    <style>
        .footer {
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 4rem 0 0 0;
            position: relative;
        }

        .footer-title {
            color: #ffffff;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: #0d6efd;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #9fa6b2;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-links a:hover {
            color: #ffffff;
            transform: translateX(5px);
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background-color: #0d6efd;
            transform: translateY(-3px);
        }

        .newsletter-input {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            /* color: #ffffff; */
            padding: 0.75rem 1.5rem;
        }

        .newsletter-input:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: #0d6efd;
            box-shadow: none;
            color: #ffffff;
        }

        .newsletter-btn {
            border-radius: 50px;
            padding: 0.75rem 2rem;
        }

        .bottom-bar {
            background-color: #151515;
            padding: 1.5rem 0;
            margin-top: 4rem;
        }

        .company-description {
            color: #9fa6b2;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .contact-info {
            color: #9fa6b2;
        }

        .contact-info i {
            color: #0d6efd;
            margin-right: 0.5rem;
            width: 20px;
        }

        .contact-item {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }

        .contact-item i {
            margin-top: 0.25rem;
        }
    </style>
</head>
<body>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h3 class="h4 text-white mb-4">Invoice System</h3>
                    <p class="company-description">
                        Leading provider of innovative invoicing solutions for businesses of all sizes. 
                        Streamline your billing process with our cutting-edge platform.
                    </p>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>123 Business Avenue<br>New York, NY 10001</div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>+1 (555) 123-4567</div>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>contact@invoicesystem.com</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h4 class="footer-title">Company</h4>
                    <ul class="footer-links">
                        <li><a href="about-us">About Us</a></li>
                        <li><a href="#">Our Team</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="press-media">Press & Media</a></li>
                        <li><a href="contact-us">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Products & Services -->
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h4 class="footer-title">Products</h4>
                    <ul class="footer-links">
                        <li><a href="features">Features</a></li>
                        <li><a href="pricing">Pricing</a></li>
                        <li><a href="#">Integration</a></li>
                        <li><a href="documenation">Documentation</a></li>
                        <li><a href="#">Release Notes</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-lg-4">
                    <h4 class="footer-title">Stay Updated</h4>
                    <p class="text-white mb-4">Subscribe to our newsletter for updates and insights.</p>
                    <form class=" newsletter-form mb-4">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control newsletter-input" id="your-email-address"  placeholder="Your email address" style="background-color: #fff;">
                            <div class="input-group-append">
                                <span class="btn btn-primary nput-group-text " id="subscribe" type="submit">Subscribe</span>
                            </div>
                        </div>
                    </form>
                    
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bottom-bar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0 text-white">© 2024 Invoice System. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav class="nav justify-content-md-end justify-content-center mt-3 mt-md-0">
                            <!-- <a class="nav-link text-white px-2" href="#">Privacy Policy</a> -->
                            <a class="nav-link text-white px-2" href="privacy-policy">Privacy Policy</a>
                            <a class="nav-link text-white px-2" href="terms-of-service">Terms of Service</a>
                            <a class="nav-link text-white px-2" href="cookies-policy">Cookie Policy</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php include 'js.php'?>
    <script>
        $(document).ready(function() {
        const NewsletterSubscription = {
            init: function() {
                this.$form = $('.newsletter-form');
                this.$emailInput = $('#your-email-address');
                this.$submitButton = $('#subscribe');
                
                if (this.$form.length) {
                    this.bindEvents();
                }
            },

            bindEvents: function() {
                // Handle form submission
                this.$form.on('submit', (e) => this.handleSubmit(e));
                
                // Handle button click (since it's a span with type="submit")
                this.$submitButton.on('click', (e) => {
                    e.preventDefault();
                    this.$form.submit();
                });
                
                // Handle input changes
                this.$emailInput.on('input', () => this.resetValidation());
            },

            resetValidation: function() {
                this.$emailInput.removeClass('is-invalid');
                // Remove any existing error message
                $('.invalid-feedback').remove();
            },

            handleSubmit: function(e) {
                e.preventDefault();
                
                // Reset any previous validation
                this.resetValidation();

                // Get email value
                const email = this.$emailInput.val().trim();
                
                // Basic validation
                if (!email) {
                    this.showError('Please enter your email address');
                    return;
                }

                // Save original button state
                const $btn = this.$submitButton;
                const originalText = $btn.html();
                
                // Update button state with loading spinner
                $btn.prop('disabled', true).html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Subscribing...
                `);

                // Submit the form
                // console.log(originalText);
                // return
                $.ajax({
                    url: '/newsletter/subscribe',
                    type: 'POST',
                    data: {
                        email: email
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .done((response) => {
                    console.log(response);
                    if (response.status) {
                        // Success case
                        Swal.fire({
                            icon: 'success',
                            title: 'Thank You!',
                            text: response.message,
                            confirmButtonColor: '#0d6efd',
                            customClass: {
                                container: 'newsletter-swal-container'
                            }
                        }).then(() => {
                            this.$form[0].reset();
                        });
                    } else {
                        // Handle validation errors
                        if (response.errors) {
                            if (response.errors.email) {
                                this.showError(response.errors.email);
                            } else {
                                this.showError('Please enter a valid email address');
                            }
                        } else {
                            // General error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message || 'Something went wrong. Please try again.',
                                confirmButtonColor: '#0d6efd'
                            });
                        }
                    }
                })
                .fail((jqXHR) => {
                    console.error('Subscription error:', jqXHR);
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Unable to process your request. Please try again later.',
                        confirmButtonColor: '#0d6efd'
                    });
                })
                .always(() => {
                    // Restore button state
                    $btn.prop('disabled', false).html(originalText);
                });
            },

            showError: function(message) {
                // Add error class to input
                this.$emailInput.addClass('is-invalid');
                
                // Add error message after the input-group
                this.$emailInput.closest('.input-group').after(`
                    <div class="invalid-feedback d-block">${message}</div>
                `);
            }
        };

        // Initialize the newsletter subscription
        NewsletterSubscription.init();
    });
    </script>
</body>
</html>