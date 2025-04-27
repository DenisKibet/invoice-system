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
                        <h1 class="h3 mb-0 text-gray-800">Payment</h1>
                    </div>
                    <div class="card-body" style="width: 100%; background-color: #ffffff;">

                        <div class="col-12 card-header" style="color:#1a1a1a; background-color: #f2efe8; border-radius: 0 12px 12px 0;">
                            <h4> <i class="fa fa-pen" style="color:#1a1a1a;vertical-align:middle;"></i>
                                Set Up Default Payment Instructions.</h4>

                        </div>
                        <form id="paymentform">
                            <div id="paymentdiv" style="display: block; width: 100%;">
                                <div class="form-group">
                                    <?php  
;                                    if (!empty($payments)) {
                                        foreach ($payments as $payment) {
                                            $paymenttext = $payment->payment_instruction;
                                            $id = $payment->id;
                                        } ?>
                                        <input type="hidden" value=<?= $id ?> name='paymentid' class="formcontrol">

                                        <?php
                                    } ?>

                                    <textarea class="form-control mt-3" name="payment_instruction" id="payment" cols="20" 
                                        placeholder="Enter a default payment instruction. eg Company name and Account number..."
                                        rows="10"><?= (!empty($paymenttext) ? $paymenttext : ''); ?></textarea>

                                </div>


                            </div>
                            <a href="#" class="btn btn-dark p-2" id="btnsave"
                                style="text-decoration: none; float: inline-end; background-color: #071a26; color:#fff;">
                                <span class="fa fa-save fa-fw mr-2"></span>
                                Update and Close</a>
                        </form>
                        <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color: black;">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Invoice system!</h5>
                                        <button type="button" class="close" data-dismiss="modal" onclick="closemodal()"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                                            onclick="closemodal()">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include 'js.php' ?>
                        <script>
                            // $('#comment').summernote('lineHeight', 0.1);
                            // $("#btnsave").click(function(e) {
                            $(document).one("click", "#btnsave", function (e) {
                                var image = "/assets/img/ajax-loader_2.gif";
                                e.preventDefault();
                                e.stopImmediatePropagation();
                                
                                var image = "/assets/img/ajax-loader_2.gif";

                                $("#btnsave").prop("disabled", true);
                                var dataURLpay = '/savePaymentIstructions';
                                var formdatasendget = $('#paymentform').serialize();
                                console.log(formdatasendget);
                                $.ajax({
                                    type: 'POST',
                                    url: dataURLpay,
                                    data: formdatasendget,
                                    cache: false, // Disable caching
                                    beforeSend: function () {
                                        $(".modal-body").html("<img src='" + image +
                                            "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%; text-align: center;'><h1> Saving payment instructions please wait.</h1></div>"
                                        );
                                        $("#previewmodal").modal("show");
                                    },
                                    success: function () {
                                        $(".modal-body").html("<br> <div style='margin-top:6%; text-align: center;'><h1> Payment Instructions Updated Successfully.</h1></div>"                    );
                                        $("#previewmodal").modal("show");
                                        
                                        setTimeout(() => {
                                            location.reload();                     
                                        }, 500);

                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        console.log('error: ' + textStatus + ': ' + errorThrown);
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
