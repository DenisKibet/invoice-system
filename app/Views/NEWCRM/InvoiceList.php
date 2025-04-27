<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Invoice System - All Invoice</title>
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

        <?php include 'sidebarinvoices.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Invoice - All Invoices</h1>
                        <div class="col-lg-" style="padding-left: 0;">
                            <a href="/NewInvoice" class="form-control btn shadow-none" 
                                style="background:#071a26;color:white;text-align:center; width: fit-content; white-space: nowrap;">
                                Create an Invoice
                            </a>
                        </div>
                    </div>

                    <div class="col-sm-12 mb-2 mt-2 card p-2" style="color:#555;padding-left:0;">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 style="font-weight:500;">Filter by:</h5>
                            </div>

                            <div class="col-sm-12 mb-3 mt-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="radio" name="filterdate" id="checkedRadio" value="DueDate" checked />
                                        <label>Due Date</label>
                                    </div>

                                    <div class="col-md-3">
                                        <input type="radio" name="filterdate" id="created_at"  value="createdAt" />
                                        <label>Created At</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label style="font-weight:700;">From:</label><br />
                                <input type="text" name="min" id="min" class="form-control filterDate" />
                            </div>
                            <div class="col-md-3">
                                <label style="font-weight:700;">To:</label><br />
                                <input type="text" name="max" id="max" class="form-control filterDate" />
                            </div>
                            <div class="col-md-1 col-sm-3" style="padding-bottom:0;">
                                <label style="visibility:hidden">Reset</label><br />
                                <input type="button" class="form-control" style="background:#808080;color:white;" id="resetFilter" value="Reset" />
                            </div>
                             <!-- Wrapping the buttons in a div with ml-auto to push them to the right -->
                            <div class="col-md-4 d-flex justify-content-end">
                                <div class="col-lg-4 col-sm-4" style="padding:0;">
                                    <label style="visibility:hidden">All</label><br />
                                    <a href="#" class="form-control btn" id="all" name="all" style="background:#808080;color:white;text-align:center;border-radius: 0;border: 1px solid #808080">All</a>
                                </div>
                                <div class="col-lg-4 col-sm-4" style="padding:0;">
                                    <label style="visibility:hidden">unpaid</label><br />
                                    <a href="#" class="form-control btn" id="unpaid" name="unpaid" style="background:#fff;color:#777;text-align:center;border-radius: 0;border-top: 1px solid #808080; border-bottom: 1px solid #808080">Unpaid</a>
                                </div>
                                <div class="col-lg-4 col-sm-4" style="padding:0;">
                                    <label style="visibility:hidden">paid</label><br />
                                    <a href="#" class="form-control btn" id="paid" name="paid" style="background:#fff;color:#777;text-align:center;border-radius: 0;border: 1px solid #808080">Paid</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center align-items-center pt-2" style="color: black; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <p class="px-3 py-1 small" style="background-color: #e9fcea;">Paid</p>
                        <p class=" px-3 py-1 small" style="background-color:  #fff5e6;">Not Paid, Not Overdue</p>
                        <p class="px-3 py-1 small" style="background-color: #ffe6e6;">Overdue</p>
                    </div>

                    <!-- Content Row -->
                    <div class="table-responsive card p-3 " style="color: #555;">
                        <table class="table table-bordered" id="qdataTable" style="width: max-content; overflow: auto; min-width: 100%" cellspacing="0">
                            <thead>
                                <tr class="header">
                                    <th>Invoice ref</th>
                                    <th>Client Name</th>
                                    <th class="agent_initial">Agent </th>
                                    <th id="filterByCreatedAt">Date</th>
                                    <th id="filterByDueDate">Due Date</th>
                                    <th>Status</th>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">paid</th>
                                    <th class="text-right">Balance</th>
                                    <!-- <th class="text-right">View Invoice</th> -->
                                    <th class="text-center">Actions</th>
                                </tr> 
                            </thead>
                            <tbody>
                                    <?php foreach ($invoices as $invoice): ?>
                                        <tr>
                                            <td class="invoiceRef" style="cursor: pointer;" data-id="<?php echo htmlspecialchars($invoice->id); ?>">
                                                <?php echo htmlspecialchars($invoice->invoice_no); ?>
                                            </td>
                                            <!-- Find the client associated with this invoice -->
                                                    <?php
                                                    $clientName = '';
                                                    foreach ($clients as $client) {
                                                        if ($client->EmailAddress == $invoice->email) {
                                                            $clientName = $client->ClientName;
                                                            break;
                                                        }
                                                    }
                                                ?>
                                            <td><?php echo $clientName; ?></td>
                                                <?php
                                                    $initials = '';
                                                    if (isset($invoice->username)) {
                                                        // Extract the first two letters of the name and convert them to uppercase
                                                        $initials = strtoupper(substr($invoice->username, 0, 2));
                                                    }
                                                ?>
                                            <td class="agent-column"><div class="agent-initials text-success card-success" style="background: #ebfaeb;"><?= $initials?></div></td>
                                            <td class="filterByCreatedAt">
                                                <?php
                                                    $invoice_date = $invoice->invoice_date;
                                                    $converted_date =str_replace('/', '-', $invoice_date);
                                                    echo $converted_date;
                                                ?>
                                            </td>                                            
                                            <td class="filterByDueDate">
                                                <?php
                                                    $invoice_due_date = $invoice->due_date;
                                                    $converted_date =str_replace('/', '-', $invoice_due_date);
                                                    echo $converted_date;
                                                ?>
                                            </td>
                                            <td><?php echo $invoice->status?></td>
                                            <td class="text-right"><?php echo $invoice->total; ?></td>
                                            <td class="text-right"><?php echo $invoice->paid?></td>
                                            <td class="text-right"><?php echo $invoice->balance; ?></td>
                                            <td class="text-center">
                                                <?php 
                                                    $hasReachedFreeLimit = $session->get("has_reached_free_limit");
                                                    $isSubscriptionActive = $session->get("is_subscription_active");
                                                    $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
                                                ?>
                                                <button class="btn btn-outline-primary btn-sm myButtonview"  title="View Invoice" data-id="<?= $invoice->id?>"><i class="fas fa-eye"></i> </button>
                                                <button class="btn btn-outline-danger btn-sm myButtondelete"  title="Delete Invoice" data-id="<?= $invoice->id?>"><i class="fas fa-trash-alt"></i> </button>
                                                <button class="btn btn-outline-success btn-sm myButtonpayment" title="Make Payment" data-id="<?= $invoice->id?>"><i class="fas fa-money-bill-alt"></i> </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <!-- <tbody>
                                    
							</tbody> -->
                            

                        </table>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <footer class="sticky-footer bg-white">
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
                    </div>
                </div>
            </footer>
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



    <div class="modal fade" id="Viewdets" tabindex="-1" role="dialog" aria-labelledby="viewdetsmodal" aria-hidden="true" style="color:black;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <h5 class="modal-title" id="viewdetsmodal">Invoice Payment</h5>
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
        <div class="modal-dialog modal-lg" role="document">
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
        // process add payment
        $(document).on("click", ".myButtonpayment", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var invoiceid = $(this).data('id');

            $.ajax({
                method: "get",
                cache: false, 
                url: "/addpayment",
                data: {
                    invoiceid: invoiceid
                },
                success: function(response) {
                    $("#Viewdets .modal-body").html();
                    $("#Viewdets .modal-body").html(response);
                    $("#Viewdets").modal("show");
                    var newDate = new Date();

                    $("#Viewdets #paymentdate").datepicker({
                        dateFormat: "dd/mm/yy"
                    });
                    $("#Viewdets #paymentdate").datepicker("setDate", new Date());

                    $(document).off("click", "#Viewdets #btnsave2").on("click", "#Viewdets #btnsave2", function(e) {
                        $button = $("#btnsave2");
                            if ($button.data("pressed") !== true) {
                                var image = "/assets/img/ajax-loader_2.gif";
                                //   $("#btnsave2").prop("disabled", true);
                                $(this).prop('disabled', true);
                                e.preventDefault();
                                e.stopImmediatePropagation();

                                var dataURLpay = '/InvoiceSavepayment';
                                var formdatasendget = $('#invoicepaymentform').serialize();
                                
                                $.ajax({
                                    type: 'GET',
                                    url: dataURLpay,
                                    data: formdatasendget,
                                    beforeSend: function() {
                                        $(".modal-body").html("<img src='" + image + "' style='margin-top:1%;margin-left:50%' />"
                                                + "<br><div style='margin-top:6%; text-align: center;'>"
                                                + "<h1> Updating payment please wait...</h1></div>");
                                            $("#Viewdets").modal("show");
                                        },
                                    success: function(data) {
                                        console.log(data);
                                        location.reload();
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        alert('error: ' + textStatus + ': ' + errorThrown);
                                    }
                                })
                            }
                        });
                    }
                });
            });
        });

        $('#resetClientInfo').click(function() {
            $('.clientInvoiceDetails').val('');
        });


        $('#paymentButton2').click(function() {
            $('#paymentInstructions2').toggle();
        });

        $('#commentButton2').click(function() {
            $('#commentArea2').toggle();
        });

        $(document).on("click", ".myButtonview", function(e) {

            // Check if alert should be shown; the veriable is decleared in the sidebar included
            <?php if ($showAlert): ?>
            alert("You have reached your free limit. Please subscribe to continue.");
            return; 
            <?php endif; ?>
            
            e.preventDefault();
            e.stopImmediatePropagation();
            var id = $(this).data('id');

            window.location.href = "/getsingleinvoice?id=" + id;
        });

        $(document).on("click", ".agentButtonview", function(e) {
            var id = $(this).data('id');

            $.ajax({
                url: '/agentsingleinvoice',
                cache: false, 
                type: 'POST',
                data: {
                    id: id
                },
                success: function(response) {
                    $("#Viewdets .modal-body").html();
                    $('#Viewdets .modal-body').html(response);
                    $('#Viewdets').modal('show');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log(error);
                }
            });
        });

        $('.myButtondelete').on('click', function(e) {

            // Check if alert should be shown
            <?php if ($showAlert): ?>
            alert("You have reached your free limit. Please subscribe to continue.");
            return; // Stop further execution
            <?php endif; ?>

            e.preventDefault();
            e.stopImmediatePropagation();
            var id = $(this).data('id');
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: '/deleteinvoice',
                    type: 'POST',
                    cache: false, 
                    data: {
                        id: id
                    },
                    success: function(response) {
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

        $('.filterDate').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        let d = $('input[name=filterdate]:checked').val();

        $('#checkedRadio, #created_at').on('click', function() {
            $('input[name=filterdate]').prop('checked', false);
            $(this).prop('checked', true);      
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                let d = $('input[name=filterdate]:checked').val();
                
                var minDate = document.getElementById('min').value;
                var min = new Date(minDate);
                var maxDate = document.getElementById('max').value;
                var max = new Date(maxDate);

                let filterdate;
                if (d == 'DueDate') {
                    filterdate = data[4].split("-");
                } else if (d == 'createdAt') {
                    filterdate = data[3].split("-");
                }

                var newdate = filterdate[2] + "-" + filterdate[1] + "-" + filterdate[0];
                var date = new Date(newdate);

                if (
                    (!minDate && !maxDate) || 
                    (!minDate && date <= max) ||
                    (min <= date && !maxDate) ||
                    (min <= date && date <= max)
                    ) {
                    return true;
                }
                return false;
            }
        );

        var table = $('#qdataTable').DataTable({
            bSort: false
        });

        $('#min, #max').on('change', function() {
            table.draw();

            var d = $('input[name=filterdate]:checked').val();

            if (d == 'DueDate') {
                $('#filterByDueDate').css('background', '#114155');
                $('.filterByDueDate').css('background', '#3fabd9').css('color', '#114155');
                $('#filterByCreatedAt').css('background', '');
                $('.filterByCreatedAt').css('background', '').css('color', '');
            } else if (d == 'createdAt') {
                $('#filterByDueDate').css('background', '');
                $('.filterByDueDate').css('background', '').css('color', '');
                $('#filterByCreatedAt').css('background', '#114155');
                $('.filterByCreatedAt').css('background', '#3fabd9').css('color', '#114155');
            }
        });

        $('#resetFilter').on('click', function() {
            $('#max').val('');
            $('#min').val('');
            table.draw();

            $('#filterByDueDate').css('background', '');
            $('.filterByDueDate').css('background', '').css('color', '');
            $('#filterByCreatedAt').css('background', '');
            $('.filterByCreatedAt').css('background', '').css('color', '');
            $('input[name=filterdate]').prop('checked', false);
            $('#checkedRadio').prop('checked', true);
        });

        $(document).tooltip({
            show: null
        });

        $('#Viewdets').on('hidden.bs.modal', function() {
            document.location.reload();
        });

        // Filter by paid
        $('#paid').on('click', function(e) {
            e.preventDefault(); 

            $(this).css('background', '#808080').css('color', '#fff');
            $('#all').css('background', '#fff').css('color', '#777');
            $('#unpaid').css('background', '#fff').css('color', '#777');
            
            $('#qdataTable tbody tr').each(function() {
                var balance = parseFloat($(this).find('td').eq(8).text()); // Get the balance column (index 9)
                
                if (balance !== 0) {
                    $(this).hide(); // Hide rows where balance is not 0
                } else {
                    $(this).show(); // Show rows where balance is 0
                }
            });
        });

        // Filter by Unpaid
        $('#unpaid').on('click', function(e) {
            e.preventDefault(); // Prevent default link behavior

            $(this).css('background', '#808080').css('color', '#fff');
            $('#all').css('background', '#fff').css('color', '#777');
            $('#paid').css('background', '#fff').css('color', '#777');
            
            $('#qdataTable tbody tr').each(function() {
                var balance = parseFloat($(this).find('td').eq(8).text()); // Get the balance column (index 9)
                
                if (balance > 0) {
                    $(this).show(); // Show rows where balance is greater than 0
                } else {
                    $(this).hide(); // Hide rows where balance is 0 or less
                }
            });
        });

        // Reset search
        $('#all').on('click', function(e) {

            $(this).css('background', '#808080').css('color', '#fff');
            $('#unpaid').css('background', '#fff').css('color', '#777');
            $('#paid').css('background', '#fff').css('color', '#777');
            
            $('#qdataTable tbody tr').show(); 
        });

        // Color code indicating the status of the invoice
        $('#qdataTable tbody tr').each(function() {
            // Get the due date text and parse it into a Date object
            var dueDateText = $(this).find('td').eq(4).text(); // Assuming the due date is in the 5th column (index 4)
            var parts = dueDateText.split('-');
            var dueDate = new Date(parts[2], parts[1] - 1, parts[0]); // Year, Month (0-based), Day            
            var today = new Date();
            today.setHours(0, 0, 0, 0); // Set time to 00:00:00 for accurate comparison

            // paid or not depending on balance value
            var balanceValue = $(this).find('td').eq(8).text(); // Assuming the due date is in the 9th column (index 8)
            
            // Find the Invoice ref cell (assuming it's the 1st column)
            var invoiceRefCell = $(this).find('td').eq(0);

            if (dueDate < today) {
                invoiceRefCell.css({
                    'background-color': '#ffcccc', // Light red for overdue
                    'color': '#000000' // Text color (black)
                });
            } else {
                invoiceRefCell.css({
                    'background-color': '#fff5e6', // Light orange for not overdue
                    'color': '#000000' // Text color (black)
                });
            }
            if(balanceValue == 0) {
                invoiceRefCell.css({
                    'background-color': '#e9fcea', // Light orange for not overdue
                    'color': '#000000' // Text color (black)
                });
            }
        });

        // Add a click event handler to the invoiceRef cells
        $('.invoiceRef').on('click', function() {
            var id = $(this).data('id');

            window.location.href = "/getsingleinvoice?id=" + id;
            
        });

</script>
</body>
</html>
