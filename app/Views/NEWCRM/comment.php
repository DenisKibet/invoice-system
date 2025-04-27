<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Default Comment</title>
    <?php include 'css.php' ?>
    <style>
        .icon {
            vertical-align: middle;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebarsettings.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Comment</h1>
                    </div>
                    <div class="card-body" style="width: 100%; background-color: #ffffff;">

                        <div class="col-12 card-header" style="color:#1a1a1a; background-color: #f2efe8; border-radius: 0 12px 12px 0;">
                            <h4> <i class="fa fa-pen" style="color:#1a1a1a;vertical-align:middle;"></i>
                                Set Up Default Comment.</h4>

                        </div>
                        <form id="commentform">
                            <div id="commentdiv" style="display: block; width: 100%;">
                                <div class="form-group">
                                    <?php  
                                       if (!empty($comments)) {
                                        foreach ($comments as $comment) {
                                            $commenttext = $comment->comment;
                                            $id = $comment->id;
                                        } ?>
                                        <input type="hidden" value=<?= $id ?> name='commentid' class="formcontrol">

                                        <?php
                                    } ?>

                                    <textarea class="form-control mt-3" name="comment" id="comment" placeholder="Enter a default comment" cols="20" rows="10"><?= (!empty($commenttext) ? $commenttext : ''); ?></textarea>
                                </div>

                            </div>
                            <a href="#" class="btn p-2" id="btnsave" 
                                style="text-decoration: none; float: inline-end; background-color: #071a26; color:#fff;">
                                <span class="fa fa-save fa-fw mr-2"></span>
                                Update and Close</a>
                        </form>
                        <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color:black;">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <!-- <div class="modal-header">
                                        <h5 class="modal-title">Invoice System!</h5>
                                        <button type="button" class="close" data-dismiss="modal" onclick="closemodal()"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div> -->
                                    <div class="modal-body">

                                    </div>
                                    <!-- <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            onclick="closemodal()">Close</button>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="warningModalLabel">Plan Expiry Alert</h5>
                                        <button type="button" class="btn-close" style="border: none;" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Content will be inserted here -->
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn btn-secondary" style="background-color: #5a5c69; border: none;" id="getBasicPlan" data-bs-dismiss="modal">
                                            Get Basic Plan for £19/month
                                        </button>
                                        <a href="/plans-list" class="font-weight-bold" style="text-decoration: none">View all plans</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    </div>

    <!-- Subscription alert -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="warningModalLabel">Plan Expiry Alert</h5>
                    <button type="button" class="btn-close" style="border: none;" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be inserted here -->
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary" style="background-color: #5a5c69; border: none;" id="getBasicPlan" data-bs-dismiss="modal">
                        Get Basic Plan for £19/month
                    </button>
                    <a href="/plans-list" class="font-weight-bold" style="text-decoration: none">View all plans</a>
                </div>
            </div>
        </div>
    </div>
    <!-- <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Invoice system <?php echo date('Y');?></span>
            </div>
        </div>
    </footer> -->
    <?php include 'js.php' ?>
    <script>
        // $('#comment').summernote('lineHeight', 0.1);
        // $("#btnsave").click(function(e) {
        $(document).one("click", "#btnsave", function (e) { 
            e.preventDefault();
            e.stopImmediatePropagation();
            
            var image = "/assets/img/ajax-loader_2.gif";
            
            $("#btnsave").prop("disabled", true);
            var dataURLpay = '/saveComment';
            var formdatasendget = $('#commentform').serialize();
            console.log(formdatasendget);
            $.ajax({
                type: 'POST',
                url: dataURLpay,
                data: formdatasendget,
                cache: false, // Disable caching
                beforeSend: function () {
                    $(".modal-body").html("<img src='" + image +
                        "' style='margin-top:1%;margin-left:50%' /> <br> <div style='margin-top:6%; text-align: center;'><h1> Saving comment please wait.</h1></div>"                    );
                    $("#previewmodal").modal("show");
                },
                success: function () {
                    $(".modal-body").html("<br> <div style='margin-top:6%; text-align: center;'><h1> Comment Updated Successfully.</h1></div>"                    );
                    $("#previewmodal").modal("show");

                    setTimeout(() => {
                        location.reload();                        
                    }, 500);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('error: ' + textStatus + ': ' + errorThrown);
                    console.error('AJAX error:', jqXHR, textStatus, errorThrown);

                }
            })
        });

$(document).ready(function() {
    function showWarningModal(event) {
        event.preventDefault(); // Prevent the default link behavior
        $('#warningModal').modal('show');
    }

    // Attach the showWarningModal function to all links that need it
    $('a[onclick="showWarningModal(event)"]').on('click', showWarningModal);

    // Add functionality to the "Get Basic Plan" button
    $('#getBasicPlan').on('click', function() {
        // Add your logic here to handle the Basic Plan subscription
        console.log('User clicked on Get Basic Plan');
    });
});
    </script>
</body>

</html>
