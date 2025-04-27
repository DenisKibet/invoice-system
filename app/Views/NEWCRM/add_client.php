<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Add Client</title>
    <?php include 'css.php' ?>
    <style>
        table {
            width: 100%;
        }

        form {
            width: 100%;
            /* border: 3px solid #858796; */
            border-radius: 10px;
            padding: 20px 10px;
            background: #eaf1fb;
        }


        .oddRow:nth-child(even) {
            background: #94d1eb;
            border-radius: 12px;
            color: #2489b5;
            padding-right: 20px;
            padding-left: 20px;
            padding-bottom: 20px;
        }

        .oddRow:nth-child(even) h4 {
            color: #2489b5;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebarcreate.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>
                <div class="d-sm-flex align-items-center justify-content-between mb-4 p-3">
                    <h1 class="h3 mb-0 text-gray-800">Add Client</h1>
                </div>
                <div class="container-fluid">
                    <form id="invoiceform" style="background: #ffffff;">
                        <div class="row container-fluid">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card-header m-3" style="color:#1a1a1a; background-color: #f2efe8; border-radius: 0 12px 12px 0;">
                                    <h4><i class="fa fa-users"></i> Client Details</h4>
                                </div>

                                <div class="col-sm-12">
                                    <p class="text-danger">required fields: *</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-6 mb-3 addClientInput">

                                            <label for="cname">Client Name:</label><span class="text-danger">*</span><br />
                                            <div id="prefetch">
                                                <input id="autouser2" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="ClientName" value="" placeholder="Client Name" required />
                                            </div>
                                            <div class="text-danger">
                                                
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addClientInput">
                                            <label for="mobile">Mobile:</label><span class="text-danger">*</span><br />
                                            <input id="usermobile" type="number" class="form-control w3-card-2" name="MobileNumber" value="" placeholder="Mobile Number" required /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addClientInput">
                                            <label for="email">Email Address:</label><span class="text-danger">*</span><br />
                                            <input id="useremail2" type="text" class="form-control w3-card-2" name="EmailAddress" value="" placeholder="Email Address" required /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addClientInput">
                                            <label for="ad_email">Additional Email:</label><br />
                                            <input type="text" class="w3-card-2 form-control" placeholder="Additional email address" value="" name="ad_email" id="ad_email" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                                            <label for="l_no">Landline Number:</label><br />
                                            <input type="number" class="w3-card-2 form-control" name="l_no" id="l_no" placeholder="Landline number" value="" />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                                            <label for="e_no">Emergency Number:</label><br />
                                            <input type="number" class="w3-card-2 form-control" name="e_no" id="e_no" placeholder="Emergency number" value="" />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                                            <label for="ad_address">Address:</label><span class="text-danger">*</span><br />
                                            <input type="text" class="w3-card-2 form-control" placeholder="Address" value="" name="address" id="address" required />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-sm-12 col-lg-6 mb-3 addClientInput">
                                            <label for="ad_address">Additional Address:</label><br />
                                            <input type="text" class="w3-card-2 form-control" placeholder="Additional address" value="" name="ad_address" id="ad_address" />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 mb-5 addClientInput">
                                            <input id="submitNewForm" name="addclient" style="background:#071a26;color:white;width:100%" type="submit" class="btn" value="Save Client" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color:black;">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ITRAVEL HOLIDAYS</h5>
                            <button type="button" class="close" data-dismiss="modal" onclick="closemodal()" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closemodal()">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="previewmodal2" tabindex="-1" role="dialog" style="color:black;">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
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
    </div>
    <?php include 'js.php' ?>
    <script>

        function getData(obj) {
            // alert(obj.value);
            feedArray = obj.value.split(",");
            // console.log(feedArray[0]);
            // console.log(feedArray[1]);
            // console.log(feedArray[2]);
            $("#clientnamecheck").val(feedArray[0]);
            $("#mobileno").val(feedArray[1]);
            $("#emailaddcheck").val(feedArray[2]);
            $("#billto").val(feedArray[3]);

        }
        $('#invoiceform').submit(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            
            var image = '/assets/img/ajax-loader_2.gif';
            var email = $("#useremail2").val().trim();
            var ad_email = $("#ad_email").val().trim();
            var ph_no = $("#usermobile").val().trim();
            var fname = $("#autouser2").val().trim();
            var l_no = $("#l_no").val().trim();
            var e_no = $("#e_no").val().trim();
            var address = $("#address").val().trim();
            var ad_address =  $("#ad_address").val().trim();
            
            // Function to validate email format
            function isValidEmail(email) {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            if((ad_email && !isValidEmail(ad_email)) || !isValidEmail(email)) {
                alert('Please enter a valid email address');
            } else {
                var formData = {
                    ph_no: ph_no,
                    fname: fname,
                    email: email,
                    ad_email: ad_email,
                    l_no: l_no,
                    e_no: e_no,
                    ad_address: ad_address,
                    address: address,
                };

                //send ajax response
                $.ajax({
                    type: "POST",
                    url: "/save_client",
                    data: formData,
                    dataType: "json",
                    encode: true,
                    beforeSend: function () {
                        $("#previewmodal2 .modal-body").html("<img src='" + image +
                        "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;margin-left:30%'><h1> Saving Client Please Wait.</h1></div>"
                        );

                        setTimeout(() => {
                            $("#previewmodal2").modal("show");
                        }, 100);
                    },
                    success: function(res) {
                        if(!res.success) {
                            setTimeout(() => {
                                $("#previewmodal2").modal("hide"); 
                                alert(res.message);                               
                            }, 100);
                        } else {
                            $("#previewmodal2 .modal-body").html("<img src='" + image +
                            "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;margin-left:30%'><h1>Client Saved Successfully</h1></div>"
                            );
                            setTimeout(() => {
                                window.location = "/clientList";                                
                            }, 100);
                        }
                    },
                    error: function(xhr, status, error) {
                        setTimeout(() => {
                            $("#previewmodal2").modal("hide");
                            alert("An error occurred while saving client. Please try again.");                            
                        }, 100);
                    }
                });
            }
        });
        
        // autocomplete fields if user exist
        $("#autouser").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "/invoiceListauto",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        // console.log('Response Data:', data);
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#autouser').val(ui.item.label); // display the selected text
                $('#userid').val(ui.item.value); // save selected id to input
                $('#mobile').val(ui.item.mobile);
                $('#useremail').val(ui.item.email);
                $('#bill_to').val(ui.item.address);
                return false;
            }
        });
        $("#autouser2").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "/invoiceListauto",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function(data) {
                        // console.log('Response Data:', data);
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                // console.log(ui);
                // Set selection
                $('#autouser2').val(ui.item.label); // display the selected text                    
                $('#usermobile').val(ui.item.mobile);
                $('#useremail2').val(ui.item.email);
                $('#address').val(ui.item.address);
                return false;
            }
        });
        $('#newFormButton').click(function() {
            $('.addClientInput').show();
            $(this).hide();
            $('#invoiceFormButton').show();
            $('.invoiceForm').hide();
            $('#saveitinerary').hide();
        });

        $('#invoiceFormButton').click(function() {
            $(this).hide();
            $('.invoiceForm').show();
            $('.addClientInput').hide();
            $('#newFormButton').show();
            $('#saveitinerary').show();
        });
    </script>

</body>

</html>
