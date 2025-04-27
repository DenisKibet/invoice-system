<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
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

    <title>Invoice System - ClientList (<?= $full_name ?>)</title>
    <?php include 'css.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebaruserlist.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="p-3 h3 mb-0 text-gray-800"><?= $full_name ?></h1>
                        <button class="btn btn-dark"><a href="/NewInvoice?email=<?= $email_address ?>" style="color:white; text-decoration:none;"><i class="fas fa-fw fa-file"></i> Add Invoice</a></button>
                    </div>

                    <div style="display:flex;justify-content:center;">
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" style="color:#555555;" id="userdets-tab" data-toggle="tab" href="#userdets" role="tab" aria-controls="userdets" aria-selected="true">Profile Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" style="color:#555555;" id="invoices-tab" data-toggle="tab" href="#client-invoices" role="tab" aria-controls="client-invoices" aria-selected="false">Invoices</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent" style="background-color: #ffffff;">
                                <div class="tab-pane card fade show active" id="userdets" role="tabpanel" aria-labelledby="userdets-tab">
                                    <div class="row p-3">
                                        <div class="col-sm-12 col-lg-6 mb-3 addClientInput">

                                            <label for="cname">Client Name:</label><br />
                                            <div id="prefetch"><input id="autouser2" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="ClientName" value="<?= $full_name ?>" placeholder="Client Name" /></div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addClientInput">
                                            <label for="mobile">Mobile:</label><br />
                                            <input id="usermobile" type="text" class="form-control w3-card-2" name="MobileNumber" value="<?= $phone_number ?>" placeholder="Mobile Number" /><br />
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addClientInput">
                                            <label for="email">Email Address:</label><br />
                                            <input id="useremail2" type="text" class="form-control w3-card-2" name="EmailAddress" value="<?= $email_address ?>" placeholder="Email Address" /><br />
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addClientInput">
                                            <label for="ad_email">Additional Email:</label><br />
                                            <input type="text" class="w3-card-2 form-control" placeholder="Additional email address" value="<?= $additional_email ?>" name="ad_email" id="ad_email" /><br />
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                                            <label for="l_no">Landline Number:</label><br />
                                            <input type="text" class="w3-card-2 form-control" name="l_no" id="l_no" placeholder="Landline number" value="<?= $landline_number ?>" />
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                                            <label for="e_no">Emergency Number:</label><br />
                                            <input type="text" class="w3-card-2 form-control" name="e_no" id="e_no" placeholder="Emergency number" value="<?= $emergency_number ?>" />
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                                            <label for="ad_address">Address:</label><br />
                                            <input type="text" class="w3-card-2 form-control" placeholder="Address" value="<?= $address ?>" name="address" id="address" />
                                        </div>

                                        <div class="col-sm-12 col-lg-6 mb-3 addClientInput">
                                            <label for="ad_address">Additional Address:</label><br />
                                            <input type="text" class="w3-card-2 form-control" placeholder="Additional address" value="<?= $additional_address ?>" name="ad_address" id="ad_address" />
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane card fade show" id="client-invoices" role="tabpanel" aria-labelledby="invoices-tab">
                                    <div class="p-3">
                                        <div class="col-sm-12 mb-5 mt-3" style="padding-left:0;">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h5 style="color:#555555;font-weight:500;">Filter by:</h5>
                                                </div>

                                                <div class="col-sm-12 mb-3 mt-3 w-full">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <input type="radio" name="filterdate" id="checkedRadio" value="DueDate" style="width:10%;padding-left:0;" checked />
                                                            <label style="width:80%;">Due Date</label>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <input type="radio" name="filterdate" id="created_at" value="createdAt" style="width:10%;padding-left:0;" />
                                                            <label style="width:80%;">Created At</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label style="font-weight:700;">From:</label><br />
                                                    <input type="text" name="min" id="mymindatefrom" class="form-control filterDate" />
                                                </div>
                                                <div class="col-md-3">
                                                    <label style="font-weight:700;">To:</label><br />
                                                    <input type="text" name="max" id="mymaxdateto" class="form-control filterDate" />
                                                </div>
                                                <div class="col-md-2" style="padding-bottom:0;">
                                                    <label style="visibility:hidden">Reset</label><br />
                                                    <input type="button" class="form-control" style="background:#555555;color:white;" id="resetFilter" value="Reset" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="qdataTable" width="100%"  cellspacing="0" style="white-space: nowrap;">
                                                <thead style="background: #2360bb;color: white;">
                                                    <tr class="header">
                                                        <th>Invoice Ref</th>
                                                        <th>Client Name</th>
                                                        <th class="text-left" id="filterByCreatedAt">Created At</th>
                                                        <th id="filterByDueDate">Due Date</th>
                                                        <th>Status</th>
                                                        <th>Agent Name</th>
                                                        <th class="text-right">Total</th>
                                                        <th class="text-right">Paid</th>
                                                        <th class="text-right">Balance</th>
                                                        <th class="text-center">Payment Method</th>
                                                        <th>View Invoice</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $totalPaid = 0;
                                                        $totalBalance = 0;
                                                        $totalAggregate = 0;
                                                        if ($invoices) {
                                                            foreach ($invoices as $row) {
                                                                $paid = str_replace('£', '', $row->paid);
                                                                $totalPaid  += floatval($paid);
                                                                $balance = str_replace('£', '', $row->balance);
                                                                $totalBalance += floatval($balance);
                                                                $total = str_replace('£', '', $row->total);
                                                                $totalAggregate += floatval($total);
                                                    ?>  
                                                    <tr>
                                                        <td style="vertical-align:middle;"><?php echo $row->invoice_no; ?></td>
                                                        <td style="vertical-align:middle;">
                                                            <?php echo $row->client_name; ?>
                                                        </td>
                                                        <td class=" text-left filterByCreatedAt" style="vertical-align:middle;">
                                                            <?php echo $row->invoice_date; ?>
                                                        </td>
                                                        <td class="filterByDueDate" style="vertical-align:middle;">
                                                            <?php echo $row->due_date; ?>
                                                        </td>
                                                        <td style="vertical-align:middle;"><?php echo $row->status; ?>
                                                        </td>
                                                        <td style="vertical-align:middle;">
                                                            <?php echo $row->username; ?></td>
                                                        <td class="text-right" style="vertical-align:middle;"><?php echo  str_replace('£', '', $row->total); ?></td>
                                                        <td class="text-right" style="vertical-align:middle;"><?php echo  str_replace('£', '', $row->paid); ?></td>
                                                        <td class="text-right" style="vertical-align:middle;"><?php echo  str_replace('£', '', $row->balance); ?></td>
                                                        <td class="text-center" style="vertical-align:middle;"><?php echo isset($row->payment_method) ? $row->payment_method: "Not set" ?></td>
                                                        <td style="vertical-align:middle;">
                                                            <?php 
                                                                $hasReachedFreeLimit = $session->get("has_reached_free_limit");
                                                                $isSubscriptionActive = $session->get("is_subscription_active");
                                                                $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
                                                            ?>
                                                            <button class="btn btn-outline-primary btn-sm myButtonviewinvoice" title="View Client Invoice" data-id="<?= $row->id?>"><i class="fas fa-eye"></i> </button>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-outline-danger btn-sm myButtondeleteinvoice" title="Delete Invoice" data-id="<?= $row->id?>"><i class="fas fa-trash-alt"></i> </button>
                                                            <button class="btn btn-outline-success btn-sm myButtonpayment" title="Make Payment" data-id="<?= $row->id?>"><i class="fas fa-money-bill-alt"></i> </button>
                                                        </td>
                                                    </tr>
                                                        <?php
                                                            }
                                                        } else { ?>
                                                    <tr>
                                                        <td colspan="12"><b>No invoices</b></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                                <?php if($invoices) { ?>
                                                    <tfoot>
                                                        <tr style="border-top: 1px solid #ccc;background: #eee;">
                                                            <td><b>Totals:</b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td ></td>
                                                            <td class="text-right"><b><?php echo '£' . number_format($totalAggregate, 2); ?></b></td>
                                                            <td class="text-right"><b><?php echo '£' . number_format($totalPaid, 2); ?></b></td>
                                                            <td class="text-right"><b><?php echo '£' . number_format($totalBalance, 2); ?></b></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tfoot>
                                                <?php } ?>
                                            </table>
                                        </div>
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
                        <span>Copyright &copy; Invoice System <?= date('Y');?></span>
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


    <!-- Logout Modal-->
    <div class="modal fade" id="Viewdets" tabindex="-1" role="dialog" aria-labelledby="viewdetsmodal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewdetsmodal">Client Enquiries</h5>
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
            $(document).on("click", ".myButtonviewquote", function(e) {

                 // Check if alert should be shown
                <?php if ($showAlert): ?>
                alert("You have reached your free limit. Please subscribe to continue.");
                return; // Stop further execution
                <?php endif; ?>

                // Retrieve data attribute value
                $('#viewdetsmodal').text('Quote Details');
                var id = $(this).data('id');
                // console.log(id);
                $.ajax({
                    url: '/getsinglequote',
                    type: 'POST',
                    cache: false, // Disable caching
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // Handle response from server
                        // console.log(response);
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

            // Date picker function
            $('.filterDate').datepicker({
                dateFormat: 'yy-mm-dd'
            });
            
            $('#checkedRadio, #created_at').on('click', function() {
                $('input[name=filterdate]').prop('checked', false);
                $(this).prop('checked', true);
            });
            
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    let d = $('input[name=filterdate]:checked').val();
                    
                    var mindate = document.getElementById('mymindatefrom').value;
                    var min = new Date(mindate);
                    var maxdate = document.getElementById('mymaxdateto').value;
                    var max = new Date(maxdate);

                    let filterdate;
                    if (d == 'DueDate') {
                        filterdate = data[3].split("/");
                    } else if (d == 'createdAt') {
                        filterdate = data[2].split("/");
                    }
                    
                    var newdate = filterdate[2] + "-" + filterdate[1] + "-" + filterdate[0];
                    var date = new Date(newdate);

                    if (!maxdate && !mindate) {
                        return true;
                    }
                    if (!maxdate && date >= min) {
                        return true;
                    }
                    if (max >= date && !mindate) {
                        return true;
                    }
                    if (max >= date && date >= min) {
                        return true;
                    }
                    return false;
                }
            );

            var table = $('#qdataTable').DataTable({
                bSort: false
            });

            // Event listener to the two range filtering inputs to redraw on input
            $('#mymindatefrom, #mymaxdateto').change(function() {
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
                $('#mymindatefrom').val('');
                $('#mymaxdateto').val('');
                table.draw();

                $('#filterByDueDate').css('background', '');
                $('.filterByDueDate').css('background', '').css('color', '');
                $('#filterByCreatedAt').css('background', '');
                $('.filterByCreatedAt').css('background', '').css('color', '');
                $('input[name=filterdate]').prop('checked', false);
                $('#checkedRadio').prop('checked', true);
            });


            $('#filterOwner').change(function() {
                table.columns(2).search($('#filterOwner').val()).draw();
                $('#OwnerHeader').css('background', '#114155');
                $('.OwnerBody').css('background', '#3fabd9').css('color', '#114155');
                var selectedOwner = $('#filterOwner').val();

                if (selectedOwner == 'All Quotes') {
                    table.columns(2).search('').draw();
                    $('#OwnerHeader').css('background', '');
                    $('.OwnerBody').css('background', '').css('color', '');
                    $('#selectedOwner').prop('selected', true);
                }
            });

            $('#resetOwner').click(function() {
                table.columns(2).search('').draw();
                $('#OwnerHeader').css('background', '');
                $('.OwnerBody').css('background', '').css('color', '');
                $('#selectedOwner').prop('selected', true);
            });

            $(document).tooltip({
                show: null
            });

            $(document).on("click", ".myButtonpayment", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                // var invoiceid = $(this).attr("invoiceid");
                var invoiceid = $(this).data('id');
                //get data
                $.ajax({
                    method: "get",
                    cache: false, // Disable caching
                    url: "/addpayment",
                    data: {
                        invoiceid: invoiceid
                    },

                    success: function(bk) {
                        $("#Viewdets .modal-body").html();
                        // $(".admin_content").html(bk);

                        $("#Viewdets .modal-body").html(bk);
                        $("#Viewdets").modal("show");
                    }
                })
            })
            $(document).on("click", ".myButtonviewinvoice", function(e) {

                 // Check if alert should be shown
                <?php if ($showAlert): ?>
                alert("You have reached your free limit. Please subscribe to continue.");
                return; // Stop further execution
                <?php endif; ?>

                e.preventDefault();
                e.stopImmediatePropagation();
                // Retrieve data attribute value
                var id = $(this).data('id');

                // console.log(id);
                window.location.href = "/getsingleinvoice?id=" + id;
            });

            $('.myButtondeleteinvoice').on('click', function(e) {

                 // Check if alert should be shown
                <?php if ($showAlert): ?>
                alert("You have reached your free limit. Please subscribe to continue.");
                return; // Stop further execution
                <?php endif; ?>

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
    </script>
</body>

</html>



