<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


    <title>Invoice System - All Notice</title>
    <?php include 'css.php' ?>
    <style>
    #dataTable td,
    #dataTable th {
        border: 1px solid #ddd;
        padding: 6px;
    }

    #dataTable tr:nth-child(even) {
        background-color: #d4ecf7;
    }

    #dataTable tr:hover {
        background-color: #93cfeb;
        color: #186081;
    }

    #dataTable th {
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: left;
        background-color: #808080;
        color: white;
    }

    #dataTable {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
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

        <?php include 'sidebarnotice.php' ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">All Notice</h1>
                    </div>
                    <!-- <div style="float:right;"><i class="material-icons">search</i> -->

                    <!-- Content Row -->
   
                    <div class="table-responsive">
                        <table class="table table-bordered" cellspacing="0" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Posted at</th>
                                    <th>Heading</th>
                                    <th>Body</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
							<tbody>
								<tr>
									<td style="vertical-align:middle">1</td>
									<td style="vertical-align:middle">28/02/2024</td>
									<td style="color:#818589;vertical-align:middle"><h5>Notice</h5></td>
									<td style="vertical-align:middle">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Commodi ad at itaque deleniti blanditiis sit corporis possimus sapiente libero eius neque ipsa sunt provident, consectetur quis explicabo dolorem porro mollitia ut consequuntur rerum beatae impedit. Neque dolores culpa, voluptas sequi inventore nesciunt? Cumque, minima nesciunt sit libero distinctio animi harum!</td>
									<td style="vertical-align:middle">
										<a style="cursor:pointer;" class="text-success myButtonUpdate" data-id="1"><i class="fa fa-pen" title="Edit Notice"></i></a>&nbsp;&nbsp;&nbsp;
										<a style="cursor:pointer" class="text-danger myButtonDelete" data-id="1"><i class="fa fa-trash" title="Delete Notice"></i></a>
									</td>
								</tr>
								<tr>
									<td style="vertical-align:middle">2</td>
									<td style="vertical-align:middle">28/02/2024</td>
									<td style="color:#818589;vertical-align:middle"><h5>Annoucements</h5></td>
									<td style="vertical-align:middle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem deserunt quas illo incidunt, a sit nesciunt. In incidunt quod accusantium! Sunt laboriosam id distinctio sed odit ipsam eaque consequatur sint ut ad? A blanditiis ipsum illo obcaecati!</td>
									<td style="vertical-align:middle">
										<a style="cursor:pointer;" class="text-success myButtonUpdate" data-id="2"><i class="fa fa-pen" title="Edit Notice"></i></a>&nbsp;&nbsp;&nbsp;
										<a style="cursor:pointer" class="text-danger myButtonDelete" data-id="2"><i class="fa fa-trash" title="Delete Notice"></i></a>
									</td>
								</tr>
								<!-- Add more rows with static data as needed -->
							</tbody>

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
                        <span>Copyright &copy; iTravelHolidays 2024</span>
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

    

    <div class="modal fade" id="Viewdets" tabindex="-1" role="dialog" aria-labelledby="viewdetsmodal"
        aria-hidden="true" style="color:black">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewdetsmodal">Edit Notice</h5>
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
        $(document).on('click', '.myButtonDelete', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var id = $(this).data('id');

            // console.log(id);
            if (confirm('Are you sure you want to delete this record?')) {
                // Construct AJAX call
                $.ajax({
                    url: '/deleteNotice',
                    type: 'POST',
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

        $(document).on('click', '.myButtonUpdate', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '/fetchNotice',
                type: 'POST',
                data: { id: id},
                success: function(response) {
                    $('#Viewdets .modal-body').html(response);
                    $('#Viewdets').modal('show');
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

        $('#Viewdets').on('hidden.bs.modal', function() {
            document.location.reload();
        });

        $(document).tooltip({ show: null});
    });
    </script>

</body>

</html>
