<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - ClientEstimate (<?= $client->ClientName  ?>)</title>
    <?php include 'css.php' ?>
    <style>
    </style>
    
</head>
<body id="page-top">
    <div id="wrapper"> <!-- Page Wrapper -->
        <?php include 'sidebarquotes.php' ?>
        <div id="content-wrapper" class="d-flex flex-column"> <!-- Content Wrapper -->
            <div id="content"><!-- Main Content -->
                <?php include 'topbar.php' ?>
                <div class="container-fluid">  <!-- Begin Page Content -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="p-3 h3 mb-0 text-gray-800"><?= $client->ClientName  ?></h1>
                        <div class="col-lg-">
                            <a href="quoteList" class="form-control btn shadow-none" 
                                style="background:#071a26;color:white;text-align:center; width: fit-content; white-space: nowrap;">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Estimate List
                            </a>
                        </div>
                    </div>
                    <div class="col-12 mt-3 mb-3">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" style="color: black;">Edit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btnpreview" style="color: black;">Preview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="btnprint" style="color: black;">Print</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <a href="/CreateQuotation" class="" style="text-decoration: none;">
                            <span class="fa fa-arrow-left fa-fw mr-2"></span>
                            Create Estimate
                        </a>

                        <a href="/convert-to-invoice" 
                            class="btn btn-primary btnConvert p-1 mr-2 <?= $estimates->status === 'Archive' ? 'archived' : '' ?>"  
                            data-id="<?= $estimates->id ?>" id="btnConvert" 
                            style="text-decoration: none; float: right; font-size: 0.8rem; <?= $estimates->status === 'Archive' ? 'opacity: 0.65;' : '' ?>">
                                <span class="fa fa-file-invoice-dollar fa-fw"></span>
                                Convert To Invoice
                        </a>
                            
                        <a href="#" class="btn btn-dark p-1 mr-2" id="btnsave" style="text-decoration: none; float: right; font-size: 0.8rem;">
                            <span class="fa fa-save fa-fw "></span>
                            Update and Close
                        </a>
                        <a href="#" class="btn btn-dark p-1 mr-2" id="btnSend" style="text-decoration: none; float: right; font-size: 0.8rem;">
                            <span ><i class="fa-solid fa-envelope"></i></span>
                            Send
                        </a>
                    </div>
                    <form id="invoiceform">
                        <div class="row container-fluid">
                            <div class="col-lg-8 col-sm-12 col-md-12">
                                <div class="card-header" style="background-color:#b3b3b3;">
                                    Client
                                </div>
                                <div id="summaryclient" style="display: none;">
                                    <input type="text" disabled name="summaryclientname" id="summaryclientname" class="form-control" style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                    <input type="text" disabled name="summaryclientemail" id="summaryclientemail" class="form-control" style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                    <a href="#" onclick="clearFieldssummary('summaryclient')" class="text-danger" style="text-decoration: none; float: left;">
                                        <span class="fa fa-trash-o fa-fw mr-2"></span>
                                        Delete
                                    </a>
                                </div>
                                <?php
                                
                                    $value = $estimates;
                                ?>
                                <div id="clientdiv" style="display: block;">
                                    <div class="form-group row pt-2">
                                        <label for="clientname" class="col-sm-3 col-form-label">Client Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="readonly" name="cname" id="clientname" placeholder="Enter a Client Name ... " style=" border-right: none; border-left: none; border-top: none;" value="<?= $client->ClientName ?>">
                                            <input type="hidden" name="estimate_no" id="estimate_no" value="<?=$value->estimate_no?>" />
                                            <input type="hidden" class="form-control" name="estimateId" id="estimateId" value="<?= $value->id ?>">
                                        </div>  
                                    </div>
                                    <div class="form-group row">
                                        <label for="mobileno" class="col-sm-3 col-form-label">Mobile</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="readonly" name="mobile" id="mobileno" placeholder="Enter a Mobile Number ..." style=" border-right: none; border-left: none; border-top: none;" value="<?= $client->MobileNumber ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="emailadd" class="col-sm-3 col-form-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" readonly="readonly" name="email" id="emailadd" placeholder="Enter an Email Address ..." style=" border-right: none; border-left: none; border-top: none;" value="<?= $client->EmailAddress ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="billto" class="col-sm-3 col-form-label">Bill to</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="readonly" name="bill_to" id="billto" placeholder="Enter an Address ..." style=" border-right: none; border-left: none; border-top: none;" value="<?= $client->address ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-header mt-3" style="background-color:#b3b3b3;">
                                    Items
                                </div>
                                <div class="card-body">
                                    <div id="summaryitem" style="display: none;">
                                        <div id="itemsmulsummary">
                                            <input type="text" disabled name="summaryitemname" id="summaryitemname" class="form-control" style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                            <input type="text" disabled name="summaryitemdescription" id="summaryitemdescription" class="form-control" style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">


                                            <div class="form-group row container">
                                                <input type="text" disabled name="summaryquantity" id="summaryquantity" class="form-control  col-sm-6" style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                                <div class="col-sm-6">
                                                    <input type="text" disabled name="summarytotalprice" id="summarytotalprice" class="form-control" style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (empty($itemlist)) { ?>
                                    <div class="itemsdiv" style="display: block;">
                                        <div id="itemsmul">
                                            <div class="form-group row">
                                                <textarea class="form-control mt-2" required cols="20" rows="5" 
                                                name="itemdescription[]" id="itemdescription" 
                                                placeholder="Item Description " 
                                                style=" border-right: none; border-left: none; border-top: none;"></textarea>
                                            </div>
                                            <div class="form-group row">
                                                <input type="number" class="form-control col-sm-3" 
                                                    oninput="quantitychange(this.value,this.id)"
                                                    name="quantity[]" id="quantity0" placeholder="" 
                                                    style=" border-right: none; border-left: none; border-top: none;">
                                                <span class="p-2">x</span>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" 
                                                    oninput="pricechange(this.value,this.id)" 
                                                    name="price[]" id="price0" placeholder="Rate" 
                                                    style=" border-right: none; border-left: none; border-top: none;">
                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control totalprice" 
                                                    name="totalprice[]" readonly="readonly" id="totalprice0" placeholder="Total" 
                                                    style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } else {
                                        $i = 0;
                                        foreach ($itemlist as $value2) {
                                            // var_dump($value2);
                                    ?>
                                     <div class="itemsdiv" style="display: block;">
                                        <div id=row<?= $i ?>>
                                            <div id="itemsmul">
                                                <div class="form-group row">
                                                    <textarea class="form-control mt-2" required cols="15" rows="4" 
                                                        name="itemdescription[]" id="itemdescription" 
                                                        placeholder="Item Description " 
                                                        style=" border-right: none; border-left: none; border-top: none;"><?= isset($value2->itemname) ? $value2->itemname : '' ?> </textarea>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="quantity_under_items l col-sm-2 " style="width:24%; padding:0">
                                                        <label for="quantity">Quantity</label>
                                                        <input type="number" class="form-control col-sm-12" 
                                                        oninput="quantitychange(this.value,this.id)"
                                                        name="quantity[]" id="quantity<?= $i ?>" 
                                                        placeholder="" style=" border-right: none; border-left: none; border-top: none;" 
                                                        value="<?= isset($value2->quantity) ? $value2->quantity : '' ?>">
                                                    </div>
                                                    <div class="multiplication d-flex flex-column col-sm-1" style="padding: 0;">
                                                        <span class="p-2"style="display: flex; height: 100%; justify-content: center; align-items: end;">x</span>
                                                    </div>
                                                    <div class="col-sm-3" style="padding: 0;">
                                                        <label for="rate">Rate</label>
                                                        <input type="text" class="form-control" 
                                                        oninput="pricechange(this.value,this.id)" 
                                                        name="price[]" id="price<?= $i ?>" 
                                                        placeholder="Rate" style=" border-right: none; border-left: none; border-top: none;" 
                                                        value="<?= isset($value2->price) ? $value2->price : '' ?>">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="totalprice">Total Price</label>
                                                        <input type="text" class="form-control totalprice" 
                                                        name="totalprice[]" readonly="readonly" id="totalprice<?= $i ?>" 
                                                        placeholder="Total" style=" border-right: none; border-left: none; border-top: none;  background-color: #eaecf4;"
                                                        value="<?= isset($value2->totalprice) ? $value2->totalprice : '' ?>">
                                                    </div>
                                                    <div class="col-sm-3" style = "padding:0;">
                                                        <label for="costPrice">Cost Price</label>
                                                        <input type="text" class="form-control costprice" 
                                                        name="costprice[]"  id="costprice<?= $i ?>" oninput="updateNetPrice(this.value, this.id)"
                                                        placeholder="Cost price" style=" border-right: none; border-left: none; border-top: none;  background-color: white;"
                                                        value="<?= isset($value2->costprice) ? $value2->costprice : '' ?>">
                                                    </div>
                                                </div>

                                                <button type="button" name="remove" id="<?= $i ?>" iditem="<?= isset($value2->item_id) ? $value2->item_id : '' ?>" class="btn btn-danger btn_remove">
                                                    X </button>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++;
                                        }
                                    } ?>
                                <div id="itemsdivadd"></div>
                                
                                <div class="mt-3 ">
                                    <a href="#" class="d-flex flex-row " id="add" style="text-decoration: none;">
                                        <p class="card-text mr-3">
                                            <span class="fa fa-plus-circle fa-fw mr-2"></span>
                                            Add Items.
                                        </p>
                                    </a>
                                </div>
                            </div>
                            <div class="card-header mt-3" style="background-color:#b3b3b3;">
                                Comments
                            </div>
                            <div class="card-body">
                                <a href="#" class="" onclick="showcomment()" style="text-decoration: none;">
                                    <p class="card-text">
                                        <span class="fa fa-pencil fa-fw mr-2"></span>
                                        Add Comment.
                                    </p>
                                </a>
                                <div id="commentdiv" style="display: block;">
                                    <div class="form-group row">
                                        <textarea class="form-control mt-3" name="comment" id="comment" cols="40" rows="4"
                                            style=" "><?= ($value->comment ? $value->comment : "") ?></textarea>

                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-lg-4 col-sm-12 col-md-12">
                                <h3>
                                    Estimate
                                    <span class="btn btn-sm btn-warning">
                                        <?= $value->status ?> 
                                    </span>
                                </h3>
                                <div class="form-group row">
                                    <label for="invoicedate" class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="invoicedate" id="invoicedate" placeholder="Date" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->invoice_date ?>">
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label for="terms" class="col-sm-3 col-form-label">Terms</label>
                                    <div class="col-sm-9">
                                        <select name="terms" class="form-control" style=" border-right: none; border-left: none; border-top: none;">
                                            <option selected value="<?= $value->terms ?>"><?= $value->terms ?></option>
                                            <option value="same day">Same Day</option>
                                            <option value="7 days">7 Days</option>
                                            <option value="14 days">14 Days</option>
                                            <option value="21 days">21 Days</option>
                                            <option value="30 days">30 Days</option>
                                            <option value="45 days">45 Days</option>
                                            <option value="60 days">60 Days</option>
                                            <option value="90 days">90 Days</option>
                                        </select>
                                    </div>
                                </div> -->
                                <!-- <div class="form-group row">
                                    <label for="date" class="col-sm-3 col-form-label">Due Date</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="duedate" id="duedate" placeholder="Date" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->due_date?>">
                                    </div>
                                </div> -->
                                <hr>
                                <div class="form-group row">
                                    <label for="subtotal" class="col-sm-3 col-form-label">Subtotal</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" name="subtotal" id="subtotal" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->subtotal?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="discount" class="col-sm-3 col-form-label">Discount</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="discount" id="discount" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->discount?>">
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group row">
                                    <label for="total" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" name="total" id="total" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->total?>">
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label for="paid" class="col-sm-3 col-form-label">Paid</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="readonly" class="form-control" name="paid" id="paid" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->paid?>">
                                    </div>
                                </div> -->
                                <!-- <div class="form-group row">
                                    <label for="balance" class="col-sm-3 col-form-label">Balance</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" name="balance" id="balance" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->balance?>">
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <label for="balance" class="col-sm-3 col-form-label">Cost Price</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" name="netprice" id="netprice" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->netprice?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="balance" class="col-sm-3 col-form-label">Profit/loss</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" name="profitDisplay" id="profitDisplay" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->profit_loss?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
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
        function closemodal() {
            $('#previewmodal').modal('hide');
        }
        
        $(document).ready(function() {
            // PREVIEW FUNCTIONALLITY
            $(document).on("click", "#btnpreview", function(e) {
                var image = "/assets/img/ajax-loader_2.gif";
                e.preventDefault();
                e.stopImmediatePropagation();

                var Total = $("#total").val().includes('£') ? $("#total").val().split('£')[1] : $("#total").val();
                console.log('total', Total);
                $("#total").val(Total);

                var estimatePreviewURL = '/estimate-preview';
                var previewFormData = $('#invoiceform').serialize();  
                const itemsTotal = decodeURI(previewFormData).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                const dataToSend = `${previewFormData}&totalitems=${itemsTotal}`;
                // console.log(dataToSend);
                // return
                $.ajax({
                    type: 'GET',
                    url: estimatePreviewURL,
                    data: dataToSend,
                    cache: false, 
                    beforeSend: function() {
                        $(".modal-body").html("<img src='" + image +
                            "' style='margin-top:1%;;margin-left:50%' />");
                        $("#previewmodal").modal("show");
                    },
                    success: function(data) {
                        // console.log(data.message);
                        $(".modal-body").html();
                        $(".modal-body").html(data);
                        $("#previewmodal").modal("show");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error: ' + textStatus + ': ' + errorThrown);
                    }
                })
            });
            // PRINT ESTIMATE USING SECURE $ BEST PRACTICE
            $(document).on("click", "#btnprint", function(e) {            
                e.preventDefault();
                e.stopImmediatePropagation();

                var Total = $("#total").val().includes('£') ? $("#total").val().split('£')[1] : $("#total").val();
                console.log('total', Total);
                $("#total").val(Total);
                
                $("#btnsave").prop("disabled", true);
            
                var formdatasendget = $('#invoiceform').serialize();
                var itemsTotal = decodeURI(formdatasendget).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                formdatasendget += `&totalitems=${itemsTotal}`;
            
                const estimateId = $('#invoiceform').find('input[name="estimateId"]').val();
            
                // Create FormData object
                const formData = new FormData($('#invoiceform')[0]);
                formData.append('totalitems', itemsTotal);
                
                // Add any additional fields you want to update
                formData.append('status', 'Printed');
                formData.append('print_date', new Date().toISOString().split('T')[0]);
                console.log(formData);
            
                fetch(`/preview-printestimate/${estimateId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Controller Response:', data.message); // This will print the response to the browser's console
                    if (data.success) {
                        window.open(`/print-estimate/${estimateId}`, '_blank');
                    } else {
                        alert("Error: " + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("An error occurred while processing your request.");
                })
                .finally(() => {
                    $("#btnsave").prop("disabled", false);
                });
            });
             // SEND ESTIMATE AT PREVIEW
            $(document).on("click", "#btnSend", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                // Cache jQuery selectors to avoid repeated DOM lookups
                const image = "/assets/img/ajax-loader_2.gif";
                const $balance = $("#balance");
                const $total = $("#total");
                const $btnSave = $("#btnsave");
                const dataUrlSend = '/send-estimate-at-preview'
                
                // Function to remove currency symbol (e.g., "£")
                const removeCurrencySymbol = value => value.includes("£") ? value.split("£")[1] : value;
                
                // Process balance and total values
                // $balance.val(removeCurrencySymbol($balance.val()));
                $total.val(removeCurrencySymbol($total.val()));

                // Disable save button
                $btnSave.prop("disabled", true);

                // Serialize form data
                const formData = $('#invoiceform').serialize();
                
                // Calculate the number of items
                const itemsTotal = (decodeURI(formData).match(/quantity\[\]/g) || []).length;
                
                // Append total items to the form data
                const finalData = `${formData}&totalitems=${itemsTotal}`;
                
                // console.log(finalData);
                // return
                $.ajax({
                    type: 'POST',
                    url: dataUrlSend,
                    data: finalData,
                    cache: false,
                    beforeSend: function() {
                        // Validate required fields
                        const requiredFields = [
                            {selector: "#duedate", message: "Due date required!"},
                            {selector: "#autouser", message: "Client Name Required!"},
                            {selector: "#mobile", message: "Mobile Number Required!"},
                            {selector: "#useremail", message: "Email Address Required!"},
                            {selector: "#bill_to", message: "Billing Address Required"}
                        ];

                        let isValid = true;
                        requiredFields.forEach(field => {
                            if ($(field.selector).val() === "") {
                                alert(field.message);
                                isValid = false;
                            }
                        });

                        if (!isValid) {
                            $("#btnsave").prop("disabled", false); // Re-enable save button if validation fails
                            return false;
                        }

                        // Display loading modal
                        $(".modal-body").html("<img src='" + image + "' style='margin-top:1%;margin-left:50%' />"
                                + "<br><div style='margin-top:6%; text-align: center;'>"
                                + "<h1> Sending mail please wait.</h1></div>");
                            $("#previewmodal").modal("show");
                        },
                    success: function(data) {
                        console.log(data.message);
                        $(".modal-body").html(
                            "<div style='margin-top:6%;;margin-left:30%'><i class='fa fa-envelope fa-3x'> </i> <h1> Mail Sent Successfully.</h1></div>"
                        );
                        $("#previewmodal").modal("show");
                        location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error: ' + textStatus + ': ' + errorThrown);
                        $("#btnsave").prop("disabled", false); // Re-enable save button on error
                    }
                });
            });
            // UPDATE ESTIMATE

            //  Redirect to convert estimate to invoice page
            $(document).on("click", ".btnConvert", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var id = $(this).data('id');
                window.location.href = "/convert-to-invoice?id=" + id;
            });
            $(document).on("click", "#btnsave", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var image = "/assets/img/ajax-loader_2.gif";

                // Cache jQuery selectors to avoid repeated DOM lookups
                const $total = $("#total");

                // Function to remove currency symbol (e.g., "£")
                const removeCurrencySymbol = value => value.includes("£") ? value.split("£")[1] : value;
                
                // Process balance and total values
                $total.val(removeCurrencySymbol($total.val()));
            
                // var myform = $("#invoiceform");
                // $("#btnsave").prop("disabled", true);
                var dataURLpay = '/update-estimate';
                var formdatasendget = $('#invoiceform').serialize();
                var itemsTotal = decodeURI(formdatasendget).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                formdatasendget += `&totalitems=${itemsTotal}`;
                console.log(decodeURI(formdatasendget).split('&'));
                // return
                $.ajax({
                type: 'POST',
                url: dataURLpay,
                data: formdatasendget,
                cache: false, // Disable caching
                beforeSend: function() {
                    // Display loading modal
                    $(".modal-body").html("<img src='" + image + "' style='margin-top:1%;margin-left:50%' />"
                        + "<br><div style='margin-top:6%; text-align: center;'>"
                        + "<h1> Updating estimate please wait.</h1></div>");
                    $("#previewmodal").modal("show");
                },
                success: function(response) {
                    console.log(response.message);
                    $("#previewmodal").modal("hide");              
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                        $("#btnsave").prop("disabled", false); // Re-enable save button on error
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ': ' + errorThrown);
                    $("#btnsave").prop("disabled", false); // Re-enable save button on error
                }
            });
            });

            // add item row disaply
            var i = $('.itemsdiv').length; // Get the initial count of existing rows
        
            // Remove any existing click handlers
            $(document).off('click', '#add');
            
            // Add a new click handler
            $(document).on('click', '#add', function(e) {
                e.preventDefault(); 
                e.stopPropagation(); 
                            
                i++;
                var newRow = $('<div id="row' + i + '">' +
                    '<div id="itemsmul">' +
                        '<div class="form-group row">' +
                            '<textarea class="form-control mt-2" required cols="15" rows="4" ' +
                                'name="itemdescription[]" id="itemdescription' + i + '" ' +
                                'placeholder="Item Description" ' +
                                'style="border-right: none; border-left: none; border-top: none;"></textarea>' +
                        '</div>' +
                        '<div class="form-group row">' +
                            '<div class="quantity_under_items l col-sm-2" style="width:24%; padding:0">' +
                                '<label for="quantity">Quantity</label>' +
                                '<input type="number" class="form-control col-sm-12" ' +
                                'oninput="quantitychange(this.value,this.id)" ' +
                                'name="quantity[]" id="quantity' + i + '" ' +
                                'placeholder="" style="border-right: none; border-left: none; border-top: none;" ' +
                                'value="1">' +
                            '</div>' +
                            '<div class="multiplication d-flex flex-column col-sm-1" style="padding: 0;">' +
                                '<span class="p-2" style="display: flex; height: 100%; justify-content: center; align-items: end;">x</span>' +
                            '</div>' +
                            '<div class="col-sm-3" style="padding: 0;">' +
                                '<label for="rate">Rate</label>' +
                                '<input type="text" class="form-control" ' +
                                'oninput="pricechange(this.value,this.id)" ' +
                                'name="price[]" id="price' + i + '" ' +
                                'placeholder="Rate" style="border-right: none; border-left: none; border-top: none;">' +
                            '</div>' +
                            '<div class="col-sm-3">' +
                                '<label for="totalprice">Total Price</label>' +
                                '<input type="text" class="form-control totalprice" ' +
                                'name="totalprice[]" readonly="readonly" id="totalprice' + i + '" ' +
                                'placeholder="Total" style="border-right: none; border-left: none; border-top: none; background-color: #eaecf4;">' +
                            '</div>' +
                            '<div class="col-sm-3" style="padding:0;">' +
                                '<label for="costPrice">Cost Price</label>' +
                                '<input type="text" class="form-control costprice" ' +
                                'name="costprice[]" id="costprice' + i + '" oninput="updateNetPrice(this.value, this.id)" ' +
                                'placeholder="Cost price" style="border-right: none; border-left: none; border-top: none; background-color: white;">' +
                            '</div>' +
                        '</div>' +
                        '<button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">' +
                            'X</button>' +
                        '<br><br>' +
                    '</div>' +
                '</div>');
                
                $('#itemsdivadd').append(newRow);
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                // get the row values
                var totalprice = $('#totalprice' + button_id).val();
                var costprice = $('#costprice' + button_id).val();
                // Get the values to be updated
                var subtotal = $('#subtotal').val();
                var discount = $('#discount').val() || 0;
                var totalCostprice = $('#netprice').val();
                var profitLoss = $('profitDisplay').val();
                // calculation
                var newSubtotal = subtotal - totalprice;
                var newTotal = newSubtotal - discount;
                var newcostprice = totalCostprice - costprice;
                var newProfitLoss = newSubtotal - newcostprice;

                // Update values before closing removind items
                $('#subtotal').val(newSubtotal);
                $('#total').val(newTotal);
                // $('#discount').val(discount);
                $('#netprice').val(newcostprice);
                $('#profitDisplay').val(newProfitLoss);
                $('#row' + button_id).remove();
            });

            // discoumt calculation
            $("#discount").on("input", function() {
                var discount = $("#discount").val();
                var paid = $("#paid").val();
                var costpricetotal = $("#netprice").val();
                
                let newsubtotal = $("#subtotal").val();
                
                var newtotal = newsubtotal - discount;
                var newbalance = (newsubtotal - paid) - discount;
                var newProfitLoss = newtotal - costpricetotal;
                console.log('paid',paid);

                // console.log(newbalance);
                $("#total").val(((newsubtotal) - discount).toFixed(2));
                $("#balance").val(((newsubtotal - paid) - discount).toFixed(2));
                $("#profitDisplay").val(newProfitLoss.toFixed(2));
            });
        });

        // function quantitychange(value, id) {
        //     var i = id.replace('quantity', '');

        //     var subtotal = 0;
        //     var valueprice = 0;
        //     var valuesplit = '';
        //     var rate = $("#price" + i).val();
        //     var quantity = $("#quantity" + i).val();
        //     var totalprice = value * rate;
        //     var costprice = parseInt($('#costprice'+i).val());
        //     var totalcostprice = 0;
        //     var total = parseInt($('#total').val().split('£')[1]);
        //     var netprice = parseInt($('#netprice').val());
        //     var discount = $("#discount").val();
        //     var paid = $("#paid").val();

        //     // subtotal = subtotal + parseInt(totalprice);
        //     $("#totalprice" + i).val(value * rate);

        //     var x = document.getElementsByClassName('totalprice');

        //     for (let r = 0; r < x.length; r++) {
        //         totalcostprice = totalcostprice + costprice;
        //         valueprice = x[r].value;
        //         let pricehere = parseInt(0);
        //         if (valueprice == 0) {
        //             pricehere = parseInt(valueprice);
        //         } else {
        //             valuesplit = valueprice.split('£');
        //             pricehere = parseInt(valuesplit[1]);

        //             if (valuesplit.length == 1) {
        //                 pricehere = parseInt(valueprice);

        //             }
        //         }
        //         subtotal += pricehere;
        //     }
        //     $("#subtotal").val(subtotal);
        //     $("#total").val('£' + ((subtotal) - discount));
        //     // $("#balance").val('£' + ((subtotal - paid) - discount));
            
        //     var subtotal = parseFloat($("#subtotal").val()) || 0;
        //     var costPrice = parseFloat($("#netprice").val()) || 0;

        //     var total = subtotal - discount;
        //     // var balance = total - paid;
        //     var profitLoss = total - costPrice; 

        //     $("#subtotal").val(subtotal);
        //     $("#total").val('£' + ((subtotal) - discount));
        //     // $("#balance").val('£' + ((subtotal - paid) - discount));
        //     $('#profitDisplay').val(total - netprice); //new
        // }

         // ====================================== new qunatity function 
        // First, declare a variable outside the function to store the original cost prices
        var originalCostPrices = {};

        function quantitychange(value, id) {
            // Extract the row number from the id
            var i = id.replace('quantity', '');
            
            var subtotal = 0;
            var valueprice = 0;
            var valuesplit = '';
            
            // Use the correct row-specific IDs
            var rate = parseFloat($("#price" + i).val()) || 0;
            var quantity = parseFloat($("#quantity" + i).val()) || 0;
            var totalprice = value * rate;
            var costprice = parseFloat($('#costprice' + i).val()) || 0;
            var totalcostprice = 0;
            var total = parseFloat($('#total').val().replace('£', '')) || 0;
            var netprice = parseFloat($('#netprice').val()) || 0;
            var discount = parseFloat($("#discount").val()) || 0;
            var paid = parseFloat($("#paid").val()) || 0;

            // Store the original cost price for this specific row if it hasn't been stored yet
            if (!originalCostPrices[i]) {
                originalCostPrices[i] = costprice;
            }
            
            // Use the original stored cost price for this specific row
            costprice = originalCostPrices[i];
            
            // Set the total price for this specific row
            $("#totalprice" + i).val((value * rate).toFixed(2));

            // Calculate the total of all rows
            var x = document.getElementsByClassName('totalprice');
            subtotal = 0;  // Reset subtotal before calculation

            for (let r = 0; r < x.length; r++) {
                valueprice = x[r].value;
                let pricehere = 0;
                
                if (valueprice === '' || valueprice === '0') {
                    pricehere = 0;
                } else {
                    // Handle cases where the value might or might not have a £ symbol
                    valuesplit = valueprice.toString().split('£');
                    pricehere = parseFloat(valuesplit[valuesplit.length > 1 ? 1 : 0]) || 0;
                }
                subtotal += pricehere;
            }

            // Calculate new cost price for this specific row
            var newcostprice = quantity * costprice;
            
            // Update all the totals
            $("#subtotal").val(subtotal.toFixed(2));
            $("#total").val((subtotal - discount).toFixed(2));
            $("#balance").val((subtotal - paid - discount).toFixed(2));
            $("#costprice" + i).val(newcostprice.toFixed(2));
            
            // Calculate total cost price across all rows
            var totalCostPrice = 0;
            $('.costprice').each(function() {
                totalCostPrice += parseFloat($(this).val()) || 0;
            });
            
            $("#netprice").val(totalCostPrice.toFixed(2));
            $('#profitDisplay').val(((subtotal - discount) - totalCostPrice).toFixed(2));
        }
        // ======================================


        function pricechange(value, id) {
            var i = id.split('price');
            i = i[1];

            var x = document.getElementsByClassName('totalprice');

            var subtotal = 0;
            var valueprice = 0;
            var valuesplit = '';
            var rate = $("#price" + i).val();
            var quantity = $("#quantity" + i).val();
            var totalprice = quantity * value;
            var costprice = $('#costprice' + i).val();
            var discount = $("#discount").val();
            var paid = $("#paid").val();
        
            $("#totalprice" + i).val(quantity * value);
            // console.log(x.length);
            for (let r = 0; r < x.length; r++) {
                valueprice = x[r].value;
                // console.log(valueprice);
                // valuesplit = Number(valueprice);
                // if (valueprice.includes('£') == 'true') {
                let pricehere = parseInt(0);
                if (valueprice == 0) {
                    pricehere = parseInt(valueprice);
                } else {
                    valuesplit = valueprice.split('£');
                    pricehere = parseInt(valuesplit[1]);
                    // console.log("Value price", valueprice)
                    // console.log("split price", parseInt(valuesplit[1]));
                    // }

                    if (valuesplit.length == 1) {
                        pricehere = parseInt(valueprice);

                    }
                }

                subtotal += pricehere;
                console.log('costprice', costprice);


            }

            $("#subtotal").val(subtotal);
            $("#total").val('£' + ((subtotal) - discount));
            // $("#balance").val('£' + ((subtotal - paid) - discount));

            var subtotal = parseFloat($("#subtotal").val()) || 0;
            var costPrice = parseFloat($("#netprice").val()) || 0;

            var total = subtotal - discount;
            // var balance = total - paid;
            var profitLoss = total - costPrice;

            $("#total").val('£' + total.toFixed(2));
            // $("#balance").val('£' + balance.toFixed(2));
            $("#profitDisplay").val( profitLoss.toFixed(2));

        }
        
         function updateNetPrice(value, id) {
            // Properly extract the row number from the id
            var i = id.replace('costprice', '');
            
            // Get all cost price elements
            var x = document.getElementsByClassName('costprice');
            var totalcostprice = 0;
            
            // Get the quantity for this specific row
            var quantity = parseFloat($("#quantity" + i).val()) || 1;
            
            // Calculate total cost price across all rows
            for (let r = 0; r < x.length; r++) {
                var rowValue = x[r].value;
                var rowQuantity = parseFloat($("#quantity" + r).val()) || 1;
                
                // Convert the value to a number, handling empty or invalid inputs
                let pricehere = 0;
                if (rowValue && rowValue !== '0') {
                    // Remove currency symbol if present
                    if (rowValue.includes('£')) {
                        rowValue = rowValue.replace('£', '');
                    }
                    pricehere = parseFloat(rowValue) || 0;
                }
                
                // Multiply by quantity for this row
                totalcostprice += pricehere * rowQuantity;
            }
            
            // Update net price with total cost price
            $('#netprice').val(totalcostprice.toFixed(2));
            
            // Get the current total (removing currency symbol if present)
            var total = parseFloat($("#total").val().replace('£', '')) || 0;
            
            // Calculate profit/loss
            var profitLoss = total - totalcostprice;
            
            // Update profit display
            $("#profitDisplay").val(profitLoss.toFixed(2));
            
            // Update the original cost prices object if it exists
            if (typeof originalCostPrices !== 'undefined') {
                originalCostPrices[i] = parseFloat(value) || 0;
            }
        }
        // ============================================

    </script>
</body>
</html>