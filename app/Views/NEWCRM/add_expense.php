<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Add Expense </title>
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
        * {
  --switch-height: 20px;
  --switch-padding: 8px;
  --switch-width: calc((var(--switch-height) * 2) - var(--switch-padding));
  --slider-height: calc(var(--switch-height) - var(--switch-padding));
  --slider-on: calc(var(--switch-height) - var(--switch-padding));
}

.switch {
  position: relative;
  display: inline-block;
  width: var(--switch-width);
  height: var(--switch-height);
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  content: "";
  position: absolute;
  height: var(--slider-height);
  width: var(--slider-height);
  left: calc(var(--switch-padding) / 2);
  bottom: calc(var(--switch-padding) / 2);
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked+.slider {
  background-color: #2196F3;
}

input:focus+.slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
  transform: translateX(var(--slider-on));
}

.slider.round {
  border-radius: var(--slider-height);
}

.slider.round:before {
  border-radius: 50%;
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
                    <h1 class="h3 mb-0 text-gray-800">Add Expense</h1>
                </div>
                <div class="container-fluid">
                    <form id="invoiceform" style="background:#f8f9fc;">
                        <div class="row container-fluid">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card-header m-3" style="color:#1a1a1a; background-color: #b3b3b3;border-radius: 0 12px 12px 0;">
                                    <h4><i class="fa fa-th-large"></i> Expense Details</h4>
                                </div>

                                <div class="col-sm-12">
                                    <p class="text-danger">required fields: *</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
										
										<div class="col-lg-6 col-sm-12 ">
                                            <label for="mobile">Expense Date:</label><span class="text-danger">*</span><br />
                                            <input id="usermobile" type="date" class="form-control w3-card-2" name="MobileNumber" value="" placeholder="1 March 2024" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 ">
                                            <label for="mobile">Merchant:</label><span class="text-danger">*</span><br />
                                            <input id="usermobile" type="text" class="form-control w3-card-2" name="MobileNumber" value="" placeholder="Enter a merchant" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 ">
                                            <label for="email">Cartegory:</label><span class="text-danger">*</span><br />
                                            <input id="useremail2" type="text" class="form-control w3-card-2" name="EmailAddress" value="" placeholder="Enter a cartegory" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

										<div class="col-lg-6 col-sm-12 ">
                                            <label for="email">Total:</label><span class="text-danger">*</span><br />
                                            <input id="useremail2" type="number" class="form-control w3-card-2" name="EmailAddress" value="" placeholder="0" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>
										
										<div class="col-lg-6 col-sm-12 ">
                                            <label for="email">Tax:</label><span class="text-danger">*</span><br />
                                            <input id="useremail2" type="number" class="form-control w3-card-2" name="EmailAddress" value="" placeholder="0 " /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

										<div class="col-lg-6 col-sm-12 ">
                                            <label for="email">Tip:</label><span class="text-danger">*</span><br />
                                            <input id="useremail2" type="number" class="form-control w3-card-2" name="EmailAddress" value="" placeholder="0" /> <br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 ">
                                            <label for="email">Description:</label><span class="text-danger">*</span><br />
                                            <input id="useremail2" type="text" class="form-control w3-card-2"  name="EmailAddress" value="" placeholder="Enter a description" /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        
                                        
                                        <div class="col-lg-6 col-sm-12 ">
                                        </div>
                                      
                                        <div class="col-lg-12 col-sm-12 mt-3 ">
                                            <input id="submitNewForm" name="additem" style="background:#5a5c69;color:white;width:100%" type="submit" class="btn" value="Save Item" />
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
        $('#submitNewForm').click(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var formData = {
                ph_no: $("#usermobile").val(),
                fname: $("#autouser2").val(),
                email: $("#useremail2").val(),
                ad_email: $("#ad_email").val(),
                l_no: $("#l_no").val(),
                e_no: $("#e_no").val(),
                ad_address: $("#ad_address").val(),
                address: $("#address").val(),
            };
            if ($("#usermobile").val() && $("#usermobile").val().trim() !== "" || $("#autouser2").val() && $(
                    "#autouser2").val().trim() !== "" || $("#useremail2").val() && $("#useremail2").val().trim() !==
                "") {
                $.ajax({
                    type: "POST",
                    url: "/SaveclientCRM",
                    data: formData,
                    dataType: "json",
                    encode: true,
                    success: function(response) {
                        // The AJAX request was successful
                        alert("Insert Successful");
                        // location.href('/clientList')
                        location.reload();
                        // console.log('Response:', response);
                    },
                    error: function(xhr, status, error) {
                        // An error occurred while processing the AJAX request
                        console.error('Error:', error);
                    }
                });
            }



            // console.log("here");
            // console.log($('#autouser').val());


            // $('#newForm').submit();
        });
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
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
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
