<div class="container-fluid">
    <form id="invoiceform">
        <div class="row container-fluid">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="pb-5">
                    <a href="#" class="btn btn-dark " id="btnsave" style="text-decoration: none; float: right;">
                        <span class="fa fa-user fa-fw "></span>
                        Update and Close</a>
                </div>
                <div class="card-header m-3" style="color:#1a1a1a; background-color: #b3b3b3;border-radius: 0 12px 12px 0;">
                    <h4><i class="fa fa-user"></i> Client Details</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mb-3 addClientInput">

                            <label for="cname">Client Name:</label><br />
                            <input type="hidden" class="form-control" name="clientId" id="clientId" value="<?= $client->id ?>">
                            <div id="prefetch"><input id="autouser2" 
                                class="itemName input-lg typeahead w3-card-2 form-control" type="text" 
                                name="ClientName" value="<?php echo $client->ClientName;?>" placeholder="Client Name" /></div>
                            <div class="text-danger">
                                
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addClientInput">
                            <label for="mobile">Mobile:</label><br />
                            <input id="usermobile" type="text" class="form-control w3-card-2" 
                                name="MobileNumber" value="<?php echo $client->MobileNumber;?>" placeholder="Mobile Number" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addClientInput">
                            <label for="email">Email Address:</label><br />
                            <input id="useremail2" type="text" class="form-control w3-card-2" 
                                name="EmailAddress" value="<?php echo $client->EmailAddress;?>" placeholder="Email Address" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addClientInput">
                            <label for="ad_email">Additional Email:</label><br />
                            <input type="text" class="w3-card-2 form-control" placeholder="Additional email address" 
                                value="<?php echo $client->ad_email;?>" name="ad_email" id="ad_email" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                            <label for="l_no">Landline Number:</label><br />
                            <input type="text" class="w3-card-2 form-control" name="l_no" id="l_no" 
                                placeholder="Landline number" value="<?php echo $client->l_no;?>" />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                            <label for="e_no">Emergency Number:</label><br />
                            <input type="text" class="w3-card-2 form-control" name="e_no" id="e_no" 
                                placeholder="Emergency number" value="<?php echo $client->e_no;?>" />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 mb-3 addClientInput">
                            <label for="ad_address">Address:</label><br />
                            <input type="text" class="w3-card-2 form-control" placeholder="Address" 
                                value="<?php echo $client->address;?>" name="address" id="address" />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6 mb-3 addClientInput">
                            <label for="ad_address">Additional Address:</label><br />
                            <input type="text" class="w3-card-2 form-control" placeholder="Additional address"
                                value="<?php echo $client->ad_address;?>" name="ad_address" id="ad_address" />
                            <div class="text-danger">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="modal" id="previewmodal2" tabindex="-1" role="dialog" style="color:black;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
</div>
<script>
     $(document).on("click", "#Viewdets #btnsave", function(e) {
        var image = '/assets/img/ajax-loader_2.gif';
        e.preventDefault();
        e.stopImmediatePropagation();
        var dataURLpay = '/saveUpdatedClientDetails';
        var formData = $('#Viewdets #invoiceform').serialize();

        // return;
        $.ajax({
            type: "POST",
            url: "/saveUpdatedClientDetails", 
            data: formData,
            dataType: "json",
            cache: false,
            encode: true,
            beforeSend: function () {
                $("#previewmodal2 .modal-body").html("<img src='" + image +
                "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;margin-left:30%'><h1> Update Client Please Wait.</h1></div>"
                );
                $("#Viewdets").modal("hide");
                $("#previewmodal2").modal("show");
            },
            success: function(response) {
                // alert(response.message)
                location.reload();
            },
            error: function(xhr, status, error) {
                $("#previewmodal2").modal("hide");
                console.error(error);
                alert(response.message)
            }
        });
    });
</script>