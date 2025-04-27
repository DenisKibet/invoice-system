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
                    <button class="btn btn-dark"><a href="/quoteList" style="color:white; text-decoration:none;"><i class="fas fa-fw fa-file"></i> Estimate List</a></button>
                </div>
                <div class="col-12 mt-3 mb-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" style="color: black;">Edit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="btnpreview" style="color: black;">Preview</a>
                        </li>
                        <!-- HIDE THE METHOD MEANWHILE -->
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#" id="btnprint" style="color: black;">Print</a>
                        </li> -->
                    </ul>
                </div>
                <div>
                    <a href="/CreateQuotation" class="" style="text-decoration: none;">
                        <span class="fa fa-arrow-left fa-fw mr-2"></span>
                        Create Estimate
                    </a>
                        <!-- <div id="tooltip" style="display:none; position:absolute; background-color:black; color:white; padding:5px; border-radius:3px;">Already converted</div> -->
                    <a href="#" 
                        class="btn btn-dark p-1 mr-2 <?= $estimates->status === 'Archived' ? 'archived' : '' ?>" 
                        id="btnConvertToInvoice" 
                        style="text-decoration: none; float: right; font-size: 0.8rem; <?= $estimates->status === 'Archived' ? 'opacity: 0.65;' : '' ?>">
                        <span class="fas fa-file-invoice-dollar fa-fw"></span>
                        Convert To Invoice
                    </a>

                    <!-- <a href="#" class="btn btn-dark p-1 mr-2" id="btnUpdate" style="text-decoration: none; float: right; font-size: 0.8rem;">
                        <span><i class="fa-solid fa-floppy-disk"></i></span>
                        Update and Close
                    </a> -->
                   
                </div>
                <form id="invoiceform">
                    <div class="row container-fluid">
                        <div class="col-lg-8 col-sm-12 col-md-12">
                            <div class="card-header" style="background-color:#e6e6e6;">
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
                                    <input type="hidden" name="estimate_no" id="estimate_no" value="<?=$value->estimate_no?>" />
                                    <input type="hidden" class="form-control" name="estimateId" id="estimateId" value="<?= $value->id ?>">
                                    <input type="hidden" name="invoice_no" id="invoice_no" value="<?=$invoice_no?>" />  
                                    <label for="clientname" class="col-sm-3 col-form-label">Client Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" 
                                        name="cname" id="clientname" placeholder="Enter a Client Name ... " 
                                        style=" border-right: none; border-left: none; border-top: none;" value="<?= $client->ClientName ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobileno" class="col-sm-3 col-form-label">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" 
                                        name="mobile" id="mobileno" placeholder="Enter a Mobile Number ..." 
                                        style=" border-right: none; border-left: none; border-top: none;" value="<?= $client->MobileNumber ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="emailadd" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" readonly="readonly" 
                                        name="invoiceemail" id="emailadd" placeholder="Enter an Email Address ..." 
                                        style=" border-right: none; border-left: none; border-top: none;" value="<?= $client->EmailAddress ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="billto" class="col-sm-3 col-form-label">Bill to</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" readonly="readonly" 
                                        name="bill_to" id="billto" placeholder="Enter an Address ..." 
                                        style=" border-right: none; border-left: none; border-top: none;" value="<?= $client->address ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="card-header mt-3" style="background-color:#e6e6e6;">
                                Items
                            </div>
                            <div class="card-body">
                                <div id="summaryitem" style="display: none;">
                                    <div id="itemsmulsummary">
                                        <input type="text" disabled name="summaryitemname" id="summaryitemname" 
                                        class="form-control" 
                                        style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                        <!-- <input type="text" disabled name="summaryitemdescription" id="summaryitemdescription" 
                                        class="form-control" 
                                        style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;"> -->

                                        <div class="form-group row container">
                                            <input type="text" disabled name="summaryquantity" id="summaryquantity" 
                                                class="form-control  col-sm-6" 
                                                style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                            <div class="col-sm-6">
                                                <!-- <input type="text" disabled name="summarytotalprice" id="summarytotalprice"
                                                class="form-control" 
                                                style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;"> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <php var_dump($itemlist)?> -->
                                <?php if (empty($itemlist)) { ?>
                                    <div class="itemsdiv" style="display: block;">
                                        <div id="itemsmul">
                                            <div class="form-group row">
                                                <input type="text" class="form-control mt-3" name="itemname[]" id="itemname" placeholder="Reference Number" style=" border-right: none; border-left: none; border-top: none;">
                                            </div>
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
                            <div class="card-header mt-3" style="background-color:#e6e6e6;">
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
                                            ><?= !empty($invoices) ? $invoices->comment : (!empty($comments) ? (is_object($comments) ? $comments->comment : $comments['comment']) : ''); ?></textarea>
                                    </div>
                                </div>
                                <a href="#" class="" onclick="showpayment()" style="text-decoration: none;">
                                    <p class="card-text">
                                        <span class="fa fa-credit-card fa-fw mr-2"></span>
                                        Add Payment Instructions.
                                    </p>
                                </a>
                            </div>
                            <div id="paymentdiv" style="display: block;">
                                <div class="form-group">
                                    <?php  
                                        if (!empty($payments)) {
                                            foreach ($payments as $payment) {
                                                $paymenttext = $payment->payment_instruction;
                                                $id = $payment->id;
                                    } ?>
                                    <input type="hidden" value=<?= $id ?> name='paymentid' class="formcontrol">

                                    <?php
                                        } 
                                    ?>
                                    <textarea class="form-control mt-3" name="payment_instruction" id="payment" cols="20" rows="4"
                                    ><?= !empty($invoices) ? $invoices[0]->payment_instruction : (!empty($paymenttext) ? $paymenttext : ''); ?></textarea>
                                </div>
                            </div>
                    
                        </div>
                        <div class="col-lg-4 col-sm-12 col-md-12 ">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong style="font-size:1.2rem;">Estimate</strong>
                                <span class="font-weight-bold" style="font-size:0.8rem;"><?= $value->estimate_no?></span>
                                <span class="font-weight-bold" style="font-size:0.8rem;">to</span>
                                <span class="font-weight-bold" style="font-size:0.8rem;"><?= $invoice_no?></span>
                            </div>
                            <div class="status mb-3">
                                <span class="badge badge-warning text-xl"><?= $value->status ?> </span>
                            </div>
                            <div class="form-group row">
                                <label for="estimatedate" class="col-sm-3 col-form-label">Est Date</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="estimatedate" id="estimatedate" placeholder="Date" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->invoice_date ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="invoicedate" class="col-sm-3 col-form-label">Inv Date</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="invoicedate" id="invoicedate"
                                        placeholder="Date"
                                        style="color:#114155; border-right: none; border-left: none; border-top: none; background-color: #eaecf4;"
                                        value=<?php !empty($invoices) ? $invoices[0]->invoice_date : '' ?>>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="terms" class="col-sm-3 col-form-label">Terms</label>
                                <div class="col-sm-9">
                                    <select name="terms" class="form-control" id="previewTerms"
                                        style=" border-right: none; border-left: none; border-top: none;">
                                        <option value="same day">same day</option>
                                        <?php
                                        if (!empty($terms)) {
                                            $default = explode(" days", $terms[0]->terms)[0];
                                            $default = $default ? intval($default) : '';
                                            $days = array($default, 7, 14, 21, 30, 45, 60, 90);
                                        } else {
                                            $days = array(7, 14, 21, 30, 45, 60, 90);
                                        }
                                        sort($days);
                                        foreach ($days as $day) {
                                            $selected = (!empty($terms) && $terms[0]->terms == "$day days") ? "selected" : "";
                                            echo "<option value='{$day} days' {$selected}>{$day} days</option>";
                                        }
                                        ?>
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
                                    <input type="text" class="form-control" name="paid" id="paid" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->paid?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="method" class="col-sm-3 col-form-label">Method</label>
                                <div class="col-sm-9">
                                    <datalist id="method">
                                        <option value="Cash">
                                        <option value="Cheque">
                                        <option value="Direct Transfer">
                                        <option value="Credit Card">
                                        <option value="PayPal">
                                    </datalist>
                                    <input type="text" list="method" class="form-control" name="method" id="methods"
                                        placeholder="Enter a method..."
                                        style=" border-right: none; border-left: none; border-top: none;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="balance" class="col-sm-3 col-form-label">Balance</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" readonly="readonly" name="balance" id="balance" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->total?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="costprice" class="col-sm-3 col-form-label">Cost Price</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" readonly="readonly" name="netprice" id="netprice" placeholder="£ 0.00" style=" border-right: none; border-left: none; border-top: none;" value="<?=$value->netprice?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="profit/loss" class="col-sm-3 col-form-label">Profit/loss</label>
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

        function closemodalpay() {
            $('#addpayment').modal('hide');
        }

    $(document).ready(function() {
        var i = $('.itemsdiv').length; 
        
        // Remove any existing click handlers
        $(document).off('click', '#add');
        
        // CLICK HANDLER FOR ADD ITEM
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
        // REMOVE ROW FUNCTIONALITY
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
            $('#subtotal').val(newSubtotal);
            $('#total').val(newSubtotal);
            $('#balance').val(newBalance);
            $('#netprice').val(newcostprice);
            $('#profitDisplay').val(newProfitLoss);
            $('#row' + button_id).remove();
        });
    });
    // INITIALIZE DATEPICKER
    $(document).ready(function() {
        $("#duedate").datepicker({
            dateFormat: "dd/mm/yy",
            minDate: new Date()
        });
        $("#duedate").datepicker("setDate", new Date());

        $("#invoicedate").datepicker({
            dateFormat: "dd/mm/yy",
            minDate: new Date(),
            maxDate: new Date()
        });
        $("#invoicedate").datepicker("setDate", new Date());
    });
    //  UPDATER DUE DATE AUTOMATICALLY
    $(document).ready(function(){
        function updateDueDate() {
            var invoiceDateStr = $('#invoicedate').val(); 
            var term = $('#previewTerms').val(); 

            var invoiceDateParts = invoiceDateStr.split('/');
            var invoiceDate = new Date(invoiceDateParts[2], invoiceDateParts[1] - 1, invoiceDateParts[0]);

            var dueDate;
            if (term === "same day") {
                dueDate = new Date(invoiceDate); 
            } else {
                var termDays = parseInt(term); 
                dueDate = new Date(invoiceDate);
                dueDate.setDate(dueDate.getDate() + termDays);
            }

            var dueDateFormatted = ("0" + dueDate.getDate()).slice(-2) + "/" + ("0" + (dueDate.getMonth() + 1)).slice(-2) + "/" + dueDate.getFullYear();

            $('#duedate').val(dueDateFormatted);
        }

        updateDueDate();

        $('#previewTerms').change(function(){
            updateDueDate();
        });
    });
    // UPDATE TERMS AUTOMATICALLY
    $(document).ready(function() {
        $('#duedate').change(function(e) {
            var invoiceDateStr = $('#invoicedate').val();
            var dueDateStr = $('#duedate').val();
            
            // Check if the date strings are not empty or invalid
            if (invoiceDateStr && dueDateStr) {
                var invoiceDateParts = invoiceDateStr.split('/');
                var invoiceDate = new Date(invoiceDateParts[2], invoiceDateParts[1] - 1, invoiceDateParts[0]);
                
                var dueDateParts = dueDateStr.split('/');
                var dueDate = new Date(dueDateParts[2], dueDateParts[1] - 1, dueDateParts[0]);

                var differenceInMillis = dueDate - invoiceDate;

                var differenceInDays = differenceInMillis / (1000 * 60 * 60 * 24);
                var turnToString = differenceInDays + " days";

                let newarray = <?php echo json_encode($days);?>;

                if(differenceInDays > 0) {
                    newarray.push(differenceInDays);
                }
                newarray.sort((a, b) => a - b);
                console.log(newarray);
                var arrCount = newarray.length;

                let newOption = "<option value='same day'>same day</option>";
                for(let i = 0; i < arrCount; i++) {
                    newOption += `<option value="${newarray[i]} days">${newarray[i]} days</option>`;
                }

                $('#previewTerms').html(newOption);
                
                if(differenceInDays === 0) {
                    $('#previewTerms').val('same day');
                } else if(differenceInDays === 1){
                    console.log(differenceInDays);
                    $('#previewTerms').val('1 day');
                } else {
                    $('#previewTerms').val(turnToString);
                }
            } else {
                // Handle the case where one or both of the date strings are empty or invalid
                console.log("Please enter valid dates.");
            }
        });
    });
    // PREVIEW FUNCTIONALITY
    $(document).on("click", "#btnpreview", function(e) {
        var image = "/assets/img/ajax-loader_2.gif";
        e.preventDefault();
        e.stopImmediatePropagation();
        var estimatePreviewURL = '/estimate-invoice-preview';
        var previewFormData = $('#invoiceform').serialize();  
        const itemsTotal = decodeURI(previewFormData).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
        const dataToSend = `${previewFormData}&totalitems=${itemsTotal}`;
        // console.log(dataToSend);
        // return;
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
                console.log(data.message);
                $(".modal-body").html();
                $(".modal-body").html(data);
                $("#previewmodal").modal("show");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('error: ' + textStatus + ': ' + errorThrown);
            }
        })
    });
    // DISCOUNT CALCULATION
    $("#discount").on("input", function() {
        // console.log('check discount');
        var discount = $("#discount").val();
        var paid = $("#paid").val();
        var costpricetotal = $("#netprice").val();
        
        let newsubtotal = $("#subtotal").val();
        
        var newtotal = newsubtotal - discount;
        var newbalance = (newsubtotal - paid) - discount;
        var newProfitLoss = newtotal - costpricetotal;
        // console.log('costpricetotal',costpricetotal);

        // console.log(newbalance);
        $("#total").val(((newsubtotal) - discount).toFixed(2));
        $("#balance").val(((newsubtotal - paid) - discount).toFixed(2));
        $("#profitDisplay").val(newProfitLoss.toFixed(2));
    });
    // PAID ACALCULATION
    $("#paid").on("input", function() {
        var discount = $("#discount").val();
        var paid = $("#paid").val().replace('£', '');

        let newsubtotal = $("#subtotal").val();
        $("#total").val(((newsubtotal) - discount).toFixed(2));
        $("#balance").val(((newsubtotal - paid) - discount).toFixed(2));

    });
    // CONVERT ESTIMATE TO INVOICE
    $(document).on("click", "#btnConvertToInvoice", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var image = "/assets/img/ajax-loader_2.gif";

        // Cache jQuery selectors to avoid repeated DOM lookups
        const $balance = $("#balance");
        const $total = $("#total");

         // Function to remove currency symbol (e.g., "£")
        const removeCurrencySymbol = value => value.includes("£") ? value.split("£")[1] : value;
        
        // Process balance and total values
        $balance.val(removeCurrencySymbol($balance.val()));
        $total.val(removeCurrencySymbol($total.val()));
      
        // var myform = $("#invoiceform");
        $("#btnsave").prop("disabled", true);
        var dataURLpay = '/save-estimate-as-invoice';
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
                    + "<br><div style='margin-top:6%; text-align: center'>"
                    + "<h1> Saving invoice, please wait...</h1></div>");
                $("#previewmodal").modal("show");
            },
            success: function(data) {
                $("#previewmodal").modal("hide"); // Hide modal
                const response = JSON.parse(data); // Parse JSON response
                
                if (response.success) {
                    window.location = "/InvoiceList"; 
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
    // Alert the User That the estimate has been converted if the uder overs over ther button
    $(document).ready(function() {
        var alertShown = false;

        $('#btnConvertToInvoice').hover(function(event) {
            if ($(this).hasClass('archived') && !alertShown) {
                alert('Already Converted To An Invoice');
                alertShown = true; 
            }
        }, function() {
            alertShown = false;
        });
    });
    // PRINT ESTIMATE USING SECURE $ BEST PRACTICE
    $(document).on("click", "#btnprint", function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

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
        console.log(formdatasendget);

        fetch(`/estimate-to-invoice-preview-print/${estimateId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            if (data.success) {
                window.open(`/print-estimate-as-invoice/${estimateId}`, '_blank');
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("An error occurred while processing your request.");
        });
    });

    // function quantitychange(value, id) {
    //     var i = id.split('quantity');
    //     i = i[1];
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
    //     $("#balance").val('£' + ((subtotal - paid) - discount));
        
    //     var subtotal = parseFloat($("#subtotal").val()) || 0;
    //     var costPrice = parseFloat($("#netprice").val()) || 0;

    //     var total = subtotal - discount;
    //     var balance = total - paid;
    //     var profitLoss = total - costPrice; 

    //     $("#subtotal").val(subtotal);
    //     $("#total").val('£' + ((subtotal) - discount));
    //     $("#balance").val('£' + ((subtotal - paid) - discount));
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
    
        $("#totalprice" + i).val((quantity * value).toFixed(2));
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
        // ===========================================

</script>