<?php 
// var_dump($users);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>invoice system - Staff List</title>
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

    #dataTable tr:nth-child(even) {
        /* background-color: #f2f2f2; */
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

    * {
        box-sizing: border-box;
    }
    #dataTable th, #dataTable td {
        border-left: none; 
        border-top: none; 
    }
    #dataTable tr:last-child td {
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Staff List</h1>
                        <div class="col-lg-" style="padding-bottom:0;">
                            <a href="create-agent" class="form-control btn shadow-none" style="background:#071a26; color:white; text-align:center;">Create an Agent</a>
                        </div>
                    </div>

                    <div class="table-responsive card p-3" style="color: #555;">
                       <table class="table table-bordered" id="dataTable" style="width: max-content; overflow: auto; min-width: 100%" cellspacing="0">
                            <!-- <div class="table-responsive"> -->
                                <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> -->
                                    <thead >
                                        <tr class="header">
                                            <!-- <th>id</th> -->
                                            <th>Username</th>
                                            <!-- <th>Mobile</th> -->
                                            <th>Email</th>
                                            <th>Role </th>
                                            <th>Date Added</th> 
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                        <tr>
                                            <!-- <td><?= $user->id ?></td> -->
                                            <td><?= $user->username ?></td>
                                            <td><?= $user->email?? 'No set'?></td>
                                            <td><?= $user->user_type ?></td>
                                            <td><?= $user->created_at ?></td>
                                            <!-- <td><?= $user->agent_mobile ?? 'N/A' ?></td> -->
                                            <!-- <td><?= $user->address ?? 'N/A' ?></td> -->
                                            <td>
                                            <!-- <a style="cursor:pointer;" class="text-primary myButtonviewinvoice"
                                                    data-id=<?= $user->id ?>><i class="fa fa-file"
                                                        title="View Staff"></i></a>&nbsp;&nbsp; -->

                                            <button class="btn btn-outline-primary btn-sm myButtonviewinvoice" title="Edit Staff" data-id="<?= $user->id?>"><i class="fas fa-edit"></i> </button>
                                            <?php 
                                                $hasReachedFreeLimit = $session->get("has_reached_free_limit");
                                                $isSubscriptionActive = $session->get("is_subscription_active");
                                                $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
                                            ?>
                                            <!-- <a style="cursor:pointer;" class="text-primary myButtonviewuser"
                                                data-id=<?= $user->id ?>><i class="fa fa-pen"
                                                    title="Update Staff Details"></i></a>&nbsp;&nbsp; -->
                                        
                                            <!-- <a style="cursor:pointer;" class="text-danger myButtondelete"
                                                data-id=<?= $user->id ?>><i class="fa fa-trash"
                                                    title="Delete Staff"></i></a> -->

                                            <button class="btn btn-outline-danger btn-sm myButtondelete" title="Delete Staff" data-id="<?= $user->id?>"><i class="fas fa-trash-alt"></i> </button>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                <!-- </table> -->
                            <!-- </div> -->
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
        aria-hidden="true" style="color: black;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewdetsmodal">Staff Quotes</h5>
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
        $(document).on('click', '.myButtonviewuser', function(e) {
            var userId = $(this).data('id');
            // console.log(userId);
            // return;
            $.ajax({
                url: '/getstaffitinerary',
                type: 'POST',
                data: { username: username},
                success: function(response) {
                    $('.modal-body').html(response);
                    $('#Viewdets').modal('show');
                    $('#Viewdets #viewdetsmodal').html('Staff Itinerary');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
        $(document).on("click", ".myButtonviewinvoice", function(e) {
            // Retrieve data attribute value
            var userId = $(this).data('id');
            // return;
            $.ajax({
                url: '/view-staff-details',
                type: 'POST',
                cache: false, // Disable caching
                data: {
                    userId: userId
                },
                success: function(response) {
                    // Handle response from server
                    // console.log(response);
                    $('.modal-body').html(response);
                    $('#Viewdets').modal('show');
                    $('#Viewdets #viewdetsmodal').html('Staff Details');
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log(error);
                }
            });
        });
        
        $(document).on("click", ".myButtondelete", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var id = $(this).data('id');

            if (confirm('Are you sure you want to delete this record?')) {
                $.ajax({
                    url: '/delete-staff',
                    type: 'POST',
                    cache: false, 
                    data: {
                        id: id
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

        $(document).tooltip({ show: null});
        
        $('#Viewdets').on('hidden.bs.modal', function() {
            document.location.reload();
        });
    });
    </script>
</body>

</html>
