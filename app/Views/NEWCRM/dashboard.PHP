<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System- Dashboard</title>

	<!-- INCLUDE CSS FILES HERE -->
    <?php include 'css.php'?>


    <style>
        #toggleNotice {
            display: none;
        }

        #toggleHeader {
            background: #2489bb;
            padding: 10px;
        }

        #toggleHeader a {
            color: white;
            vertical-align: middle;
        }

        #viewNotice {
            background: #a9d8ef;
            color: #2489bb;
            border-bottom: 2px solid #2489bb;
            border-left: 1px solid #a9d8ef;
            border-right: 1px solid #a9d8ef;
        }

        .singleNoticeItem {
            padding-left: 10px;
            border-bottom: 1px solid #2489bb;
        }

        .singleNoticeItem:nth-child(even) {
            background: white;
        }
        /* Login alert */
        .custom-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        width: 300px;
        background-color: white;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
        padding: 5px;
        border-left: 4px solid #4CAF50;
        border-bottom: 2px solid #4CAF50;
        transition: opacity 1s ease, right 1s ease; /* Optional: smoother transition */
    }


    .alert-content {
        display: flex;
        align-items: flex-start;
    }

    .icon {
        color: #4CAF50;
        font-size: 20px;
        margin-right: 12px;
    }

    .text-content {
        flex-grow: 1;
    }

    .alert-title {
        font-size: 16px;
        font-weight: bold;
        color: #4CAF50;
        margin-bottom: 5px;
    }

    .message {
        font-size: 14px;
        color: #333;
    }

    .close-btn {
        position: absolute;
        top: -10px;
        right: -10px;
        background-color: #4CAF50;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 14px;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* For model */
    .modal-dialog {
    max-width: 460px;
    }

    .btn-primary {
    background-color: #6C63FF;
    border: none;
    }

    .btn-primary:hover {
    background-color: #5a52e8;
    }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- INCLUDE SIDEBAR HERE -->
        <?php include "sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- INCLUDE TOP BAR HERE -->
                <?php include "topbar.php" ?>
			
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <?php if (isset($message) && $message === 'loginSuccess'): ?>
                        <div id="customAlert" class="custom-alert">
                            <div class="alert-content">
                                <span class="icon">✓</span>
                                <div class="text-content">
                                    <div class="alert-title">Success</div>
                                    <span class="message">Login Successful.</span>
                                </div>
                            </div>
                            <button class="close-btn">×</button>
                        </div>
                    <?php endif; ?>

                    <!-- Content Row -->
                    <div class="row mb-5" style="padding-left:10px;padding-right:20px;">
                        <?php                                            
                        // The user has reached the free plan limit but has an active subscription
                        if ($hasReachedFreeLimit && $isSubscriptionActive) {
                        ?>
                            <div id="warningAlert" class="alert col-sm-12" role="alert" style="background-color: #e80e51; color: #ffffff; cursor: pointer;">
                                Your Free plan has expired.
                            </div>
                        <?php
                        }
                        ?>
                    
                    <div class="mt-2 card p-3" style="color:#555;padding-left:0;">
                        <h5 class="font-weight-bold">Overview</h5>
                        <div class="row">
                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-primary shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/InvoiceList" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total Invoice <span style=" font-size:large;">(<?= $invoiceSummary['count'] ?>)</span>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800"> 
                                                        <?php echo 'Ksh ' . number_format($invoiceSummary['total_amount'], 2, '.' , ',');?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-fw fa-folder fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-success shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/InvoiceList" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Paid Invoice <span style=" font-size:large;">(<?= $getPaidInvoicesSummary['count'] ?>)</span>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php  echo 'Ksh ' . number_format($getPaidInvoicesSummary['total_paid'], 2, '.', ','); ?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-fw fa-folder fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-info shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/InvoiceList" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Partialy Paid Invoice <span style=" font-size:large;">(<?= $partiallySummary['count'] ?>)</span>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php  echo 'Ksh ' . number_format($partiallySummary['total_paid'] ,2 , '.', ',');?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-fw fa-folder fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-warning shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/InvoiceList" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                        Unpaid Invoices <span style=" font-size:large;">(<?= $positiveBalanceInvoices['count'] ?>)</span>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo 'Ksh ' . number_format($positiveBalanceInvoices['total_balance'],2, '.',',');?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-fw fa-file-invoice-dollar fa-2x text-gray-300""></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-danger shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/InvoiceList" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                        Overdue Invoices <span style=" font-size:large;">(<?= $overdueInvoices['count'] ?>)</span>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo 'Ksh ' . number_format($overdueInvoices['total_amount'], 2, '.', ',');?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-fw fa-exclamation-circle fa-2x text-danger"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-primary shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/quoteList" style="text-decoration:none"> 
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total Estimates <span style=" font-size:large;">(<?= $estimateSummary['count'] ?>)</span>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo 'Ksh ' .  number_format($estimateSummary['total_amount'],2, '.', ',');?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-info shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/InvoiceList" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                        Estimates to invoices <span style=" font-size:large;">(<?= $invoicesFromEstimates['count'] ?>)</span>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo 'Ksh ' . number_format($invoicesFromEstimates['total_amount'],2, '.', ',');?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-fw fa-exchange-alt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-secondary shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/clientList" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                        Total Clients 
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php
                                                        echo $totalClients;
                                                        ?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <h5 class="pt-4 font-weight-bold"> Current Month</h5>
                        <div class="row">
                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-primary shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/financials" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        <p><?php echo $currentMonth;?> sales  <span style=" font-size:large;">(<?= $monthlyInvoiceSummary['count']; ?>)</span></p>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo 'Ksh ' . number_format($monthlyInvoiceSummary['total_amount'],2, '.', ',');?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-primary shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/financials" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        <p><?php echo 'Today Sale';?>   <span style=" font-size:large;">(<?= $todaySales['count'] ?>)</span></p>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php
                                                            echo 'Ksh '. $todaySales['total'] ;
                                                        ?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-3 mb-4">
                                <div class="card border-left-primary shadow-sm h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <a href="/quoteList" style="text-decoration:none">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total Estimates <span style=" font-size:large;">(<?= $monthlyEstimatesSummary['total_estimates']; ?>)</span>
                                                    </div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                        <?php echo 'Ksh ' .$monthlyEstimatesSummary['total_amount'];?>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-12 mb-1 mt-3">
                        <h3>Recent Activity</h3> 
                    </div>
                    <div class="card col-lg-6 col-sm-12">
                        <div class="card-header">
                            Recently Added
                        </div>
                        <div class="card-body">
							<?php
                            foreach ($listClient as $client){
                            ?>
                                <p>Invoice <?= $client->invoice_no ?> from <?= $client->client_name?> </p>
                                <p><?= $client->status?></p>
                            <?php
                            }
                            ?>
						
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <!-- <div class="container my-auto"> -->
                    <div class="bottom-bar">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <p class="mb-0 text-dark" style="margin-left: 0%;">© <?=date('Y');?> Invoice System. All rights reserved.</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <nav class="nav justify-content-md-end justify-content-center mt-3 mt-md-0">
                                        <a class="nav-link text-dark px-2" href="privacy-policy">Privacy Policy</a>
                                        <a class="nav-link text-dark px-2" href="terms-of-service">Terms of Service</a>
                                        <a class="nav-link text-dark px-2" href="cookies-policy">Cookie Policy</a>
                                    </nav>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
     
    <!-- Subscription Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow border-0 bg-white">
                <div class="modal-body p-4 text-dark">
                    <div class="position-absolute top-0 end-0 p-3">
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>    

                    <div class="text-center my-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger rounded-circle mb-3" style="width: 64px; height: 64px;">
                            <i class="fas fa-exclamation text-white fs-4"></i>
                        </div>
                        <h4 class="fs-4 mb-3">Your invoice system plan has expired</h4>
                        <p class="text-muted">Subscribe now to one of our new plans and unlock premium features</p>
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 g-3 my-4">
                        <div class="col mt-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check text-success me-3"></i>
                                <span>Unlimited clients</span>
                            </div>
                        </div>
                        <div class="col mt-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check text-success me-3"></i>
                                <span>Unlimited extra users</span>
                            </div>
                        </div>
                        <div class="col mt-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check text-success me-3"></i>
                                <span>Unlimited estimates</span>
                            </div>
                        </div>
                        <div class="col mt-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check text-success me-3"></i>
                                <span>Premium support</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mt-5">
                        <button type="button" class="btn btn-primary py-2 shadow-none" id="getBasicPlanDashboardShow">
                            Get Basic Plan for Ksh 19/month
                        </button>
                        <a href="/plans-list" class="btn btn-outline-primary py-2 ms-3 shadow-none" id="viewAllPlans">
                            View all plans <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'js.php' ?>

    <script>
        $(document).ready(function() {
            // login alert
            function closeAlert() {
                $('#customAlert').animate({
                    opacity: 0,
                    right: '100%' // Move to the right out of view
                }, 2000, function() {
                    $(this).hide();
                });
            }

            // Manual close when clicking the close button
            $('.close-btn').click(function() {
                closeAlert();
            });

            // Automatically close the alert after 3 seconds with a fade and slide
            setTimeout(function() {
                closeAlert();
            }, 3000); // 3 seconds before fading starts

            $('#warningAlert').on('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                 $("#warningModal").modal("show");
            });
            
            $('#getBasicPlanDashboardShow').on('click', function(e) {
                
                var planData = {
                    planName: 'Basic',
                    duration: 'monthly',
                    price: 19
                };

                $.ajax({
                    method: 'POST',
                    url: '/initiate-plan-payment-from-dashboard',
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
