<form id="editPaymentForm">
    <input type="hidden" name="paymentId" value="<?= $payment->id ?>">
    <div class="form-group">
        <label for="amount">Amount</label>
        <input type="number" class="form-control" id="amount" name="amount" value="<?= $payment->amount ?>" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="method">Payment Method</label>
        <input type="text" class="form-control" id="method" name="method" value="<?= $payment->method ?>" required>
    </div>
    <div class="form-group">
        <label for="details">Details</label>
        <textarea class="form-control" id="details" name="details" rows="3"><?= $payment->details ?></textarea>
    </div>
    <button type="submit" class="btn btn-dark">Update Payment</button>
</form>