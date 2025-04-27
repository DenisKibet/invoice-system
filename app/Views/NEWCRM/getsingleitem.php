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
                <div class="card-header m-3" style="color:#1a1a1a; background-color: #b3b3b3;border-radius: 0 12px 12px 0;">
                    <h4><i class="fa fa-th-large"></i> Item Description</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mb-3 ">
                            <label for="item_description">Enter a Description:</label><br />
                            <div id="item_description"><input id="autouser2" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="Item_description" value="<?php echo $item->item_description?>" placeholder="Description" /></div>
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 ">
                            <label for="rate">Rate:</label><br />
                            <input id="rate" type="text" class="form-control w3-card-2" name="rate" value="<?php echo $item->rate;?>" placeholder="0" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 ">
                            <label for="cost">Cost:</label><br />
                            <input id="cost" type="text" class="form-control w3-card-2" name="cost" value="<?php echo $item->cost;?>" placeholder="0" /><br />
                            <div class="text-danger">
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12 addClientInput">
                            <label for="catgeory">Category: </label><br>
                            <select class="form-control w3-card-2" id="catgeory" name="category">
                                <option value="">None</option>
                                <option value="Hours" <?php echo $item->category == 'Hours' ? 'selected' : ''; ?>>Hours</option>
                                <option value="Days" <?php echo $item->category == 'Days' ? 'selected' : ''; ?>>Days</option>
                            </select>
                        </div>

                        <div class="col-lg-6 col-sm-12 "> 
                            <?php
                                $tax_enabled = $item->enable_taxes;
                            ?>
                            <div class="d-flex flox-row">
                                <p class="mr-3">Enable Taxes</p>
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

<script>
    $(document).ready(function() {
        var taxEnabled = <?php echo $tax_enabled; ?>;
        if (taxEnabled == 1) {
            $('#enable_taxes').prop('checked', true);
        } else {
            $('#enable_taxes').prop('checked', false);
        }
    });
</script>