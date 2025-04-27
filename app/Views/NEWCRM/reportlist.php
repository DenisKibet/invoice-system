<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Report List</title>

    <?php include 'css.php'?>
    <style>
        /* start of monthly section */
        .monthOfTheYear {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 10px;
            position: relative; /* Ensure .monthOfTheYear is the containing block */
        }

        .monthOfTheYear span {
            flex: 1;
            text-align: center;
            padding: 5px;
            min-width: 50px;
            position: relative; /* To position the red underline relative to the span */
        }

        .current-month {
            font-weight: bold; 
            color: #000000; 
        }

        .current-month::after {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background-color: red;
            color: #5a5c69;
            position: absolute;
            bottom: -2px; /* Position the red line at the bottom of the current month span */
        }

        .underline {
            background-color: #f8f9fc;
            color: #5a5c69;
            height: 10px; 
        }

        .moneyIn-MoneyOut {
            display: flex;
            gap: 20px;
            align-items: baseline; 
            justify-content: center;
        }
        .canvas-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .canvas-container canvas {
            border: 0px solid #000;
            align-self: flex-start; 
        }
        .canvas-container p {
            margin: 5px 0;
            text-align: center; 
        }

        /* end of monthly section */
        .hover-div {
            width: 200px;
            height: 100px;
            background-color: blue;
            transition: background-color 0.3s;
        }

        .hover-div:hover {
            background-color: grey;
        }
        
        .hover-div a {
            color: #ccc; 
            text-decoration: none;
        }

        .record {
            color:black ;
            display: flex;
            justify-content: space-between;
        }

        .left-align {
            text-align: left;
            font-size: 18px;
        }

        .right-align {
            text-align: right;
            font-size: 18px;
        }
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
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebarreport.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid" style="color:black;">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><b>Reports</b></h1>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" style="color:#555555;" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="color:#555555;" id="reportlist-tab" data-toggle="tab" href="#reportlist" role="tab" aria-controls="reportlist" aria-selected="false">Report List</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" style="background-color:white;" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <?php 
                                $monthsOfTheYear = array('JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC');
                                $currentMonth = strtoupper(date('F')); 
                            ?>
                            <div class="monthOfTheYear pb-0">
                                <?php foreach ($monthsOfTheYear as $month) { 
                                    $class = ($month === strtoupper(substr($currentMonth, 0, 3))) ? 'current-month' : ''; // Add class if it matches
                                ?>
                                    <span class="<?php echo $class; ?>"><?php echo $month; ?></span>
                                <?php } ?>
                            </div>
                            <div class="underline pt-2" style="background-color: #f8f9fc;" >
                            </div>

                            <div class="my-4">
                                <div class="d-flex justify-content-between align-items-center">
                                <h2 class="mb-0">Business Insights</h2>
                                <p class="updated-time">Updated 4 Dec 12:36 am</p>
                                </div>

                                <!-- Insights Section -->
                                <!-- <div class="row mt-3">
                                <php
                                // Net incomings calculation
                                $netPercentage = (($lastMonthRevenue['current_month_revenue'] - $lastMonthRevenue['previous_month_revenue']) / $lastMonthRevenue['previous_month_revenue']) * 100;
                                $netDirection = $netPercentage >= 0 ? "up" : "down";
                                
                                // Incomings calculation
                                $incomingsPercentage = (($lastMonthExpenditure['current_month_revenue'] - $lastMonthExpenditure['previous_month_revenue']) / $lastMonthExpenditure['previous_month_revenue']) * 100;
                                $incomingsDirection = $incomingsPercentage >= 0 ? "up" : "down";
                                
                                // Outgoings calculation
                                $outgoingsPercentage = (($lastMonthBalanceReport['opening_balance'] - $lastMonthBalanceReport['closing_balance']) / $lastMonthBalanceReport['closing_balance']) * 100;
                                $outgoingsDirection = $outgoingsPercentage >= 0 ? "up" : "down";
                                ?>
                                
                                <div class="col-md-4">
                                    <div class="insights-card">
                                        <h6>INSIGHTS</h6>
                                        <p>Your net incomings went <php echo $netDirection; ?> by <b><php echo number_format(abs($netPercentage), 2); ?>%</b> last month. <a href="#" class="white-space: nowrap;">See cashflow details</a></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="insights-card">
                                        <h6>INSIGHTS</h6>
                                        <p>Your incomings went <php echo $incomingsDirection; ?> by <b><php echo number_format(abs($incomingsPercentage), 2); ?>%</b> last month. <a href="#">See cashflow details</a></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="insights-card">
                                        <h6>INSIGHTS</h6>
                                        <p>Your outgoings went <php echo $outgoingsDirection; ?> by <b><php echo number_format(abs($outgoingsPercentage), 2); ?>%</b> last month. <a href="#">See cashflow details</a></p>
                                    </div>
                                </div>
                            </div> -->

                                <!-- Summary Section -->
                                <h4 class="mt-4">Summary</h4>
                                <div class="row">
                                <!-- Incomings -->
                                <div class="col-lg-4">
                                    <div class="summary-header">Incomings</div>
                                    <div class="row"> 
                                        <div class="col-6">
                                            <div class="summary-card" style="background-color: #e4f2dc;">
                                                <small>Last month</small>
                                                <h3>KSh <?php echo number_format($lastMonthRevenue['previous_month_revenue'], 2); ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="summary-card" style="background-color: #f4f9f4;">
                                                <small>This month</small>
                                                <h3>KSh <?php echo number_format($lastMonthRevenue['current_month_revenue'], 2); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Outgoings -->
                                <div class="col-lg-4">
                                    <div class="summary-header" style="border-color: #66a6d9;">Outgoings</div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="summary-card" style="background-color: #daeaf7;">
                                                <small>Last month</small>
                                                <h3>KSh <?php echo number_format($lastMonthExpenditure['previous_month_revenue'], 2); ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="summary-card" style="background-color: #f4f9f4;">
                                                <small>This month</small>
                                                <h3>KSh <?php echo number_format($lastMonthExpenditure['current_month_revenue'], 2); ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Balance -->
                                <div class="col-lg-4">
                                    <div class="summary-header" style="border-color: #046c4e;">Balance</div>
                                    <div class="row">
                                    <div class="col-6">
                                        <div class="summary-card" style="background-color: #d0e1d7;">
                                            <small>Last month closing</small>
                                            <h3>KSh <?php echo number_format($lastMonthBalanceReport['closing_balance'], 2); ?></h3>
                                            </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="summary-card" style="background-color: #f4f9f4;">
                                        <small>Today opening</small>
                                        <h3>KSh <?php echo number_format($lastMonthBalanceReport['opening_balance'], 2); ?></h3>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <hr class="mb-5" style="1px solid  red">
                            
                            <!-- <div class="calender-logo">
                                <img class="pt-3 pb-5" src="assets/images/calenderLogo.png" width="10%" height="auto" style="display: block; margin: 0 auto;  border-radius: 50%;" />
                            </div>

                            <p class="pb-0" style="text-align: center; color:  #000000; font-weight: bold;">YOUR <?php echo strtoupper(date('F')); ?> SUMMERY</p> -->
                            <!-- START OF TEXT 1 -->
                            <div class="row">
                            <div class="col-lg-6">
                            <div class="moneyIn-MoneyOut">
                                <div class="canvas-container bg-red">
                                    <canvas id="myCanvas1"></canvas>
                                    <p class="mb-0" style="color: #999999;">money in</p>
                                    <p class="pt-0" style="color: #000000; font-weight: bold;">KSh <?php echo $money_in?></p>
                                </div>
                                <div class="canvas-container">
                                    <canvas id="myCanvas2"></canvas>
                                    <p class="mb-0" style="color: #999999;">money out</p>
                                    <p class="pt-0" style="color: #000000; font-weight: bold;">KSh <?php echo $money_out?></p> 
                                </div> 
                            </div>
                            <hr>
                            <div class="balanceStatement" style="display: flex; justify-content: center; align-items: center;">
                                <?php
                                    $moneyIn = $money_in;
                                    $moneyOut = $money_out;

                                    $balance = $moneyIn - $moneyOut;

                                    $negativeBalance = $moneyOut - $moneyIn;

                                    if ($moneyIn > $moneyOut) {
                                        echo "<p style=\"color: dark;\">You had KSh " . number_format($balance, 2) . " left over after " . date('F') . "'s spend.</p>";
                                    } elseif ($moneyOut > $moneyIn) {
                                        echo "<p style=\"color: red;\">In " . date('F') . ", you spent KSh " . number_format(abs($negativeBalance), 2) . " more than the total amount in.</p>";
                                    } else {
                                        echo "Money In is equal to Money Out<br>";
                                    }
                                ?>
                            </div>
                            </div>
                            <hr>

                            <div class="col-lg-6">
                            <div class="moneyIn-MoneyOut">
                                <div class="canvas-container">
                                    <canvas id="myCanvas3"></canvas>
                                    <p class="mb-0" style="color: #999999;">paid</p>
                                    <p class="pt-0" style="color: #000000; font-weight: bold;">KSh <?php echo $totalPaidFoCurrentMonth?></p>
                                </div>
                                <div class="canvas-container">
                                    <canvas id="myCanvas4"></canvas>
                                    <p class="mb-0" style="color: #999999;">Balance</p>
                                    <p class="pt-0" style="color: #000000; font-weight: bold;">KSh <?php echo $totalBalancesFoCurrentMonth?></p> 
                                </div> 
                            </div>
                            <hr>
                            <div class="balanceStatement" style="display: flex; justify-content: center; align-items: center;">
                                <?php
                                    $TotalPaidFoCurrentMonth = $totalPaidFoCurrentMonth;
                                    $TotalBalancesFoCurrentMonth = $totalBalancesFoCurrentMonth;

                                    $balanceRange = $TotalPaidFoCurrentMonth - $TotalBalancesFoCurrentMonth;

                                    $greaterBalance = $TotalBalancesFoCurrentMonth - $TotalPaidFoCurrentMonth;
                                    $greaterPaid = $TotalPaidFoCurrentMonth - $TotalBalancesFoCurrentMonth;


                                    if ($TotalPaidFoCurrentMonth === $TotalBalancesFoCurrentMonth) {
                                        echo "<p style=\"color: dark;\">In " . date('F') . ", you had all the balances KSh " . number_format($TotalBalancesFoCurrentMonth, 2) . " paid </p>";
                                    } elseif ($TotalBalancesFoCurrentMonth > $TotalPaidFoCurrentMonth) {
                                        echo "<p style=\"color: dark;\">In " . date('F') . ", you had a balance of KSh " . number_format(abs($greaterBalance), 2) . " unpaid.</p>";
                                    } elseif ($TotalBalancesFoCurrentMonth < $TotalPaidFoCurrentMonth) {
                                        echo "<p style=\"color: dark;\">In " . date('F') . ", you had a balance of KSh " . number_format(abs($greaterPaid), 2) . " paid.</p>";
                                    }else{
                                        echo "Money In is equal to Money Out<br>";
                                    }
                                ?>
                            </div>
                            </div>
                            </div>
                            <hr>
                            <!-- END OF TEST -->
                            <!-- <div class="largestPayment" style="display: flex; justify-content: center; align-items: center;">
                                <p>LARGEST PAYMENT</p>
                            </div>

                            <hr> -->



                            <!--Next phase  -->
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <h3>Total outstanding balance: </h3>
                                        <a href="/InvoiceListunpaid" style="text-decoration: none; color: inherit;">
                                            <h1><b><?= "KSh " . $totalbalance ?></b></h1>
                                        </a>
                                        <br />
                                        <br />
                                        Recent balances
                                        <table class="table">
                                            <thead>
                                                <tr style="color: #000;">
                                                    <th>Client Name</th>
                                                    <th>Email</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody style="color: #000;">
                                                <?php foreach ($balancecust as $custrecord) { ?>
                                                    <tr>
                                                        <td>
                                                            <a href="get_client_details/?clientid=<?= $custrecord->email ?>" style="text-decoration:none">
                                                                <?= $custrecord->client_name; ?>
                                                            </a>
                                                        </td>
                                                        <td><?= $custrecord->email; ?></td>
                                                        <td>
                                                            <?php
                                                            $balance = $custrecord->balance;
                                                            if (strpos($balance, 'KSh ') === false) {
                                                                $balance = 'KSh ' . $balance;
                                                            }
                                                            echo $balance;
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <br />
                            <div class="container-fluid row">
                                <div class="col-6 mb-3">
                                    <h3>Tax Year <?= date('Y'); ?> sales</h3>
                                    <h4><b><?= $totalinvoicesyear['count'] . ' invoices'  ?></b></h4>
                                    <h1><b><?= 'KSh ' . $totalinvoicesyear['total_amount'] ?></b></h1>
                                </div>
                                <div class="col-6"><select name="yearSelect" id="yearSelect" class="form-control" required>
                                        <option value="">Select Year</option>
                                        <?php foreach ($yearGroups as $year => $data) { ?>
                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <canvas id="myChartbarchart"></canvas>
                                            <p style="text-align: center;"> Average: KSh <?= $average ?>/month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle" style="white-space: nowrap; color: #000;">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>No of Invoices</th>
                                                    <th>Money In(KSh )</th>
                                                    <th>Money Out(KSh )</th>
                                                    <th>Total Profit(KSh )</th>
                                                    <!-- <th>Total Amount(KSh )</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $displayData = json_decode($displaydata1, true); 
                                                    foreach ($displayData as $month => $monthData) { ?>
                                                    <tr>
                                                        <td><?= $month ?></td>
                                                        <td><?= is_array($monthData) ? $monthData['No of Invoices'] : "—" ?></td>
                                                        <td><?= is_array($monthData) ? $monthData['Moeny In'] : "—" ?></td>
                                                        <td><?= is_array($monthData) ? $monthData['Money Out'] : "—" ?></td>
                                                        <td><?= is_array($monthData) ? $monthData['Total Profit'] : "—" ?></td>
                                                        <!-- <td><?= is_array($monthData) ? $monthData['Total Amount'] : "—" ?></td> -->
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <br />

                            <div>
                                <h3>Annual sales by client</h3>
                                <canvas id="chartIdpie" aria-label="chart"></canvas>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <h3>Staff Performance</h3>
                                    <canvas id="chartIdpiestaff" aria-label="chart"></canvas>
                                </div>
                                <div class="col">
                                    <?php
                                    $dataArray = json_decode($chartDatapiestaff, true);
                                    foreach ($dataArray as $username => $count) {
                                    ?>
                                        <div class="record">
                                            <div class="left-align"><?= $username; ?></div>
                                            <div class="right-align">
                                                <?= $totalinvoicesyear['count']; ?></div>
                                        </div>
                                        <hr class="sidebar-divider">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        


                        </div>
                        <div class="tab-pane fade m-4" style="background-color:white;" id="reportlist" role="tabpanel" aria-labelledby="reportlist-tab">
                            <div class="container-fluid mt-5">
                                <div class="row">
                                <div class="col">
                                        <div class="form-group">
                                            <label for="yearSelect">Tax Year:</label>
                                            <select name="yearSelect" id="yearSelectgenerate" class="form-control" required>
                                                <option value="">Select Year</option>
                                                <?php foreach ($yearGroups as $year => $data) { ?>
                                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="selectOption">Report Types:</label>
                                            <select class="form-control" id="selectOption" required>
                                                <option>Select an Option:</option>
                                                <option value="salesByClient">Sales by Client</option>
                                                <option value="salesByDate">Sales by Date</option>
                                                <option value="salesByStaff">Sales By Staff</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- Add the Generate Report button here -->
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-dark mb-4" onclick="generateReport()">Generate Report</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
         $(document).ready(function() {
            // Get the current date and time
            var loadTime = new Date();
            
            // Format the date and time (e.g., "4 Dec 12:36 am")
            var options = { day: 'numeric', month: 'short', hour: 'numeric', minute: 'numeric', hour12: true };
            var formattedTime = loadTime.toLocaleString('en-US', options);
            
            $(".updated-time").text("Updated " + formattedTime);
        });
        // newMonthlyReport
        $(document).ready(function () {
            // money in -money out section
            function drawRoundedRect(canvasId, color, amount, totalAmount) {
                var canvas = $(canvasId).get(0);
                var context = canvas.getContext('2d');

                var maxHeight = 220; // Maximum height for each canvas

                // Calculate height based on amount and totalAmount, maintaining ratio and constraining within maxHeight
                var height = Math.min((amount / totalAmount) * maxHeight, maxHeight);

                canvas.width = 150; // Fixed width for each canvas
                canvas.height = height; // Set canvas height dynamically based on amount

                // Define a method to draw a rounded rectangle
                CanvasRenderingContext2D.prototype.roundRect = function (x, y, width, height, radius) {
                    if (width < 2 * radius) radius = width / 2;
                    if (height < 2 * radius) radius = height / 2;
                    this.beginPath();
                    this.moveTo(x + radius, y);
                    this.arcTo(x + width, y, x + width, y + height, radius);
                    this.arcTo(x + width, y + height, x, y + height, radius);
                    this.arcTo(x, y + height, x, y, radius);
                    this.arcTo(x, y, x + width, y, radius);
                    this.closePath();
                    return this;
                };

                // Dimensions of the rounded rectangle
                var rectWidth = 40;
                var rectHeight = height - 20; // Adjusting height for better positioning
                var rectX = (canvas.width / 2) - (rectWidth / 2);
                var rectY = (canvas.height / 2) - (rectHeight / 2);
                var radius = rectWidth / 2; // Make corners fully circular

                // Draw the rounded rectangle
                context.roundRect(rectX, rectY, rectWidth, rectHeight, radius);

                // Set fill style and fill the rectangle
                context.fillStyle = color;
                context.fill();
            }

            // typecasting to float and  Usage example based on PHP variables 
            var moneyInAmount = parseFloat(<?php echo json_encode($moneyIn); ?>);
            var moneyOutAmount = parseFloat(<?php echo json_encode($moneyOut); ?>);
            var totalAmount = moneyInAmount + moneyOutAmount; // Assuming total amount for ratio calculation

            // Draw rounded rectangle on #myCanvas1 with blue color and height based on moneyInAmount
            drawRoundedRect('#myCanvas1', ' #6666ff', moneyInAmount, totalAmount);

            // Draw rounded rectangle on #myCanvas2 with red color and height based on moneyOutAmount
            drawRoundedRect('#myCanvas2', '#e60000', moneyOutAmount, totalAmount);


            // balance and paid graphs
            function drawRoundedRect(canvasId, color, amount, totalAmount) {
                var canvas = $(canvasId).get(0);
                var context = canvas.getContext('2d');

                var maxHeight = 220; // Maximum height for each canvas

                // Calculate height based on amount and totalAmount, maintaining ratio and constraining within maxHeight
                var height = Math.min((amount / totalAmount) * maxHeight, maxHeight);

                canvas.width = 150; // Fixed width for each canvas
                canvas.height = height; // Set canvas height dynamically based on amount

                // Define a method to draw a rounded rectangle
                CanvasRenderingContext2D.prototype.roundRect = function (x, y, width, height, radius) {
                    if (width < 2 * radius) radius = width / 2;
                    if (height < 2 * radius) radius = height / 2;
                    this.beginPath();
                    this.moveTo(x + radius, y);
                    this.arcTo(x + width, y, x + width, y + height, radius);
                    this.arcTo(x + width, y + height, x, y + height, radius);
                    this.arcTo(x, y + height, x, y, radius);
                    this.arcTo(x, y, x + width, y, radius);
                    this.closePath();
                    return this;
                };

                // Dimensions of the rounded rectangle
                var rectWidth = 40;
                var rectHeight = height - 20; // Adjusting height for better positioning
                var rectX = (canvas.width / 2) - (rectWidth / 2);
                var rectY = (canvas.height / 2) - (rectHeight / 2);
                var radius = rectWidth / 2; // Make corners fully circular

                // Draw the rounded rectangle
                context.roundRect(rectX, rectY, rectWidth, rectHeight, radius);

                // Set fill style and fill the rectangle
                context.fillStyle = color;
                context.fill();
            }

            // Typecasting to float and usage example based on PHP variables 
            var moneyInAmount = parseFloat(<?php echo json_encode($moneyIn); ?>);
            var moneyOutAmount = parseFloat(<?php echo json_encode($moneyOut); ?>);
            var totalAmount = moneyInAmount + moneyOutAmount; // Assuming total amount for ratio calculation

            var totalPaid = parseFloat(<?php echo json_encode($TotalPaidFoCurrentMonth); ?>);
            var totalBalance = parseFloat(<?php echo json_encode($TotalBalancesFoCurrentMonth); ?>);
            var totalMonthlyAmount = totalPaid + totalBalance;

            // Draw rounded rectangle on #myCanvas1 with blue color and height based on moneyInAmount
            drawRoundedRect('#myCanvas1', '#6666ff', moneyInAmount, totalAmount);

            // Draw rounded rectangle on #myCanvas2 with red color and height based on moneyOutAmount
            drawRoundedRect('#myCanvas2', '#e60000', moneyOutAmount, totalAmount);

            // Draw rounded rectangle on #myCanvas3 with green color and height based on totalPaid
            drawRoundedRect('#myCanvas3', '#28a745', totalPaid, totalMonthlyAmount);

            // Draw rounded rectangle on #myCanvas4 with orange color and height based on totalBalance
            drawRoundedRect('#myCanvas4', '#ff8c00', totalBalance, totalMonthlyAmount);
        });

        
        
        // end on newMonthlyReport


        function generateReport() {
            // Get selected values and trim any whitespace
            const reportType = document.getElementById("selectOption").value.trim();
            const selectedYear = document.getElementById("yearSelectgenerate").value.trim();

            // Validate report type
            if (!reportType || reportType === "Select an Option") {
                alert("Please select a valid report type.");
                return;
            }

            // Validate year (uncomment if year selection is mandatory)
            if (!selectedYear) {
                alert("Please select a year.");
                return;
            }

            // Construct the URL and navigate
            const url = `/reportlistgenerate?reportType=${encodeURIComponent(reportType)}&year=${encodeURIComponent(selectedYear)}`;
            window.location.href = url;
        }

        $(document).ready(function() {
            $('#yearSelect').on('change', function() {
                var selectedYear = $(this).val();
                if (selectedYear !== '') {
                    // Construct the new URL with the selected year as a query parameter
                    // var newUrl = 'get_client_details?year=' + selectedYear;
                    var newUrl = '/reportlistsearch?year=' + selectedYear;



                    // Redirect the browser to the new URL
                    window.location.href = newUrl;
                    
                }
            });
        });

        const ctx = document.getElementById('myChartbarchart');
        const chartData = <?= $chartData ?>;

        new Chart(ctx, {
            type: 'bar',
            data: {
                // labels: Object.keys(chartData), // Months as labels
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],

                datasets: [{
                    label: '# of Invoices',
                    data: Object.values(chartData),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                y: {
                    beginAtZero: true,
                    max: 0.5,
                    display: false, // Hide the y-axis grid lines
                    ticks: {
                    callback: function(value) {
                        return (value * 100).toFixed(0) + '%';
                    }
                    }
                },
                x: {
                    grid: {
                    display: false // Hide the x-axis grid lines
                    }
                }
                },
                plugins: {
                legend: {
                    display: false // Hide the legend
                }
                }
            }
        });


        var chrtstaff = document.getElementById("chartIdpiestaff").getContext("2d");
        const chartDatapiestaff = <?= $chartDatapiestaff ?>;
        const labelsstaff = Object.keys(chartDatapiestaff);
        const datasetDatastaff = Object.values(chartDatapiestaff);
        const uniqueColorsstaff = generateUniqueColors(labelsstaff.length);
        // Convert datasetData to numbers (since they are in string format)
        const numericDatastaff = datasetDatastaff.map(parseFloat);

        var chartId = new Chart(chrtstaff, {
            type: 'doughnut',
            data: {
                labels: labelsstaff,
                datasets: [{
                    label: "Staff Perfomance",
                    data: numericDatastaff,
                    backgroundColor: uniqueColorsstaff,
                    hoverOffset: 5
                }],
            },
            options: {
                responsive: false,
            },
        });


        var chrt = document.getElementById("chartIdpie").getContext("2d");
        const chartDatapie = <?= $chartDatapie ?>;
        const labels = Object.keys(chartDatapie);
        const datasetData = Object.values(chartDatapie);
        const uniqueColors = generateUniqueColors(labels.length);
        // Convert datasetData to numbers (since they are in string format)
        const numericData = datasetData.map(parseFloat);

        var chartId = new Chart(chrt, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: "Annual Sales By Client",
                    data: numericData,
                    backgroundColor: uniqueColors,
                    hoverOffset: 5
                }],
            },
            options: {
                responsive: false,
            },
        });
        // Function to generate an array of unique colors
        function generateUniqueColors(count) {
            const uniqueColorSet = new Set();
            const uniqueColors = [];

            while (uniqueColors.length < count) {
                const color = getRandomColor();
                if (!uniqueColorSet.has(color)) {
                    uniqueColors.push(color);
                    uniqueColorSet.add(color);
                }
            }

            return uniqueColors;
        }

        // Function to generate a random color
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>

</body>

</html>
