<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Error</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <h1>Payment Error</h1>
    <?php if (isset($errorDetails)): ?>
        <p>Status: <?= esc($errorDetails['status']) ?></p>
        <p>Message: <?= esc($errorDetails['message']) ?></p>
    <?php else: ?>
        <p>An unknown error occurred during the payment process.</p>
    <?php endif; ?>
    
    <a href="<?= site_url('dashboard') ?>">Return to Home</a>
</body>
</html>