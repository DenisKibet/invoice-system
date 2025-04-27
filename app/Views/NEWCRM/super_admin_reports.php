<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Reports Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> -->
    
    <!-- Chart.js for advanced visualizations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    
    <!-- Datatables for advanced table functionality -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <?php include 'css.php'?>

    
    <!-- Custom Inline Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            --secondary-gradient: linear-gradient(to right, #ff6a00, #ee0979);
        }
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
        }
        .dashboard-card {
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(0,0,0,0.15);
        }
        .stat-card {
            background: var(--primary-gradient);
            color: white;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255,255,255,0.1);
            transform: rotate(-45deg);
        }
        .chart-container {
            /* position: relative; */
            height: 350px;
        }
        .badge-custom {
            background: var(--secondary-gradient);
            color: white;
        }
        .datatable-container {
            background-color: white;
            border-radius: 12px;
            padding: 20px;
        }
       
        body {
            background-color: #f4f6f9;
        }
        .dashboard-card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .dashboard-card:hover {
            transform: scale(1.02);
        }
        .stat-card {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }
        /* Spinner on click */
        .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        width: 80px;
        height: 80px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    body.no-scroll {
        overflow: hidden;
    }

     /* Make wrapper take full viewport height */
    #wrapper {
        min-height: 100vh;
        position: relative;
    }

    /* Fix sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
    }

    /* Fix topbar */
    .topbar {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1000;
        /* Adjust left value to match sidebar width */
        margin-left: 14rem; /* Adjust this value based on your sidebar width */
    }

    /* Adjust content wrapper */
    #content-wrapper {
        min-height: 100vh;
        /* Adjust margin-left to match sidebar width */
        margin-left: 14rem; /* Should match your sidebar width */
    }

    /* Make main content scrollable */
    #content {
        /* Add padding-top to account for fixed topbar */
        padding-top: 4.375rem; /* Adjust based on your topbar height */
        height: 100vh;
        overflow-y: auto;
    }

    /* Ensure container-fluid takes remaining height */
    .container-fluid {
        height: 100%;
        padding: 1.5rem;
    }
    /* ====================================================================================================== */
    /* BUSINES INSIGHT STYLE */
    .insights-card {
      background-color: #f4f9f4;
      border: 1px solid #e0e6e0;
      border-radius: 5px;
      padding: 15px;
    }
    .insights-card h6 {
      color: #046c4e;
      font-weight: bold;
    }
    .summary-header {
      border-bottom: 3px solid #a0ce4e;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .summary-card {
      border: 1px solid #dcdcdc;
      border-radius: 5px;
      padding: 10px;
      text-align: center;
    }
    .summary-card h3 {
      font-size: 1.8rem;
      font-weight: bold;
    }
    .updated-time {
      font-size: 0.9rem;
      color: #a0a0a0;
      text-align: right;
    }
    /* ====================================================================================================== */
    </style>
</head>
<body class="bg-light" id="page-top">

     <!-- Page Wrapper -->
     <div id="wrapper">

        <!-- INCLUDE SIDEBAR HERE --> 
        <?php include 'super_admin_sidebar.php' ?>

          <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- INCLUDE TOP BAR HERE -->
                <nav class="topbar">
                    <?php include 'super_admin_topbar.php' ?>
                </nav>
                <!-- Begin Page Content -->
                <div class="container-fluid">
    
                    <!-- Main content -->
                    <div class="main-content">
                        <div class=" main-container container-fluid reports-container">
                            <!-- <h1 class="mb-4 text-center text-primary">Multi-Tenant System Revenue Dashboard</h1> -->
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-9">
                                    <h1 class="display-6 text-primary mb-2">Revenue Intelligence Dashboard</h1>
                                    <p class="text-muted">Real-time insights into your multi-tenant ecosystem</p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-outline-primary shadow-none text-nowrap" id="refreshDashboard">
                                            <i class="fas fa-sync"></i> Refresh Data
                                        </button>
                                        <button class="btn btn-primary shadow-none text-nowrap" data-bs-toggle="modal" data-bs-target="#exportModal">
                                            <i class="fas fa-download"></i> Export
                                        </button>
                                    </div>
                                </div>
                            </div>
<!-- ============================================================================================================ -->
                            <div class="my-4">
                                <div class="d-flex justify-content-between align-items-center">
                                <h2 class="mb-0">Business Insights</h2>
                                <p class="updated-time">Updated 4 Dec 12:36 am</p>
                                </div>

                                <!-- Insights Section -->
                                <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="insights-card">
                                    <h6>INSIGHTS</h6>
                                    <p>Your net incomings went down by <b>91.68%</b> last month. <a href="#" class="white-space: nowrap;">See cashflow details</a></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="insights-card">
                                    <h6>INSIGHTS</h6>
                                    <p>Your incomings went down by <b>14.47%</b> last month. <a href="#">See cashflow details</a></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="insights-card">
                                    <h6>INSIGHTS</h6>
                                    <p>Your outgoings went down by <b>9.75%</b> last month. <a href="#">See cashflow details</a></p>
                                    </div>
                                </div>
                                </div>

                                <!-- Summary Section -->
                                <h4 class="mt-4">Summary</h4>
                                <div class="row">
                                <!-- Incomings -->
                                <div class="col-md-4">
                                    <div class="summary-header">Incomings</div>
                                    <div class="row"> 
                                        <div class="col-6">
                                            <div class="summary-card" style="background-color: #e4f2dc;">
                                                <small>Last month</small>
                                                <h3>£<?php echo number_format($lastMonthRevenue['previous_month_revenue'], 2); ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="summary-card" style="background-color: #f4f9f4;">
                                                <small>This month</small>
                                                <h3>£<?php echo number_format($lastMonthRevenue['current_month_revenue'], 2); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Outgoings -->
                                <div class="col-md-4">
                                    <div class="summary-header" style="border-color: #66a6d9;">Outgoings</div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="summary-card" style="background-color: #daeaf7;">
                                                <small>Last month</small>
                                                <h3>£0</h3>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="summary-card" style="background-color: #f4f9f4;">
                                                <small>This month</small>
                                                <h3>£0</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Balance -->
                                <div class="col-md-4">
                                    <div class="summary-header" style="border-color: #046c4e;">Balance</div>
                                    <div class="row">
                                    <div class="col-6">
                                        <div class="summary-card" style="background-color: #d0e1d7;">
                                        <small>Last month closing</small>
                                        <h3>£<?php echo number_format($lastMonthBalance['closing_balance'], 2); ?></h3>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="summary-card" style="background-color: #f4f9f4;">
                                        <small>Today opening</small>
                                        <h3>£<?php echo number_format($lastMonthBalance['opening_balance'], 2); ?></h3>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <hr class="mb-5" style="1px solid  red">

<!-- ============================================================================================================ -->
                            <!-- Top Statistics Row -->
                            <div class="row mt-4 mb-4">
                                <div class="col-md-3">
                                    <div class="card dashboard-card stat-card p-3 text-center">
                                        <h5>Total Revenue</h5>
                                        <?php
                                            $formatter = new \NumberFormatter('en_GB', \NumberFormatter::CURRENCY);
                                            $formattedRevenue = $formatter->formatCurrency($yearlyRevenue['total_revenue'], 'GBP');

                                            // Calculate percentage increase
                                            $currentRevenue = $yearlyRevenue['total_revenue'];
                                            $prevRevenue = $yearlyRevenue['previous_month_revenue'];
                                            $percentageIncrease = $prevRevenue > 0
                                                ? (($currentRevenue - $prevRevenue) / $prevRevenue) * 100
                                                : 0;

                                            $formattedPercentage = number_format($percentageIncrease, 1) . '%';
                                        ?>
                                        <h2 class="fw-bold"><?= $formattedRevenue ?></h2>
                                        <small>+<?= $formattedPercentage ?> from last month</small>
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="card dashboard-card stat-card p-3 text-center">
                                        <h5>Active Tenants</h5>
                                        <!-- <h2 class="fw-bold">245</h2> -->
                                        <?php
                                            $totalCurrentActive = $currentlyActiveTenants['total_current_active'];
                                            $prevActive = $currentlyActiveTenants['total_active_subscription_as_at_lastmonth'];
                                        ?>
                                        <h2 class="fw-bold"><?=$totalCurrentActive ?></h2>
                                        <small>+<?= $prevActive?> new this month</small>
                                    </div>
                                </div>
                                
                                <?php
                                    $totalPlans = $plansSummery['subcription_count'];
                                    $montlyPlans = $plansSummery['monthly_subscription_count'];
                                    $yearlyPlans = $plansSummery['yearly_subscription_count'];
                                    
                                    // Calculate percentage of monthly and yearly plans
                                    $percentMonthly = $totalPlans > 0 ? round(($montlyPlans / $totalPlans) * 100, 2) : 0;
                                    $percentYearly = $totalPlans > 0 ? round(($yearlyPlans / $totalPlans) * 100, 2) : 0;
                                    
                                    // Calculate percentage change from previous period (if $prevRevenue is available)
                                    // $percentMonthlyChange = $montlyPlans > 0 && isset($prevRevenue)
                                    //     ? round((($montlyPlans - $prevRevenue) / $prevRevenue) * 100, 2)
                                    //     : 0;
                                ?>

                                <div class="col-md-3">
                                    <div class="card dashboard-card stat-card p-3 text-center">
                                        <h5>Monthly Plans</h5>
                                        <h2 class="fw-bold"><?= $montlyPlans ?></h2>
                                        <small><?= $percentMonthly ?>% of total tenants</small>
                                        <!-- <php if ($percentMonthlyChange != 0): ?>
                                            <small class="text-<= $percentMonthlyChange > 0 ? 'success' : 'danger' ?>">
                                                <= $percentMonthlyChange > 0 ? '+' : '' ?><= $percentMonthlyChange ?>% 
                                                from previous period
                                            </small>
                                        <php endif; ?> -->
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card dashboard-card stat-card p-3 text-center">
                                        <h5>Yearly Plans</h5>
                                        <h2 class="fw-bold"><?= $yearlyPlans ?></h2>
                                        <small><?= $percentYearly ?>% of total tenants</small>
                                    </div>
                                </div>
                            </div>
                            <!-- Charts Row -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card dashboard-card p-3">
                                        <h5 class="text-center mb-3">Monthly Revenue Trend</h5>
                                        <div class="chart-container">
                                            <canvas id="revenueChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card dashboard-card p-3">
                                        <h5 class="text-center mb-3">Plan Distribution</h5>
                                        <div class="chart-container">
                                            <canvas id="planDistributionChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <!-- Advanced Charts Row -->
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="card dashboard-card p-3">
                                        <h5 class="text-center mb-3">Comprehensive Revenue Breakdown</h5>
                                        <div class="chart-container">
                                            <canvas id="comprehensiveRevenueChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card dashboard-card p-3">
                                        <h5 class="text-center mb-3">Subscription Health</h5>
                                        <div class="chart-container">
                                            <canvas id="subscriptionHealthChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Detailed Tenant Table -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="table-responsive card p-3" >
                                        <h5 class="text-center mb-2">Tenant Revenue Breakdown</h5>
                                        <div class="card-body table-responsive">
                                            <table class="table table-striped table-hover" style="width: max-content; overflow: auto; min-width: 100%" cellspacing="0">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th>Tenant Name</th>
                                                        <th>Plan Type</th>
                                                        <th>Revenue</th>
                                                        <th>Subscription Status</th>
                                                        <th>Payment Date</th>
                                                        <th>Expiry Date </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($subscriptionDataForTable as $data):?>
                                                        <tr>
                                                            <!-- <td>TechCorp Solutions <= if (isset($data->tenant_company_name) {echo })_?></td> -->
                                                            <td><?= !empty($data->tenant_company_name) ? $data->tenant_company_name : 'TechCorp Solutions' ?> </td>
                                                            <td><?= $data->plan_name ?> <span class="text small"> (<?= $data->subscription_duration?>)</span> </td>
                                                            <td>£<?= $data->amount?></td>
                                                            <td><span class="badge bg-success" style="width:60%;"><?=ucfirst($data->subscription_status)?></span></td>
                                                            <td><?=$data->start_date?></td>
                                                            <td><?= $data->end_date?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this HTML just before the closing </body> tag -->
    <div id="loadingOverlay" class="overlay">
        <div class="spinner"></div>
    </div>


    <div class="modal fade" id="exportModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Export Report Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-csv me-2"></i> Export as CSV
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-excel me-2"></i> Export as Excel
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-file-pdf me-2"></i> Export as PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "js.php"?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        // Refresh Dashboard functionality
        $('#refreshDashboard').on('click', function() {
            // Show the loading overlay
            $('#loadingOverlay').css({
                'display': 'flex'
            });
            
            // Add no-scroll to body to prevent scrolling
            $('body').addClass('no-scroll');
            
            // Simulate a loading time (you can replace this with actual data refresh)
            setTimeout(function() {
                // Reload the page
                location.reload(false);
            }, 100); // 2 seconds delay to show the spinner
        });

        $(document).ready(function() {
            // Get the current date and time
            var loadTime = new Date();
            
            // Format the date and time (e.g., "4 Dec 12:36 am")
            var options = { day: 'numeric', month: 'short', hour: 'numeric', minute: 'numeric', hour12: true };
            var formattedTime = loadTime.toLocaleString('en-US', options);
            
            $(".updated-time").text("Updated " + formattedTime);
        });

        // Optional: Close overlay if it takes too long (fallback)
        $(document).ajaxError(function() {
            $('#loadingOverlay').hide();
            $('body').removeClass('no-scroll');
        });

        // Revenue Chart
        var revenueCtx = document.getElementById('revenueChart').getContext('2d');

        // Parse the PHP-passed data
        const lineGraphData = <?= $displayDataForLineGraph ?>;
        
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep','Oct', 'Nov', 'Dec'],
                // labels: Object.keys(lineGraphData), // Months as labels
                datasets: [{
                    label: 'Monthly Revenue',
                    // data: [65000, 59000, 80000, 81000, 56000, 95000, 75000, 79000, 65000, 85000, 90000],
                    data: Object.values(lineGraphData),
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Plan Distribution Chart
        var planCtx = document.getElementById('planDistributionChart').getContext('2d');
        
        // Parse the PHP-passed data
        var pieChartData = <?= json_encode($pieChartData) ?>;
        
        // Prepare labels and data arrays
        var labels = Object.keys(pieChartData);
        var dataValues = Object.values(pieChartData);

        new Chart(planCtx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: dataValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(75, 200, 140, 0.8)',
                        'rgba(90, 100, 150, 0.8)',
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
    
    $(document).ready(function() {
        // Comprehensive Revenue Chart
        var revenueCtx = document.getElementById('comprehensiveRevenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Monthly Revenue',
                        data: [65000, 59000, 80000, 81000, 56000, 95000],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgb(75, 192, 192)',
                        borderWidth: 1
                    },
                    {
                        label: 'Recurring Revenue',
                        data: [55000, 49000, 70000, 71000, 46000, 85000],
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    }
                }
            }
        });

        // Subscription Health Pie Chart
        var healthCtx = document.getElementById('subscriptionHealthChart').getContext('2d');

        // Parse the PHP-passed data
        var doughnutData = <?= json_encode($doughnutData)?>;

         // Prepare labels and data arrays
        var labels = Object.keys(doughnutData);
        var dataValues = Object.values(doughnutData);

        new Chart(healthCtx, {
            type: 'doughnut',
            data: {
                // labels: ['Active', 'Expiring Soon', 'Cancelled'],
                labels: labels ,
                datasets: [{
                    // data: [75, 15, 10],
                    data: dataValues,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
    </script>
</body>
</html>
