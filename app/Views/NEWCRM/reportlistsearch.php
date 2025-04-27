
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Invoice System - Reports</title>
    <?php include 'css.php' ?>
    <style>
         .hover-div {
            width: 200px;
            /* Set the width of your div */
            height: 100px;
            /* Set the height of your div */
            background-color: blue;
            /* Set the initial background color */
            transition: background-color 0.3s;
            /* Add a smooth transition effect */
        }

        .hover-div:hover {
            background-color: grey;
            /* Change the background color when hovering */
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
                        <div class="tab-pane fade show active p-3" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">

                            <div class="container-fluid row">
                                <div class="col-6">
                                    <h3>Tax Year <?= $yearselected; ?> sales</h3>
                                    <h4><b><?= $totalinvoicesyear['count'] . ' invoices'  ?></b></h4>
                                    <h1><b><?= '£' . $totalamount  ?></b></h1>
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
                                            <p style="text-align: center;"> Average: £<?= $average ?>/month</p>
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
                                                    <th>Money In(£)</th>
                                                    <th>Money Out(£)</th>
                                                    <th>Total Profit(£)</th>
                                                    <!-- <th>Total Amount(£)</th> -->
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
                                    // var_dump($chartDatapiestaff);
                                    $dataArray = json_decode($chartDatapiestaff, true);
                                    foreach ($dataArray as $username => $count) {
                                    ?>
                                        <div class="record">
                                            <div class="left-align"><?= $username; ?></div>
                                            <div class="right-align">
                                                <?= $count; ?></div>
                                        </div>
                                        <hr class="sidebar-divider">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>                          
                        </div>
                        <div class="tab-pane fade" id="reportlist" role="tabpanel" aria-labelledby="reportlist-tab">
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
                                        <button type="button" class="btn btn-dark" onclick="generateReport()">Generate Report</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Ivoice System <?= date('Y')?> </span>
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
        function generateReport() {
            // Get the selected values
            var reportType = document.getElementById("selectOption").value;
            var selectedYear = document.getElementById("yearSelectgenerate").value;

            // Construct the URL with selected values
            var url = "reportlistgenerate?reportType=" + reportType + "&year=" + selectedYear;

            // Navigate to the new URI
            window.location.href = url;
        }
        $(document).ready(function() {
            $('#yearSelect').on('change', function() {
                var selectedYear = $(this).val();
                console.log(selectedYear);
                if (selectedYear !== '') {
                    // Construct the new URL with the selected year as a query parameter
                    var newUrl = '/reportlistsearch?year=' + selectedYear;

                    // Redirect the browser to the new URL
                    window.location.href = newUrl;
                }
            });
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
