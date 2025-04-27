<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - ClientInvoice (<?= $client[0]->ClientName  ?>)</title>
    <?php include 'css.php' ?>
    <style>
    </style>
    
</head>

<body id="page-top">
    <div id="wrapper"> <!-- Page Wrapper -->
        <?php include 'sidebarinvoices.php' ?>
        <div id="content-wrapper" class="d-flex flex-column"> <!-- Content Wrapper -->
            <div id="content"><!-- Main Content -->
                <?php include 'topbar.php' ?>
                <div class="container-fluid">  <!-- Begin Page Content -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="p-3 h3 mb-0 text-gray-800"><?= $client[0]->ClientName  ?></h1>
                        <div class="col-lg-">
                            <a href="InvoiceList" class="form-control btn shadow-none" 
                                style="background:#071a26;color:white;text-align:center; width: fit-content; white-space: nowrap;">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                Invoice List
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

                    <div class="pb-3" >
                        <a href="/NewInvoice" class="" style="text-decoration: none; color: #2360bb;">
                            <span class="fa fa-arrow-left fa-fw mr-2"></span>
                            Create Invoice</a>
                        <a href="#" invoiceid="<?php echo $invoiceId ?>" class="transactionhistory btn btn-secondary p-1 mr-2" style="text-decoration: none; float: right; font-size: 0.8rem;">
                            <i style="vertical-align: middle;color:white font-size: 0.5rem;" class="material-icons icon">payment</i>
                            Transaction History</a>
                        <a href="#" class="btn p-1 mr-2" id="btnsave" style="text-decoration: none; float: right; background: #2360bb; color: white; font-size: 0.8rem;">
                            <i style="vertical-align: middle;color:white font-size: 0.5rem;" class="material-icons icon">save</i>
                            Update and Close</a>
                        <a href="#" class="btn p-1 mr-2" id="btnsend" style="text-decoration: none; float: right; background: #2360bb; color: white; font-size: 0.8rem;">
                            <i style="vertical-align: middle;color:white font-size: 0.5rem;" class="material-icons icon">email</i>
                            Send</a>
                        <a href="#" class="btn p-1 mr-2" id="btnpayment" style="text-decoration: none; float: right; background: #1cc88a; color: white; font-size: 0.8rem;" data-id="<?= $invoiceId ?>">
                            <i style="vertical-align: middle;color:white font-size: 0.5rem;" class="material-icons icon">payment</i>
                            Make Payment</a>
                    </div>
                    <form id="invoiceform">
                        <div class="row container-fluid">
                            <div class="col-lg-8 col-sm-12 col-md-12">
                                <div class="card-header" style="background-color:#b3b3b3;">
                                    Client 
                                </div>
                                <div class="card-body">

                                    <!-- <a href="#" id="addclient" onclick="showclient()" style="text-decoration: none; display:block">
                                        <p class="card-text">
                                            <span class="fa fa-user fa-fw mr-2"></span>
                                            Add a Client.

                                        </p>
                                    </a> -->
                                    <div id="summaryclient" style="display: none;">
                                        <input type="text" disabled name="summaryclientname" id="summaryclientname" class="form-control" style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                        <input type="text" disabled name="summaryclientemail" id="summaryclientemail" class="form-control" style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                        <a href="#" onclick="clearFieldssummary('summaryclient')" class="text-danger" style="text-decoration: none; float: left;">
                                            <span class="fa fa-trash-o fa-fw mr-2"></span>
                                            Delete
                                        </a>
                                    </div>
                                    <?php
                                    // Since $invoice seems to be an object, we can access its properties directly
                                    // Assuming $invoice holds only one invoice object
                                    $value = $invoice;
                                    ?>

                                    <div id="clientdiv" style="display: block;">
                                        <div class="form-group row">
                                            <label for="clientname" class="col-sm-3 col-form-label">Client Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="cname" id="clientname" placeholder="Enter a Client Name ..." style="border-right: none; border-left: none; border-top: none;" value="<?= $invoice->client_name  ?>">
                                                <input type="hidden" name="invoice_no" id="invoice_no" value="<?=$invoice->invoice_no?>" />
                                                <input type="hidden" name="items_total" id="items_total" value="<?=$invoice->items_total?>" />
                                                <input type="hidden" class="form-control" name="invoiceid" id="invoiceid" value="<?= $value->id ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="mobileno" class="col-sm-3 col-form-label">Mobile</label>
                                            <div class="col-sm-9">
                                                <!-- Assuming there's a 'mobile' property in the $value object -->
                                                <input type="text" class="form-control" name="mobile" id="mobileno" placeholder="Enter a Mobile Number ..." style="border-right: none; border-left: none; border-top: none;" value="<?= $client[0]->MobileNumber ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="emailadd" class="col-sm-3 col-form-label">Email</label>
                                            <div class="col-sm-9">
                                                <!-- Assuming there's an 'email_address' property in the $value object -->
                                                <input type="email" class="form-control" name="email" id="emailadd" placeholder="Enter an Email Address ..." style="border-right: none; border-left: none; border-top: none;" value="<?= $client[0]->EmailAddress ?>">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="billto" class="col-sm-3 col-form-label">Bill to</label>
                                            <div class="col-sm-9">
                                                <!-- Assuming there's a 'bill_to' property in the $value object -->
                                                <input type="text" class="form-control" name="bill_to" id="billto" placeholder="Enter an Address ..." style="border-right: none; border-left: none; border-top: none;" value="<?= $client[0]->address ?>">
                                            </div>
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

                                    <?php 
                                        if (empty($itemlist)) { ?>
                                        <div class="itemsdiv" style="display: block;">
                                            <div id="itemsmul">
                                                <!-- <div class="form-group row">
                                                    <input type="text" class="form-control mt-3" name="itemname[]" id="itemname" placeholder="Reference Number" style=" border-right: none; border-left: none; border-top: none;">
                                                </div> -->
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
                                                    <div class="saveNewItem" style="float: right; display: ;">
                                                    <button type="button" class="cancelSaveButton" id="cancelSaveButton"
                                                        style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px; ">Cancel
                                                    </button>
                                                    <button type="button" class="saveNewItemAtInvoiceCreation" id="saveNewItemAtInvoiceCreation" 
                                                        style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px; ">Save New Item
                                                    </button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php } else {
                                            $i = 0;
                                            foreach ($itemlist as $value2) {
                                        ?>
                                        <div class="itemsdiv" style="display: block;">
                                            <div id=row<?= $i ?>>
                                                <div id="itemsmul">

                                                    <div class="form-group row">
                                                        <textarea class="form-control itemname mt-2" required cols="15" rows="4" 
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
                                                    <div class="saveNewItem" style="float: right; display: none;">
                                                        <button type="button" class="cancelSaveButton" id="cancelSaveButton"
                                                            style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px; ">Cancel
                                                        </button>
                                                        <button type="button" class="saveNewItemAtInvoiceCreation" id="saveNewItemAtInvoiceCreation" 
                                                            style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px; ">Save New Item
                                                        </button>
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


                                    <div class="mt-3">
                                        <a href="#" class="" id="add" style="text-decoration: none;">
                                            <p class="card-text">
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
                                            <textarea class="form-control mt-3" 
                                                name="comment" id="comment" cols="40" rows="4"
                                                placeholder="Enter a payment instructions for your customer if you have any." 
                                                style=""><?= ($value->comment ? $value->comment : "") ?></textarea>
                                        </div>
                                    </div>


                                    <a href="#" class="" onclick="showpayment()" style="text-decoration: none;">
                                        <p class="card-text">
                                            <span class="fa fa-credit-card fa-fw mr-2"></span>
                                            Add Payment Instructions. 
                                        </p>
                                    </a>
                                    <div id="paymentdiv" style="display: block;">
                                        <div class="form-group row">
                                            <textarea class="form-control mt-3" name="payment" id="payment" cols="40" rows="4" 
                                                placeholder="Enter a payment instructions for your customer if you have any." 
                                                style=""><?= ($value->payment_instruction ? $value->payment_instruction : "")  ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12 col-md-12">
                                <h3>
                                    Invoice
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
                                <div class="form-group row">
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
                                </div>
                                <div class="form-group row">
                                    <label for="date" class="col-sm-3 col-form-label">Due Date</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="duedate" id="duedate" placeholder="Date" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->due_date?>">
                                    </div>
                                </div>
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
                                <div class="form-group row">
                                    <label for="paid" class="col-sm-3 col-form-label">Paid</label>
                                    <div class="col-sm-9">
                                        <input type="text" readonly="readonly" class="form-control" name="paid" id="paid" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->paid?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="balance" class="col-sm-3 col-form-label">Balance</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" name="balance" id="balance" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->balance?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="costprice" class="col-sm-3 col-form-label">Cost Price</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" name="netprice" id="netprice" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->netprice?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profitLoss" class="col-sm-3 col-form-label">Profit/loss</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" name="profitDisplay" id="profitDisplay" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->profit_loss?>">
                                    </div>
                                </div>
                                <?php
                                    $selectedItem = $invoice->payment_reminder; // Directly get the value from the invoice object
                                ?>
                                <div class="form-group row">
                                    <label for="exampleDropdown" class="col-sm-3 col-form-label">Payment Reminder</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="paymentReminder">
                                            <option value="on" <?php echo ($selectedItem == 'on') ? 'selected' : ''; ?>>on</option>
                                            <option value="off" <?php echo ($selectedItem == 'off') ? 'selected' : ''; ?>>off</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        // var_dump($value);
                        $invoicedate = ($value->invoice_date);
                        $duedate = ($value->due_date);
                    ?>
                    </form>
                    <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color:black;">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Invoice System</h5>
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
                    <div class="modal fade" id="addpayment" role="dialog">
                        <div class="modal-dialog modal-xs">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header" style="background: #cecccc2b;">
                                    <h6 class="modal-title">Add Payment</h6>
                                </div>
                                <div class="modal-body">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'js.php' ?>
    <script>
        // Growing text area for item descriptions
        // $(document).ready(function() {
        //     const maxRows = 8;
            
        //     $(document).on('input', '.itemname', function() {
        //         // Reset height to calculate correct scrollHeight
        //         $(this).css('height', 'auto');
                
        //         // Get line height (computed at runtime to ensure accuracy)
        //         const lineHeight = parseInt(window.getComputedStyle(this).lineHeight);
                
        //         // Calculate maximum height (8 rows)
        //         const maxHeight = lineHeight * maxRows;
                
        //         // Calculate content height
        //         const scrollHeight = this.scrollHeight;
                
        //         // Set new height - if content is less than 8 rows, it will fit to content
        //         // if more than 8 rows, it will cap at maxHeight
        //         $(this).css('height', Math.min(scrollHeight, maxHeight) + 'px');
        //     });

        //     // Trigger the resize on page load for existing content
        //     $('.itemname').each(function() {
        //         $(this).trigger('input');
        //     });
        // });

            $(document).on("click", ".payment", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var paymentid = $(this).attr("invoiceid");
                // console.log(invoiceid);
                // //get data
                $.ajax({
                    method: "get",
                    cache: false, // Disable caching
                    url: "/addpayment",
                    data: {
                        paymentid: paymentid
                    },

                    success: function(bk) {
                        $(".modal-body").html();
                        // $(".admin_content").html(bk);

                        $(".modal-body").html(bk);
                        $("").modal("show");
                    }
                })
            })
            
            function closemodal() {
                $('#previewmodal').modal('hide');
            }

            function closemodalpay() {
                $('#addpayment').modal('hide');
            }
            
            // Sending data to controller before populating tha data to the preview
           $(document).on("click", "#btnpreview", function(e) {
               var image = "/assets/img/ajax-loader_2.gif";
                e.preventDefault();
                e.stopImmediatePropagation();

                function removeCurrencySymbol(value) {
                    // Remove the pound sign (£) from the beginning of the string
                    return value.replace(/^£/, '');
                }

                // Example usage:
                var total = $('#total').val();
                var balance = $('#balance').val();

                var cleanTotal = removeCurrencySymbol(total);
                var cleanBalance = removeCurrencySymbol(balance);

                // If you need to update the input field with the clean value:
                $('#total').val(cleanTotal);
                $('#balance').val(cleanBalance);

                var dataURLpay = '/preview';
                var formdatapay = $(' #invoiceform').serialize();
                const itemsTotal = decodeURI(formdatapay).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                const dataToSend = `${formdatapay}&totalitems=${itemsTotal}`;
                // return;
                $.ajax({
                    type: 'GET',
                    url: dataURLpay,
                    data: dataToSend,
                    cache: false, 
                    beforeSend: function() {
                        $(".modal-body").html("<img src='" + image + 
                            "' style='margin-top:1%;;margin-left:50%' />");
                        $("#previewmodal").modal("show");
                    },
                    success: function(data) {
                        // console.log(data.message);
                        $(".modal-body").html(data);
                        $("#previewmodal").modal("show");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error: ' + textStatus + ': ' + errorThrown);
                    }
                });
            });

            $(document).on("click", "#btnpayment", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                var invoiceid = $(this).data('id');
                console.log('id', invoiceid);
                // return;
                $.ajax({
                    method: "get",
                    cache: false, 
                    url: "/addpayment",
                    data: {
                        invoiceid: invoiceid
                    },

                    success: function(bk) {
                        // console.log(bk);
                        $("#previewmodal .modal-body").html();
                        $("#previewmodal .modal-body").html(bk);
                        $("#previewmodal").modal("show");
                        var newDate = new Date();
                
                        // $("#addpayment #paymentdate").val("newDate");
                        $("#previewmodal #paymentdate").datepicker({
                            dateFormat: "dd/mm/yy"
                        });
                        $("#previewmodal #paymentdate").datepicker("setDate", new Date());

                        $(document).off("click", "#previewmodal #btnsave2").on("click", "#previewmodal #btnsave2", function(e) {
                   
                            // Your click event handler code here
                            $button = $("#btnsave2");
                            if ($button.data("pressed") !== true) {
                                var image = "/assets/img/ajax-loader_2.gif";
                                //   $("#btnsave2").prop("disabled", true);
                                $(this).prop('disabled', true);
                                e.preventDefault();
                                e.stopImmediatePropagation();

                                var dataURLpay = '/InvoiceSavepayment';
                                var formdatasendget = $('#invoicepaymentform').serialize();
                                
                                $.ajax({
                                    type: 'GET',
                                    url: dataURLpay,
                                    data: formdatasendget,
                                    beforeSend: function() {
                                        $(".modal-body").html("<img src='" + image + "' style='margin-top:1%;margin-left:50%' />"
                                                + "<br><div style='margin-top:6%; text-align: center;'>"
                                                + "<h1> Updating payment please wait.</h1></div>");
                                            $("#previewmodal").modal("show");
                                        },
                                    success: function(data) {
                                        console.log(data);
                                        location.reload();
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        alert('error: ' + textStatus + ': ' + errorThrown);
                                    }
                                })
                            }
                        });
                    }
                })
            })
        $(document).on("click", "#btnsend", function(e) {
            var image = "/assets/img/ajax-loader_2.gif";
            
            e.preventDefault();
            e.stopImmediatePropagation();
            var dataURLpay = '/NEWCRM/Home/SendInvoice';
            var formdatasendget = $('#invoiceform').serialize() + '&status=sent';
            // console.log(formdatasendget);
            var itemsTotal = decodeURI(formdatasendget).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
            formdatasendget += `&totalitems=${itemsTotal}`;
            console.log(decodeURI(formdatasendget).split('&'));
            // return;

            $.ajax({
                type: 'GET',
                url: dataURLpay,
                data: formdatasendget,
                cache: false, // Disable caching
                beforeSend: function() {
                    $(".modal-body").html("<img src='" + image + "' style='margin-top:1%;margin-left:50%' />"
                        + "<br><div style='margin-top:6%; text-align: center;'>"
                        + "<h1> Sending  mail please wait.</h1></div>");
                    $("#previewmodal").modal("show");
                },
                success: function(data) {
                    $(".modal-body").html(
                        "<div style='margin-top:6%; text-align: center;'><i class='fa fa-envelope fa-3x'> </i> <h1> Mail Sent Successfully.</h1></div>"
                    );
                    $("#previewmodal").modal("show");
                    location.reload();             
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('error: ' + textStatus + ': ' + errorThrown);
                    // alert(data);
                }
            })
        });

        $(document).on("click", "#btnsave", function(e) {

            var totalitems = $('#items_total').val();

            // for(let i=0; i < totalitems; i++) {
            //     var total = $(`#totalprice${i}`).val();
            //     if (total.includes("£")) {
            //         total = total.split("£")[1];
            //     }
            //     $(`#totalprice${i}`).val(total);
            // }

            // Process balance
            var Bal = $("#balance").val();
            if (Bal.includes("£")) {
                Bal = Bal.split("£")[1];
            }
            $("#balance").val(Bal);

            // Process total
            var Total = $("#total").val();
            if (Total.includes("£")) {
                Total = Total.split("£")[1];
            }
            $("#total").val(Total);
            // var myform = $("#invoiceform");

            var image = "/assets/img/ajax-loader_2.gif";
            e.preventDefault();
            e.stopImmediatePropagation();
            $("#btnsave").prop("disabled", true);
            var dataURLpay = '/update-invoice';
            var formdatasendget = $('#invoiceform').serialize();
            // console.log(formdatasendget);
            var itemsTotal = decodeURI(formdatasendget).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
            formdatasendget += `&totalitems=${itemsTotal}`;
            // console.log(decodeURI(formdatasendget).split('&'));
            console.log(formdatasendget);

            // return;

            $.ajax({
                type: 'GET',
                url: dataURLpay,
                data: formdatasendget,
                cache: false, // Disable caching
                beforeSend: function() {
                    $(".modal-body").html("<img src='" + image + "' style='margin-top:1%;margin-left:50%' />"
                        + "<br><div style='margin-top:6%; text-align: center;'>"
                        + "<h1> Updating invoice please wait.</h1></div>");
                    $("#previewmodal").modal("show");
                },
                success: function(data) {
                    console.log(data);
                    $("#previewmodal").modal("hide");
                    location.reload(); 

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

            function removeCurrencySymbol(value) {
                // Remove the pound sign (£) from the beginning of the string
                return value.replace(/^£/, '');
            }

            // Example usage:
            var total = $('#total').val();
            var balance = $('#balance').val();

            var cleanTotal = removeCurrencySymbol(total);
            var cleanBalance = removeCurrencySymbol(balance);

            // If you need to update the input field with the clean value:
            $('#total').val(cleanTotal);
            $('#balance').val(cleanBalance);

            $("#btnsave").prop("disabled", true);
        
            var formdatasendget = $('#invoiceform').serialize();
            var itemsTotal = decodeURI(formdatasendget).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
            formdatasendget += `&totalitems=${itemsTotal}`;
        
            const invoiceId = $('#invoiceform').find('input[name="invoiceid"]').val();
        
            // Create FormData object
            const formData = new FormData($('#invoiceform')[0]);
            formData.append('totalitems', itemsTotal);
        
            // Add any additional fields you want to update
            formData.append('status', 'Printed');
            formData.append('print_date', new Date().toISOString().split('T')[0]);
        
            fetch(`/preview-printinvoice/${invoiceId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.open(`/print-invoice/${invoiceId}`, '_blank');
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


        function showclient() {
            var x = document.getElementById("clientdiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            var y = document.getElementById("addclient");
            if (y.style.display === "none") {
                y.style.display = "block";
            } else {
                y.style.display = "none";
            }
        }

        function saveclient() {
            var x = document.getElementById("summaryclient");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            var x = document.getElementById("clientdiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            var clientname = $("#clientname").val();
            var mobileno = $("#mobileno").val();
            var emailadd = $("#emailadd").val();
            var billto = $("#billto").val();
            $("#summaryclientname").val(clientname + ',');
            $("#summaryclientemail").val(emailadd);
        }

        function saveitem() {
            var x = document.getElementById("summaryitem");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            var x = document.getElementByClassNames("itemsdiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            var itemname = $("#itemname").val();
            var itemdescription = $("#itemdescription").val();
            var quantity = $("#quantity").val();
            var price = $("#price").val();
            var totalprice = $("#totalprice").val();
            $("#summaryitemname").val(itemname);
            $("#summaryitemdescription").val(itemdescription);
            $("#summaryquantity").val(quantity + ' x ' + price);
            $("#summarytotalprice").val(totalprice);
        }
        $(document).ready(function() {
            function calculateTotalSum() {
                var totalSum = $('.totalprice').toArray().reduce((sum, el) => sum + (parseFloat($(el).val()) || 0), 0);
                $('#subtotal').val(totalSum.toFixed(2));
                $('#total').val(totalSum.toFixed(2));
                updateBalance();
                // updateOtherFierlsIfDiscoustExixt();
            }

            function calculateCostpriceSum() {
                var costpriceSum = $('.costprice').toArray().reduce((sum, el) => sum + (parseFloat($(el).val()) || 0), 0);
                $('#netprice').val(costpriceSum.toFixed(2));
            }

            function calculateProfit() {
                var totalSum = $('.totalprice').toArray().reduce((sum, el) => sum + (parseFloat($(el).val()) || 0), 0);
                var costpriceSum = $('.costprice').toArray().reduce((sum, el) => sum + (parseFloat($(el).val()) || 0), 0);
                var profit = totalSum - costpriceSum;
                $('#profitDisplay').val(profit.toFixed(2));
            }

            function updateBalance() {
                var totalSum = parseFloat($('#total').val()) || 0;
                var paidAmount = parseFloat($('#paid').val()) || 0;
                var discountAmount = parseFloat($('#discount').val()) || 0;
                var newBalance;
                
                // Calculate new total after discount
                var newTotal = totalSum - discountAmount;
                
                if ($('#paid').length && $('#paid').val() !== '') {
                    // If paid field exists and has a value
                    newBalance = newTotal - paidAmount;
                } else {
                    // If paid field doesn't exist or is empty
                    newBalance = newTotal;
                }
                
                // Update total and balance fields
                $('#total').val(newTotal.toFixed(2));
                $('#balance').val(newBalance.toFixed(2));
            }
             // START OF INITAUTOCOMPLETE FUNCTION
             function initAutocomplete(selector) {
                $(selector).autocomplete({
                    source: function(request, response) {
                        // Fetch data from server using AJAX
                        $.ajax({
                            url: "/invoiceItemauto", 
                            type: 'post',
                            dataType: "json",
                            data: {
                                search: request.term
                            },
                            success: function(data) {
                                response(data);
                                var rowId = $(selector).closest('.oddRow').attr('id');
                                if (data.length === 0) {
                                    // No matches found, show the save button
                                    $("#" + rowId + " .saveNewItem").show();
                                } else {
                                    // Matches found, hide the save button
                                    $("#" + rowId + " .saveNewItem").hide();
                                }
                            }
                        });
                    },
                    select: function(event, ui) {
                        var itemElement = $(this);
                        var parent = itemElement.closest('#itemsmul');
                        
                        // Set selection
                        itemElement.val(ui.item.label);
                        parent.find('.costprice').val(ui.item.cost_price);
                        parent.find('.price').val(ui.item.rate);
                        
                        // Calculate total price
                        var quantity = parseInt(parent.find('.quantity').val()) || 1;
                        var rate = parseInt(ui.item.rate);
                        var total_price = quantity * rate;
                        parent.find('.totalprice').val(total_price.toFixed(2));

                        // update the other fields with the autocomplete values
                        $('#total').val('£' + total_price);
                        $('#balance').val('£' +total_price);

                        // // Calculate and update the total and costprice sum of all total prices
                        calculateTotalSum();
                        calculateCostpriceSum();
                        calculateProfit();
                        // updateOtherFierlsIfDiscoustExixt();
                        return false;
                    }
                });
            }
            // END OF INITAUTOCOMPLETE FUNCTION
            var i = $('.itemsdiv').length; // Get the initial count of existing rows
            // Remove any existing click handlers
            $(document).off('click', '#add');
            
            // Add a new click handler
            $(document).on('click', '#add', function(e) {
            // console.log(i);
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
                                '<input type="text" class="form-control price" ' +
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

                        // the save and cancel if not in db
                        '<div class="saveNewItem" style="float: right; display: none;">' +
                            '<button type="button" class="cancelSaveButton" id="cancelSaveButton' + i + '"' +
                                'style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px; margin-right: 4px;">Cancel' +
                            '</button>' +
                            '<button type="button" class="saveNewItemAtInvoiceCreation" id="saveNewItemAtInvoiceCreation' + i + '"' +
                                'style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px;">Save New Item' +
                            '</button>' +
                        '</div>' +

                        '<button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">' +
                            'X</button>' +
                        '<br><br>' +
                    '</div>' +
                '</div>');
                
                $('#itemsdivadd').append(newRow);
                // Initialize autocomplete for the newly added textarea
                initAutocomplete('#itemdescription' + i);
            });
            
            $('.itemname').each(function() {
                initAutocomplete($(this));
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                // get the row values
                var totalprice = $('#totalprice' + button_id).val();
                var costprice = $('#costprice' + button_id).val();
                // Get the values to be updated
                var subtotal = $('#subtotal').val();
                var paid = $('#paid').val();
                var totalCostprice = $('#netprice').val();
                var profitLoss = $('profitDisplay').val();
                // calculation
                var newSubtotal = subtotal - totalprice;
                var newBalance = newSubtotal - paid;
                var newcostprice = totalCostprice - costprice;
                var newProfitLoss = newSubtotal - newcostprice;

                // Update values before closing removind items
                $('#subtotal').val(newSubtotal.toFixed(2));
                $('#total').val(newSubtotal.toFixed(2));
                $('#balance').val(newBalance.toFixed(2));
                $('#netprice').val(newcostprice.toFixed(2));
                $('#profitDisplay').val(newProfitLoss.toFixed(2));
                
                $('#row' + button_id + '').remove();
            });
        });

        function additemdiv() {
            var myDiv = document.getElementById("itemsmul");
            var myDiv2 = document.getElementById("itemsmulsummary");
            // console.log('cloning');
            document.getElementByClassNames("itemsdiv").appendChild(myDiv.cloneNode(true));
            document.getElementById("summaryitem").appendChild(myDiv2.cloneNode(true));
        }

        function showitems() {
            var x = document.getElementByClassNames("itemsdiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

        function showcomment() {
            var x = document.getElementById("commentdiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

        function showpayment() {
            var x = document.getElementById("paymentdiv");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }

        $("#duedate").datepicker({
            dateFormat: "dd/mm/yy",
        });
        $('#duedate').datepicker('setDate', '<?php echo $duedate; ?>');
        $("#invoicedate").datepicker({
            dateFormat: "dd/mm/yy",
        });
        $('#invoicedate').datepicker('setDate', '<?php echo $invoicedate; ?>');

        function clearFieldssummary(fieldid) {
            var container, inputs, index;

            container = document.getElementById(fieldid);
            inputs = container.getElementsByTagName('input');
            for (index = 0; index < inputs.length; ++index) {
                if (inputs[index].type == "text")
                    inputs[index].value = '';
                if (inputs[index].type == "email")
                    inputs[index].value = '';

            }
            var x = document.getElementById("summaryclient");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
            var y = document.getElementById("addclient");
            if (y.style.display === "none") {
                y.style.display = "block";
            } else {
                y.style.display = "none";
            }

        }

        function clearFields(fieldid) {
            var container, inputs, index;

            container = document.getElementById(fieldid);
            inputs = container.getElementsByTagName('input');
            for (index = 0; index < inputs.length; ++index) {
                if (inputs[index].type == "text")
                    inputs[index].value = '';
                if (inputs[index].type == "email")
                    inputs[index].value = '';

            }
            showclient();
        }
        // discoumt calculation
        $("#discount").on("input", function() {
            // console.log('check discount');
            var discount = $("#discount").val();
            var paid = $("#paid").val();
            var costpricetotal = $("#netprice").val();
            
            let newsubtotal = $("#subtotal").val();
            
            var newtotal = newsubtotal - discount;
            var newbalance = (newsubtotal - paid) - discount;
            var newProfitLoss = newtotal - costpricetotal;

            // console.log(newbalance);
            $("#total").val(((newsubtotal) - discount).toFixed(2));
            $("#balance").val(((newsubtotal - paid) - discount).toFixed(2));
            $("#profitDisplay").val(newProfitLoss.toFixed(2));


        });
        $("#paid").on("input", function() {
            var discount = $("#discount").val();
            var paid = $("#paid").val();

            let newsubtotal = $("#subtotal").val();
            $("#total").val(((newsubtotal) - discount).toFixed(2));
            $("#balance").val(((newsubtotal - paid) - discount).toFixed(2));

        });

        function pricechange(value, id) {
            var i = id.split('price');
            i = i[1];

            var x = document.getElementsByClassName('totalprice');

            var subtotal = 0;
            var valueprice = 0;
            var valuesplit = '';
            var rate = $("#price" + i).val();
            var quantity = $("#quantity" + i).val();
            var costprice = $("#costprice" + i).val();  //new
            var totalprice = quantity * value;
            var discount = $("#discount").val();
            var paid = $("#paid").val();
            
            $("#totalprice" + i).val((quantity * value).toFixed(2));

            // subtotal = subtotal + parseInt(totalprice);
            $("#totalprice" + i).val(quantity * value);
            for (let r = 0; r < x.length; r++) {
                valueprice = x[r].value;

                let pricehere = parseInt(0);
                if (valueprice == 0) {
                    pricehere = parseInt(valueprice);
                } else {
                    valuesplit = valueprice.split('£');
                    pricehere = parseInt(valuesplit[1]);

                    if (valuesplit.length == 1) {
                        pricehere = parseInt(valueprice);

                    }
                }
                subtotal += pricehere;
            }
            $("#subtotal").val(subtotal.toFixed(2));
            $("#total").val(((subtotal) - discount).toFixed(2));
            $("#balance").val(((subtotal - paid) - discount).toFixed(2));

            var subtotal = parseFloat($("#subtotal").val()) || 0;
            var costPrice = parseFloat($("#netprice").val()) || 0;

            var total = subtotal - discount;
            var balance = total - paid;
            var profitLoss = total - costPrice;

            $("#total").val(total.toFixed(2));
            $("#balance").val(balance.toFixed(2));
            $("#profitDisplay").val( profitLoss.toFixed(2));

        }

        // function quantitychange(value, id) {
        //     // var i = id.split('quantity');
        //     // i = i[1];
        //     var i = id.replace('quantity', '');

        //     var subtotal = 0;
        //     var valueprice = 0;
        //     var valuesplit = '';
        //     var rate = $("#price" + i).val();
        //     var quantity = $("#quantity" + i).val();
        //     var totalprice = value * rate;
        //     var costprice = parseInt($("#costprice" +i).val());
        //     var totalcostprice = 0;
        //     var total = parseInt($("#total").val().split('£')[1]);
        //     var netprice = parseInt($("#netprice").val());
        //     var discount = $("#discount").val();
        //     var paid = $("#paid").val();
        //     console.log("costprice", costprice);

        //     $("#totalprice" + i).val((value * rate).toFixed(2));

        //     var x = document.getElementsByClassName('totalprice');
        //     for (let r = 0; r < x.length; r++) {
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
        //     $("#subtotal").val(subtotal.toFixed(2));
        //     $("#total").val(((subtotal) - discount).toFixed(2));
        //     $("#balance").val(((subtotal - paid) - discount).toFixed(2));
            
        //     var subtotal = parseFloat($("#subtotal").val()) || 0;
        //     var costPrice = parseFloat($("#netprice").val()) || 0;

        //     var total = subtotal - discount;
        //     var balance = total - paid;
        //     var profitLoss = total - costPrice;

        //     $("#subtotal").val(subtotal.toFixed(2));
        //     $("#total").val(((subtotal) - discount).toFixed(2));
        //     $("#balance").val(((subtotal - paid) - discount).toFixed(2));
        //     $('#profitDisplay').val((total - netprice).toFixed(2)); 
            
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



        // // UPDATE NET PRICE FUNCTION
        // function updateNetPrice(value, id) {
        //     const index = id.split('price')[1];
        //     const $costPriceElements = $('.costprice');
            
        //     let totalCostPrice = 0;
            
        //     $costPriceElements.each(function() {
        //         let price = parseFloat($(this).val().replace('£', '')) || 0;
        //         totalCostPrice += price;
        //     });
            
        //     $('#netprice').val(totalCostPrice.toFixed(2));

        //     const total = parseFloat($('#total').val().replace('£', '')) || 0;
        //     const profitLoss = total - totalCostPrice;

        //     $('#profitDisplay').val(profitLoss.toFixed(2));
        // }              
        
        
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

        //END OF UPDATE NET PRICE FUNCTION

        function clearFieldsitem(fieldid) {
            var container, inputs, index;

            container = document.getElementById(fieldid);
            inputs = container.getElementsByTagName('input');
            for (index = 0; index < inputs.length; ++index) {
                if (inputs[index].type == "text")
                    inputs[index].value = '';
                if (inputs[index].type == "number")
                    inputs[index].value = '';

            }
            showitems();

        }

        $(document).on("click", ".transactionhistory", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var invoiceid = $(this).attr("invoiceid");
            //get data
            $.ajax({
                method: "get",
                cache: false, // Disable caching
                url: "/load_transaction_detailsnew",
                data: {
                    invoiceid: invoiceid
                },
                beforeSend: function() {
                    var image = "/assets/img/ajax-loader_2.gif";
                    $("#previewmodal .modal-body").html("<img src='" + image +
                        "' style='margin-top:10%;;margin-left:40%' />")
                    $("#previewmodal").modal("show");

                },
                success: function(bk) {
                    $(".overlay1").hide();
                    // $(".admin_content").html(bk);                
                    $("#previewmodal .modal-body").html();
                    $("#previewmodal .modal-body").html(bk);

                    $("#previewmodal").modal("show");

                }
            })
        })

    </script>
</body>
</html>
           
                