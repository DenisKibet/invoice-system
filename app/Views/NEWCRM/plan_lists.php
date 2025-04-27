<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase a plan</title>
    <?php include 'css.php'?>
    <style>
          /* Custom CSS styles */
        .monthly-pay {
            font-size: 0.8rem;
            max-width: fit-content;
            margin-inline: auto;
            display: flex;
            /* gap: 5px;  */
            border-radius: 50px;
        }
        
        .monthly-pay input {
            width: 125px; 
            padding: 3px;
            box-sizing: border-box;
            color: #ffffff;
            text-align: center; 
            border: 0px;
        }
        .reset-style {
            padding: 0;
            border: none;
            font: inherit;
            color: inherit;
            background-color: transparent;
            cursor: pointer;
        }
        
        /* Adjust spacing between cards */
        .pricing-body .card {
            margin-right: 10px; 
            
        }

        .pricing-body .card:last-child {
            margin-right: 0; 
        }
    </style>
</head>
<body>
    <div class="header d-flex justify-content-between align-items-center pt-4 mx-5">
        <span class="ms-5 font-weight-bold" style="font-size:1.6rem; cursor:pointer;" onclick="goBack()">&times;</span>
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
        <div class="pricing-header-test text-center mt-4">
            <div class="pricing-header" style="color: #000000; font-size: 1.5rem;">
                <p class="font-weight-bold">Choose a plan</p>
            </div>
            <div>
                <p style="font-size: 0.9rem;">Your free plan has expired.Renew now to create more invoices</p>
            </div>
            <div class="monthly-pay border" style="height: auto;">
                <input type="button" class="reset-style" style="border-radius: 50px 0px 0px 50px; color: #000000;" id="payMonthly" value="Pay monthly">                
                <input type="button" class="reset-style" style="border-radius: 0px 50px 50px 0px;" id="payYearly" value="Pay yearly (save 25%)">                
            </div>
        </div>

        <!-- plan listing -->
        <div class="row pricing-body g-1 justify-content-between mt-4">
            <div class="col-sm-4">
                <div class="card" style="border-radius: 1.1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div class="card-header-text p-0 text-center" style="border-top-left-radius: 1.1rem; border-top-right-radius: 1.1rem; background-color: #99e699;">
                        <p class="py-2 font-weight-bold text-black" style="margin-bottom: 0; color: #000000;">
                            £1 for the first month
                        </p>
                    </div>
                    <div class="card-body" style="color: #000000;">
                        <div class="d-flex flex-row justify-content-between align-items-baseline mb-2">
                            <h5 class="card-title font-weight-bold" style="color: #000000;">Basic</h5>
                            <p class="mb-0 border font-weight-bold text-black" style="padding: 1px 12px; background-color: #99e699; border-radius: 50px;">
                                Most Popular
                            </p>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">For solo entrepreneurs</h6>
                        <div class="pricing-amount d-flex align-items-center" style="display: inline-block; text-align: bottom;">
                            <div style="flex: 0.0;">
                                <p class="font-weight-bold" style="color: #000000; font-size: 3rem; margin-bottom: 0;">£19</p>
                            </div>
                            <div class="gbp-per-month">
                                <p style="margin-bottom: 0;">GBP</p>
                                <p style="margin-bottom: 0; line-height: 0.5rem;">/month</p>
                            </div>
                        </div>
                        <p class="card-text">billed once yearly</p>
                        <hr>
                        
                        <div class="card-body-text">
                            <p class="font-weight-bold text-black">Card rates starting at</p>
                            <div class="card-atrributes" style="line-height: 0.5rem;">
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">2% + 25p GBP online</span></p>
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">17% + 0p GBP in person</span></p>
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">2% + 3rd-party payment providers</span></p>
                            </div>
                        </div>
                        <div class="try-for-free text-center my-3">
                            <button type="button" class="text-white reset-style" id="basic_plan" style="background-color:#000000; width: 100%; border-radius: 50px;">Select</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card" style="border-radius: 1.1rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <div class="card-header-text p-0 text-center" style="border-top-left-radius: 1.1rem; border-top-right-radius: 1.1rem; background-color: #99e699;">
                        <p class="py-2 font-weight-bold text-black" style="margin-bottom: 0; color: #000000;">
                            £1 for the first month
                        </p>
                    </div>
                    <div class="card-body" style="color: #000000;">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                            <h5 class="card-title font-weight-bold" style="color: #000000;">Shopify</h5>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">For small teams</h6>
                        <div class="pricing-amount d-flex align-items-center" style="display: inline-block; text-align: bottom;">
                            <div style="flex: 0.0;">
                                <p class="font-weight-bold" style="color: #000000; font-size: 3rem; margin-bottom: 0;">£49</p>
                            </div>
                            <div class="gbp-per-month">
                                <p style="margin-bottom: 0;">GBP</p>
                                <p style="margin-bottom: 0; line-height: 0.5rem;">/month</p>
                            </div>
                        </div>
                        <p class="card-text">billed once yearly</p>
                        <hr>
                        <div class="card-body-text">
                            <p class="font-weight-bold text-black">Card rates starting at</p>
                            <div class="card-atrributes" style="line-height: 0.5rem;">
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">1.7% + 25p GBP online</span></p>
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">1.6% + 0p GBP in person</span></p>
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">1% + 3rd-party payment providers</span></p>
                            </div>
                        </div>
                        <div class="try-for-free text-center my-3">
                            <button type="button" class="text-white reset-style" id="shopify_plan" style="background-color:#000000; width: 100%; border-radius: 50px;">Select</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4" id="advance">
                <div class="card" style="border-radius: 1.1rem; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <div class="card-header-text p-0 text-center" style="border-top-left-radius: 1.1rem; border-top-right-radius: 1.1rem; background-color: #99e699;">
                        <p class="py-2 font-weight-bold text-black" style="margin-bottom: 0; color: #000000;">
                            £1 for the first month
                        </p>
                    </div>
                    <div class="card-body" style="color: #000000;">
                        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                            <h5 class="card-title font-weight-bold" style="color: #000000;">Advance</h5>
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">As your business scales</h6>
                        <div class="pricing-amount d-flex align-items-center" style="display: inline-block; text-align: bottom;">
                            <div style="flex: 0.0;">
                                <p class="font-weight-bold" style="color: #000000; font-size: 3rem; margin-bottom: 0;">£259</p>
                            </div>
                            <div class="gbp-per-month">
                                <p style="margin-bottom: 0;">GBP</p>
                                <p style="margin-bottom: 0; line-height: 0.5rem;">/month</p>
                            </div>
                        </div>
                        <p class="card-text">billed once yearly</p>
                        <hr>
                        <div class="card-body-text">
                            <p class="font-weight-bold text-black">Card rates starting at</p>
                            <div class="card-atrributes" style="line-height: 0.5rem;">
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">1.5% + 25p GBP online</span></p>
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">1.5% + 0p GBP in person</span></p>
                                <p><i class="fa fa-check" aria-hidden="true"></i> <span style="padding-left: 0.8rem;">0.6% + 3rd-party payment providers</span></p>
                            </div>
                        </div>
                        <div class="try-for-free text-center my-3">
                            <button type="button" class="text-white reset-style" id="advance_plan" data-plan-name="Advanced Plan" data-amount-per-month="259" style="background-color:#000000; width: 100%; border-radius: 50px;">Select</button>                        </div>
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


<?php include 'js.php' ?>
<script>
    // go back
    function goBack() {
        window.history.back();
    }
    $(document).ready(function() {
        // Set background color for "Pay yearly (save 25%)" button on page load
        $('#payYearly').css('background-color', '#000');
        $('#payYearly').css('color', '#fff');
        var selectedPaymentOption = 'yearly'; // Default to yearly

        // Specific functions and methods.
        $('#payMonthly').click(function() {
            $(this).css('background-color', '#000'); 
            $(this).css('color', '#fff'); 
            $('#payYearly').css('color', '#000'); 
            $('#payYearly').css('background-color', '#fff'); 
            selectedPaymentOption = 'monthly';
        })

        $('#payYearly').click(function() {
            $(this).css('background-color', '#000'); 
            $(this).css('color', '#fff'); 
            $('#payMonthly').css('color', '#000'); 
            $('#payMonthly').css('background-color', '#fff'); 
            selectedPaymentOption = 'yearly';
        })

        // Basic plan
        $(document).on("click", "#basic_plan", function(e) {
            var planData = {
                planName: 'Basic',
                duration: selectedPaymentOption,
                price: 19
            };
            
            $.ajax({
                method: 'POST',
                url: '/initiate-plan-payment',
                data: JSON.stringify(planData),
                contentType: 'application/json',
                success: function(response) {
                    if (response.paymentUrl) {
                        window.location.href = response.paymentUrl;
                    } else {
                        console.log('Unexpected response:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Failed: ' + error);
                }
            });
        });

        // Shopify plan
        $(document).on("click", "#shopify_plan", function(e) {
            var planData = {
                planName: 'Shopify',
                duration: selectedPaymentOption,
                price: 49
            };
            
            $.ajax({
                method: 'POST',
                url: '/initiate-plan-payment',
                data: JSON.stringify(planData),
                contentType: 'application/json',
                success: function(response) {
                    if (response.paymentUrl) {
                        window.location.href = response.paymentUrl;
                    } else {
                        console.log('Unexpected response:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Failed: ' + error);
                }
            });
        });

        // Advance plan
        $(document).on("click", "#advance_plan", function(e) {
            var planData = {
                planName: 'Advance',
                duration: selectedPaymentOption,
                price: 259
            };

            $.ajax({
                method: 'POST',
                url: '/initiate-plan-payment',
                data: JSON.stringify(planData),
                contentType: 'application/json',
                success: function(response) {
                    if (response.paymentUrl) {
                        window.location.href = response.paymentUrl;
                    } else {
                        console.log('Unexpected response:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Failed: ' + error);
                }
            });
        });

    });  

</script>
</body>
</html>