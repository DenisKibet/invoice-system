<style>
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
<div class="container-fluid">
    <form id="invoiceform" style="background:white;">
        <div class="row container-fluid">
            <div class="col-lg-12 col-sm-12 col-md-12">
                <div class="pb-5">
                    <a href="#" class="btn btn-dark " id="btnsave" style="text-decoration: none; float: right;">
                        <span class="fa fa-cube fa-fw "></span>
                        Update and Close</a>
                </div>
                <div class="card-header m-3" style="color:#1a1a1a; background-color: #b3b3b3;border-radius: 0 12px 12px 0;">
                    <h4><i class="fa fa-th-large"></i> Item Description</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mb-3 ">
                            <label for="item_description">Enter a Description:</label><br />
                            <input type="hidden" class="form-control" name="itemId" id="itemId" value="<?= $item->id ?>">
                            <div id="item_description"><input id="autouser2" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="Item_description" value="<?php echo $item->item_description?>" placeholder="Description" /></div>
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 ">
                            <label for="cost">Cost (Cost Price):</label><br />
                            <input id="cost" type="text" class="form-control w3-card-2" name="cost" value="<?php echo $item->cost;?>" placeholder="0" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-12 col-sm-12 ">
                            <label for="rate">Rate (Selling Price):</label><br />
                            <input id="rate" type="text" class="form-control w3-card-2" name="rate" value="<?php echo $item->rate;?>" placeholder="0" /><br />
                            <div class="text-danger">
                            </div>
                        </div>
<!-- 
                        <div class="col-lg-6 col-sm-12 addClientInput">
                            <label for="catgeory">Category: </label><br>
                            <select class="form-control w3-card-2" id="catgeory" name="category">
                                <option value="">None</option>
                                <option value="Hours" <?php echo $item->category == 'Hours' ? 'selected' : ''; ?>>Hours</option>
                                <option value="Days" <?php echo $item->category == 'Days' ? 'selected' : ''; ?>>Days</option>
                            </select>
                        </div> -->

                        <div class="col-lg-6 col-sm-12 "> 
                            <?php
                                $tax_enabled = $item->enable_taxes;
                            ?>
                            <div class="d-flex flox-row">
                                <p class="mr-3">Enable Taxes</p> <br>
                                <label class="switch">
                                    <input type="checkbox" id="enable_taxes">
                                    <span class="slider round"></span>
                                </label>
                                <p class="ml-3">Default taxes will be applied to this item</p>
                            </div >
                            
                        </div>
                        <div class="col-lg-6 col-sm-12 ">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color:black;">
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
</div> -->

<script>
    $(document).ready(function() {
        var taxEnabled = <?php echo $tax_enabled; ?>;
        if (taxEnabled == 1) {
            $('#enable_taxes').prop('checked', true);
        } else {
            $('#enable_taxes').prop('checked', false);
        }
    });

    $(document).on("click", "#Viewdets #btnsave", function(e) {
        enable_taxes = $("#enable_taxes").prop("checked") ? 1 : 0
        $('#enabled_taxes').val(enable_taxes);
        
        var image = "/assets/img/ajax-loader_2.gif";
        e.preventDefault();
        e.stopImmediatePropagation();
        var dataURLpay = '/deleteItem';
        var formData = $('#Viewdets #invoiceform').serialize();
        formData += "&enable_taxes=" + enable_taxes;

        // return;
        $.ajax({
            type: "POST",
            url: "/updatesingleitem", 
            data: formData,
            dataType: "json",
            encode: true,
            beforeSend: function () {
                $(" .modal-body").html("<img src='" + image +
                    "' style='margin-top:1%;;margin-left:50%' /> <br> <div style='margin-top:6%;;margin-left:30%'> <h1> Updating item, please wait...</h1></div>"
                );
                $("#previewmodal").modal("show");
            },
            success: function(response) {
                $("#Viewdets #previewmodal").modal("hide");
                location.reload();
            },
            error: function(xhr, status, error) {
                alert(response.message)
            }
        });
    });
</script>