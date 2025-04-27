<div class="content-wrapper-pdfview pt-3 col-lg-12 p-3 bg-white rounded" id="previewPdfview" >
    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
        <tr>
            <td style="text-align: ; padding-top: 30px;">
                <?php
                    $logoPath = $company->logo_path ?? 'Company Logo';
                ?>
                <img src="<?= $logoPath ?>" alt="Company Logo" style="width: 100px; height: auto;">
            </td>
            <td style="width: 50%; text-align: right; padding-top: 10px; vertical-align: top;">
                <h1 style="font-size: 2rem; font-weight: 400; margin: 0 0 15px 0; color: #000;">ESTIMATE</h1>
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
                <table style="float: right; border-collapse: collapse;">
                    <tr>
                        <td style="text-align: right; padding: 0;"><strong>Estimate Number:</strong></td>
                        <td style="text-align: left; padding: 0 0 0 10px; font-size: 13px; line-height: 1.5;"><?php echo $formData['estimate_no']?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right; padding: 0;"><strong>Estimate Date:</strong></td>
                        <td style="text-align: left; padding: 0 0 0 10px; font-size: 13px; line-height: 1.5;"><?php if(!empty($formData['invoicedate'])) echo $formData['invoicedate'];?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

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
                        <?= htmlspecialchars($item['itemname']) ?>
                    </td>
                    <td style="text-align: center; border-bottom: 1px solid #ddd;">
                        <?= htmlspecialchars($item['quantity']) ?>
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #ddd;">
                        Ksh<?= htmlspecialchars(number_format($item['price'],2,'.',',')) ?>
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #ddd;">
                        Ksh<?= htmlspecialchars(number_format($item['totalprice'], 2 ,'.',',')) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr style="color: #333;">
            <td colspan="2"></td>
            <td style="text-align: right; padding-top: 12px;">Sub Total:</td>
            <td style="text-align: right; padding-top: 12px;">
                <?php 
                    $subtotal = isset($formData['subtotal']) ? $formData['subtotal'] : 0.00;
                    echo 'Ksh' . number_format($subtotal, 2, '.', ',');
                ?>
                <!-- <?php echo 'Ksh' . (!empty($formData['subtotal']) ? $formData['subtotal'] : 0.00); ?> -->
            </td>
        </tr>
        <tr style="color: #333;">
            <td colspan="2"></td>
            <td style="text-align: right;">Discount:</td>
            <td style="text-align: right;">
                <?php 
                    $discount = isset($formData['discount']) ? $formData['discount'] : 0.00;
                    echo 'Ksh' . number_format($discount, 2, '.', ',');
                ?>
            </td>
        </tr>
        <tr style="color: #333; font-weight: bold;">
            <td colspan="2"></td>
            <td style="text-align: right;">Total:</td>
            <td style="text-align: right;">
            <?php 
                    $total = isset($formData['total']) ? $formData['total'] : 0.00;
                    echo 'Ksh' . number_format($total, 2, '.', ',');
                ?>
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
</div>


