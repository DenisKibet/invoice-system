<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice System - Pricing</title>
    <?php include 'css.php' ?>
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
<body id="page-top">
    <?php include 'welcome_topbar.php'?>

    <div class="container mb-5">
        <div class="pricing-header-test text-center mt-4">
            <div class="pricing-header" style="color: #000000; font-size: 1.5rem;">
                <p class="font-weight-bold">Scalable pricing plans</p>
            </div>
            <div>
                <p style="font-size: 1.2rem;">For all businesses at every stage and size</p>
            </div>
            <div class="monthly-pay border" style="height: auto;">
                <input type="button" class="reset-style" style="border-radius: 50px 0px 0px 50px; color: #000000;" id="payMonthly" value="Pay monthly">                
                <input type="button" class="reset-style" style="border-radius: 0px 50px 50px 0px;" id="payYearly" value="Pay yearly (save 25%)">                
            </div>
        </div>
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
                            <button type="button" class="text-white reset-style" id="basic_plan" style="background-color:#000000; width: 100%; border-radius: 50px;">Try for free</button>
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
                            <button type="button" class="text-white reset-style" id="shopify_plan" style="background-color:#000000; width: 100%; border-radius: 50px;">Try for free</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
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
                            <button type="button" class="text-white reset-style" id="advance_plan" style="background-color:#000000; width: 100%; border-radius: 50px;">Try for free</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'welcome_footer.php'?>

    <?php include 'js.php' ?>
    
    <script>
        $(document).ready(function() {
            // Set initial background color for "Pay yearly" button
            $('#payYearly').css({ backgroundColor: '#000', color: '#fff' });

            $('#payMonthly, #payYearly').click(function() {
                // Reset styles for both buttons
                $('#payMonthly, #payYearly').css({ backgroundColor: '#fff', color: '#000' });
                // Set styles for the clicked button
                $(this).css({ backgroundColor: '#000', color: '#fff' });
            });
        });
    </script>
</body>
</html>
