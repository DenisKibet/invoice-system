<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>iTravelHolidays - <?php echo $title ?></title>
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
            padding: 6px;
            text-align: left;
            border: none;
            border-bottom: 1px solid #ddd;
        }

        /* #qdataTable tr:nth-child(even) {
            background-color: #d4ecf7;
        } */

        #qdataTable tr:hover {
            background-color: #e6e6e6;
            color: #186081;
        }

        #qdataTable th {
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: left;
            background-color: #f9fafb;
            color:  #bfbfbf;
            font-size: 0.7rem
        }

        #qdataTable td {
        padding-top: 1rem;
        padding-bottom: 1rem;
        color: #555;
        font-size: 17px;
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

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Invoice - <?php echo $title ?></h1>
                    </div>
                    <!-- <div style="float:right;"><i class="material-icons">search</i> -->

                    <div class="col-sm-12 mb-5 mt-3" style="padding-left:0;">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 style="color:#555555;font-weight:500;">Filter by:</h5>
                            </div>

                            <div class="col-sm-12 mb-3 mt-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="radio" name="filterdate" id="checkedRadio" value="DueDate" checked />
                                        <label>Due Date</label>
                                    </div>

                                    <div class="col-md-3">
                                        <input type="radio" name="filterdate" value="createdAt" />
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
                            <div class="col-md-1" style="padding-bottom:0;">
                                <label style="visibility:hidden">Reset</label><br />
                                <input type="button" class="form-control" style="background:#555555;color:white;" id="resetFilter" value="Reset" />
                            </div>
                        </div>
                    </div>


                    <!-- Content Row -->
                    <div class="table-responsive card p-3" style="color: #555;">
                        <table class="table table-bordered" id="qdataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="header">
                                    <th>Invoice Number</th>
                                    <th>Client Name</th>
                                    <th id="filterByDueDate">Due Date</th>
                                    <th>Status</th>
                                    <th>Agent Status</th>
                                    <th>Total</th>
                                    <th>Balance</th>
                                    <th id="filterByCreatedAt">Created At</th>
                                    <th>View Invoice</th>
                                    <th>Action</th>
                                    <!-- <th>Reference No.</th> -->
                                    <!-- <th>Paid</th>
                                    <th>Method</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalBalance = 0;
                                $totalAggregate = 0;
                                if ($invoices) {
                                    foreach ($invoices as $row) {
                                        $balance = str_replace('£', '', $row->balance);
                                        $totalBalance += floatval($balance);
                                        $total = str_replace('£', '', $row->total);
                                        $totalAggregate += floatval($total);
                                ?><tr>
                                            <td class="color-dark" style="vertical-align:middle; "><?php echo $row->invoice_no; ?></td>

                                            <td style="vertical-align:middle;">
                                                <a style="text-decoration:none" href="/get_client_details/?clientid=<?= $row->email ?>"><?= $row->client_name ?></a>
                                            </td>
                                            <td class="filterByDueDate" style="vertical-align:middle;">
                                                <?php echo $row->due_date; ?></td>
                                            <td style="vertical-align:middle;"><?php echo $row->status; ?></td>
                                            <td style="vertical-align:middle;"><?php echo 'agentstatus'; ?></td>
                                            <td style="vertical-align:middle;"><?php echo  str_replace('£', '', $row->total); ?></td>
                                            <td style="vertical-align:middle;"><?php echo str_replace('£', '', $row->balance); ?></td>
                                            <td class="filterByCreatedAt" style="vertical-align:middle;">
                                                <?php echo $row->created_at; ?></td>
                                            <td style="vertical-align:middle;">
                                                <a style="cursor:pointer;" class="text-success myButtonview" data-id=<?= $row->id ?>>
                                                    <i class="material-icons icon" style="color:#2489b5" title="Client View">
                                                        insert_drive_file</i></a>&nbsp;&nbsp;
                                                <a style="cursor:pointer;" class="text-success agentButtonview" data-id=<?= $row->id ?>>
                                                    <i class="material-icons icon" style="color:#858796" title="Agent View">
                                                        insert_drive_file</i></a>
                                            </td>
                                            <td style="vertical-align:middle;">
                                                <a style="cursor:pointer;" class="text-danger myButtondelete" data-id=<?= $row->id ?>><i class="fa fa-trash" title="Delete Invoice"></i></a>&nbsp;&nbsp;
                                                <a style="cursor:pointer;" class="text-primary myButtonpayment" data-id=<?= $row->id ?>>
                                                    <i class="material-icons icon" style="color:#1cc88a" title="Make Payment">payment</i></a><br />
                                            </td>
                                            <!-- <td><php echo $row->item_reference-number;?></td> -->
                                        </tr><?php
                                            }
                                        } ?>
                            </tbody>
                            <tfoot>
                                <tr style="border-top: 1px solid #333;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Total:</td>
                                    <td><?php echo '£' . $totalAggregate; ?></td>
                                    <td><?php echo '£' . $totalBalance; ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Content Row -->

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
        // function myFunction() {
        //   var input, filter, table, tr, td, i, txtValue;
        //   input = document.getElementById("myInput");
        //   filter = input.value.toUpperCase();
        //   table = document.getElementById("clients");
        //   tr = table.getElementsByTagName("tr");
        //   for (i = 0; i < tr.length; i++) {
        //     td = tr[i].getElementsByTagName("td")[0];
        //     if (td) {
        //       txtValue = td.textContent || td.innerText;
        //       if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //         tr[i].style.display = "";
        //       } else {
        //         tr[i].style.display = "none";
        //       }
        //     }       
        //   }
        // }
        $(document).on("click", ".myButtonpayment", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            // var invoiceid = $(this).attr("invoiceid");
            var invoiceid = $(this).data('id');
            //get data
            $.ajax({
                method: "get",
                cache: false, // Disable caching
                url: "/NEWCRM/Home/addpayment",
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
        $(document).ready(function() {
            $('#resetClientInfo').click(function() {
                $('.clientInvoiceDetails').val('');
            });


            $('#paymentButton2').click(function() {
                $('#paymentInstructions2').toggle();
            });

            $('#commentButton2').click(function() {
                $('#commentArea2').toggle();
            });
        });
        $(document).ready(function() {
            $(document).on("click", ".myButtonview", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                // Retrieve data attribute value
                var id = $(this).data('id');

                // console.log(id);
                // Construct AJAX call
                $.ajax({
                    url: '/getsingleinvoice',
                    cache: false, // Disable caching
                    type: 'POST',
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

            // $('.agentButtonview').on('click', function() {
            $(document).on("click", ".agentButtonview", function(e) {
                // Retrieve data attribute value
                var id = $(this).data('id');

                // console.log(id);
                // Construct AJAX call
                $.ajax({
                    url: '/agentsingleinvoice',
                    cache: false, // Disable caching
                    type: 'POST',
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
            $('.filterDate').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });

        $(document).ready(function() {
            // $('input[name=filterdate]').change(function() {
            var d = $('input[name=filterdate]:checked').val();

            if (d == 'DueDate') {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var minDate = document.getElementById('min').value;
                        var min = new Date(minDate);
                        var maxDate = document.getElementById('max').value;
                        var max = new Date(maxDate);
                        var filterdate = data[2].split("/");
                        var newdate = filterdate[2] + "-" + filterdate[1] + "-" + filterdate[0];
                        // console.log(newdate);
                        var date = new Date(newdate);

                        if (!minDate && !maxDate) {
                            return true;
                        }
                        if (!minDate && date <= max) {
                            return true;
                        }
                        if (min <= date && !maxDate) {
                            return true;
                        }
                        if (min <= date && date <= max) {
                            return true;
                        }
                        return false;
                    }
                );
            } else if (d == 'createdAt') {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var minDate = document.getElementById('min').value;
                        var min = new Date(minDate);
                        var maxDate = document.getElementById('max').value;
                        var max = new Date(maxDate);
                        var date = new Date(data[7]);

                        if (!minDate && !maxDate) {
                            return true;
                        }
                        if (!minDate && date <= max) {
                            return true;
                        }
                        if (min <= date && !maxDate) {
                            return true;
                        }
                        if (min <= date && date <= max) {
                            return true;
                        }
                        return false;
                    }
                );
            }
            // });

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
        });
    </script>

</body>

</html>
