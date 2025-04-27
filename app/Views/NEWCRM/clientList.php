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

    * {
        box-sizing: border-box;
    }
    #qdataTable th, #qdataTable td {
        border-left: none; 
        border-top: none; 
    }
    #qdataTable tr:last-child td {
        border-bottom: none; 
    }

    /* Style the search field */
    /* form.example input[type=text] {
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
    } */
    </style>

    <title>Invoice System - Client List</title>
    <?php include 'css.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

	<!-- INCLUDE sidebaruserlist -->
	<?php include 'sidebaruserlist.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Client List</h1>
                        <div class="col-lg-" style="padding-bottom:0;">
                            <a href="CreateClient" class="form-control btn" style="background:#071a26; color:white; text-align:center;">Create Client</a>
                        </div>
                    </div>

                    <div class="col-sm-12 mb-5 mt-3 card p-3" style="color:#555;padding-left:0;">
                        <div class="row">
                            <div class="col-sm-12">
                                <h5 style="color:#808080;font-weight:500;">Filter by Date:</h5>
                            </div>
                            <div class="col-lg-3">
                                <label style="font-weight:700;">From:</label><br />
                                <input type="text" name="min" id="min" class="form-control filterDate" />
                            </div>
                            <div class="col-lg-3">
                                <label style="font-weight:700;">To:</label><br />
                                <input type="text" name="max" id="max" class="form-control filterDate" />
                            </div>
                            <div class="col-lg-2" style="padding-bottom:0;">
                                <label style="visibility:hidden">Reset</label><br />
                                <input type="button" class="form-control" style="background:#808080;color:white;" id="resetFilter" value="Reset" />
                            </div>
                        </div>
                    </div>

                    <!-- content row -->
                    <div class="table-responsive card p-3" style="color: #555;">
                       <table class="table table-bordered" id="qdataTable" style="width: max-content; overflow: auto; min-width: 100%" cellspacing="0">
                            <thead>
                                <tr class="header">
                                    <th>id</th>
                                    <th>Full Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th id="dateCreated" >Date Added</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($clients) {
                                    foreach ($clients as $client) { ?>
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <?= $client->id ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <a style="text-decoration:none" class="text-color-none"
                                            href="/get_client_details/?clientid=<?= $client->EmailAddress ?>">
                                            <?= $client->ClientName?>
                                        </a>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $client->MobileNumber ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $client->EmailAddress ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $client->address ?>
                                    </td>
                                    <td class="dateCreated" style="vertical-align:middle;">
                                        <?= $client->created_at ?>
                                    </td>
                                    <td style="vertical-align:middle;display:flex; gap:.25rem;">
                                        <?php 
                                            $hasReachedFreeLimit = $session->get("has_reached_free_limit");
                                            $isSubscriptionActive = $session->get("is_subscription_active");
                                            $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
                                        ?>
                                        <button class="btn btn-outline-primary btn-sm myButtonviewUpdate" title="Edit Client" data-id="<?= $client->id?>"><i class="fas fa-edit"></i> </button>
                                        <button class="btn btn-outline-danger btn-sm myButtondelete" title="Edit Client" data-name=<?= implode("_", explode(" ", $client->ClientName)) ?> data-id=<?= $client->id ?>><i class="fas fa-trash-alt"></i> </button>
                                    </td>
                                </tr>
                                <?php }
                                } ?>
                            </tbody>
                       </table>
                    </div>
                </div>
                <!-- /.container-fluid -->

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
                    <h5 class="modal-title" id="viewdetsmodal">Client Quotes</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>

                </div>
                <div class="modal-body" id="modalbody"></div>
            </div>
        </div>
    </div>

    <?php include 'js.php' ?>
    <script>
        $(document).ready(function() {
            $('.filterDate').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {                    
                    var minDate = $('#min').val();
                    var min = new Date(minDate);
                    var maxDate = $('#max').val();
                    var max = new Date(maxDate);

                    let filterdate = data[5].split(' ')[0];

                    var date = new Date(filterdate);

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

                $('#dateCreated').css('background', '#114155').css('color', '#fff');
                $('.dateCreated').css('background', '#3fabd9').css('color', '#114155');
            });

            $('#resetFilter').on('click', function() {
                $('#max').val('');
                $('#min').val('');
                table.draw();

                $('#dateCreated').css('background', '').css('color', '');
                $('.dateCreated').css('background', '').css('color', '');
            });

            $(document).on("click", ".myButtonviewUpdate", function(e) {
                
                // Check if alert should be shown; the veriable is decleared in the sidebar included
                <?php if ($showAlert): ?>
                alert("You have reached your free limit. Please subscribe to continue.");
                return; // Stop further execution
                <?php endif; ?>
                
                var clientId = $(this).data('id');
                $('#Viewdets .modal-body').html("");
                $('#Viewdets #viewdetsmodal').html("Client Details");
                
                $.ajax({
                    url: '/updateClientDetails',
                    type: 'POST',
                    cache: false, 
                    data: {
                        clientId: clientId
                    },
                    success: function(response) {
                        $('#Viewdets .modal-body').html(response);
                        $('#Viewdets').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });

            $(document).on("click", ".myButtondelete", function(e) {
                
                // Check if alert should be shown; the veriable is decleared in the sidebar included
                <?php if ($showAlert): ?>
                alert("You have reached your free limit. Please subscribe to continue.");
                return; // Stop further execution
                <?php endif; ?>

                e.preventDefault();
                e.stopImmediatePropagation();
                var clientId = $(this).data('id');
                var clientName = $(this).data('name').split('_').join(' ');

                if (confirm(`Are you sure you want to delete ${clientName}?`)) {
                    $.ajax({
                        url: '/deleteclient',
                        type: 'POST',
                        data: {
                            clientId: clientId
                        },
                        success: function(response) {
                            alert(response.message);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            alert(response.message);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
