<!-- <php include ?> -->
    <style>
        #descriptionTable th {
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
            text-align: left;
            background-color: #fff;
            color:  #000;
            font-size: 1rem;
        }
         #descriptionTable td {
            padding-top: 0.4rem;
            padding-bottom: 0.4rem;
            text-align: left;
            background-color: #fff;
            color:  #000;
            font-size: 1rem;
        }
    </style>

<div class="invoice-details p-2 " style="width:100%;">
    <h3>Invoice Details</h3>
    <?php if(isset($transactions) && is_object($transactions)): ?>
    <table class="table table-bordered" id="descriptionTable">
        <tr>
            <th>Invoice Number</th>
            <td><?php echo $transactions->invoice_no; ?></td>
        </tr>
        <tr>
            <th>Client Name</th>
            <td><?php echo $transactions->client_name; ?></td>
        </tr>
        <tr>
            <th>Invoice Date</th>
            <!-- <td><php echo $transactions->invoice_date ?></td> -->
            <td>
                <?php 
                    $date_string = $transactions->invoice_date;
                    
                    // Convert the date
                    $timestamp = strtotime(str_replace('/', '-', $date_string));
                    
                    if ($timestamp === false) {
                        // If conversion fails, show original value
                        echo $date_string;
                    } else {
                        // Format the date
                        echo date('F j, Y', $timestamp);
                    }
                ?>
            </td>
        </tr>
            <th>Due Date</th>
            <!-- <td><php echo $transactions->due_date ?></td> -->
            <td>
                <?php 
                    $date_string = $transactions->due_date;
                    
                    // Convert the date
                    $timestamp = strtotime(str_replace('/', '-', $date_string));
                    
                    if ($timestamp === false) {
                        // If conversion fails, show original value
                        echo $date_string;
                    } else {
                        // Format the date
                        echo date('F j, Y', $timestamp);
                    }
                ?>
            </td>
        </tr>
        <tr>
            <th>Total Amount</th>
            <td><?php echo $transactions->total; ?></td>
        </tr>
        <tr>
            <th>Paid Amount</th>
            <td><?php echo $transactions->paid; ?></td>
        </tr>
        <tr>
            <th>Balance</th>
            <td><?php echo $transactions->balance; ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo $transactions->status; ?></td>
        </tr>
    </table>
    <?php else: ?>
    <p>No invoice details available.</p>
    <?php endif; ?>
</div>

<div class="paymentsummary-table p-2" style="margin-top:20px; width:100%;">
    <h3>Payment History</h3>
    <table class="display" id="paymentsummary-table" style="width:100%">
        <thead>
            <tr>
                <th>Payment Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Payment Instruction</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($transactionHistory) && is_array($transactionHistory)): ?>
                <?php foreach($transactionHistory as $history): ?>
                    <tr> 
                        <td><?php echo date('d/m/Y', strtotime($history->created_at)) ?></td>
                        <td><?php echo isset($history->amount) ? $history->amount : 'N/A'; ?></td>
                        <td><?php echo isset($history->method) ? $history->method : 'N/A'; ?></td>
                        <td><?php echo $history->details; ?></td>
                        <td><a href="#" paymentid="<?php echo $history->id ?>" class="edit fa fa-pencil text-primary" id="modify"> Modify</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No payment history available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="editpayment" role="dialog">
    <div class="modal-dialog modal-xs">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background: #cecccc2b;">
                <h6 class="modal-title">Modify Payment</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            </div>            
        </div>
    </div>
</div>

<script>
    // Define the function in the global scope
    function closemodaleditpay() {
        $('#editpayment').modal('hide');
    }

    $(document).ready(function() {
        $('#paymentsummary-table').DataTable({
            "scrollX": true,
            "order": [[0, "desc"]]
        });

        $(document).on("click", ".edit", function(e) {
            e.preventDefault();
            var paymentid = $(this).attr("paymentid");
            $.ajax({
                method: "get",
                url: "/editpayment",
                data: {
                    paymentid: paymentid
                },
                success: function(bk) {
                    $(".overlay1").hide();
                    $("#editpayment .modal-body").html(bk);
                    $("#editpayment").modal("show");
                }
            });
        });

        $(document).on("submit", "#editPaymentForm", function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var invoiceId = <?php echo json_encode($transactions->id);?>;

            // You can append the invoiceId to the serialized form data
            formData += '&invoiceId=' + invoiceId;
            // console.log(invoiceId);
            // return
            $.ajax({
                method: "post",
                url: "/updatepayment",
                data: formData,
                success: function(response) {
                    console.log(response);
                    // alert();
                    $("#editpayment").modal("hide");
                    // // Reload the page or update the table row
                    location.reload();
                },
                error: function() {
                    alert("An error occurred while updating the payment");
                }
            });
        });
    });
</script>