<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Default Terms</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Terms</h1>
                    </div>
                    <div class="card-body" style="width: 100%; background-color: #ffffff;">

                        <div class="col-12 card-header" style="color:#1a1a1a; background-color: #e6e6e6;border-radius: 0 12px 12px 0;">
                            <h4> <i class="fa fa-pen" style="color:#1a1a1a;vertical-align:middle;"></i>
                                Set Up Default Payment Terms.</h4>

                        </div>

                        <form id="termsform">
                            <div class="card border-0 ">
                                <div class="card-body p-4">
                                    <div class="form-group">
                                        <?php  
                                        if (!empty($terms)) {
                                            foreach ($terms as $term) {
                                                $termstext = $term->terms;
                                                $numberOfDays = (explode(" ", $termstext))[0];
                                                $id = $term->id;
                                            } ?>
                                            <input type="hidden" value="<?= $id ?>" name='termsid' class="form-control">
                                        <?php } ?>

                                        <div class="input-group">
                                            <input 
                                                type="number" 
                                                name="terms"
                                                id="terms" 
                                                cols = "20"
                                                class="form-control shadow-none" 
                                                min="0" 
                                                max="21"
                                                placeholder="Enter a default Term, eg 30"
                                                value = "<?= isset($numberOfDays) ? $numberOfDays: "" ;?>"
                                                required
                                            >
                                            <div class="input-group-append">
                                                <span class="input-group-text">days</span>
                                            </div>
                                        </div>
                                        <small class="form-text text-muted">Enter a number between 1 and 999 (Number of days before the invoice due date)
                                    </div>
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
                                    <div class="modal-header">
                                        <h5 class="modal-title">Invoice System!</h5>
                                        <button type="button" class="close" onclick="closemodal()" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" onclick="closemodal()">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php include 'js.php' ?>

                        <script>
                            $(document).on('input', "#terms", function (e) {
                                this.value = Math.max(0, Math.min(999, this.value));
                            });

                            function closemodal() {
                                $('#previewmodal').modal('hide');
                            }

                            $(document).on("click", "#btnsave", function (e) { 
                                var image = "/assets/img/ajax-loader_2.gif";
                                e.preventDefault();
                                e.stopImmediatePropagation();

                                $("#btnsave").prop("disabled", true);
                                var dataURLpay = '/updatedterms';
                                var terms = $('#termsform').serialize()+ " days";

                                $.ajax({
                                    type: 'POST',
                                    url: dataURLpay,
                                    data: terms,
                                    cache: false, // Disable caching
                                    beforeSend: function () {
                                        $(".modal-body").html("<img src='" + image + "' style='margin-top:1%;margin-left:50%' />"
                                            + "<br><div style='margin-top:6%; text-align: center;'>"
                                            + "<h1> Saving terms please wait.</h1></div>");
                                        $("#previewmodal").modal("show");
                                    },
                                    success: function (data) {
                                        $("#previewmodal").modal("hide");
                                        location.reload(); 
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        alert('error: ' + textStatus + ': ' + errorThrown);
                                    }
                                })
                            });
                        </script>
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
</body>

</html>
