<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Add Project</title>
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
			/* PROJECT DROP DOWMN */
			.container {
		width: 300px;
		margin: 50px auto;
		}

		input[type="text"] {
		width: 100%;
		padding: 10px;
		margin-bottom: 10px;
		}

		.dropdown {
		display: none;
		border: 1px solid #ccc;
		border-top: none;
		overflow-y: auto;
		max-height: 200px;
		}

		.dropdown-item {
		padding: 10px;
		cursor: pointer;
		}

		.dropdown-item:hover {
		background-color: #f0f0f0;
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
                    <h1 class="h3 mb-0 text-gray-800">Add Project</h1>
                </div>
                <div class="container-fluid">
                    <form id="invoiceform" style="background:#f8f9fc;">
                        <div class="row container-fluid">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card-header m-3" style="color:#1a1a1a; background-color: #b3b3b3;">
                                    <h4><i class="fa fa-clipboard-list"></i> Project Details</h4>
                                </div>

                                <div class="col-sm-12">
                                    <p class="text-danger">required fields: *</p>
                                </div>
                                <div class="card-body">
                                    <div class="row  ">
                                        <div class="col-sm-12 col-lg-6 mb-3  addClientInput">
                                            <label for="cname">Client Name:</label><span class="text-danger">*</span><br />
                                            <div id="prefetch"><input id="projectInput" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="ClientName" value="" placeholder="Client Name" /></div>
                                            <div class="text-danger">
											<div class="dropdown" id="dropdown"></div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mt-4 addClientInput">
                                            <input id="submitNewForm" name="addclient" style="background:#5a5c69;color:white;width:100%" type="submit" class="btn" value="Save Project" />
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

		// `	PROJECT DROP DOWMN
		const input = document.getElementById('projectInput');
		const dropdown = document.getElementById('dropdown');

		// Dummy data - array of names
		const names = ['Arnold', 'Steve', 'James', 'Jude', 'Revelation', 'Sophia'];

		// Function to generate dropdown list
		function generateDropdown(names) {
		dropdown.innerHTML = ''; // Clear previous dropdown items
		names.forEach(name => {
			const item = document.createElement('div');
			item.classList.add('dropdown-item');
			item.textContent = name;
			item.addEventListener('click', () => {
			input.value = name; // Set input value to selected name
			dropdown.style.display = 'none'; // Hide dropdown after selection
			});
			dropdown.appendChild(item);
		});
		dropdown.style.display = 'block'; // Show the dropdown
		}

		// Event listener for input field focus
		input.addEventListener('focus', () => {
		generateDropdown(names);
		});

		// Event listener for input field blur
		input.addEventListener('blur', () => {
		// Delay hiding dropdown to allow click event on dropdown items
		setTimeout(() => {
			dropdown.style.display = 'none';
		}, 200);
		});

    </script>

</body>

</html>
