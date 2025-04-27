
<div class="container-fluid">
    <form id="invoiceform" enctype="multipart/form-data">
        <div class="row container-fluid">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="card-header m-3" style="color:#1a1a1a; background-color: #b3b3b3;border-radius: 0 12px 12px 0;">
                    <h4><i class="fa fa-address-card"></i> Company Details</h4>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        
                        <div class="col-lg-6 col-sm-12 mb-4 addCompanyDetails">
                            <label for="logo">Company Logo:</label><br />
                            <?php 
                                $logoPath = $company->logo_path ?? ''; 
                            ?>
                            <img id="currentLogo" src="<?= base_url($logoPath) ?>" class="img-fluid" style="height: 50px;" alt="Set Company Logo" />
                        </div>
                        <div class="col-lg-6 col-sm-12 mb-4 addCompanyDetails">
                            <label for="logo">Update Company Logo:</label><br />
                            <input type="file" id="logo" name="logo" class="form-control-file" accept="image/*">
                            <small class="form-text text-muted">Accepted formats: .jpg, .png. Max size: 2MB.</small>
                            <div class="mt-3">
                                <img id="logoPreview" src="#" alt="Logo Preview" style="display: none; max-height: 150px;">
                            </div>
                        </div>


                        <div class="col-sm-12 col-lg-6 mb-3 addCompanyDetails">
                            <input type="hidden" class="form-control" name="companyId" id="companyId" value="<?= $company->id ?>"> 
                            <label for="companyName">Company Name:</label><br />
                            <div id="prefetch"><input id="autouser2" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="CompanytName" value="<?php echo $company->company_name?>" placeholder="Company Name" /></div>
                            <div class="text-danger">
                                
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="registration_no">Registration Number:</label><br />
                            <input id="registration_no" type="text" class="form-control w3-card-2" name="registration_no" value="<?php echo $company->registration_no?>" placeholder="Registration Number" /><br />
                            <div class="text-danger"></div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="mobile">Telephone Number:</label><br />
                            <input id="usermobile" type="text" class="form-control w3-card-2" name="MobileNumber" value="<?php echo $company->mobile_no?>" placeholder="Mobile Number" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="MobileNumber2">Additional Number:</label><br />
                            <input id="MobileNumber2" type="text" class="form-control w3-card-2" name="MobileNumber2" value="<?php echo $company->additional_no?>" placeholder="Additonal Mobile" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="email">Email Address:</label><br />
                            <input id="email" type="text" class="form-control w3-card-2" name="email" value="<?php echo $company->email?>" placeholder="Email Address" /><br />
                            <div class="text-danger">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="post_code">Post code:</label><br />
                            <input id="post_code" type="text" class="form-control w3-card-2" name="post_code" value="<?php echo $company->post_code?>" placeholder="Post code" /><br />
                            <div class="text-danger">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="Street">Street:</label><br />
                            <input id="Street" type="text" class="form-control w3-card-2" name="Street" value="<?php echo $company->street?>" placeholder="Street" /><br />
                            <div class="text-danger">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="city">City:</label><br />
                            <input id="city" type="text" class="form-control w3-card-2" name="city" value="<?php echo $company->city?>" placeholder="City" /><br />
                            <div class="text-danger">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="Country">Country:</label><br />
                            <input id="Country" type="text" class="form-control w3-card-2" name="country" value="<?php echo $company->country?>" placeholder="Country" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addCompanyDetails">
                            <label for="website">Website:</label><br />
                            <input id="website" type="text" class="form-control w3-card-2" name="website" value="<?php echo $company->website?>" placeholder="Website" /><br />
                            <div class="text-danger">
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12 mt-3 ">
                            <input id="btnsave" name="update_company" 
                                style="background:#071a26; color: #fff; width:100%" 
                                type="submit" class="btn" value="Update and Close" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
$(document).on("click", "#Viewdets #btnsave", function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $("#btnsave").prop("disabled", true);
    var image = "/assets/img/ajax-loader_2.gif";

    var dataURLpay = '/updateCompany';
    var formData = new FormData($('#invoiceform')[0]);

    $.ajax({
        type: 'POST',
        url: dataURLpay,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $(".modal-body").html("<img src='" + image +
                "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;text-align:center'> </i> <h1> Updating company please wait.</h1></div>"
            );
            $("#previewmodal").modal("show");
        },
        success: function(data) {
            $("#previewmodal").modal("hide");
            location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('error: ' + textStatus + ': ' + errorThrown);
        },
        complete: function() {
            $("#btnsave").prop("disabled", false);
        }
    });
});

document.getElementById('logo').addEventListener('change', function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('currentLogo');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
});

</script>