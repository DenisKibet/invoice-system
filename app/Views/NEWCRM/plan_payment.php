<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice System</title>
    <?php include 'css.php'?>
    <style>
        .vl {
            border-left: 1px solid #e5e5e5;
            height: 500px;
            left: 50%;
            margin-left: -3px;
            top: 0;
        }
         /* Reset and base styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f3f4f6;
    padding: 20px;
    line-height: 1.5;
}

/* Form container */
.payment-container {
    max-width: 800px;
    margin: 0 auto;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 24px;
}

.payment-title {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 24px;
    color: #1f2937;
}

/* Form elements */
.form-group {
    margin-bottom: 16px;
}

label {
    display: block;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 4px;
    color: #4b5563;
}

input[type="text"] {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 16px;
}

input[type="text"]:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
}

/* Card icons */
.card-icons {
    margin-top: 4px;
}

.card-icon {
    display: inline-block;
    margin-right: 8px;
    width: 40px;
    height: 25px;
    background-color: #e5e7eb;
    border-radius: 4px;
}

/* Grid layout for expiry and CVC */
.form-row {
    display: flex;
    gap: 16px;
}

.form-row .form-group {
    flex: 1;
}

/* Submit button */
.submit-button {
    display: block;
    width: 100%;
    padding: 12px;
    background-color: #4f46e5;
    color: #ffffff;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.submit-button:hover {
    background-color: #4338ca;
}

/* Terms and security message */
.terms-agreement {
    margin-top: 16px;
    font-size: 14px;
    color: #6b7280;
}

.terms-agreement a {
    color: #4f46e5;
    text-decoration: none;
}

.terms-agreement a:hover {
    text-decoration: underline;
}

.security-message {
    display: flex;
    align-items: center;
    margin-top: 16px;
    font-size: 14px;
    color: #6b7280;
}

.security-icon {
    margin-right: 8px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
}
.form-row {
    display: flex;
    justify-content: space-between;
}

.form-group {
    flex: 1;
    margin-right: 10px;
}

.form-group:last-child {
    margin-right: 0;
}

    </style>
</head>
<body id="page-top">
    <!-- logo -->
    <div class="header d-flex justify-content-between align-items-center pt-4 mx-5">
        <span class="ms-5 font-weight-bold d-none" style="font-size:1.6rem; cursor:pointer;" onclick="goBack()">&larr;</span>
        <?php 
            $companyDetailsModel = new \App\Models\CompanyDetailsModel();
            $companyDetails = $companyDetailsModel->find(1);
            $logoPath = $companyDetails->logo_path ?? 'assets/images/logo-holder.png'; // Using the alternative logo as fallback
        ?>
        <a href="/dashboard" class="mx-auto">
            <img src="<?= base_url($logoPath) ?>" class="img-fluid" style="height: 40px;" alt="Company Logo" />
        </a>
    </div>
    <hr>
    <div class="container">
        <!-- Plan details -->  
        <div class="row"  style="color: black;">
            <div class="col-sm-4 selected-plan">
                <!-- Display the content depending on the plan name -->
                <?php if ($plan === 'Basic'): ?>
                    <h5 class="font-weight-bold mb-4" style="color: black;">Basic Plan</h5>
                    <div class="card-atrributes" style="line-height: 0.5rem;">
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited clients</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited extra users</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited estimates</span></p>
                    </div>
                    <a href="plans-list" class="font-weight-bold" style="text-decoration:none; font-size: 1.2rem;">View other plans</a>
                <?php endif; ?>
                <?php if ($plan === 'Shopify'): ?>
                    <h5 class="font-weight-bold mb-4" style="color: black;">Shopify</h5>
                    <div class="card-atrributes" style="line-height: 0.5rem;">
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited clients</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited extra users</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited estimates</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">100 Invoices</span></p>
                    </div>
                    <a href="plans-list" class="font-weight-bold" style="text-decoration:none; font-size: 1.2rem;">View other plans</a>
                <?php endif; ?>
                <?php if ($plan === 'Advance'): ?>
                    <h5 class="font-weight-bold mb-4" style="color: black;">Advance</h5>
                    <div class="card-atrributes" style="line-height: 0.5rem;">
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited clients</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited extra users</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited estimates</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited Invoices</span></p>
                        <p><i class="fa fa-check fa-xs" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">Unlimited Client support</span></p>
                    </div>
                    <a href="plans-list" class="font-weight-bold" style="text-decoration:none; font-size: 1.2rem;">View other plans</a>
                <?php endif; ?>
            </div> 
            <!-- line seperator -->
            <div class="vl"></div>
            <div class="col-sm-7 order-details">
                <div class="payment-container">

                    <div class="order-summery">
                        <h5 class="font-weight-bold">Order Summery</h5>
                        <p class="mb-0 font-weight-bold" id="companyname"><?=$company->company_name?></p>
                        <p id="companyemail"><?=$company->email?></p>
                        <div class="selectedPlan d-flex flex-direction-row"> 
                            <?php if ($duration === 'monthly'): ?>
                                <p class="font-weight-bold" id="choosenplan"><?php echo $plan. ' plan'?> <span>(<?= $duration?>)</span></p>
                                <p id="planAmount" class="ml-auto"><?= '£'.$price?></span></p>
                            <!-- <php endif?> -->
                            <?php elseif ($duration === 'yearly'): ?>
                                <?php
                                    $annualPrice = $price * 12;
                                    $annualPercentDiscount = 25;
                                    $annualDueAmount = ($annualPrice * (75/100));
                                ?>
                                <p class="font-weight-bold" id="choosenplan"><?php echo $plan. ' plan'?> <span>(<?= $duration?>)</span></p>
                                <p id="planAmount" class="ml-auto"><?= '£'.$annualDueAmount?></span></p>
                            <?php endif?>
                        </div>
                        <div class="selectedPlan d-flex flex-direction-row" style="font-size: 1.6rem;">
                            <p class="font-weight-bold">Total due today</p>
                            <?php if ($duration === 'monthly'): ?>
                                <p id="planAmount" class="ml-auto"><?= '£'.$price?></span></p>
                            <?php elseif ($duration === 'yearly'): ?>
                                <p id="planAmount" class="ml-auto"><?= '£'.$annualDueAmount?></span></p>
                            <?php endif?>
                        </div>
                        <hr style="border-top: 2px solid #5a5c69;">
                    </div>

                    <div class="paymentMethod mt-4">
                        <h5 class="font-weight-bold mb-3">Payment method</h5>
                        <div class="card">
                            <div class="card-body">
                                 <!-- Used to display form errors -->
                                 <div id="card-errors" role="alert"></div>
                                    <form id="paymentForm" action="<?= site_url('process-payment') ?>" method="POST">
                                    <input type="hidden" name="companyName" value="<?= $company->company_name ?>">
                                    <input type="hidden" name="companyEmail" value="<?= $company->email ?>">
                                    <input type="hidden" name="totalAmountDue" value="<?= $duration === 'monthly' ? $price : $annualDueAmount ?>">

                                    <!-- Credit Card Number -->
                                    <div class="form-group">
                                        <label for="card-number">Credit card number</label>
                                        <div id="card-number" class="form-control"></div> <!-- Stripe Card Element -->
                                    </div>

                                    <!-- Expiry Date and Security Code -->
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="card-expiry">Expiry date</label>
                                            <div id="card-expiry" class="form-control"></div> <!-- Stripe Expiry Element -->
                                        </div>
                                        <div class="form-group">
                                            <label for="card-cvc">Security code</label>
                                            <div id="card-cvc" class="form-control"></div> <!-- Stripe CVC Element -->
                                        </div>
                                    </div>

                                    <!-- Display errors -->
                                    <div id="card-errors" role="alert" style="color: red;"></div>

                                    <div class="terms-agreement">
                                        By clicking on Buy, I agree to the <a href="#">Terms of Service</a>, <a href="#">Privacy Policy</a>, and <a href="#">Billing Policy</a>.
                                    </div>

                                    <button type="submit" class="submit-button mt-3 position-relative" id="buyButton">
                                        <span class="button-text">Buy <?= $plan ?></span>
                                        <span class="spinner-border spinner-border-sm position-absolute top-50 start-50 translate-middle d-none" role="status" aria-hidden="true"></span>
                                    </button>

                                    <div class="security-message">
                                        <span class="security-icon fa fa-lock"></span>
                                        Payment information is protected with bank-level encryption
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <footer class="sticky-footer mt-5 col-sm-12" style="background-color: #333;">
        <div class="container my-auto">
            <div class="copyright text-center my-auto text-white">
                <span>Copyright &copy; Invoice system <?=date('Y');?></span>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
                            
    <?php include('js.php');?>
    <script src="https://js.stripe.com/v3/"></script>
   
<script>
$(document).ready(function() {
    // go back
    function goBack() {
        window.history.back();
    }
    // Payment processor 
    var stripe = Stripe('pk_test_51Pl6Ib00vsPcUykJoJwqBBdGixYY95BZTVq98V5HbmdVKrbrjT1REyAqWmOmsqpof4yjgdZqtvox6r9KIZtV5Ef900BvVCVGUw'); // Replace with your actual publishable key
    var elements = stripe.elements();

    var style = {
        base: {
            fontSize: '16px',
            color: '#32325d',
        }
    };

    // Create an instance of the card Element
    var cardNumber = elements.create('cardNumber', { style: style });
    var cardExpiry = elements.create('cardExpiry', { style: style });
    var cardCvc = elements.create('cardCvc', { style: style });

    // Mount the Elements into their corresponding divs
    cardNumber.mount('#card-number');
    cardExpiry.mount('#card-expiry');
    cardCvc.mount('#card-cvc');

    // Handle real-time validation errors from the card Element
    cardNumber.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    cardExpiry.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    cardCvc.on('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    $('#paymentForm').on('submit', function(event) {
        event.preventDefault();
        
        stripe.createToken(cardNumber).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
            }
        });
    });

    // Submit the form with the token ID
    function stripeTokenHandler(token) {
        var form = document.getElementById('paymentForm');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
    // Bostrap spinner
    $('#buyButton').on('click', function() {
        var buttonText = $(this).find('.button-text');
        var spinner = $(this).find('.spinner-border');
        
        buttonText.addClass('invisible');
        spinner.removeClass('d-none');
        
        // Simulate form submission (replace with your actual form submission logic)
        setTimeout(function() {
            buttonText.removeClass('invisible');
            spinner.addClass('d-none');
        }, 2000); // Reset after 2 seconds (adjust as needed)
    });
});

</script>
</body>
</html>