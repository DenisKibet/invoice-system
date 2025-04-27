<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
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
        padding-top:0.8rem;
        padding-bottom:0.8rem;
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

    <title>Invoice System - Company Details</title>
    <?php include 'css.php' ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebarcompany.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>
                <!-- <php echo '<pre>'; var_dump($_SESSION); echo '</pre>';?> -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Company Profile </h1>
                        <!--  Display the lint to create company if non exist -->
                        <?php if (!$companies): ?>  
                            <div class="col-lg-" style="padding-bottom:0;">
                                <a href="companyDetails" class="form-control btn shadow-none" style="background:#071a26;color:white;text-align:center;  width: fit-content; white-space: nowrap;">Set Company Details</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- content row -->
                    <div class="table-responsive card p-3" style="color: #555;">
                        <table class="table table-bordered" id="qdataTable" style="width: max-content; overflow: auto; min-width: 100%" cellspacing="0">
                            <thead>
                                <tr class="header">
                                    <th>Company Name</th>
                                    <th>Registration no</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Post code</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Website</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($companies){
                                    foreach($companies as $company) {?>
                                <tr>
                                    <td style="vertical-align:middle;">
                                        <?= $company->company_name?></a>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $company->registration_no ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $company->mobile_no ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $company->email ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $company->post_code ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $company->city ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $company->country ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?= $company->website ?>
                                    </td>
                                    <td style="vertical-align:middle;">
                                        <?php 
                                            $hasReachedFreeLimit = $session->get("has_reached_free_limit");
                                            $isSubscriptionActive = $session->get("is_subscription_active");
                                            $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
                                        ?>
                                        <button class="btn btn-outline-primary btn-sm myButtonviewCompany"  title="View Company" data-id="<?= $company->id?>"><i class="fas fa-edit"></i> </button>
                                        <button class="btn btn-outline-danger btn-sm myButtondelete"  title="Delete Company" data-id="<?= $company->id?>"><i class="fas fa-trash-alt"></i> </button>
                                    </td>
                                </tr>
                                <?php }
                                    }?>
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
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewdetsmodal">Company Details</h5>
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
    $(document).on("click", ".myButtonviewCompany", function(e) {

        // Check if alert should be shown; the veriable is decleared in the sidebar included
        <?php if ($showAlert): ?>
        alert("You have reached your free limit. Please subscribe to continue.");
        return; // Stop further execution
        <?php endif; ?>

        e.preventDefault();
        e.stopImmediatePropagation();
        var id = $(this).data('id');

        $.ajax({
            url: '/viewcompany',
            type: 'POST',
            cache: false, 
            data: {
                id: id
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

    $(document).on('click', '.myButtonEditComapany', function(e) {

        // Check if alert should be shown
        <?php if ($showAlert): ?>
            alert("You have reached your free limit. Please subscribe to continue.");
            return; // Stop further execution
        <?php endif; ?>

        e.preventDefault();
        e.stopImmediatePropagation();
        var id = $(this).data('id');
        console.log(id);
        return;
        $.ajax({
            url: '/updateCompany',
            type: 'POST',
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

    $(document).on("click", ".myButtondelete", function(e) {

        // Check if alert should be shown; the veriable is decleared in the sidebar included
        <?php if ($showAlert): ?>
            alert("You have reached your free limit. Please subscribe to continue.");
            return; // Stop further execution
        <?php endif; ?>
        
        e.preventDefault();
        e.stopImmediatePropagation();
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: '/deletecomapany',
                type: 'POST',
                cache: false, 
                data: {
                    id: id
                },
                success: function(response) {
                    alert(response.message);
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log(error);
                }
            });
        }
    });
    </script>
</body>

</html>
