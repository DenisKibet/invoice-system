<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Invoice System - All Estimates</title>
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

    /* Style the search field */
    form.example input[type=text] {
        float: left;
        width: 200px;
        -webkit-transition: width 0.4s ease-in-out;
        transition: width 0.4s ease-in-out;
    }

    /* Clear floats */
    form.example::after {
        content: "";
        clear: both;
        display: table;
    }

    input:focus {
        outline-color: #858796;
        width: 100%;
    }

    div.second {
        float: right;
    }

    div.first {
        float: left;
    }

    ul.first,
    ul.second {
        padding-left: 0;
    }

    ul.first li {
        list-style-type: none;
        float: left;
    }

    ul.second li {
        list-style-type: none;
        float: left;
    }

    ul li div.colorCode:hover {
        -ms-transform: scale(1.2);
        /* IE 9 */
        -webkit-transform: scale(1.2);
        /* Safari 3-8 */
        transform: scale(1.2);
        border: 1px solid white;
        border-radius: 12px;
    }

    .hiddenTooltip {
        visibility: hidden;
        width: 120px;
        background-color: #aadaee;
        color: #2489b5;
        text-align: center;
        border-radius: 6px;
        margin-bottom: 5px;
        padding: 5px;
        font-size: 10px;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
        bottom: 100%;
        left: 50%;
        /* margin-left: -60px; */
    }

    .colorCode:hover .hiddenTooltip {
        visibility: visible;
    }

    @media screen and (max-width:720px) {
        .overflowTable {
            overflow-x: auto;
        }
    }
    </style>

    <title></title>
    <?php include 'css.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

	<?php include 'sidebarquotes.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Estimate - All Estimates</h1>
                    </div> -->
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Estimate - All Estimates</h1>
                        <div class="col-lg-" style="padding-bottom:0;">
                        <a href="CreateQuotation" class="form-control btn shadow-none" style="background:#071a26;color:white;text-align:center; width: fit-content; white-space: nowrap;">Create an Estimate</a>
                        </div>
                    </div>

                    <div class="col-sm-12 mb-5 mt-3 card p-3" style="color:#555;padding-left:0;">
                        <div class="row">
                            <div class="col-md-12 col-lg-2">
                                <h5 style="color:#808080;font-weight:500;">Filter by Date:</h5>
                                <label style="font-weight:700;">From:</label><br />
                                <input type="text" name="min" id="min" class="form-control filterDate" />
                            </div>
                            <div class="col-md-12 col-lg-2">
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
                            <div class="col-md-12 col-lg-2">
                                <h5 style="color:#808080;font-weight:500;">Filter by Status:</h5>
                                <label>Select Status</label>
                                <select name="filterStatus" id="filterStatus" class="form-control">
                                    <option id="selectedStatus" selected value="All Status">All Status</option>
                                    <option id="Unsent" value="Unsent">Unsent</option>
                                    <option id="Sent" value="Sent">Sent</option>
                                    <option id="Accepted" value="Accepted">Accepted</option>
                                    <option id="Invoiced" value="Invoiced">Invoiced</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive card p-3" style="color: #555;">
                        <table class="table table-bordered" id="qdataTable" style="width: max-content; overflow: auto; min-width: 100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <!-- <th>id</th> -->
                                    <th>Estimate ref</th>
                                    <th>Client Name</th>
                                    <th id="OwnerHeader">Agent Name</th>
                                    <th id="StatusHeader">Status</th>
                                    <th id="dateCreated">Date Created</th>
                                    <th class="mr-3" style="text-align:right;">Total</th>
                                    <th style="text-align:center;" style=>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($estimates as $estimate): ?>
                                    <tr>
                                        <td class="estimateRef text-primary" style="cursor: pointer;" data-id="<?php echo htmlspecialchars($estimate->id); ?>">
                                            <?php echo htmlspecialchars($estimate->estimate_no); ?>
                                        </td>
                                        <!-- <td id="ownerid"><php echo $estimate->estimate_no?></td> -->
                                        <td style="vertical-align: middle;">
                                            <?php echo $estimate->client_name;?></a>
                                        </td>
                                        <td ><?php echo $estimate->username ?></td>
                                        <td class="estimateStatus"><?php echo $estimate->status ?></td>
                                        <td class="dateCreated">
                                            <?php
                                                // Assuming $estimate->invoice_date contains the date in the format 16/05/2024
                                                $invoice_date = $estimate->invoice_date;
                                                $converted_date =str_replace('/', '-', $invoice_date);
                                                echo $converted_date;
                                            ?>
                                        </td>
                                        <td style="text-align:right;"><?php echo $estimate->total ?></td>
                                        <td style="text-align: center;">
                                            <?php 
                                                $hasReachedFreeLimit = $session->get("has_reached_free_limit");
                                                $isSubscriptionActive = $session->get("is_subscription_active");
                                                $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
                                            ?>
                                            <button class="btn btn-outline-primary btn-sm btnConvertToInvoice"  title="View Estimate" data-id="<?= $estimate->id?>"><i class="fas fa-eye"></i> </button>
                                            <button class="btn btn-outline-danger btn-sm myButtondelete"  title="Delete Estimate" data-id="<?= $estimate->id?>"><i class="fas fa-trash-alt"></i> </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <footer>
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="totalAmount" class="text-right">£0.00</td>
                                <td></td>
                            </footer>
                        </table>
                    </div>
                </div>

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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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

    <div class="modal fade" id="Viewdets" tabindex="-1" role="dialog" aria-labelledby="viewdetsmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewdetsmodal"></h5>
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
         // Add a click event handler to the estimateRef  cells
         $('.estimateRef ').on('click', function() {
            var id = $(this).data('id');
            window.location.href = "/getsinglestimate?id=" + id;
            
        });
        $(document).ready(function() {
            $('#Viewdets').on('hidden.bs.modal', function() {
                document.location.reload();
            });

            // view estimate by clicking view icon
            $('.myButtonview').on('click', function () {
                $('#viewdetsmodal').text('Estimate Details');
                var id = $(this).data('id');
                console.log(id);
                return 
                $.ajax({
                    url: '/getsinglestimate',
                    type: 'POST',
                    cache: false, 
                    data: {
                        id: id
                    },
                    success: function(response) {
                        console.log(response);
                        $('.modal-body').html(response);
                        $('#Viewdets').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            //  View estimate from estimateRef
            $('.estimateRef').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/convert-to-invoice',
                    type: 'GET',
                    cache: false, 
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $("#Viewdets .modal-body").html();
                        $('#Viewdets .modal-body').html(response);
                        $('#Viewdets').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

            });

            // View and convert estimate to invoice
            $(document).on("click", ".btnConvertToInvoice", function(e) {
                console.log('Hello');
                <?php if ($showAlert): ?>
                    alert("You have reached your free limit. Please subscribe to continue.");
                    return; 
                <?php endif; ?>

                e.preventDefault();
                e.stopImmediatePropagation();
                var id = $(this).data('id');
                window.location.href = "/getsinglestimate?id=" + id;

            });

            // Delete estimate
            $(document).on("click", ".myButtondelete", function(e) {

                <?php if ($showAlert): ?>
                alert("You have reached your free limit. Please subscribe to continue.");
                return; 
                <?php endif; ?>

                e.preventDefault();
                e.stopImmediatePropagation();
                var id = $(this).data('id');

                if (confirm('Are you sure you want to delete this record?')) {
                    $.ajax({
                        url: '/deleteestimate',
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
                            console.log(error);
                        }
                    });
                }
            });


        

        
            });
            $(document).ready(function() {
                $('.filterDate').datepicker({
                    dateFormat: 'yy-mm-dd'
                    // dateFormat: 'dd-mm-yy'
                });
            });


            $(document).ready(function() {
            // Function to calculate the total of visible rows
            function calculateTotal() {
                var table = $('#qdataTable').DataTable();
                var total = 0;

                table.rows({ search: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
                    var data = this.data();
                    var rowTotal = parseFloat(data[5].replace('£', '').replace(',', '')) || 0;
                    total += rowTotal;
                });

                $('#totalAmount').text('£' + total.toFixed(2));
            }

            // Custom search function to filter by date
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var min_date = $('#min').val();
                                var max_date = $('#max').val();
                    var min = new Date(min_date);
                    var max = new Date(max_date);
                    var dateString = data[4] || ''; // Assuming date is in the 5th column (index 4)

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

            // Initialize DataTable if not already initialized
            if (!$.fn.DataTable.isDataTable('#qdataTable')) {
                var table = $('#qdataTable').DataTable({
                    bSort: false,
                    drawCallback: function() {
                        calculateTotal();
                    }
                });
            }

            // Initialize tooltips
            $(document).tooltip({
                show: null
            });

            // Initial total calculation
            calculateTotal();

            // Event listener to recalculate total on date filter change
            $('#min, #max').change(function() {
                var table = $('#qdataTable').DataTable();
                table.draw();
                $('#dateCreated').css('background', '#acaeb9');
                $('.dateCreated').css('background', '#c8c9d0').css('color', '#114155');
            });

            // Reset date filters
            $('#resetFilter').on('click', function() {
                $('#min').val('');
                $('#max').val('');
                var table = $('#qdataTable').DataTable();
                table.draw();
                $('#dateCreated').css('background', '');
                $('.dateCreated').css('background', '').css('color', '');
            });

            $('#filterOwner').change(function() {
                var table = $('#qdataTable').DataTable();
                var selectedOwner = $('#filterOwner').val();

                if (selectedOwner == 'All Agent') {
                    console.log(selectedOwner);
                    // Reset filter
                    table.columns(2).search('').draw();
                    $('#OwnerHeader').css('background', '');
                    $('.OwnerBody').css('background', '').css('color', '');
                    $('#selectedOwner').prop('selected', true);
                } else {
                    // Apply filter
                    table.columns(2).search(selectedOwner).draw();
                    $('#OwnerHeader').css('background', '#acaeb9');
                    $('.OwnerBody').css('background', '#c8c9d0').css('color', '#114155');
                }
            });

            // Filter by Status
            $(document).ready(function() {
                var table = $('#qdataTable').DataTable();

                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        var selectedStatus = $('#filterStatus').val();
                        var status = data[3]; 

                        if (selectedStatus === 'All Status' || status === selectedStatus) {
                            return true;
                        }
                        return false;
                    }
                );

                $('#filterStatus').change(function() {
                    table.draw();
                    var selectedStatus = $('#filterStatus').val();

                    if (selectedStatus === 'All Status') {
                        // Reset filter
                        $('#StatusHeader').css('background', '');
                        $('.OwnerBody').css('background', '').css('color', '');
                        $('#selectedStatus').prop('selected', true);
                    } else {
                        // Apply filter
                        $('#StatusHeader').css('background', '#acaeb9');
                        $('.OwnerBody').css('background', '#c8c9d0').css('color', '#114155');
                    }
                });
            });
        });
    </script>
</body>

</html>
