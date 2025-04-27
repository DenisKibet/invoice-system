<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Invoice System</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet"> -->
    <?php include 'css.php'?>
    <style>
        body {
            color: #333;
            line-height: 1.6;
        }

        .contact-header {
            background-color: #1a1a1a;
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
        }

        .section-title {
            color: #1a1a1a;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 2rem 0 1rem 0;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: #0d6efd;
        }

        .contact-content {
            margin-bottom: 4rem;
        }

        .contact-section {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .contact-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .contact-info-item i {
            font-size: 1.5rem;
            color: #0d6efd;
            margin-right: 1rem;
            min-width: 24px;
        }

        .contact-form .form-control {
            margin-bottom: 1rem;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .contact-form textarea.form-control {
            min-height: 150px;
        }

        .contact-form .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 500;
        }

        .contact-form .btn-primary:hover {
            background-color: #0b5ed7;
        }
    </style>
</head>
<body>
    <?php include 'welcome_topbar.php'?>
    
    <!-- Header -->
    <div class="contact-header">
        <div class="container">
            <h1 class="display-4">Contact Us</h1>
            <p class="lead">Get in touch with our team for support or inquiries.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container contact-content">
        <div class="row">
            <!-- Contact Information -->
            <div class="col-md-4">
                <div class="contact-section">
                    <h2 class="section-title">Get In Touch</h2>
                    <div class="contact-info">
                        <div class="contact-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Address</h4>
                                <p>123 Business Street<br>New York, NY 10001</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <h4>Phone</h4>
                                <p>+1 (555) 123-4567</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <h4>Email</h4>
                                <p>contact@invoicesystem.com</p>
                            </div>
                        </div>
                        <div class="contact-info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <h4>Business Hours</h4>
                                <p>Monday - Friday: 9:00 AM - 6:00 PM<br>
                                Sunday: 10:00 AM - 2:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-md-8">
                <div class="contact-section">
                    <h2 class="section-title">Send us a Message</h2>
                    <form class="contact-form" action="<?= url_to('contact-us-now')?>" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="contactUs">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'welcome_footer.php'?>
    
    <!-- Font Awesome for icons -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <?php include 'js.php'?>
    <script>
        $(document).ready(function() {
        // Get the form element
        const contactForm = $('.contact-form');
        
        // Handle form submission
        $('#contactUs').on('click', function(e) {
            e.preventDefault();
            
            // Get the button element
            const submitBtn = $(this);
            const originalBtnText = submitBtn.html();
            
            // Clear any existing error messages
            $('.error-message').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            // Get form data
            const formData = contactForm.serialize();
            
            // Disable the submit button and show loading state
            submitBtn.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
            
            $.ajax({
                url: contactForm.attr('action'),
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonColor: '#0d6efd'
                        }).then((result) => {
                            // Clear the form
                            contactForm[0].reset();
                        });
                    } else {
                        // Handle validation errors
                        if (response.errors) {
                            Object.keys(response.errors).forEach(function(key) {
                                const inputField = $(`#${key}`);
                                inputField.addClass('is-invalid');
                                
                                // Add error message below the input
                                inputField.after(`
                                    <div class="invalid-feedback error-message">
                                        ${response.errors[key]}
                                    </div>
                                `);
                            });

                            // Scroll to the first error
                            const firstError = $('.is-invalid').first();
                            if (firstError.length) {
                                $('html, body').animate({
                                    scrollTop: firstError.offset().top - 100
                                }, 500);
                            }
                        } else {
                            // Show error message
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message || 'Something went wrong. Please try again.',
                                confirmButtonColor: '#0d6efd'
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    // Handle server errors
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'There was a problem processing your request. Please try again later.',
                        confirmButtonColor: '#0d6efd'
                    });
                },
                complete: function() {
                    // Re-enable submit button and restore original text
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });

        // Real-time validation
        contactForm.find('input, textarea').on('input', function() {
            const input = $(this);
            if (input.hasClass('is-invalid')) {
                input.removeClass('is-invalid');
                input.next('.error-message').remove();
            }
        });
    });
    </script>
</body>
</html>