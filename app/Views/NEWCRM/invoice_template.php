<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        /* Your custom styles */
    </style>
</head>
<body>
    <h1>Invoice #<?= $invoiceid ?></h1>
    <p>Company Name: <?= $cname ?></p>
    <p>Invoice ID: <?= $invoiceid ?></p>
    <p>Mobile: <?= $mobile ?></p>
    <p>Email: <?= $emailAddress ?></p>
    <p>Bill To: <?= $bill_to ?></p>
    <p>Invoice Date: <?= $invoicedate ?></p>
    <p>Terms: <?= $terms ?></p>
    <p>Due Date: <?= $duedate ?></p>
    <h2>Items</h2>
    <ul>
        <?php foreach ($itemdescription as $index => $description): ?>
            <li>Item: <?= $description ?>, Quantity: <?= $quantity[$index] ?>, Price: <?= $price[$index] ?>, Total: <?= $totalprice[$index] ?></li>
        <?php endforeach; ?>
    </ul>
    <p>Subtotal: <?= $subtotal ?></p>
    <p>Discount: <?= $discount ?></p>
    <p>Total: <?= $total ?></p>
    <p>Paid: <?= $paid ?></p>
    <p>Balance: <?= $balance ?></p>
    <p>Cost Price: <?= $costprice ?></p>
    <p>Profit: <?= $profitDisplay ?></p>
    <p>Status: <?= $status ?></p>
    <p>Comment: <?= $comment ?></p>
    <p>Payment Info: <?= $payment ?></p>
</body>
</html>
