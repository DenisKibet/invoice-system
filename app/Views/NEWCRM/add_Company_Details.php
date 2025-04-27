<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Add Company-Details</title>
    <?php include 'css.php' ?>
    <style>
   
    </style>
</head>

<body id="page-top">
    <!-- page wraper -->
    <div id="wrapper">

    <?php include 'sidebarcreate.php' ?>
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- main content -->
        <div id="content">
            <?php include 'topbar.php' ?>

            <div class="d-sm-flex align-items-center  mb-4 p-3">
                <h1 class="h3 mb-0 text-gray-800 mr-3">Add Company Details</h1>
                <div  class="alert alert-info d-flex align-items-center mb-0 py-0">
                    <i class="fas fa-info-circle"></i>
                    After setting up the initial company details, you can make future edits in Company Details table.
                </div>
            </div>
            <!-- Company details form will go here -->
            <div class="container-fluid">
                <form id="invoiceform" style="background: #ffffff;">
                        <div class="row container-fluid">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card-header m-3" style="color:#1a1a1a; background-color: #f2efe8;border-radius: 0 12px 12px 0;">
                                    <h4><i class="fa fa-address-card"></i> Company Details</h4>
                                </div>

                                <div class="col-sm-12">
                                    <p class="text-danger">required fields: *</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-6 mb-3 addCompanyDetails">
                                            <label for="companyName">Company Name:</label><span class="text-danger">*</span><br />
                                            <div id="prefetch"><input id="autouser2" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="CompanytName" value="" placeholder="Company Name" /></div>
                                            <div class="text-danger">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="registration_no">Registration Number:</label><br />
                                            <input id="registration_no" type="text" class="form-control w3-card-2" name="registration_no" value="" placeholder="Registration Number"/><br />
                                            <div class="text-danger"></div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="mobile">Telephone Number:</label><br />
                                            <input id="usermobile" type="text" class="form-control w3-card-2" name="MobileNumber" value="" placeholder="Mobile Number" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="MobileNumber2">Additional Number:</label><br />
                                            <input id="MobileNumber2" type="text" class="form-control w3-card-2" name="MobileNumber2" value="" placeholder="Additonal Mobile" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="email">Email Address:</label><span class="text-danger">*</span><br />
                                            <input id="email" type="text" class="form-control w3-card-2" name="email" value="" placeholder="Email Address" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="post_code">Post code:</label><br />
                                            <input id="post_code" type="text" class="form-control w3-card-2" name="post_code" value="" placeholder="Post code" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="Street">Street:</label><br />
                                            <input id="Street" type="text" class="form-control w3-card-2" name="Street" value="" placeholder="Street" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="city">City:</label><br />
                                            <input id="city" type="text" class="form-control w3-card-2" name="city" value="" placeholder="City" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="Country">Country:</label><br />
                                            <input id="Country" type="text" class="form-control w3-card-2" name="country" value="" placeholder="Country" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label for="website">Website:</label><br />
                                            <input id="website" type="text" class="form-control w3-card-2" name="website" value="" placeholder="Website" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-sm-12 mb-4 addCompanyDetails">
                                            <label for="logo">Upload Company Logo:</label><br />
                                            <input type="file" id="logo" name="logo" class="form-control-file" accept="image/*">
                                            <small class="form-text text-muted">Accepted formats: .jpg, .png. Max size: 2MB.</small>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                                            <label> Logo Preview:</label><br />
                                            <div class="m-1">
                                                <img id="logoPreview" src="#" alt="Logo Preview" style="display: none; max-height: 60px;">
                                            </div>
                                        </div>


                                        <div class="col-lg-12 col-sm-12 mb-5 mt-2 addCompanyDetails">
                                            <input id="submitNewForm" name="addCompanydetails" 
                                                style="background:#071a26;color: #ffffff; width:100%" 
                                                type="submit" class="btn" value="Save Company" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
       
        </div>
        <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Invoice System</h5>
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
    </div>
    <?php include 'js.php' ?>
    <script>
   $(document).on("click", "#submitNewForm", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $("#btnsave").prop("disabled", true);
        var image = "/assets/img/ajax-loader_2.gif";


        var formData = new FormData();
        // Required fields
        formData.append('CompanytName', $("#autouser2").val().trim());
        formData.append('registration_no', $("#registration_no").val().trim());
        formData.append('MobileNumber', $("#usermobile").val().trim());
        formData.append('email', $("#email").val().trim());
        formData.append('website', $("#website").val().trim());
        
        // Optional fields
        formData.append('MobileNumber2', $("#MobileNumber2").val().trim());
        formData.append('post_code', $("#post_code").val().trim());
        formData.append('Street', $("#Street").val().trim());
        formData.append('city', $("#city").val().trim());
        formData.append('country', $("#Country").val().trim());

        // Handle file upload
        var logo = $("#logo")[0].files[0];
        if (logo) {
            formData.append('logo', logo);
        }

        // Validate required fields
        if (!$("#autouser2").val().trim() || 
            !$("#email").val().trim()) {
            alert("Please fill in all required fields (Company Name, and Email).");
            return;
        }

        $.ajax({
            type: "POST",
            url: "/save_company_details",
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $("previewmodal .modal-body").html("<img src='" + image + "' style='margin-top:1%;margin-left:50%' />"
                    + "<br><div style='margin-top:6%; text-align: center;'>"
                    + "<h1> Saving company details, Please wait...</h1></div>");
                $("#previewmodal").modal("show");
            },
            success: function(response) {
                console.log('Response:', response);
                if (response.success) {
                    $(".modal-body").html(
                        "<div style='margin-top:6%; text-align: center;'><i class='fa fa-address-card fa-3x'> </i> <h1> Company Details Saved Successfully.</h1></div>"
                    );
                    $("#previewmodal").modal("show");
                    window.location = "/companyList";
                } else {
                    console.error('Server Error:', response);
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
                alert("An error occurred while saving company details: " + error);
            }
        });
    });

    document.getElementById('logo').addEventListener('change', function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('logoPreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

</body>

</html>
