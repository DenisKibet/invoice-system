<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <style>
     #dataTable {
        font-family: Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        border: none;
    }
    
    #dataTable td,
    #dataTable th {
        padding: 3px;
        text-align: left;
        border: none;
        border-bottom: 1px solid #ddd; 
    }

    #dataTable tr:hover {
        background-color: #e6e6e6;
        color: #186081;
    }

    #dataTable th {
        padding-top: 0.4rem;
        padding-bottom: 0.4rem;
        text-align: left;
        background-color: #f9fafb;
        color:  #bfbfbf;
        font-size: 0.7rem;
    }

    #dataTable td {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        color: #555;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    
    #dataTable th {
        color: #777;
    }

    #dataTable td,
    #dataTable th {
        border-right: none;
    }

    #dataTable th, #dataTable td {
        border-left: none; 
        border-top: none; 
    }
    #dataTable tr:last-child td {
        border-bottom: none; 
    }


    * {
        box-sizing: border-box;
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
    </style>

    <title>Invoice System - Item List</title>
    <?php include 'css.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

	<!-- INCLUDE sidebaruserlist -->
	<?php include 'sidebaritems.php'?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Item List</h1>
                        <div class="col-lg-" style="padding-bottom:0;">
                            <a href="creatItem" class="form-control btn shadow-none" style="background:#071a26;color:white;text-align:center;">Create an Item</a>
                        </div>
                    </div>

                        <!-- content row -->
                    <div class="table-responsive card p-3" style="color: #555;">
                        <table class="table table-bordered" id="dataTable" style="width: max-content; overflow: auto; min-width: 100%" cellspacing="0">
                            <thead>
                                <tr class="header">
                                    <th>Id</th>
                                    <th>Descirption</th>
                                    <th>Rate</th>
                                    <th>Cost</th>
                                    <th>Taxes Enabled</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($items) {
                                    foreach ($items as $item) { ?>
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <?= $item->id ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $item->item_description?></a>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $item->rate ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $item->cost ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                    <?= $item->enable_taxes == 0 ? 'No' : 'Yes' ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?php 
                                            $hasReachedFreeLimit = $session->get("has_reached_free_limit");
                                            $isSubscriptionActive = $session->get("is_subscription_active");
                                            $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
                                        ?>
                                        <button class="btn btn-outline-primary btn-sm myButtonEditItem"  title="View Company" data-id="<?= $item->id?>"><i class="fas fa-edit"></i> </button>
                                        <button class="btn btn-outline-danger btn-sm myButtondeleteItem"  title="Delete Company" data-id="<?= $item->id?>"><i class="fas fa-trash-alt"></i> </button>
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
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'js.php' ?>
    <script>
    $(document).ready(function() {
        // $(document).on("click", ".myButtonviewItem", function(e) { 
        //     var itemId = $(this).data('id');
        //     $('#Viewdets .modal-body').html("");
        //     $('#Viewdets #viewdetsmodal').html("Item Details");
        //     // return;
        //     $.ajax({
        //         url: '/getsingleitem',
        //         type: 'GET',
        //         cache: false,
        //         data: {
        //             itemId: itemId
        //         },
        //         success: function(response) {
        //             $('#Viewdets .modal-body').html(response);
        //             $('#Viewdets #viewdetsmodal').html("Item Details");
        //             $('#Viewdets').modal('show');
        //         },
        //         error: function(xhr, status, error) {
        //             console.log(error);
        //         }
        //     });
        // });

        $(document).on("click", ".myButtonEditItem", function(e) {

            // Check if alert should be shown
            <?php if ($showAlert): ?>
            alert("You have reached your free limit. Please subscribe to continue.");
            return; // Stop further execution
            <?php endif; ?>

            var itemId = $(this).data('id');
            $('#Viewdets .modal-body').html("");
            $('#Viewdets #viewdetsmodal').html("Item Details");
            // return;
            $.ajax({
                url: '/updateItem',
                type: 'POST',
                cache: false, 
                data: {
                    itemId: itemId,
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
      
        $(document).on("click", ".myButtondeleteItem", function(e) {
            
            // Check if alert should be shown
            <?php if ($showAlert): ?>
            alert("You have reached your free limit. Please subscribe to continue.");
            return; // Stop further execution
            <?php endif; ?>

            e.preventDefault();
            e.stopImmediatePropagation();
            var itemId = $(this).data('id');
            
            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: '/deleteSingleItem',
                    type: 'POST',
                    cache: false, 
                    data: {
                        itemId: itemId
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            }

        });
    });
    </script>
</body>

</html>
