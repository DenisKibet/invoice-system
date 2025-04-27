<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice System - Add Agent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <?php include 'css.php' ?>
    <style>
    .password-container {
        position: relative;
    }

    .password-container input {
        padding-right: 30px; /* Make room for the icon */
    }

    .password-container .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        cursor: pointer;
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
                    <h1 class="h3 mb-0 text-gray-800">Add Agent</h1>
                </div>
                <div class="container-fluid">
                    <form id="agentform" style="background: #ffffff;">
                        <div class="row container-fluid">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card-header m-3" style="color:#1a1a1a; background-color: #f2efe8; border-radius: 0 12px 12px 0;">
                                    <h4><i class="fa fa-users"></i> Agent Details</h4>
                                </div>

                                <div class="col-sm-12">
                                    <p class="text-danger">required fields: *</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-6 mb-3 addAgentInput">
                                            <label for="cname">Agent Name:</label><span class="text-danger">*</span><br />
                                            <div id="prefetch"><input id="autouser2" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="agentName" value="" placeholder="Agent Name" required /></div>
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addAgentInput">
                                            <label for="email">Email Address:</label><span class="text-danger">*</span><br />
                                            <input id="useremail2" type="text" class="form-control w3-card-2" name="emailAddress" value="" placeholder="Email Address" required /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addAgentInput">
                                            <label for="password">Agent Password:</label><span class="text-danger">*</span><br />
                                            <div class="password-container">
                                                <input type="password" class="w3-card-2 form-control" placeholder="Agent password" value="" name="password" id="password" required />
                                                <i class="bi bi-eye-slash password-toggle" id="passwordToggle"></i>
                                            </div>
                                            <div class="text-danger"></div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 addAgentInput">
                                            <label for="mobile">Mobile:</label><span class="text-danger">*</span><br />
                                            <input id="usermobile" type="number" class="form-control w3-card-2" name="mobileNumber" value="" placeholder="Mobile Number" required /><br />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3 addAgentInput">
                                            <label for="e_no">Emergency Number:</label><br />
                                            <input type="number" class="w3-card-2 form-control" name="e_no" id="e_no" placeholder="Emergency number" value="" />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3 addAgentInput">
                                            <label for="ad_address">Address:</label><span class="text-danger">*</span><br />
                                            <input type="text" class="w3-card-2 form-control" placeholder="Address" value="" name="address" id="address" required />
                                            <div class="text-danger">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-sm-12 mb-5 addAgentInput">
                                            <input id="saveAgent" name="addAgent" style="background:#071a26;color:white;width:100%" type="submit" class="btn" value="Save Agent" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color:black;">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
     $(document).ready(function() {
        // Password visibility toggle
        const $passwordInput = $('#password');
        const $passwordToggle = $('#passwordToggle');

        $passwordToggle.on('click', function() {
            const type = $passwordInput.attr('type') === 'password' ? 'text' : 'password';
            $passwordInput.attr('type', type);
            $(this).toggleClass('bi-eye bi-eye-slash');
        });
        // Form submission and validation
        $('#saveAgent').click(function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var image = '/assets/img/ajax-loader_2.gif';

            // Define required fields with their IDs and labels
            var requiredFields = [
                { id: 'autouser2', label: 'Agent Name' },
                { id: 'useremail2', label: 'Email Address' },
                { id: 'password', label: 'Agent Password' },
                { id: 'usermobile', label: 'Mobile' },
                { id: 'address', label: 'Address' }
            ];

            var missingFields = [];

            // Check each required field
            requiredFields.forEach(function(field) {
                var value = $('#' + field.id).val().trim();
                if (value === '') {
                    missingFields.push(field.label);
                }
            });

            if (missingFields.length > 0) {
                alert("Please fill in the following required fields:\n" + missingFields.join("\n"));
                return;
            }

            // If all required fields are filled, proceed with form submission
            var agentData = $('#agentform').serialize();
            var image = "/assets/img/ajax-loader_2.gif";

            $.ajax({
                type: "POST",
                url: "/save-agent",
                data: agentData,
                dataType: "json",
                encode: true,
                beforeSend: function () {
                    $("#previewmodal2 .modal-body").html("<img src='" + image +
                    "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;margin-left:30%'><h1> Saving Agent Please Wait.</h1></div>"
                    );
                    $("#previewmodal2").modal("show");
                },
                success: function() {
                    window.location = "/stafflist";
                },
                error: function(xhr, status, error) {
                    $("#previewmodal2").modal("hide");
                    console.error(error);
                    alert("An error occurred while saving agent. Please try again.");
                }
            });
        });
    });
    </script>
</body>
</html>