<div class="content-wrapper-pdfview pt-3 col-lg-12 p-3 bg-white rounded" id="previewPdfview" >
    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
        <tr>
            <td style="text-align: ; padding-top: 20px;">
                <?php
                    $logoPath = $company->logo_path ?? '';
                ?>
                <img src="<?= $logoPath ?>" alt="" style="width: 100px; height: auto;">
            </td>
            <td style="width: 50%; text-align: right; padding-top: 10px; vertical-align: top;">
                <h1 style="font-size: 2rem; font-weight: 400; margin: 0 0 15px 0; color: #000;">INVOICE</h1>
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #333;">
                    <span style="font-weight: bold;"><?= !empty($company->company_name) ? $company->company_name : '' ?></span>
                    <?php if(!empty($company->post_code) || !empty($company->street)): ?>
                        <br><?= !empty($company->post_code) ? $company->post_code : '' ?><?= !empty($company->street) ? ', ' . $company->street : ''?>
                    <?php endif; ?>
                    <?php if(!empty($company->city)): ?>
                        <br><?= $company->city ?>
                    <?php endif; ?>
                    <?php if(!empty($company->country)): ?>
                        <br><?= $company->country ?>
                    <?php endif; ?>
                    <?php if(!empty($company->mobile_no)): ?>
                        <br><?= $company->mobile_no ?>
                    <?php endif; ?>
                    <?php if(!empty($company->email)): ?>
                        <br><?= $company->email ?>
                    <?php endif; ?>
                    <?php if(!empty($company->website)): ?>
                        <br><?= $company->website ?>
                    <?php endif; ?>
                </p>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">

    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-bottom: 20px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p style="margin: 0; font-size: 13px; line-height: 1.5;">
                    <span style="color: #999999;">BILL TO</span>
                </p>

                <table style="line-height: 1.2; font-size: 13px;">
                    <tr>
                        <td>
                            <span style="font-weight: bold;"><?php if(!empty($formData['cname'])) echo $formData['cname']?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php if(!empty($formData['email'])) echo $formData['email']?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php if(!empty($formData['mobile'])) echo $formData['mobile']?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php if(!empty($formData['bill_to'])) echo $formData['bill_to']?></span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: top; font-size: 13px; line-height: 1.5;">
                <table style="margin-left: auto; border-collapse: collapse;">
                    <tr>
                        <td style="text-align: right; padding:0;"><strong>Invoice Number:</strong></td>
                        <td style="text-align: left; padding: 0 0 0 10px; font-size: 13px; line-height: 1.5;"><?php echo $formData['invoice_no']?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding:0;"><strong>Invoice Date:</strong></td>
                        <td style="text-align: left; padding: 0 0 0 10px; font-size: 13px; line-height: 1.5;"><?php if(!empty($formData['invoicedate'])) echo $formData['invoicedate'];?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding:0;"><strong>Terms:</strong></td>
                        <td style="text-align: left; padding: 0 0 0 10px; font-size: 13px; line-height: 1.5;"><?php if(!empty($formData['terms'])) echo $formData['terms'];?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding:0;"><strong>Payment Due:</strong></td>
                        <td style="text-align: left; padding: 0 0 0 10px; font-size: 13px; line-height: 1.5;"><?php if(!empty($formData['duedate'])) echo $formData['duedate'];?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">

    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 13px;">
        <tr>
            <th style="text-align: left; padding: 8px;">Items</th>
            <th style="text-align: center; padding: 8px;">Quantity</th>
            <th style="text-align: right; padding: 8px;">Price</th>
            <th style="text-align: right; padding: 8px;">Amount</th>
        </tr>
        <?php if (!empty($itemdata)) : ?>
            <?php $lastIndex = count($itemdata) - 1; ?>
            <?php foreach ($itemdata as $index => $item): ?>
                <tr style="color: #333;<?= $index === $lastIndex ? 'border-bottom: 1px solid #737373;' : 'border-bottom: 1px solid #333;' ?>">
                    <td style="padding: 8px; border-bottom: 1px solid #ddd; width: 55%;">
                        <?= nl2br(htmlspecialchars($item['itemname'])) ?>
                    </td>
                    <td style="text-align: center; border-bottom: 1px solid #ddd;">
                        <?= htmlspecialchars($item['quantity']) ?>
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #ddd;">
                        Ksh<?= isset($item['price']) && is_numeric($item['price']) ? number_format((float)$item['price'], 2, '.', ',') : '0.00' ?>
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #ddd;">
                        Ksh<?= isset($item['totalprice']) && is_numeric($item['totalprice']) ? number_format((float)$item['totalprice'], 2, '.', ',') : '0.00' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr style="color: #333; line-height: 1.4;">
            <td colspan="2"></td>
            <td style="text-align: right; padding-top: 12px;">Sub Total:</td>
            <td style="text-align: right; padding-top: 12px;">
                <?php 
                    $subtotal = isset($formData['subtotal']) && is_numeric($formData['subtotal']) ? $formData['subtotal'] : 0.00;
                    echo 'Ksh' . number_format((float)$subtotal, 2, '.', ',');
                ?>
            </td>
        </tr>
        <tr style="color: #333; line-height: 1.4;">
            <td colspan="2"></td>
            <td style="text-align: right;">Discount:</td>
            <td style="text-align: right;">
                <?php 
                    $discount = isset($formData['discount']) && is_numeric($formData['discount']) ? $formData['discount'] : 0.00;
                    echo 'Ksh' . number_format((float)$discount, 2, '.', ',');
                ?>
            </td>
        </tr>
        <tr style="color: #333; line-height: 1.4;">
            <td colspan="2"></td>
            <td style="text-align: right;">Total:</td>
            <td style="text-align: right;">
                <?php 
                    $total = isset($formData['total']) && is_numeric($formData['total']) ? $formData['total'] : 0.00;
                    echo 'Ksh' . number_format((float)$total, 2, '.', ',');
                ?>
            </td>
        </tr>
        <tr style="color: #333; line-height: 1.4;">
            <td colspan="2"></td>
            <td style="text-align: right;">Paid:</td>
            <td style="text-align: right;">
                <?php 
                    $paid = isset($formData['paid']) && is_numeric($formData['paid']) ? $formData['paid'] : 0.00;
                    echo 'Ksh' . number_format((float)$paid, 2, '.', ',');
                ?>
            </td>
        </tr>
        <tr style="color: #333; font-weight:bold; line-height: 1.4;">
            <td colspan="2"></td>
            <td style="text-align: right;"><strong>BALANCE DUE:</strong></td>
            <td style="text-align: right;"><strong>
                <?php 
                    $balance = isset($formData['balance']) && is_numeric($formData['balance']) ? $formData['balance'] : 0.00;
                    echo 'Ksh' . number_format((float)$balance, 2, '.', ',');
                ?></strong>
            </td>
        </tr>
    </table>    

    <table style="width: 100%; margin-top: 35px; font-size: 12px; font-family: Arial, sans-serif;">
        <tr>
            <th  style="text-align: left;">Comments</th>
        </tr>
        <tr style="color: #333;">
            <td>
                <?php echo isset($formData['comment']) ? nl2br($formData['comment']) : ''; ?>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 35px; font-size: 12px; font-family: Arial, sans-serif;">
        <tr>
            <th style="text-align: left;">Payment Instructions</th>
        </tr>
        <tr style="color: #333;">
            <td>
                <?php echo isset($formData['payment']) ? nl2br($formData['payment']) : ''; ?>
            </td>
        </tr>
    </table>
</div>