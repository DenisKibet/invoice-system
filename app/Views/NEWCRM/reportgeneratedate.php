
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Invoice System - Report List</title>
    <?php include 'css.php' ?>
    <style>
        .table th {
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
            text-align: left;
            color:  000;
            font-size: 0.7rem;
        }
        .table td {
            color: black !important;
            font-size: 1rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .table tfoot {
            font-weight: bold;
            font-size: 20px;
        }

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
            display: flex;
            justify-content: space-between;
        }

        .left-align {
            text-align: left;
            font-weight: 700;
            font-size: 20px;
        }

        .right-align {
            text-align: right;
            font-weight: 700;
            font-size: 20px;
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
                    <a href="/reportlist" class="btn btn-dark">Go Back to Report List</a>
                    <br />
                    <br />
                    <table class="table" style="background-color:white;">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Sub Total</th>
                                <th>Total</th>
                                <th>Amount Paid</th>
                                <th>Amount Owed</th>
                                <th># of Invoices</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalcumulative_sub_total = array_fill_keys($allMonths, 0);
                            $totalcumulative_total = array_fill_keys($allMonths, 0);
                            $totalcumulative_paid = array_fill_keys($allMonths, 0);
                            $totalcumulative_balance = array_fill_keys($allMonths, 0);
                            $totalinvoices = array_fill_keys($allMonths, 0);
                            foreach ($reportlist as $item) {
                                $month = $item->month;

                                $totalcumulative_sub_total[$month] += floatval($item->cumulative_sub_total);
                                $totalcumulative_total[$month] += floatval($item->cumulative_total);
                                $totalcumulative_paid[$month] += floatval($item->cumulative_paid);
                                $totalcumulative_balance[$month] += floatval($item->cumulative_balance);
                                $totalinvoices[$month] += $item->count;
                            }

                            foreach ($allMonths as $month) {
                            ?>
                                <tr>
                                    <td><?php echo $month; ?></td>
                                    <td><?php echo 'Ksh ' . number_format($totalcumulative_sub_total[$month], 2); ?></td>
                                    <td><?php echo 'Ksh ' . number_format($totalcumulative_total[$month], 2); ?></td>
                                    <td><?php echo 'Ksh ' . number_format($totalcumulative_paid[$month], 2); ?></td>
                                    <td><?php echo 'Ksh ' . number_format($totalcumulative_balance[$month], 2); ?></td>
                                    <td><?php echo !empty($totalinvoices[$month]) ? $totalinvoices[$month] : 0; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total:</td>
                                <td><?php echo 'Ksh ' . number_format(array_sum($totalcumulative_sub_total), 2); ?></td>
                                <td><?php echo 'Ksh ' . number_format(array_sum($totalcumulative_total), 2); ?></td>
                                <td><?php echo 'Ksh ' . number_format(array_sum($totalcumulative_paid), 2); ?></td>
                                <td><?php echo 'Ksh ' . number_format(array_sum($totalcumulative_balance), 2); ?></td>
                                <td><?php echo array_sum($totalinvoices); ?></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Invoice System <?=date('Y');?></span>
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


</body>

</html>
