<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - New Invoice</title>
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

    #invoiceFormButton,
    .addClientInput {
        display: none;
    }

    .oddRow:nth-child(even) {
        background: #f8f9fc;
        border-radius: 12px;
        color: #2489b5;
        padding: 0;
        margin-bottom: 1rem;
    }
    .oddRow:nth-child(even) h4 {
        color: #2489b5;
    }

    /* send section  */
    .email-form-row {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .input-group {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
    .input-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    .email-input {
        margin-left: 10px;
        border: none;
        border-bottom: 1px dashed #ccc;
        outline: none;
        width: 250px; /* Adjust width as needed */
    }
    .email-label {
        font-weight: bold;
        margin-right: 10px;
    }
    .email-button {
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 3px;
        padding: 5px 10px;
        cursor: pointer;
    }
    .subject-input {
        border: none;
        border-bottom: 1px dashed #ccc;
        outline: none;
        width: 100%; /* Adjust width as needed */
    }
    .deposit-request-section {
    width: 100%;
    }

    .add-request {
        margin-bottom: 10px;
        
    }

    .button-container button {
        width: 90%;
        height: 40px;
        display: block;
        margin-bottom: 10px;
        border: none;
    }

   
    
    
    /* tongle switches */
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

/* preview section */
.invoice-number {
        display: flex;
        justify-content: flex-start;
        align-items: baseline;
    }

    .invoice-number p {
        margin: 0;
        padding-right:10px;
    }

    .invoice-number span {
        margin-left: auto;
    }
.thick-hr-line{
    border: none;
    height: 3px; 
    background-color: black;
    width: 100%;
    margin: 0;
    padding: 0;
}
.address {
        text-align: right;
    }
.vertical-line {
    border-left: 1px solid #000; 
    height: auto; 
    margin-left: 10px; 
    margin-right: 10px;
}
.halfway-hr  {
    width: 100%; 
    margin: 0 auto; 
    float: right;
}


.row {
    display: flex;
}

.col-6 {
    flex: 1;
}
/* send section, attachment section */
.uploaded-attachment {
    display: inline-block;
    position: relative;
    border: 1px solid #ccc;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    width: 140px;
    height: 140px;
    /* line-height: 140px; */
}

.upload-to-attach {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    border: 1px solid #ccc; 
    padding: 10px;
    border-radius: 10px;
    text-align: center;
    width: 140px; /* Adjust as needed */
    height: 140px; /* Adjust as needed */
    line-height: 140px; 
    cursor: pointer;
}

.upload-to-attach input[type="file"] {
    display: none; /* Hide the file input */
}

.fa-paperclip {
    font-size: 45px; /* Adjust icon size as needed */
    color: #555; /* Icon color */
    vertical-align: middle; /* Align icon vertically */
}

/* BILL TO SECTION */
.bill-to {
    text-align: right;
}

/* add deposite request */
.add-request a{
    cursor: pointer;
    text-decoration: none;
    color: #324bff;
    font-weight: bold;
}

/* Send payment reminders */
.send-payment-reminders {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.send-payment-reminders input[type="checkbox"] {
    cursor: pointer;
    width: 25px; 
    height: 25px; 
    margin-right: 10px;
}

.send-payment-reminders p {
    cursor: pointer;
    margin: 0;
    flex-grow: 1;
}

.send-payment-reminders button {
    margin-left: 10px;
    border: none;
    background: none;
    color: #324bff;
    cursor: pointer;
    text-decoration: none;
}

.send-payment-reminders button:hover {
    text-decoration: none;
}
    </style>
</head>

<body id="page-top">
    <div id="wrapper">    <!-- Page Wrapper -->
        <?php include 'sidebarcreate.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content"> <!-- Main Content -->
                <?php include 'topbar.php' ?>
                <div class="d-sm-flex align-items-center justify-content-between mb-4 p-3">
                    <h1 class="h3 mb-0 text-gray-800">New Invoice</h1>
                </div>
                <div class="col-12 mt-3 mb-3 p-3">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" id="createbtn" style="color: black;">Create</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="btnpreview" style="color: black;">Preview</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="btnsend" style="color: black;">Send</a>
                        </li>
                    </ul>
                </div>
                
                <div id="createform">
                    <!-- <div>
                         <a href="#" class="btn btn-dark p-2 m-3 mr-5" id="1btnsave"
                        style="text-decoration: none; float: right;">
                        <span class="fa fa-save fa-fw mr-2"></span>
                        Save and Close</a>
                    </div> -->
                    <div class="container-fluid">
                        <form id="invoiceform" style="background: #ffffff;">
                            <div class="row container-fluid">
                                <div class="col-lg-8 col-sm-12 col-md-12" style="box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.5);">
                                    <div class="card-header m-3"
                                        style="color:#1a1a1a; background-color: #F2EFE8;border-radius: 0 12px 12px 0;">
                                        <h4><i class="fa fa-users"></i> Client Details</h4>
                                    </div>

                                    <div class="col-sm-12">
                                        <p class="text-danger">required fields: *</p>
                                    </div>
                            
                                    <div class="card-body">
                                        <div class="row" id="fetch_client">
                                            <input type="hidden" name="userid" id="userid" value="<?= isset($userid)?$userid:"" ?>" />
                                            <input type="hidden" name="invoice_no" id="invoice_no" value="<?=$invoice_no?>" />
                                            <div class="col-lg-6 col-sm-12 mb-3 invoiceForm">
                                                <label for="cname">Client Name: <span class="text-danger">*</span></label><br>
                                                <div id="prefetch"><input id="autouser"
                                                    class="itemName input-lg typeahead w3-card-2 form-control"
                                                    type="text" name="cname" value="<?= isset($cname)?$cname:"" ?>"
                                                    placeholder="Client Name" required />
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12 mb-3 invoiceForm">
                                                <label for="mobile">Mobile: <span class="text-danger">*</span></label><br>
                                                <input class="form-control w3-card-2" type="text" id="mobile" name="mobile" value="<?= isset($mobile)?$mobile:"" ?>"
                                                    required placeholder="Mobile Number">
                                            </div>
                                            <div class="col-lg-6 col-sm-12 mb-3 invoiceForm">
                                                <label for="email">Email Address: <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control w3-card-2" name="invoiceemail"
                                                value="<?= isset($email)?$email:"" ?>" placeholder="Email Address"
                                                    id="useremail" required />
                                            </div>
                                            <div class="col-lg-6 col-sm-12 mb-3 invoiceForm">
                                                <label for="bill_to">Bill To: </label>
                                                <input type="text" class="form-control w3-card-2" name="bill_to"
                                                    id="bill_to" value="<?= isset($bill_to)?$bill_to:"" ?>"
                                                    placeholder="Address" required />
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 p-0" id="add_new_client" style="display: none;">
                                        <table style="border-spacing: 30px;">
                                            <tr>
                                                <td style="width: 50%">
                                                    <input type="submit" id="DeleteNewClient" value="Back" style="background: #5a5c69; color: white; width: 100%; border: none; height: 35px; border-radius: 4px;">
                                                </td>
                                                <td style="width: 50%">
                                                    <input type="submit" id="SaveNewClient" value="Save Client"  style="background: #5a5c69; color: white; width: 100%; border: none; height: 35px; border-radius: 4px;">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>


                                    
                                        <div class="mt-3 append_client " id="add_client12">
                                            <a href="#" class="d-flex flex-row " id="add_client" style="text-decoration: none;">
                                                <p class="card-text mr-3">
                                                    <span class="fa fa-plus-circle fa-fw mr-2"></span>
                                                    Add Client. 
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card-header m-3"
                                        style="color:#1a1a1a; background-color: #F2EFE8; border-radius: 0 12px 12px 0;">
                                        <h4><i class="fa fa-list"></i> Items</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="summaryitem" style="display: none;">
                                            <div id="itemsmulsummary">
                                                <input type="text" disabled name="summaryitemname" id="summaryitemname"
                                                    class="form-control"
                                                    style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                                <input type="text" disabled name="summaryitemdescription"
                                                    id="summaryitemdescription" class="form-control"
                                                    style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">


                                                <div class="form-group row container">
                                                    <input type="text" disabled name="summaryquantity" id="summaryquantity"
                                                        class="form-control  col-sm-6"
                                                        style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                                    <div class="col-sm-6">
                                                        <input type="text" disabled name="summarytotalprice"
                                                            id="summarytotalprice" class="form-control"
                                                            style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: white;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="itemsdiv" style="display: block;">
                                            <div class="oddRow" id="row0">
                                                <div class="form-group row">
                                                    <textarea class="form-control itemname mt-2" required cols="15" rows="2"
                                                        name="itemname[]" id="itemname"
                                                        placeholder="Item Description "
                                                        style=" border-right: none; border-left: none; border-top: none; text-align: left;"></textarea>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="quantity_under_items l col-sm-2 " style="width:24%; padding:0">
                                                        <label for="quantity">Quantity</label>
                                                        <input type="number" class="form-control col-sm-12"
                                                            oninput="quantitychange(this.value,this.id)" data-id="0"
                                                            name="quantity[]" id="quantity" placeholder="0" value="1"
                                                            style=" border-right: none; border-left: none; border-top: none;">
                                                    </div>
                                                    <div class="multiplication d-flex flex-column col-sm-1" style="padding: 0;">
                                                        <span class="p-2"style="display: flex; height: 100%; justify-content: center; align-items: end;">x</span>
                                                    </div>
                                                    <div class="col-sm-3" style="padding: 0;">
                                                        <label for="rate">Rate</label>
                                                        <input type="number" class="form-control price" data-id="0"
                                                            oninput="pricechange(this.value,this.id)" name="price[]"
                                                            id="price" placeholder="0.00"
                                                            style=" border-right: none; border-left: none; border-top: none;">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label for="totalprice">Total Price</label>
                                                        <input type="text" class="form-control totalprice"
                                                            readonly="readonly" name="totalprice[]" id="totalprice"
                                                            placeholder="0.00"
                                                            style=" border-right: none; border-left: none; border-top: none; border-bottom:none; background-color: #eaecf4; "
                                                            value="">
                                                    </div>
                                                    <div class="col-sm-3" style="padding: 0;">
                                                        <label for="costPrice">Total Cost Price</label>
                                                        <input type="number" class="form-control costprice" name="costprice[]" 
                                                        id="costprice" placeholder="0.00" oninput="updateNetPrice(this.value, this.id)"
                                                        style=" border-right: none; border-left: none; border-top: none;">
                                                    </div>
                                                    <!-- <input type="hidden" name="originalCostprice" id="originalCostprice"> -->
                                                </div>
                                                <div class="saveNewItem" style="float: right; display: none;">
                                                    <button type="button" class="cancelSaveButton" id="cancelSaveButton"
                                                        style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px; ">Cancel
                                                    </button>
                                                    <button type="button" class="saveNewItemAtInvoiceCreation" id="saveNewItemAtInvoiceCreation" 
                                                        style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px; ">Save New Item
                                                    </button>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="mt-3 ">
                                            <a href="#" class="d-flex flex-row " id="add" style="text-decoration: none;">
                                                <p class="card-text mr-3">
                                                    <span class="fa fa-plus-circle fa-fw mr-2"></span>
                                                    Add Items.
                                                </p>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="card-header m-3"
                                        style="color:#1a1a1a; background-color: #F2EFE8; border-radius: 0 12px 12px 0;">
                                        <h4><i class="fa fa-comments"></i> Comments</h4>
                                    </div>
                                    <div class="card-body">

                                        <a href="#" class="" onclick="showcomment()" style="text-decoration: none;">
                                            <p class="card-text">
                                                <span class="fa fa-comment fa-fw mr-2"></span>
                                                View Comment.
                                            </p>
                                        </a>
                                        <div id="commentdiv" style="display: block;">
                                            <div class="form-group row">
                                                <textarea class="form-control comment mt-3" name="comment" id="comment" cols="40" rows="4"  
                                                placeholder="Enter Comment"><?= !empty($invoices) ? $invoices[0]->comment : (!empty($comments) ? $comments[0]->comment : 'Thank you, it was nice doing business with you.'); ?></textarea>
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
                                                <textarea class="form-control payment_instruction mt-3" name="payment_instruction" id="payment" cols="40"
                                                    rows="4" placeholder= "Enter payment instruction"><?= !empty($invoices) ? $invoices[0]->payment_instruction : (!empty($paymenttext) ? $paymenttext : "Account name: Business Name\nAccount number: 12345...."); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-md-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5><strong>Invoice</strong></h5>
                                        <span class="font-weight-bold"><?php if(!empty($company)) echo $invoice_no?></span>
                                    </div>
                                    <div class="status mb-3">
                                        <span class="badge badge-secondary">Unsent</span>
                                    </div>
                                    <div class="form-group row">
                                        <label for="invoicedate" class="col-sm-3 col-form-label">Date</label>
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
                                                style="border-right: none; border-left: none; border-top: none;">
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
                                        <label for="date" class="col-sm-3 col-form-label">Due Date <span class="text-danger">*</span></label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="duedate" id="duedate" autocomplete= off
                                                placeholder="Date"
                                                style=" border-right: none; border-left: none; border-top: none;" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <label for="subtotal" class="col-sm-3 col-form-label">Sub-Total</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="readonly" name="subtotal"
                                                id="subtotal" placeholder="Ksh0.00"
                                                style=" border-right: none; border-left: none; border-top: none;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="discount" class="col-sm-3 col-form-label">Discount</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="discount" id="discount"
                                                placeholder="Ksh0.00"
                                                style=" border-right: none; border-left: none; border-top: none;">
                                        </div>
                                    </div>

                                    <hr>
                                    <div class="form-group row">
                                        <label for="total" class="col-sm-3 col-form-label">Total</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="readonly" name="total"
                                                id="total" placeholder="Ksh0.00"
                                                style=" border-right: none; border-left: none; border-top: none;">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="paid" class="col-sm-3 col-form-label">Paid</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="paid" id="paid"
                                                placeholder="Ksh0.00"
                                                style=" border-right: none; border-left: none; border-top: none;">
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
                                            <input type="text" class="form-control" readonly="readonly" name="balance"
                                                id="balance" placeholder="Ksh0.00"
                                                style=" border-right: none; border-left: none; border-top: none;">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="netprice" class="col-sm-3 col-form-label">Cost Price</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" readonly="readonly" name="netprice"
                                                id="netprice" placeholder="Ksh0.00"
                                                style=" border-right: none; border-left: none; border-top: none;">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="profit" class="col-sm-3 col-form-label">Profit/Loss</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" readonly="readonly" name="profit"
                                                id="profitDisplay" placeholder="Ksh0.00"
                                                style=" border-right: none; border-left: none; border-top: none;">
                                        </div>
                                    </div>

                                    <div class="col-sm-12 p-0">
                                        <a href="#" class="btn btn-block p-1 mt-5" id="btnsave" 
                                            style="text-decoration: none; background-color: #071a26; color: #fff;">
                                            <span class="fa fa-save fa-fw mr-2"></span>
                                            Save and Close
                                        </a>
                                    </div>
                                </div>
                            </div>
                                </div>
                            </div>
                                            
                            <div id="preview" style="display: none;">
                                <div class="container-fluid" style="padding-right: 0;">
                                    <div class="view-as-pdf" >
                                        View as PDF
                                        <label class="switch" id="pdfToggle">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                    <div class="border bg-white row py-3" style="width: 100%;">
                                    <div class="col-lg-8">
                                        <span class="invoicePreviewpdF" style="width:100%;"><?php include 'invoicepdfview.php' ?></span>
                                        <?php include 'invoicepdf.php' ?>
                                    </div>
                                    <div class="content-wrapper-right col-lg-4" style="background-color: white;">
                                            <div class="invoice-data">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5><strong>Invoice</strong></h5>
                                                    <span class="font-weight-bold"><?php if(!empty($company)) echo $invoice_no?></span>
                                                </div>
                                                <div class="status mb-3">
                                                    <span class="badge badge-secondary">Unsent</span>
                                                </div>
                                                <div class="amount-display d-flex flex-row">
                                                    <p ><strong>Total</strong></p>
                                                    <p class="ml-auto" id="previewRightTotal" >Ksh0.00</p>
                                                </div>
                                                <div class="amount-display d-flex flex-row">
                                                    <p><strong>Paid</strong></p>
                                                    <p class="ml-auto" id="previewRightPaid">Ksh0.00</p>
                                                </div>
                                                <div class="amount-display d-flex  flex-row">
                                                    <p><strong>Balance</strong></p>
                                                    <p class="ml-auto" id="previewRightBalance1">Ksh0.00</p>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="payment-method">
                                                <div class="send-payment-reminders d-flex flex-row justify-content-between" style="vertical-align: bottom;">
                                                    <input type="checkbox" id="paymentReminder" name="paymentReminder" value="on" checked>
                                                    <p class="">Send Payment Reminders</p>
                                                    <button id="payment-reminder" class="payment-reminder btn btn-outline-none" 
                                                        data-toggle="modal" data-target="#paymentModal" style="font-size:1.1rem;">
                                                        View
                                                    </button>
                                                </div>

                                                <hr>
                                            
                                                <div class="recurring-invoice d-flex flex-row justify-content-between ">
                                                    <h6>Recurring invoice</h6>
                                                    <div class="dropdown">
                                                        <select name="recurringInvoicePreview" id="recurringInvoicePreview">
                                                            <option value="off">Off</option>
                                                            <option value="every_week">Every week</option>
                                                            <option value="every_two_weeks">Every two weeks</option>
                                                            <option value="every_month" >Every month</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="sendinvoice" style="display: none;">
                                <div class="container-fluid">
                                    <div class="border bg-white row py-3 pl-3  ">
                                        <div class="content-wrapper border pt-3 col-lg-8" style="background-color: white;">
                                            <div class="send-header">
                                                <div class="email-form-row py-2">
                                                    <div class="email-form-row">
                                                        <label class="email-label mr-5" for="to">To</label><br>
                                                        <input type="email" id="sendInvoiceto" name="sendInvoiceto" class="email-input" placeholder="Email Address" readonly>
                                                    </div>
                                                    <div>
                                                        <button class="email-button">Cc</button>&nbsp;
                                                        <button class="email-button">Bcc</button>
                                                    </div>
                                                </div>
                                                <div class="email-form-row ">
                                                    <label class="email-label mr-3" for="subject">Subject</label>
                                                    <input type="text" id="InvoiceSubject" name="InvoiceSubject" class="subject-input"
                                                           value="Invoice <?php echo $invoice_no; ?> from <?php echo $company->company_name ?? 'Unknown Company'; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="input-group py-4">
                                                <textarea class="form-control mt-3" name="userMessage" id="userMessage" cols="24" rows="6" style="text-align: left;">Thank you for doing business with us.</textarea>
                                            </div>
                                            
                                            <div class="font-weight-bold mt-4g">
                                                Attachments (1)
                                            </div>

                                            <hr>
                                            <div class="pdf-attachment-section d-flex flex-row" id="pdfAttachmentSection">
                                                <div class=" pr-3" id="uploadedFiles">
                                                <div class="uploaded-attachment" id="uploaded-attachment">
                                                        <i class="fas fa-file-pdf" style="font-size:5em;"></i>
                                                        <div class="attached-docs">
                                                            <p class="mt-1 mb-0" style="white-space: nowrap;" id="pdfFileName">INV001.pdf</p>
                                                            <p class="mb-2" id="pdfFileSize">24.26 KB</p>
                                                        </div>
                                                </div>
                                                </div>
                                                <div class="custom-icon-wrapper-attachment upload-to-attach" id="uploadIcon">
                                                    <label for="fileInput" class="">
                                                        <input type="file" id="fileInput" accept=".pdf">
                                                        <i class="fas fa-paperclip" style="font-size:2em;color:#858796;"></i>
                                                        <div id="fileInfo"></div>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="insert-attachment">
                                                <div class=""></div>
                                            </div>

                                            <div class="mt-2 text-left">
                                                <div class="powered-by py-3">
                                                    <a href="#">Powered by Invoice-system</a>
                                                </div>
                                                <div class="tongle-powered-by-switch d-flex flex-row ">
                                                    <label class="switch">
                                                        <input type="checkbox">
                                                        <span class="slider round"></span>
                                                    </label>
                                                    <p class="ml-3">Include SaTechs footer</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="content-wrapper-right col-lg-4 p-4" style="background-color: white; border-radius: 10px;">
                                            <div class="invoice-data mb-4">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5><strong>Invoice</strong></h5>
                                                    <span class="font-weight-bold"><?php if(!empty($company)) echo $invoice_no?></span>
                                                </div>
                                                <div class="status mb-3">
                                                    <span class="badge badge-secondary">Unsent</span>
                                                </div>
                                                <div class="amount-display d-flex justify-content-between mb-2">
                                                    <p><strong>Total</strong></p>
                                                    <p id="sendSectionTotal">Ksh0.00</p>
                                                </div>
                                                <div class="amount-display d-flex justify-content-between mb-2">
                                                    <p><strong>Paid</strong></p>
                                                    <p id="sendSectionPaid">Ksh0.00</p>
                                                </div>
                                                <div class="amount-display d-flex justify-content-between">
                                                    <p><strong>Balance</strong></p>
                                                    <p id="sendSectionBalance">Ksh0.00</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-sm-12 p-0">
                                                <href="#" class="btn btn-block p-1 mt-5 send-invoice-btn" id="send-invoice-btn" 
                                                    style="text-decoration: none; background-color: #071a26; color: #fff;">
                                                    <span class="fa fa-save fa-fw mr-2"></span>
                                                    Save and Send Invoice
                                                </a>
                                            </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- Footer -->
                <!-- <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
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
                    </div>
                </footer> -->
                <!-- End of Footer -->
            </div>
        </div>
        <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color:black;">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">SATECH INVOICE SYSTEM</h5>
                        <button type="button" class="close" data-dismiss="modal" onclick="closemodal()"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"
                            onclick="closemodal()">Close</button>
                    </div>
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

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" style=" color:#0d0d0d;" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#f5f5f6;">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Reminder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Payment reminders will be sent:</p>
                    <ul>
                        <li>
                            Daily from 7 days before the due date.
                        </li>
                        <li>
                            Daily upto 30 days after due date.
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Got it</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="depositRequestModal" tabindex="-1" aria-labelledby="depositRequestModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="color:#0d0d0d;">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#f5f5f6;">
                    <h5 class="modal-title" id="depositRequestModalLabel">Add Deposit Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php include 'save_deposite_request.php'; ?>
                </div>
            </div>
        </div>
    </div>


    <?php include 'js.php' ?>
    <script>
        
        // Growing text area for item descriptions
       $(document).ready(function() {
            const maxRows = 8;
            const lineHeight = parseInt($('.itemname').css('line-height'));
            const commentLineHeight = parseInt($('.comment').css('line-height'));
            const paymentLineHeight = parseInt($('.payment_instruction').css('line-height'));
            
            // Use event delegation to handle dynamically added elements
            $(document).on('input', '.itemname', function() {
                $(this).css('height', 'auto');
                const scrollHeight = this.scrollHeight;
                const maxHeight = lineHeight * maxRows;
                
                $(this).css('height', Math.min(scrollHeight, maxHeight) + 'px');
            });
            // Growing text area for commet
            $(document).on('input', '.comment', function() {
                $(this).css('height', 'auto');
                const scrollHeight = this.scrollHeight;
                const maxHeight = commentLineHeight * maxRows;

                $(this).css('height', Math.min(scrollHeight, maxHeight) + 'px');
            });

            //  Growing text area for payment instruction
            $(document).on('input', '.payment_instruction', function() {
                $(this).css('height', 'auto');
                const scrollHeight = this.scrollHeight;
                const maxHeight = paymentLineHeight * maxRows;

                $(this).css('height', Math.min(scrollHeight, maxHeight) + 'px');
            });
        });



        function closemodal() {
            $('#previewmodal').modal('hide');
        }

        // start of toggle 
        $(document).ready(function() {
        // Initially hide the "abc" page
            $("#pdfview").hide();

            $("#pdfToggle input[type='checkbox']").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#htmlview").hide();
                    $("#pdfview").show();

                    function removeCurrencySymbol(value) {
                    // Remove the pound sign (Ksh) from the beginning of the string
                        return value.replace(/^Ksh/, '');
                    }

                    // Example usage:
                    var total = $('#total').val();
                    var balance = $('#balance').val();
                    var price = $('#price').val();

                    var cleanTotal = removeCurrencySymbol(total);
                    var cleanBalance = removeCurrencySymbol(balance);
                    console

                    // If you need to update the input field with the clean value:
                    $('#total').val(cleanTotal);
                    $('#balance').val(cleanBalance);

                    var formdatasendget = $('#invoiceform').serialize();
                    var itemsTotal = decodeURI(formdatasendget).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                    formdatasendget += `&totalitems=${itemsTotal}`;
                    // console.log(decodeURI(formdatasendget).split('&'));

                    // return
                    $.ajax({
                    type: 'GET',
                    url: '/pdf-view', 
                    data: formdatasendget,
                    beforeSend: function() {
                        const $loader = $(`
                            <div class="row justify-content-center" style="width: 100%; height: 400px; display: flex; align-items: center;">
                                <div class="col-md-8">
                                    <div id="pdfLoader" style="text-align: center; padding: 20px; display: flex; align-items: center; justify-content: center; flex-direction: column; gap: 1rem;">
                                        <img src="/assets/img/ajax-loader_2.gif" alt="Loading..." />
                                        <p>Generating pdf, please wait...</p>
                                    </div>
                                </div>
                            </div>
                        `);
                        $("#pdfview").html($loader).show();
                    },
                    success: function(response) {
                        
                        // Extract the Base64 encoded PDF data and filename
                        var pdfData = response.pdfData;
                        lobalPdfSize = response.size_in_bytes;
                        globalPdfSizeKB = response.size_in_kb;
                        globalPdfSizeMB = response.size_in_mb;
                        

                        // Create an object URL for the Base64 PDF data
                        var pdfUrl = 'data:application/pdf;base64,' + pdfData;

                        // Add the link to the pdfview div
                        $("#pdfview").html('<iframe src="' + pdfUrl + '" width="100%" height="300%"></iframe><br/>');
                        // $("#pdfview").append(link);
                        
                        // You can also store the data as attributes on the pdfview element
                        // $("#pdfview").attr('data-filename', globalFilename);
                        $("#pdfview").attr('data-filesize', globalPdfSizeKB);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

                    //window.location.href = '/pdf-view';  //alternive way
                } else {
                    $("#htmlview").show();
                    $("#pdfview").hide();
                }
            });
        });

        
        // end of toggle 

        // start of toggle btn add client
        $(document).ready(function(e){
            
            $("#add_client12").click(function(e){
                e.preventDefault(); 
            $("#fetch_client").show();
            $("#add_new_client").show();
            $("#add_client12").hide();
            });
        });

        //delete button
        $(document).ready(function(e){
            
            
            $("#DeleteNewClient").click(function(e){
                e.preventDefault(); 
                $("#fetch_client").show();
                $("#add_new_client").hide();
                $("#add_client12").show();
            });
        });
        
        // save client  button
        $(document).ready(function(e){
            $("#SaveNewClient").click(function(e){
                e.preventDefault(); 

                var image = "/assets/img/ajax-loader_2.gif";

                var formData = {
                    name: $("#autouser").val(),
                    mobile_no: $("#mobile").val(),
                    email: $("#useremail").val(),
                    bill_to: $("#bill_to").val(),
                };
                // console.log(formData);
                // return
                
                $.ajax({
                    type: 'POST',
                    url: '/savenewclient', 
                    data: formData,
                    beforeSend: function () {
                        $("#previewmodal2 .modal-body").html("<img src='" + image +
                        "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;margin-left:30%'><h1> Saving Client Please Wait.</h1></div>"
                        );
                        $("#previewmodal2").modal("show");
                    },
                    success: function(response) {
                        $("#previewmodal2").modal("hide");
                    
                    },
                    error: function(xhr, status, error) {
                        $("#previewmodal2").modal("hide");
                        console.error('Error:', error);
                        alert("An error occurred while saving client details.");
                    }
                });
                $("#fetch_client").show();
                $("#add_new_client").hide();
                $("#add_client12").show();
            });
        });



        $(document).ready(function() {
            $("#btnpreview").on("click", function(e) { 
                e.preventDefault();
                e.stopImmediatePropagation();

                function removeCurrencySymbol(value) {
                    // Remove the pound sign (Ksh) from the beginning of the string
                    return value.replace(/^Ksh/, '');
                }

                // Example usage:
                var total = $('#total').val();
                var balance = $('#balance').val();
                var price = $('#price').val();

                var cleanTotal = removeCurrencySymbol(total);
                var cleanBalance = removeCurrencySymbol(balance);

                // If you need to update the input field with the clean value:
                $('#total').val(cleanTotal);
                $('#balance').val(cleanBalance);

                var image = "/assets/img/ajax-loader_2.gif";

                var dataURLpay = '/preview-at-create-new-invoice';
                var formdatapay = $('#invoiceform').serialize();
                const itemsTotal = decodeURI(formdatapay).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                const dataToSend = `${formdatapay}&totalitems=${itemsTotal}`;
                // console.log(decodeURI(dataToSend).split('&'));
                
                // return
                $.ajax({
                    type: 'GET',
                    url: dataURLpay,
                    data: dataToSend,
                    cache: false, 
                    success: function(data) {
                        $('.invoicePreviewpdF').html(data.html);                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX request failed:', textStatus, errorThrown);
                        alert('Error: ' + textStatus + ': ' + errorThrown);
                    }
                });
                // Capture values to be populated
                var total = $("#total").val();
                var paid = $("#paid").val();
                var balance = $("#balance").val()

                // right handside values
                // Update the Total
                var totalValue = total !== '' ? total : "0.00";
                $('#previewRightTotal').text(totalValue);

                // Update the Paid
                var paidValue = paid !== '' ? paid : "0.00";
                $('#previewRightPaid').text("Ksh" + paidValue);

                // Update the Balance
                var balanceValue = balance !== '' ? balance : "Ksh0.00";
                $('#previewRightBalance1').html(`<strong>Ksh${balanceValue}</strong>`);
                
                // show preview div and hide the rest
                $('#createform').hide();
                $('#preview').show();
                $('#sendinvoice').hide()

                // make preview button active
                $('#createbtn').removeClass('active');
                $('#btnpreview').addClass('active');
                $('#btnsend').removeClass('active')
            });

            $("#createbtn").on("click", function(e) { 
                // show 'create form' div and hide the rest
                $('#createform').show();
                $('#preview').hide();
                $('#sendinvoice').hide()

                // make create button active
                $('#createbtn').addClass('active');
                $('#btnpreview').removeClass('active');
                $('#btnsend').removeClass('active')
            });

            // BUTTON SEND 
            $("#btnsend").on("click", function(e) { 
                //show send div and hide the rest
                $('#createform').hide();
                $('#preview').hide();
                $('#sendinvoice').show()

                // make send button active
                $('#createbtn').removeClass('active');
                $('#btnpreview').removeClass('active');
                $('#btnsend').addClass('active')

                const invoiceClientEmail =$('#useremail').val();
                $("#sendInvoiceto").val(invoiceClientEmail);
                
                var sendSectionTotal =$('#total').val();
                var sendSectionTotalValue = sendSectionTotal !== '' ? sendSectionTotal : "Ksh0.00";            
                $("#sendSectionTotal").text(sendSectionTotalValue);

                var sendSectionPaid =$('#paid').val();
                var sendSectionPaidValue = sendSectionPaid !== '' ? sendSectionPaid : "0.00";            
                $("#sendSectionPaid").text(`Ksh${sendSectionPaidValue}`);            

                var sendSectionBalance =$('#balance').val();
                var sendSectionBalanceValue = sendSectionBalance !== '' ? sendSectionBalance : "Ksh0.00";            
                $('#sendSectionBalance').html(`<strong>${sendSectionBalanceValue}</strong>`);

                function removeCurrencySymbol(value) {
                    // Remove the pound sign (Ksh) from the beginning of the string
                    return value.replace(/^Ksh/, '');
                }

                // Example usage:
                var total = $('#total').val();
                var balance = $('#balance').val();
                var price = $('#price').val();
                console.log(price);

                var cleanTotal = removeCurrencySymbol(total);
                var cleanBalance = removeCurrencySymbol(balance);

                // If you need to update the input field with the clean value:
                $('#total').val(cleanTotal);
                $('#balance').val(cleanBalance);



                // $('#uploaded-attachment')
                var formdatasendget = $('#invoiceform').serialize();
                var itemsTotal = decodeURI(formdatasendget).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                formdatasendget += `&totalitems=${itemsTotal}`;
                // console.log(decodeURI(formdatasendget).split('&'));
                // return

                $.ajax({
                    type: 'GET',
                    url: '/pdf-view', 
                    data: formdatasendget,

                    success: function(response) {
                        // Extract the Base64 encoded PDF data and filename
                        var filename = response.filename;
                        var lobalPdfSize = response.size_in_bytes;
                        var globalPdfSizeKB = response.size_in_kb;
                        var globalPdfSizeMB = response.size_in_mb;

                        // Update the filename and file size in the HTML
                        $('#pdfFileName').text(filename);  // Update the filename text
                        $('#pdfFileSize').text(globalPdfSizeKB + ' KB');  // Update the file size text in KB
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

                // UPLOAD OTHER SUPPORT DOCS
                const fileInput = $('#fileInput');
                const uploadedFiles = $('#uploadedFiles');
                const fileInfo = $('#fileInfo');

                function formatBytes(bytes, decimals = 2) {
                    if (bytes === 0) return '0 Bytes';

                    const k = 1024;
                    const dm = decimals < 0 ? 0 : decimals;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];

                    const i = Math.floor(Math.log(bytes) / Math.log(k));

                    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
                }

                function getFileIcon(fileName) {
                    const extension = fileName.split('.').pop().toLowerCase();
                    let iconClass = 'fa-file';
                    
                    switch(extension) {
                        case 'pdf':
                            iconClass = 'fa-file-pdf';
                            break;
                        case 'doc':
                        case 'docx':
                            iconClass = 'fa-file-word';
                            break;
                        case 'txt':
                            iconClass = 'fa-file-alt';
                            break;
                    }
                    
                    return iconClass;
                }

                function createFileElement(file) {
                    const fileId = 'file-' + Math.random().toString(36).substr(2, 9);
                    const iconClass = getFileIcon(file.name);
                    
                    const $element = $(`
                        <div id="${fileId}" class="uploaded-attachment">
                            <i class="fas ${iconClass}" style="font-size: 2em; color: #6c757d;"></i>
                            <div class="attached-docs">
                                <p class="file-name">${file.name}</p>
                                <p class="file-size">${formatBytes(file.size)}</p>
                            </div>
                            <button class="remove-file" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `);

                    $element.find('.remove-file').on('click', function() {
                        $element.fadeOut(300, function() {
                            $(this).remove();
                        });
                    });

                    return $element;
                }

                fileInput.on('change', function(event) {
                    const files = event.target.files;
                    
                    if (files.length > 0) {
                        $.each(files, function(i, file) {
                            const $fileElement = createFileElement(file);
                            uploadedFiles.append($fileElement);
                        });
                        
                        // Clear input to allow uploading the same file again
                        fileInput.val('');
                    }
                });
            }); 
        });

        // SAVE INVOICE
        $(document).ready(function() {
            const $form = $('#invoiceform');
            const $btnSave = $('#btnsave');
            const $previewModal = $('#previewmodal');

            $btnSave.on('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                $btnSave.prop('disabled', true);

                updateCurrencyFields();

                if (!validateForm()) {
                    $btnSave.prop('disabled', false);
                    return;
                }

                saveInvoice();
            });

            function updateCurrencyFields() {
                ['#balance', '#total'].forEach(field => {
                    const $field = $(field);
                    $field.val(parseCurrency($field.val()));
                });
            }

            function parseCurrency(value) {
                return parseFloat(value.replace(/[^0-9.-]+/g, ''));
            }

            function validateForm() {
                const requiredFields = ['#duedate', '#autouser', '#mobile', '#useremail', '#bill_to'];
                const errorMessages = [
                    'Due date required!',
                    'Client Name Required!',
                    'Mobile Number Required!',
                    'Email Address Required!',
                    'Billing Address Required'
                ];

                for (let i = 0; i < requiredFields.length; i++) {
                    if ($(requiredFields[i]).val() === '') {
                        alert(errorMessages[i]);
                        return false;
                    }
                }

                return true;
            }

            function saveInvoice() {
                const formData = $('#invoiceform').serialize();
                const itemsTotal = decodeURI(formData).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                const dataToSend = `${formData}&totalitems=${itemsTotal}`;
                // console.log();
                
                // return;
                $.ajax({
                    type: 'POST',
                    url: '/saveInvoice',
                    data: dataToSend,
                    cache: false,
                    beforeSend: showLoadingModal,
                    success: handleSuccess,
                    error: handleError
                });
            }

            function showLoadingModal() {
                const loadingContent = `
                    <img src="/assets/img/ajax-loader_2.gif" style="margin-top:1%;margin-left:50%" />
                    <div style="margin-top:6%; text-align: center">
                        <h1>Saving invoice, please wait...</h1>
                    </div>`;
                $previewModal.find('.modal-body').html(loadingContent);
                $previewModal.modal('show');
            }

            function handleSuccess(data) {
                $previewModal.modal('hide');
                window.location.href = '/InvoiceList';
            }

            function handleError(jqXHR, textStatus, errorThrown) {
                alert(`Error: ${textStatus}: ${errorThrown}`);
            }
        });
        // END OF SAVING INVOICE

        $(document).on("click", "#btnprint", function(e) {
            var image = "/assets/img/ajax-loader_2.gif";
            e.preventDefault();
            e.stopImmediatePropagation();
            $("#btnprint").prop("disabled", false);
            var dataURLpay = '/Printinvoice';
            var formdatasendget = $('#invoiceform').serialize();
            $.ajax({
                type: 'GET',
                url: dataURLpay,
                data: formdatasendget,
                success: function(data) {
                    
                    if (data) {
                        window.open("/Printinvoice" + '?' + formdatasendget,
                            "_blank"); // site.com/controller/Details
                    }
                    // $(".modal-body").html(data);
                    // $("#previewmodal").modal("show");
                    // $(".message").html(data);               

                },
                error: function(jqXHR, te0xtStatus, errorThrown) {
                    alert('error: ' + textStatus + ': ' + errorThrown);
                }
            })
            
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
            var clientname = $("#clientnamecheck").val();
            var mobileno = $("#mobileno").val();
            var emailadd = $("#emailaddcheck").val();
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
            var x = document.getElementById("itemsdiv");
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
            var costprice = $("costprice").val();
            $("#summaryitemname").val(itemname);
            $("#summaryitemdescription").val(itemdescription);
            $("#summaryquantity").val(quantity + ' x ' + price);
            $("#summarytotalprice").val(totalprice);
        }

        $(document).ready(function() {
                var i = 0;
                var j = 1;

            // function to calcultae the sum of total, costprice, profit values
            function calculateTotalSum() {
                var totalSum = $('.totalprice').toArray().reduce((sum, el) => sum + (parseFloat($(el).val()) || 0), 0);
                $('#subtotal').val(totalSum.toFixed(2));
                $('#total').val(totalSum.toFixed(2));
                $('#balance').val(totalSum.toFixed(2));
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


            
            // Function to initialize autocomplete
            function initAutocomplete(selector) {
                $(selector).autocomplete({
                    source: function(request, response) {
                        // Fetch data from server using AJAX
                        $.ajax({
                            url: "/invoiceItemauto", // Replace with your endpoint
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
                        var parent = itemElement.closest('.oddRow');
                        // Set selection
                        itemElement.val(ui.item.label);
                        parent.find('.price').val(ui.item.rate);
                        parent.find('.costprice').val(ui.item.cost_price);
                        // parent.find('.netprice').val(ui.item.cost_price); // Update net price section

                        // Calculate total price
                        var quantity = parseInt(parent.find('.quantity').val()) || 1;
                        var rate = parseInt(ui.item.rate);
                        var total_price = quantity * rate;
                        parent.find('.totalprice').val(total_price.toFixed(2));

                        // update the other fields with the autocomplete values
                        $('#total').val('Ksh' + total_price);
                        $('#balance').val('Ksh' +total_price);

                        // Calculate and update the total and costprice sum of all total prices
                        calculateTotalSum();
                        calculateCostpriceSum();
                        calculateProfit();
                        return false;
                    }
                });
            }

            $(document).on('click', '#add', function(e) {
            e.preventDefault();
            i++;
            j++;
            $('#itemsdiv').append(
                '<div class="oddRow col-sm-12" style="background-color: #ffffff;" id="row' + i + '">' +
                    '<div class="form-group row " style="margin-top:20px;">'+
                        '<textarea class="form-control itemname mt-2" required cols="15" rows="2"  name="itemname[]" id="itemname' +i +
                            '" placeholder="Item Description" style=" border-right: none; border-left: none; border-top: none;">'+
                        '</textarea>'+
                    '</div>'+
                    

                    '<div class="form-group row">'+
                        '<div class="col-sm-2" style="padding: 0;">'+
                            '<label for="quantity' + i + '" class="col-sm-12 col-form-label pl-0" style="color:#777;">Quantity</label> '+
                            '<input type="number" class="form-control col-sm-12" oninput="quantitychange(this.value,this.id)" name="quantity[]" data-id="' +
                                i + '" id="quantity' + i +
                            '" placeholder="" value="1" style=" border-right: none; border-left: none; border-top: none;">'+
                        '</div>'+

                        '<div class="col-sm-1" style="padding: 0;">'+
                            '<span class="p-2" style="display: flex; height: 100%; justify-content: center; align-items: end;" style="color:#777;">x</span>'+
                        '</div>'+

                        '<div class="col-sm-3" style="padding: 0;">'+
                            '<label for="rate' + i + '" class="col-sm-12 col-form-label pl-0" style="color:#777;">Rate</label>'+
                                '<input type="text" class="form-control price" name="price[]" oninput="pricechange(this.value,this.id)" data-id="' +
                                i + '" id="price' + i +
                                '" placeholder="0.00">'+
                        '</div>'+

                        '<div class="col-sm-3">'+
                            '<label for="total_price' + i + '" class="col-sm-12 col-form-label pl-0" style="color:#777;">Total Price</label> '+
                                '<input type="text" class="form-control totalprice" readonly="readonly" name="totalprice[]" id="totalprice' +
                                i +
                                '" placeholder="Total" value="0.00">'+
                        '</div>'+

                        '<div class="col-sm-3" style="padding: 0;">'+
                            '<label for="cost_price' + i + '" class="col-sm-12 col-form-label pl-0" style="color:#777;">Cost Price</label>'+
                                '<input type="number" class="form-control costprice" name="costprice[]" id="costprice' +
                                i + '" placeholder="0.00" oninput="updateNetPrice(this.value, this.id)">'+
                        '</div>'+
                    '</div>'+
                    
                    // the save and cancel if not in db
                    '<div class="saveNewItem" style="float: right; display: none;">' +
                        '<button type="button" class="cancelSaveButton" id="cancelSaveButton' + i + '"' +
                            'style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px; margin-right: 4px;">Cancel' +
                        '</button>' +
                        '<button type="button" class="saveNewItemAtInvoiceCreation" id="saveNewItemAtInvoiceCreation' + i + '"' +
                            'style="background-color: #5a5c69; color: #ffffff; border: none; border-radius: 4px; padding: 4px 10px 4px 10px;">Save New Item' +
                        '</button>' +
                    '</div>' +
                    
                    '<div >'+
                        '<button type="button" name="remove" id="' +
                        i +
                        '" class="btn btn-danger btn_remove" style="border-right: none; border-left: none; border-top: none;">X</button>'+
                    '</div>'+
                '</div>'
            );
            // Initialize autocomplete for the newly added textarea
            initAutocomplete('#itemname' + i);
        });

        // Initialize autocomplete for existing textareas on page load
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
                $('#subtotal').val(newSubtotal);
                $('#total').val(newSubtotal);
                $('#balance').val(newBalance);
                $('#netprice').val(newcostprice);
                $('#profitDisplay').val(newProfitLoss);

                $('#row' + button_id + '').remove();

            });
        });

        function additemdiv() {
            var myDiv = document.getElementById("itemsmul");
            var myDiv2 = document.getElementById("itemsmulsummary");
            // console.log('cloning');
            document.getElementById("itemsdiv").appendChild(myDiv.cloneNode(true));
            document.getElementById("summaryitem").appendChild(myDiv2.cloneNode(true));
        }

        function showitems() {
            var x = document.getElementById("itemsdiv");
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
            minDate: new Date(),
        });
        $("#duedate").datepicker("setDate", new Date());
        $("#invoicedate").datepicker({
            dateFormat: "dd/mm/yy",
            minDate: new Date(),
            maxDate: new Date(),
        });
        $("#invoicedate").datepicker("setDate", new Date());

        // upadete due date automatically
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

        //update terms automatcally
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
        
        function calculateProfitLoss() {
        var total = parseFloat($("#total").val().replace('Ksh', ''));
        var netPrice = parseFloat($("#netprice").val());
        var profitLoss = total - netPrice;
        $("#profitDisplay").val(profitLoss.toFixed(2));
        }
        // end of profit calculation

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
                        location.reload();
                        // console.log('Response:', response);
                    },
                    error: function(xhr, status, error) {
                        // An error occurred while processing the AJAX request
                        console.error('Error:', error);
                    }
                });
            }

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
                $('#autouser').val(ui.item.label); 
                $('#userid').val(ui.item.value); 
                $('#mobile').val(ui.item.mobile);
                $('#useremail').val(ui.item.email);
                $('#bill_to').val(ui.item.bill_to);
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
                $('#autouser2').val(ui.item.label);               
                $('#usermobile').val(ui.item.mobile);
                $('#useremail2').val(ui.item.email);
                $('#address').val(ui.item.address);
                return false;
            }
        });

        //item descritption auto completion
        $("#itemname").autocomplete({
            source: function(request, response) {
                // Fetch data
                $.ajax({
                    url: "/invoiceItemauto",
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                success: function(data) {
                    response(data);
                        if (data.length === 0) {
                            // No matches found, show the save button
                            $("#saveNewItemAtInvoiceCreation").show();
                            $("#cancelSaveButton").show();
                            $(".saveNewItem").show();
                        } else {
                            // Matches found, hide the save button
                            $("#saveNewItemAtInvoiceCreation").hide();
                            $("#cancelSaveButton").hide();
                            // $(".saveNewItem").hide();
                        }
                    }
                });
            },
            select: function(event, ui) {
                console.log(ui);
                // Set selection
                var label = ui.item.label;
                var rate = parseFloat(ui.item.rate).toFixed(2);
                var cost_price = parseFloat(ui.item.cost_price).toFixed(2);
                $('#itemname').val(label); 
                $('#price').val(rate); 
                $('#costprice').val(cost_price);
                $('#netprice').val(cost_price); 
                $('#originalCostprice').val(cost_price); 

                var quantity = parseInt($('#quantity').val()) || 1;
                var rate = parseFloat(ui.item.rate).toFixed(2);
                var total_price = quantity * rate;

                $('#totalprice').val(total_price);
                $('#subtotal').val(total_price);
                $('#total').val('Ksh' + total_price);
                $('#balance').val('Ksh' +total_price);
                
                var profit_loss = total_price -  cost_price;
                $('#profitDisplay').val(profit_loss);


                return false;
            }
        });
        // end of add item autocomplte

        // Event delegation for dynamically added save buttons
        $(document).on('click', '.saveNewItemAtInvoiceCreation', function(e) {
            e.preventDefault();
            var rowId = $(this).closest('.oddRow').attr('id');
            var itemDescription = $("#" + rowId + " .itemname").val();
            var rate = $("#" + rowId + " .price").val();
            var cost = $("#" + rowId + " .costprice").val();
            // console.log(cost);

            if (!itemDescription || !rate ) {
                alert("Please make sure Item Description and  Rate fields are filled out.");
                return;
            }

            var formData = {
                Item_description: itemDescription,
                quantity: $("#" + rowId + " .quantity").val() || 1,
                rate: rate,
                cost: cost,
            };

            $.ajax({
                type: 'POST',
                url: '/saveNewItem',
                data: formData,
                dataType: "json",
                encode: true,
                beforeSend: function () {
                    // Show loading modal
                    $("#previewmodal2 .modal-body").html("<img src='/assets/img/ajax-loader_2.gif' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;margin-left:30%'><h1> Saving Item Please Wait.</h1></div>");
                    $("#previewmodal2").modal("show");
                },
                success: function(response) {
                    $("#previewmodal2").modal("hide");
                    $("#" + rowId + " .saveNewItem").hide();
                },
                error: function(xhr, status, error) {
                    $("#previewmodal2").modal("hide");
                    console.error('Error:', error);
                    var response = xhr.responseJSON;
                    if (response && response.message) {
                        alert(response.message);
                    } else {
                        alert('An unexpected error occurred.');
                    }
                }
            });
            $(this).hide();
            $(".cancelSaveButton").hide();
        });

        // Event delegation for dynamically added cancel buttons
        $(document).on('click', '.cancelSaveButton', function() {
            var rowId = $(this).closest('.oddRow').attr('id');
            // console.log(rowId);
            // $("#" + rowId + " .itemname").val('');
            // $("#" + rowId + " .quantity").val(1);
            // $("#" + rowId + " .price").val('');
            // $("#" + rowId + " .totalprice").val('');
            // $("#" + rowId + " .costprice").val('');
            $("#" + rowId + " .saveNewItem").hide();
        });
        //  end of the save button for rew item
        
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
        
        //    QUANTITY CHANGE

        $("#discount").on("input", function() {
            var discount = $("#discount").val();
            var paid = $("#paid").val();
            var costpricetotal = $("#netprice").val();

            let newsubtotal = $("#subtotal").val();
            
            var newtotal = newsubtotal - discount;
            var newbalance = (newsubtotal - paid) - discount;
            var newProfitLoss = newtotal - costpricetotal;
            
            $("#total").val(newtotal.toFixed(2));
            $("#balance").val(newbalance.toFixed(2));
            $("#profitDisplay").val(newProfitLoss.toFixed(2));


        });
        $("#paid").on("input", function() {
            var discount = $("#discount").val();
            var paid = $("#paid").val().replace('Ksh', '');

            let newsubtotal = $("#subtotal").val();
            $("#balance").val(((newsubtotal - paid) - discount).toFixed(2));

        });

        // // First, declare a variable outside the function to store the original cost price
        // var originalCostPrices = {};

        // function quantitychange(value, id) {
        //     var i = id.split('quantity');
        //     i = i[1];
        //     var subtotal = 0;
        //     var valueprice = 0;
        //     var valuesplit = '';
        //     var rate = $("#price" + i).val();
        //     var quantity = $("#quantity" + i).val();
        //     var totalprice = value * rate;
        //     var costprice = parseInt($('#costprice'+i).val()) || 0;
        //     var totalcostprice = 0;
        //     var total = parseInt($('#total').val().split('Ksh')[1]);
        //     var netprice = parseInt($('#netprice').val()) || 0;
        //     var discount = $("#discount").val();
        //     var paid = $("#paid").val();

        //     // Store the first cost price value if it hasn't been stored yet
        //     if (!originalCostPrices[i]) {
        //         originalCostPrices[i] = costprice;
        //     }
        //     // Use the original stored cost price for calculations
        //     costprice = originalCostPrices[i];
            
        //     $("#totalprice" + i).val(value * rate);

        //     var x = document.getElementsByClassName('totalprice');

        //     for (let r = 0; r < x.length; r++) {
        //         totalcostprice = totalcostprice + costprice;
        //         valueprice = x[r].value;
        //         let pricehere = parseInt(0);
        //         if (valueprice == 0) {
        //             pricehere = parseInt(valueprice);
        //         } else {
        //             valuesplit = valueprice.split('Ksh');
        //             pricehere = parseInt(valuesplit[1]);

        //             if (valuesplit.length == 1) {
        //                 pricehere = parseInt(valueprice);
        //             }
        //         }
        //         subtotal += pricehere;
        //         console.log("subtotal", );
        //     }
        //     $("#subtotal").val(subtotal);
        //     $("#total").val('Ksh' + ((subtotal) - discount));
        //     $("#balance").val('Ksh' + ((subtotal - paid) - discount));
            
        //     var subtotal = parseFloat($("#subtotal").val()) || 0;
        //     var costPrice = parseFloat($("#netprice").val()) || 0;

        //     var total = subtotal - discount;
        //     var balance = total - paid;
        //     var profitLoss = total - costPrice;

        //     $("#subtotal").val(subtotal);
        //     $("#total").val(((subtotal) - discount));
        //     $("#balance").val(((subtotal - paid) - discount));
        //     newcostprice = quantity * costprice;
        //     $("#costprice").val(newcostprice);
        //     $("#netprice").val(newcostprice);

        //     // console.log("Value of costprice", cosprice1);
        //     $('#profitDisplay').val(total - newcostprice); 
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
            var total = parseFloat($('#total').val().replace('Ksh', '')) || 0;
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
                    // Handle cases where the value might or might not have a Ksh symbol
                    valuesplit = valueprice.toString().split('Ksh');
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

        //     var i = id.split('price');
        //     i = i[1];

        //     var x = document.getElementsByClassName('costprice');
        //     // console.log(x.length)
            
        //     var totalcostprice = 0;
        //     var costprice = ($('costprice' + i).val()) || 0;  //new
        //     // console.log(costprice);
            
        //     for (let r = 0; r < x.length; r++) {
        //         valueprice = x[r].value;
                
        //         let pricehere = parseInt(0);
        //         if (valueprice == 0) {
        //             pricehere = parseInt(valueprice);
        //         } else {
        //             valuesplit = valueprice.split('Ksh');
        //             pricehere = parseInt(valuesplit[1]);
        //             if (valuesplit.length == 1) {
        //                 pricehere = parseInt(valueprice);
        //             }
        //         }
        //         totalcostprice += pricehere || 0;
        //     }
        //     $('#netprice').val(totalcostprice)

        //     var total = parseInt($("#total").val()) || 0;
        //     var profitLoss = total - totalcostprice;
            
        //     $("#profitDisplay").val(profitLoss.toFixed(2));
        // }
    
        // ============================================


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
                    if (rowValue.includes('Ksh')) {
                        rowValue = rowValue.replace('Ksh', '');
                    }
                    pricehere = parseFloat(rowValue) || 0;
                }
                
                // Multiply by quantity for this row
                totalcostprice += pricehere * rowQuantity;
            }
            
            // Update net price with total cost price
            $('#netprice').val(totalcostprice.toFixed(2));
            
            // Get the current total (removing currency symbol if present)
            var total = parseFloat($("#total").val().replace('Ksh', '')) || 0;
            
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
        var costprice = $('costprice' + i).val();  
        var discount = $("#discount").val();
        var paid = $("#paid").val();
    
        $("#totalprice" + i).val((quantity * value).toFixed(2));
        
        for (let r = 0; r < x.length; r++) {
            valueprice = x[r].value;

            let pricehere = parseInt(0);
            if (valueprice == 0) {
                pricehere = parseInt(valueprice);
            } else {
                valuesplit = valueprice.split('Ksh');
                pricehere = parseInt(valuesplit[1]);

                if (valuesplit.length == 1) {
                    pricehere = parseInt(valueprice);

                }
            }

            subtotal += pricehere;
        }

        $("#subtotal").val(subtotal);
        $("#total").val(((subtotal) - discount));
        $("#balance").val(((subtotal - paid) - discount));

        var subtotal = parseFloat($("#subtotal").val()) || 0;
        var costPrice = parseFloat($("#netprice").val()) || 0;

        var total = subtotal - discount;
        var balance = total - paid;
        var profitLoss = total - costPrice;

        $("#total").val(total.toFixed(2));
        $("#balance").val(balance.toFixed(2));
        $("#profitDisplay").val( profitLoss.toFixed(2));

        }
    

        //receive data from the invoice list
        $(document).ready(function() {
            // Retrieve invoiceId from URL parameter
            var urlParams = new URLSearchParams(window.location.search);
            var invoiceId = urlParams.get('invoiceId');

            // Make AJAX call to retrieve invoice data
            $.ajax({
                url: '/getsingleinvoice',
                type: 'POST',
                data: { invoiceId: invoiceId },
                success: function(response) {
                    // console.log('response', response);

                    // Populate the fields with retrieved data
                    $('#useremail').val(response.invoice.email);
                    $('#invoicedate').val(response.invoice.invoice_date);
                    $('#previewTerms').val(response.invoice.terms);
                    $('#duedate').val(response.invoice.due_date);

                    var items = response.items;
                    // console.log('ITEMS', items);
                    for (var i = 0; i < items.length; i++) {
                        var item = items[i];
                        // console.log(item);
                        // Populate corresponding HTML elements with item data
                        $('#itemname' + i).val(item.itemname);
                        $('#quantity' + i).val(item.quantity);
                        $('#price' + i).val(item.price);
                        $('#totalprice' + i).val(item.totalprice);
                        $('#costprice' + i).val(item.costprice);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });


        // deposite request
        $('#add-request-link').click(function(e) {
            let Bal = $("#balance").val();
            let duedate = $("#duedate").val();
            
            Bal = Bal ? Bal : 'Ksh0.00';
            duedate = duedate;
            $('#depositRequestModal').modal('show');
            $('#depositRequestModal #invoiceBalance').text(Bal);
            $('#depositRequestModal #due_date').val(duedate);
        });


        // send payment reminders
        $('#payment-reminder').click(function(e){
            e.preventDefault();
        });

        // paymentReminder
        $('#paymentReminder').click(function() {
            var checkbox = $(this);
            var newValue = checkbox.is(':checked') ? 'on' : 'off';
            checkbox.val(newValue);
        });

        // SAVING AND SENDING INVOICE DURING CREATION
        $(document).ready(function() {
            const $form = $('#invoiceform');
            const $sendInvoiceBtn = $('#send-invoice-btn');
            const $btnSave = $('#btnsave');
            const $previewModal = $('#previewmodal');

            $sendInvoiceBtn.on('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                $btnSave.prop('disabled', true);

                updateCurrencyFields();

                if (!validateForm()) {
                    $btnSave.prop('disabled', false);
                    return;
                }

                sendInvoice();
            });

            function updateCurrencyFields() {
                ['#balance', '#total'].forEach(field => {
                    const $field = $(field);
                    $field.val(parseCurrency($field.val()));
                });
            }

            function parseCurrency(value) {
                return parseFloat(value.replace(/[^0-9.-]+/g, ''));
            }
            
            function validateForm() {
                const requiredFields = ['#duedate', '#autouser', '#mobile', '#useremail'];
                const errorMessages = [
                    'Due date required!',
                    'Client Name Required!',
                    'Mobile Number Required!',
                    'Email Address Required!',
                    // 'Billing Address Required'
                ];

                for (let i = 0; i < requiredFields.length; i++) {
                    if ($(requiredFields[i]).val() === '') {
                        alert(errorMessages[i]);
                        return false;
                    }
                }

                return true;
            }

            function sendInvoice() {

                function removeCurrencySymbol(value) {
                    // Remove the pound sign (Ksh) from the beginning of the string
                    return value.replace(/^Ksh/, '');
                }

                // Example usage:
                var total = $('#total').val();
                var balance = $('#balance').val();

                var cleanTotal = removeCurrencySymbol(total);
                var cleanBalance = removeCurrencySymbol(balance);

                // If you need to update the input field with the clean value:
                $('#total').val(cleanTotal);
                $('#balance').val(cleanBalance);

                const formData = $('#invoiceform').serialize();
                const itemsTotal = decodeURI(formData).split('&').map(item => item.split('=')[0]).filter(item => item === 'quantity[]').length;
                const dataToSend = `${formData}&totalitems=${itemsTotal}`;
                // console.log(dataToSend);
                
                // return;
                $.ajax({
                    type: 'POST',
                    url: '/send-invoice-at-creation',
                    data: dataToSend,
                    cache: false,
                    beforeSend: showLoadingModal,
                    success: handleSuccess,
                    error: handleError
                });
            }

            function showLoadingModal() {
                const loadingContent = `
                    <img src="/assets/img/ajax-loader_2.gif" style="margin-top:1%;margin-left:50%" />
                    <div style="margin-top:6%; text-align: center;">
                        <h1>Saving and sending invoice, please wait.</h1>
                    </div>`;
                $previewModal.find('.modal-body').html(loadingContent);
                $previewModal.modal('show');
            }

            function handleSuccess(data) {
                // console.log(data);
                // $previewModal.modal('hide');
                $(".modal-body").html(
                    "<div style='margin-top:6%; text-align: center'> </i> <h1> Mail Sent Successfully.</h1></div>"
                );
                $("#previewmodal").modal("show");
                window.location.href = '/InvoiceList';
            }

            function handleError(jqXHR, textStatus, errorThrown) {
                alert(`Error: ${textStatus}: ${errorThrown}`);
            }
        });
        // END OF SAVING AND SENDING INVOICE DURING CREATION
    </script>
</body>
</html>
