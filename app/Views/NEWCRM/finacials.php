<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Invoice System - Financials</title>
    <?php include 'css.php' ?>
    <style>
    #qdataTable {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        border: none;
    }
    #qdataTable td,
    #qdataTable th {
        padding: 3px;
        text-align: left;
        border: none;
        border-bottom: 1px solid #ddd; 
    }
    #qdataTable td.agent-column {
        text-align: center; 
        vertical-align: middle;
    }

    .agent-initials {
        text-align: center;
        background: #fff;
        border-radius: 50%;
        width: 27px;
        height: 27px;
        line-height: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        margin: 0;
        border-radius: 9999px;
        padding: 1.2rem;
    }

    #qdataTable tr:nth-child(even) {
        /* background-color: #f2f2f2; */
    }

    #qdataTable tr:hover {
        background-color: #e6e6e6;
        color: #186081;
        /* cursor:pointer; */
    }

    #qdataTable th {
        padding-top: 0.4rem;
        padding-bottom: 0.4rem;
        text-align: left;
        background-color: #f9fafb;
        color:  #bfbfbf;
        font-size: 0.7rem;
    }

    #qdataTable td {
        padding-top: 0.2rem;
        padding-bottom: 0.2rem;
        color: #555;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    #qdataTable th {
        color: #777;
    }

    #qdataTable td,
    #qdataTable th {
        border-right: none;
    }

    #qdataTable th, #qdataTable td {
        border-left: none; 
        border-top: none; 
    }
    #qdataTable tr:last-child td {
        border-bottom: none; 
    }

    * {
        box-sizing: border-box;
    }

    .icon {
        vertical-align: middle;
    }
</style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebarfinancials.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Financials</h1>
                    </div>

                    <div class="col-sm-12 mb-5 mt-3 card p-3" style="color:#555;padding-left:0;">
                        <div class="row">
                            <div class="col-md-12 col-lg-3">
                                <h5 style="color:#808080;font-weight:500;">Filter by Date:</h5>
                                <label style="font-weight:700;">From:</label><br />
                                <input type="text" name="min" id="min" class="form-control filterDate" />
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <h5 style="color:#2489bb;font-weight:500;visibility:hidden;">Filter by Date:</h5>
                                <label style="font-weight:700;">To:</label><br />
                                <input type="text" name="max" id="max" class="form-control filterDate" />
                            </div>
                            <div class="col-md-12 col-lg-2 mb-3" style="padding-bottom:0;">
                                <h5 style="color:#2489bb;font-weight:500;visibility:hidden;">Filter:</h5>
                                <label style="font-weight:700;visibility:hidden;">From:</label><br />
                                <input type="button" class="form-control col-lg-6"
                                    style="background:#808080;color:white;" id="resetFilter" value="Reset" />
                            </div>

                            <div class="col-md-12 col-lg-2">
                                <h5 style="color:#808080;font-weight:500;">Filter by Agent:</h5>
                                <label>Select Agent</label>
                                <select name="filterOwner" id="filterOwner" class="form-control">
                                    <option id="selectedOwner" selected value="All Agent">All Agent</option>
                                    <?php foreach($users as $owner) { ?>
                                    <option value='<?= $owner->username ?>'><?= $owner->username ?></option>
                                    <?php } ?>
                                    <option value="Unassigned">Unassigned</option>
                                </select>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="table-responsive card p-3" style="color: #555;">
                        <table class="table table-bordered" id="qdataTable" style="width: max-content; overflow: auto; min-width: 100%" cellspacing="0">
                            <thead>
                                <tr class="header">
                                    <th>Invoive ref</th>
                                    <th>Client</th>
                                    <th class="agent_initial">Agent </th>
                                    <th id="dateCreated">Date</th>
                                    <th class="text-right" >Sale Price</th>
                                    <th class="text-right" >Net Price</th>
                                    <th class="text-right" >Paid</th>
                                    <th class="text-right" >Balance</th>
                                    <th class="text-right" >Profit/Loss</th>
                                    <th class="text-right" >Margin %</th>
                                </tr>
                            </thead>
                                <!-- <php 
                                    foreach ($invoices as $invoice)
                                    // var_dump($invoice->id);
                                ?> -->
                           <tbody> 
                                <?php 
                                    $hasReachedFreeLimit = $session->get("has_reached_free_limit");
                                    $isSubscriptionActive = $session->get("is_subscription_active");
                                    $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
                                ?>
                                <?php foreach ($invoices as $invoice): ?>
                                <tr class="text-right agentButtonview" data-id="<?php echo $invoice->id; ?>" style="cursor: pointer;">
                                    <td class="text-primary"><?php echo $invoice->invoice_no?></td>
                                    <!-- <?php
                                        $clientName = '';
                                        foreach ($clients as $client) {
                                            if ($client->EmailAddress == $invoice->email) {
                                                $clientName = $client->ClientName;
                                                break;
                                            }
                                        }
                                    ?> -->
                                    <td><?php echo $clientName; ?></td>
                                        <!-- <?php
                                            $initials = '';
                                            if (isset($invoice->username)) {
                                                $initials = strtoupper(substr($invoice->username, 0, 2));
                                            }
                                        ?> -->
                                    <td class="agent-column"><div class="agent-initials text-success card-success" style="background: #ebfaeb;"><?= $initials?></div></td>
                                    <td class="dateCreated">
                                        <?php
                                            $invoice_date = $invoice->invoice_date;
                                            $converted_date =str_replace('/', '-', $invoice_date);
                                            echo $converted_date;
                                        ?>
                                    </td>
                                    <td class="text-right"><?php echo $invoice->total; ?></td>
                                    <td class="text-right"><?php echo $invoice->netprice; ?></td>
                                    <td class="text-right"><?php echo $invoice->paid; ?></td>
                                    <td class="text-right"><?php echo $invoice->balance; ?></td>
                                    <td class="text-right" <?php echo ($invoice->profit_loss < 0) ? 'style="color: red;"' : ''; ?>>
                                        <?php echo $invoice->profit_loss; ?>
                                    </td>
                                    
                                        <?php 
                                            $salesProfit = floatval($invoice->profit_loss);
                                            // var_dump($salesProfit);
                                            $netPrice = floatval($invoice->netprice);
                                            
                                            // Check if $netPrice is not zero to avoid division by zero error
                                            if ($netPrice != 0) {
                                                $percentProfit = ($salesProfit / $netPrice) * 100;
                                            } else {
                                                // Handle division by zero error if necessary
                                                $percentProfit = 0;
                                            }
                                            $percentProfitFormatted = sprintf("%.0f", $percentProfit);

                                            
                                        ?>
                                    <td class="text-right" <?php echo ($percentProfitFormatted < 0) ? 'style="color: red;"' : ''; ?>>
                                        <?php echo $percentProfitFormatted; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr style="border-top: 1px solid #333;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td class="text-right" id="totalSalePrice">Ksh0.00</td>
                                    <td class="text-right" id="totalNetPrice">Ksh0.00</td>
                                    <td class="text-right" id="totalPaidPrice">Ksh0.00</td>
                                    <td class="text-right" id="totalBalancePrice">Ksh0.00</td>
                                    <td class="text-right" id="totalProfitLossPrice">Ksh0.00</td>
                                    <td class="text-right" id="totalMargin">Ksh0.00</td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->

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
    </div>

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



    <div class="modal fade" id="Viewdets" tabindex="-1" role="dialog" aria-labelledby="viewdetsmodal" aria-hidden="true" style="color:black">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewdetsmodal">Invoice Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modalbody"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Viewdetspayment" tabindex="-1" role="dialog" aria-labelledby="viewdetsmodalpayment" aria-hidden="true" style="color:black">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewdetsmodalpayment">Payment Details</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="modalbody"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php' ?>
    <script>
        $(document).ready(function() {
            $(document).on("click", ".agentButtonview", function(e) {

                // Check if alert should be shown; the veriable is decleared in the sidebar included
                <?php if ($showAlert): ?>
                alert("You have reached your free limit. Please subscribe to continue.");
                return; // Stop further execution
                <?php endif; ?>

                // Retrieve data attribute value
                var id = $(this).data('id');

                window.location.href = "/agentsingleinvoice?id=" + id;
            });

            $('.myButtondelete').on('click', function(e) {
                // Retrieve data attribute value
                e.preventDefault();
                e.stopImmediatePropagation();
                var id = $(this).data('id');

                // console.log(id);
                if (confirm('Are you sure you want to delete this record?')) {
                    // Construct AJAX call
                    $.ajax({
                        url: '/deleteinvoice',
                        type: 'POST',
                        cache: false, // Disable caching
                        data: {
                            id: id
                        },
                        success: function(response) {
                            // Handle response from server
                            alert(response);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.log(error);
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            // Datepicker initialization
            $('.filterDate').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min_date = $('#min').val();
                                var max_date = $('#max').val();
                    var min = new Date(min_date);
                    var max = new Date(max_date);
                    var dateString = data[3] || ''; // Assuming date is in the 5th column (index 4)

                    var dateParts = dateString.split("-");
                    var day = dateParts[2];
                    var month = dateParts[1];
                    var year = dateParts[0];
                    // var rowDate = new Date(year + "-" + month + "-" + day);
                    var rowDate = new Date(day + "-" + month + "-" + year);

                    if ((!min_date && !max_date) ||
                        (!min_date && rowDate <= max) ||
                        (!max_date && rowDate >= min) ||
                        (rowDate >= min && rowDate <= max)) {
                        return true;
                    }
                    return false;
                }
            );

            // Initialize DataTable
            var table = $('#qdataTable').DataTable({
                bSort: false,
                drawCallback: function() {
                    var api = this.api();
                    var data = api.rows({ page: 'current' }).data();

                    // Calculate totals
                    var totalSalePrice = 0;
                    var totalNetPrice = 0;
                    var totalPaidPrice = 0;
                    var totalBalancePrice = 0;
                    var totalProfitLossPrice = 0;
                    var totalMargin = 0;

                    data.each(function(d) {
                        totalSalePrice += parseFloat(d[4]) || 0;
                        totalNetPrice += parseFloat(d[5]) || 0;
                        totalPaidPrice += parseFloat(d[6]) || 0;
                        totalBalancePrice += parseFloat(d[7]) || 0;
                        totalProfitLossPrice += parseFloat(d[8]) || 0;
                        totalMargin += parseFloat(d[9]) || 0;
                    });

                    var totalMargin = totalNetPrice !== 0 ? (totalProfitLossPrice / totalNetPrice) * 100 : 0;
                    // consloe.log(totalMargin);

                    // Update footer
                    $('#totalSalePrice').html('Ksh' + totalSalePrice.toFixed(2));
                    $('#totalNetPrice').html('Ksh' + totalNetPrice.toFixed(2));
                    $('#totalPaidPrice').html('Ksh' + totalPaidPrice.toFixed(2));
                    $('#totalBalancePrice').html('Ksh' + totalBalancePrice.toFixed(2));
                    $('#totalProfitLossPrice').html('Ksh' + totalProfitLossPrice.toFixed(2));
                    $('#totalMargin').html(totalMargin.toFixed(2) + '%');
                }
            });

            // Event listener to the two date filtering inputs to redraw on input
            $('#min, #max').on('change', function() {
                table.draw();
            });

            // Reset filters
            $('#resetFilter').on('click', function() {
                $('#max').val('');
                $('#min').val('');
                table.draw();
            });

            // Additional code for AJAX calls and button click handlers here
        });

        $('#filterOwner').change(function() {
            var ownerArray = <?php echo json_encode($users); ?>;
            console.log(ownerArray);
            
            var table = $('#qdataTable').DataTable();
            var selectedOwner = $('#filterOwner').val();
            var initials = '';

            if (selectedOwner == 'All Agent') {
                console.log(selectedOwner);
                // Reset filter
                table.columns(2).search('').draw();
                $('#OwnerHeader').css('background', '');
                $('.OwnerBody').css('background', '').css('color', '');
                $('#selectedOwner').prop('selected', true);
            } else if (selectedOwner == 'Unassigned') {
                // Apply filter for unassigned
                table.columns(2).search('Unassigned').draw();
                $('#OwnerHeader').css('background', '#acaeb9');
                $('.OwnerBody').css('background', '#c8c9d0').css('color', '#114155');
            } else {
                // Find the selected owner in the ownerArray
                var selectedOwnerData = ownerArray.find(function(owner) {
                    return owner.username === selectedOwner;
                });

                // If the owner is found, extract initials
                if (selectedOwnerData) {
                    initials = selectedOwnerData.username.substring(0, 2).toUpperCase();
                }

                // Apply filter using initials
                table.columns(2).search(initials).draw();
                $('#OwnerHeader').css('background', '#acaeb9');
                $('.OwnerBody').css('background', '#c8c9d0').css('color', '#114155');
            }
        });



    </script>

</body>

</html>
