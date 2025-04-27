<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - Add Item</title>
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
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: none;
        }
        /* If there is eror in the page the define the look of submit button */
        #submitNewForm:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        }

        #submitNewForm {
            background: #5a5c69;
            color: white;
            width: 100%;
            cursor: pointer;
        }

        #submitNewForm:hover:not(:disabled) {
            background: #4e5058;
        }
        
        .file-upload-wrapper {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 4px;
            background: #f8f9fa;
        }
        /* submit */
        .btn-submit {
            background: black;
            color: white;
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: opacity 0.3s;
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

                <div class="container-fluid">
                <div class="card">
                    <div class="card-header m-3" style="color: #1a1a1a; background-color: #f2efe8; border-radius: 0 12px 12px 0;">
                        <h4><i class="fa fa-th-large"></i> Item Description</h4>
                    </div>
                    
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="manual-tab" data-toggle="tab" href="#manual" role="tab">Manual Entry</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="file-tab" data-toggle="tab" href="#file" role="tab">File Upload</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="manual" role="tabpanel">
                                <form id="manualEntryForm">
                                    <p class="text-danger mb-4">required fields: *</p>
                                    
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-6 mb-3">
                                            <label for="item_description">Enter Item Description:<span class="text-danger">*</span></label>
                                            <div id="item_description">
                                                <input id="autouser2" class="itemName input-lg typeahead form-control" type="text" 
                                                    name="Item_description" placeholder="Description"/>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <label for="cost">Cost Price:</label>
                                            <input id="cost" type="number" class="form-control" name="cost" placeholder="0" />
                                        </div>

                                        <div class="col-lg-12 col-sm-12 mb-3">
                                            <label for="rate">Selling Price:<span class="text-danger">*</span></label>
                                            <input id="rate" type="number" class="form-control" name="rate" placeholder="0"/>
                                        </div>
                                        
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <p class="mb-2">Enable Taxes</p>
                                            <div class="d-flex align-items-center">
                                                <label class="switch mr-3">
                                                    <input type="checkbox" id="enable_taxes">
                                                    <span class="slider round"></span>
                                                </label>
                                                <span>Default taxes will be applied to this item</span>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12 mb-3" id="taxRateSection" style="display: none;">
                                            <label for="taxRate">Input Tax Rate(%)</label>
                                            <input id="taxRate" type="number" class="form-control" name="taxRate" placeholder="0" />
                                            <div id="taxRateError" class="error-message"></div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary w-100 shadow-none" id="submitNewForm" >
                                                Save Item
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab-pane fade" id="file">
                                <form id="bulkUploadForm">
                                    <div class="file-upload-wrapper mb-4">
                                        <i class="fa fa-cloud-upload fa-3x mb-3"></i>
                                        <h5>Drag & Drop or Click to Upload</h5>
                                        <p class="text-muted">Supported formats: CSV, XLSX</p>
                                        <input type="file" class="form-control" name="bulk_file" 
                                            accept=".csv,.xlsx" required>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="#" class="btn btn-outline-primary" id="downloadTemplate">
                                            <i class="fa fa-download"></i> Download Template
                                        </a>
                                        <button type="submit" class="btn-submit" style="width: auto;">
                                            <i class="fa fa-upload"></i> Upload and Process
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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

            <footer class="sticky-footer bg-white">
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
                    </div>
                </div>
            </footer>
        </div>
    </div>


    <?php include 'js.php' ?>
    <script>
    $(document).ready(function() {
        // Handle tax rate section visibility
        $('#enable_taxes').change(function() {
            $('#taxRateSection').toggle(this.checked);
        });

        // Update file input label with selected filename
        $('input[type="file"]').on('change', function() {
            const fileName = this.files[0]?.name || 'Choose file';
            $(this).next('.custom-file-label').text(fileName);
        });

        // Tax rate validation
        const $taxRate = $('#taxRate');
        const $taxRateError = $('#taxRateError');
        const $submitButton = $('#submitNewForm');

        function showError(message) {
            $taxRateError.text(message).show();
            $submitButton.prop('disabled', true);
        }

        function clearError() {
            $taxRateError.text('').hide();
            $submitButton.prop('disabled', false);
        }

        $taxRate.on('input', function() {
            let value = parseFloat($(this).val());

            if (isNaN(value)) {
                showError('Please enter a valid number');
                $(this).val('');
            } else if (value < 0) {
                showError('Tax rate cannot be negative');
                $(this).val('0');
            } else if (value > 100) {
                showError('Tax rate cannot exceed 100%');
                $(this).val('100');
            } else {
                clearError();
            }
        });

        // Form submission for manual entry
        $('#manualEntryForm').on('submit', function(e) {
            e.preventDefault();
            
            const requiredFields = [
                { id: 'autouser2', label: 'Item Description' },
                { id: 'rate', label: 'Selling Price' }
            ];

            let missingFields = [];

            // Validate required fields
            requiredFields.forEach(field => {
                const value = $('#' + field.id).val().trim();
                if (value === '') {
                    missingFields.push(field.label);
                }
            });

            if (missingFields.length > 0) {
                alert("Please fill in the following required fields:\n" + missingFields.join("\n"));
                return;
            }

            let enableTaxes = $("#enable_taxes").is(":checked") ? 1 : 0;
            let formData = $(this).serialize() + "&enable_taxes=" + enableTaxes;

            $.ajax({
                type: "POST",
                url: "/saveitem",
                data: formData,
                dataType: "json",
                encode: true,
                beforeSend: function () {
                    $("#previewmodal .modal-body").html(`
                        <img src='/assets/img/ajax-loader_2.gif' style='margin-top:1%;margin-left:50%' />
                        <br>
                        <div style='margin-top:6%;margin-left:30%'><h1>Saving item, please wait...</h1></div>
                    `);
                    $("#previewmodal").modal("show");
                    $submitButton.prop('disabled', true); // Prevent multiple submissions
                },
                success: function(response) {
                    console.log(response);
                    window.location = '/ItemList';
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("An error occurred while saving the item. Please try again.");
                    $("#previewmodal").modal("hide");
                    $submitButton.prop('disabled', false);
                }
            });
        });

        // Bulk Upload Form Handling
        $('#bulkUploadForm').on('submit', function(e) {
            e.preventDefault();

            let fileInput = $('input[name="bulk_file"]')[0].files[0];
            if (!fileInput) {
                alert("Please select a file to upload.");
                return;
            }

            let formData = new FormData();
            formData.append("bulk_file", fileInput);

            $.ajax({
                type: "POST",
                url: "/upload-items",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    // $("#previewmodal .modal-body").html(`
                    //     <img src='/assets/img/ajax-loader_2.gif' style='margin-top:1%;margin-left:50%' />
                    //     <br>
                    //     <div style='margin-top:6%; text-align: center;'><h1>Uploading file, please wait...</h1></div>
                    // `);
                    // $("#previewmodal").modal("show");
                },
                success: function(response) {
                    console.log(response);
                    // alert("File uploaded successfully.");
                    // window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // alert("An error occurred while uploading the file. Please try again.");
                    $("#previewmodal").modal("hide");
                }
            });
        });

        $('#downloadTemplate').on('click', function(e) {
            e.preventDefault();
            
            // Show loading state
            const $button = $(this);
            const originalText = $button.html();
            $button.html('<i class="fa fa-spinner fa-spin"></i> Generating...').prop('disabled', true);
            
            // Create a hidden iframe for download
            const iframe = $('<iframe/>', {
                style: 'display:none'
            }).appendTo('body');
            
            // Start download
            iframe.attr('src', '/download-template');
            
            // Reset button state after a short delay
            setTimeout(function() {
                $button.html(originalText).prop('disabled', false);
                // Remove the iframe after download starts
                setTimeout(function() {
                    iframe.remove();
                }, 2000);
            }, 5000);
        });
    });
</script>
</body>
</html>
