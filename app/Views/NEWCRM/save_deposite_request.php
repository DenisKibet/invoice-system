<?php include 'css.php' ?>
<style>
    .requestTitle {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }
    .requestTitle p {
        margin: 0;
    }
    .setDepositeAmount {
        display: flex;
        justify-content: space-between;
        width: 80%;
        margin: 20px auto;
        border-bottom: 2px solid #d7d7db; /
}
    /* .setDepositeAmount p {
        margin: 0 0 0 10px;
    } */
    .setPercentage {
        display: flex;
        align-items: center;
        margin: 20px auto;
    }
    .setPercentage p {
        margin: 0 10px 0 0; /* Adjust spacing between text and input */
    }

    /* input[type="text"] {
        border: none;
        width: 100%;
    }
    input[type="text"]:focus {
        outline: none;
        border: none;
        border-bottom: 1px solid #3333ff !important;
    } */

    /*  Input number */
    input[type="number"]:focus {
        outline: none;
        border: none;
        <!-- border-bottom: 1px solid #3333ff !important; -->
    }

    input[type="number"] {
    -webkit-appearance: textfield;
        -moz-appearance: textfield;
            appearance: textfield;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none;
    }

    #DepositeRequest:disabled {
        cursor: not-allowed;        
        /* cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" style="animation: spin 2s linear infinite;"><circle cx="12" cy="12" r="10" fill="red"/></svg>'), auto; */
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }
</style>


<div class="container">
    <form id="SetDepositeRequest" style="background:#fff;">
        <div class="requestTitle">
            <p>Invoice total</p>
            <p id="invoiceBalance"></p>
            <!-- <php echo $balance; ?> £0.00-->
        </div>
        <hr>
        <div class="setDepositeAmount" id="setDepositeAmount">
            <p id="percent" style="margin: 0 0 0 10px;  cursor:pointer;">Percent (%)</p>
            <p id="fixed" style="margin: 0 10px 0 0;  cursor:pointer;">Fixed (£)</p>
        </div>
        <div id="percent_page">
            <div class="setPercentage" style="display:flex; flex-direction:row; ">
                <div style="width: 40%;">
                    <p>Set percentage</p>
                </div>
                <div style="width: 50%;">
                    <input type="text" name="set_percentage" id="set_percentage"  oninput= "percentageCalculation()" 
                        style="border: none; border-bottom: 1px solid #d7d7db; padding-left: 10px;"
                        value="50%">
                </div>
            </div>
            <p id="warning-message" style="color: red; display: none; font-size: 0.7rem;">
                Please choose a number between 0 and 100 (inclusive)</p>
            
            <div class="setPercentage" style="display:flex; flex-direction:row; ">
                <div style="width: 40%;">
                    <p>Deposit amount</p>
                </div>
                <div style="width: 50%;">
                        <input type="text" name="deposite_amount" id="deposite_amount" oninput= "amountCalculation()"
                        style=" border: none; border-bottom: 1px solid #d7d7db; padding-left: 10px;"
                        value="0">
                </div>
            </div>
            <p id="-deposite-warning-message" style="color: red; display: none; font-size: 0.7rem;">
                Deposit amount is greater than the invoice balance.</p>

            <div class="setPercentage" style="display:flex; flex-direction:row;">
                <div style="width: 40%;">
                    <p>Due date</p>
                </div>
                <div style="width: 50%;">
                    <input type="text" name="due_date" id="due_date"
                        style=" border: none; border-bottom: 1px solid #d7d7db; padding-left: 10px; cursor:pointer;"
                        value="">
                </div>
            </div>
        
        </div>
        <div id="fixed-amout_page" style="display:none;">
            <div class="setPercentage" style="display:flex; flex-direction:row; ">
                <div style="width: 40%;">
                    <p>Deposit amount</p>
                </div>
                <div style="width: 50%;">
                        <input type="number" name="fixed_deposite_amount" id="fixed_deposite_amount" oninput= "fixedAmountCalculation()"
                        style=" border: none; border-bottom: 1px solid #d7d7db; padding-left: 10px;"
                        value="0">
                </div>
            </div>
            <p id="fixed-deposite-warning-message" style="color: red; display: none; font-size: 0.7rem;">
                Deposit amount is greater than the invoice balance.</p>

            <div class="setPercentage" style="display:flex; flex-direction:row;">
                <div style="width: 40%;">
                    <p>Due date</p>
                </div>
                <div style="width: 50%;">
                    <input type="text" name="due_date" id="due_date"
                        style=" border: none; border-bottom: 1px solid #d7d7db; padding-left: 10px; cursor:pointer;"
                        value="">
                </div>
            </div>
        </div>
        <div>
            <a href="#" class="btn btn-dark p-2 m-3" id="DepositeRequest"
                style="text-decoration: none; border:none; float: right;">
                Save and Close</a>
        </div>
    </form>
</div>

<?php include 'js.php';?>
<script>
    $(document).ready(function() {
        // Reload the page when the modal is closed
        $('#depositRequestModal').on('hidden.bs.modal', function() {
            // location.reload(); 
        });

        // tongle click
        $('#percent').css('border-bottom', '3px solid red');
        $('#percent, #fixed').click(function() {
            $('.setDepositeAmount p').css('border-bottom', 'none'); 
            $(this).css('border-bottom', '3px solid red'); 
        });

        $(document).on('click', '#fixed', function() {
            $('#fixed-amout_page').show(); 
            $('#percent_page').hide();    
        });

        $(document).on('click', '#percent', function() {
            $('#percent_page').show();    
            $('#fixed-amout_page').hide(); 
        });
        // end of toggle with click

        // start of the percetage section
        $('#set_percentage').focus(function() {
            $(this).data('originalValue', $(this).val());
        });
        
        $('#set_percentage').click(function() {
            var value = $(this).val().replace('%', '');
            $(this).val(value);
         });

         $('#set_percentage').on('input', function() {
            let currentValue = $(this).val();

            currentValue = currentValue.replace(/[^0-9.]/g, '');
            
            currentValue = currentValue.replace(/^0+(?=\d)/, '');
            
            const parts = currentValue.split('.');
            if (parts.length > 2) {
                currentValue = parts[0] + '.' + parts.slice(1).join('');
            }
            
            if (currentValue === '') {
                currentValue = '0';
            }

            $(this).val(currentValue); 

            percentageCalculation();
            checkAndUpdateButtonState();


        });
    });

    function percentageCalculation() {
        let percentAmount = parseFloat($('#set_percentage').val());
        let invoiceAmount = $('#invoiceBalance').text().replace('£', '');
        invoiceAmount = parseFloat(invoiceAmount);

        if (isNaN(percentAmount) || percentAmount < 0 || percentAmount > 100) {
            $('#warning-message').show();
            return;
        } else {
            $('#warning-message').hide();
        }

        let newInvoiceAmount = invoiceAmount * (percentAmount / 100);
        newInvoiceAmount = newInvoiceAmount.toFixed(2);

        $('#deposite_amount').val(newInvoiceAmount);
    }


    $(document).ready(function() {
        $('#deposite_amount').on('input', function() {
            let depositAmount = $(this).val();
            
            depositAmount = depositAmount.replace(/[^0-9.]/g, '');
            
            depositAmount = depositAmount.replace(/^0+(?=\d)/, '');
            
            const parts = depositAmount.split('.');
            if (parts.length > 2) {
                depositAmount = parts[0] + '.' + parts.slice(1).join('');
            }
            
            $(this).val(depositAmount);

            if ($(this).val() === '') {
                $(this).val(0);
            }

            amountCalculation();
            checkAndUpdateButtonState();

        });
    });

    function amountCalculation() {
        let invoiceAmount = $('#invoiceBalance').text().replace('£', ''); 
        invoiceAmount = parseFloat(invoiceAmount); 
        let depositAmount = $('#deposite_amount').val();
        depositAmount = parseFloat(depositAmount); 
        
        if (depositAmount > invoiceAmount) {
            $('#-deposite-warning-message').show(); 
        } else {
            $('#-deposite-warning-message').hide(); 
            let percentage = ((depositAmount * 100) / invoiceAmount).toFixed(2);
            percentage = percentage + '%';

            $('#set_percentage').val(percentage);

            // console.log(percentage);
        }
    }
    
    // end of percentage calculation
    
    //FIXED AMOUNT SECTION
    // Function to handle input changes for fixed deposit amount
    $('#fixed_deposite_amount').on('input', function() {
        let depositAmount = $(this).val();
        
        depositAmount = depositAmount.replace(/[^0-9.]/g, '');
        
        depositAmount = depositAmount.replace(/^0+(?=\d)/, '');

       const parts = depositAmount.split('.');
        if (parts.length > 2) {
            depositAmount = parts[0] + '.' + parts.slice(1).join('');
        }
        
        $(this).val(depositAmount);

        if ($(this).val() === '') {
            $(this).val(0);
        }
            fixedAmountCalculation();
            checkAndUpdateButtonState();

    });


    function fixedAmountCalculation () {
        let invoiceAmount = $('#invoiceBalance').text().replace('£', '');
        invoiceAmount = parseFloat(invoiceAmount); 
        let depositAmount = $('#fixed_deposite_amount').val();
        
        depositAmount = parseFloat(depositAmount); 

        if (depositAmount > invoiceAmount) {
            $('#fixed-deposite-warning-message').show(); 
        } else {
            $('#fixed-deposite-warning-message').hide(); 
        }
        console.log(depositAmount);
    }



    // SAVE AND CLOSE  SECTION
    const $warningMessage = $('#warning-message');
    const $depositeWarningMessage = $('#deposite-warning-message');
    const $fixedDepositeWarningMessage = $('#fixed-deposite-warning-message');
    const $depositeRequestButton = $('#DepositeRequest');

    function checkAndUpdateButtonState() {
        if ($warningMessage.is(':visible') || $depositeWarningMessage.is(':visible') || $fixedDepositeWarningMessage.is(':visible')) {
            // console.log('Warning message is visible');
            $depositeRequestButton.prop('disabled', true);
            $depositeRequestButton.css('cursor', 'not-allowed');
            $depositeRequestButton.css('ponter-events', 'none');
            $depositeRequestButton.css("background-color","#d7dadb");

        } else {
            // console.log('Warning message is not visible');
            $depositeRequestButton.prop('disabled', false);
            $depositeRequestButton.css('cursor', 'pointer');
            $depositeRequestButton.css('background-color', '#5a5c69');
        }
    }

    // Initial check on page load
    checkAndUpdateButtonState();

    $(document).on('click', '#DepositeRequest', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        // Check and update button state
        checkAndUpdateButtonState();

        var dataURLpay = '/save-deposite-request';
        var depositeDetails = $('#SetDepositeRequest').serialize();
        console.log(depositeDetails);
        $('#saveDepositeRequest #testdeposit').text($('#deposite_amount').val());
        $('.deposit-request-section #saveDepositeRequest').val($('#deposite_amount').val());
        $('#add-request-link').modal('hide');
    });

    // // Hover event handler for the button
    // $depositeRequestButton.hover(
    //     function() {
    //         // Check if the button is disabled and set cursor accordingly
    //         if ($depositeRequestButton.prop('disabled')) {
    //             $(this).css('cursor', 'not-allowed');
    //         }
    //     },
    //     function() {
    //         // Reset cursor on hover out
    //         $(this).css('cursor', 'auto');
    //     }
    // );

    

</script>