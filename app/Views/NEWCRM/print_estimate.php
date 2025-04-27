<div class="content-wrapper-pdfview border pt-3 col-lg-8 shadow p-3 bg-white rounded" id="previewPdfview" >
    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
        <tr>
            <td style="text-align: ; padding-top: 20px;">
                <?php
                    $logoPath = $company->logo_path ?? 'Company Logo';
                ?>
                <img src="<?= $logoPath ?>" alt="Company Logo" style="width: 100px; height: auto;">
            </td>
            <td style="width: 50%; text-align: right; padding-top: 10px; vertical-align: top;">
                <h1 style="font-size: 2rem; font-weight: 400; margin: 0 0 15px 0; color: #000;">ESTIMATE</h1>
                <p style="margin: 0; font-size: 13px; line-height: 1.5; color: #333;">
                    <span style="font-weight: bold;"><?= !empty($company->company_name) ? $company->company_name : '' ?></span><br>
                    <?= !empty($company->post_code) ? $company->post_code : ' ' ?>, <?= !empty($company->street) ? $company->street : ''?><br>
                    <?= !empty($company->city) ? $company->city : '' ?> <br>
                    <?= !empty($company->country) ? $company->country : '' ?><br>
                    <br>
                    <?= !empty($company->mobile_no) ? $company->mobile_no : '' ?><br>
                    <?= !empty($company->website) ? $company->website : '' ?>
                </p>
            </td>
        </tr>
    </table>

    <hr style="border: none; border-top: 1px solid #ccc; margin: 20px 0;">

    <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; margin-bottom: 20px;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <p style="margin: 0; font-size: 14px; line-height: 1.5;">
                    <span style="color: #999999;">BILL TO</span>
                </p>
                <table style="line-height: 1.2; font-size: 13px;">
                    <tr>
                        <td>
                            <span style="font-weight: 500;"><?php if(!empty($estimate->client_name)) echo $estimate->client_name?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php if(!empty($client->MobileNumber)) echo $client->MobileNumber?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php if(!empty($estimate->email)) echo $estimate->email?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><?php if(!empty($client->address)) echo $client->address?></span>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; text-align: right; vertical-align: top; font-size: 13px; line-height: 1.5;">
                <table style="float: right; border-collapse: collapse;">
                    <tr>
                        <td style="font-weight: 500; text-align: right; padding: 0;">Estimate Number:</td>
                        <td style="text-align: left; padding: 0 0 0 10px; font-size: 13px; line-height: 1.5;"><?php echo $estimate->estimate_no?></td>
                    </tr>
                    <tr>
                        <td style="font-weight: 500; text-align: right; padding: 0;">Estimate Date:</td>
                        <td style="text-align: left; padding: 0 0 0 10px; font-size: 13px; line-height: 1.5;"><?php if(!empty($estimate->invoice_date)) echo $estimate->invoice_date;?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; font-size: 13px; font-family: Arial, sans-serif;">
        <tr>
            <th style="font-weight: 500; text-align: left; padding: 8px;">Items</th>
            <th style="font-weight: 500; text-align: center; padding: 8px;">Quantity</th>
            <th style="font-weight: 500; text-align: right; padding: 8px;">Price</th>
            <th style="font-weight: 500; text-align: right; padding: 8px;">Amount</th>
        </tr>
        <?php if (!empty($itemlist)) : ?>
            <?php $lastIndex = count($itemlist) - 1; ?>
            <?php foreach ($itemlist as $index => $item): ?>
                <tr style="color: #333;<?= $index === $lastIndex ? 'border-bottom: 1px solid #737373;' : 'border-bottom: 1px solid #333;' ?>">
                    <td style="padding: 8px; border-bottom: 1px solid #ddd; width: 55%;">
                        <?= htmlspecialchars($item->itemname) ?>
                    </td>
                    <td style="text-align: center; border-bottom: 1px solid #ddd;">
                        <?= htmlspecialchars($item->quantity) ?>
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #ddd;">
                        Ksh<?= htmlspecialchars(number_format($item->price,2,'.',',')) ?>
                    </td>
                    <td style="text-align: right; border-bottom: 1px solid #ddd;">
                        Ksh<?= htmlspecialchars(number_format($item->totalprice, 2 , '.', '.')) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr style="color: #333;">
            <td colspan="2"></td>
            <td style="text-align: right; padding-top: 12px;">Sub Total:</td>
            <td style="text-align: right; padding-top: 12px;">
                <?php
                      $subtotal = isset($estimate->subtotal) ? $estimate->subtotal : 0.00;
                      echo 'Ksh' . number_format($subtotal, 2, '.', ',');
                ?>
            </td>
        </tr>
        <tr style="color: #333;">
            <td colspan="2"></td>
            <td style="text-align: right;">Discount:</td>
            <td style="text-align: right;">
                <?php
                    $discount = isset($estimate->discount) ? $estimate->discount : 0.00;
                    echo 'Ksh' . number_format($discount, 2, '.', ',');
                ?>
            </td>
        </tr>
        
        <tr style="color: #333; font-weight: bold;">
            <td colspan="2"></td>
            <td style="text-align: right;">Total:</td>
            <td style="text-align: right;">
                <?php
                    $total = isset($estimate->total) ? $estimate->total : 0.00;
                    echo 'Ksh' . number_format($total, 2, '.', ',');
                ?>
            </td>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 35px; font-size: 13px; font-family: Arial, sans-serif;">
        <tr>
            <th  style="text-align: left;">Comments</th>
        </tr>
        <tr style="color: #333;">
            <td>
                <?php echo isset($estimate->comment) ? nl2br($estimate->comment) : ''; ?>
            </td>
        </tr>
    </table>
</div>