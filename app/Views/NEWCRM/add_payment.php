<form id="invoicepaymentform">
      <div class="card-body">
          <div class="form-group row">
              <label for="amountpaid" class="col-sm-3 col-form-label">Amount</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="amountpaid" id="amountpaid" placeholder="0.00" style=" border-right: none; border-left: none; border-top: none;" required>
                  <input type="hidden" class="form-control" name="invoiceid" id="invoiceid" style=" border-right: none; border-left: none; border-top: none;" value=<?= $invoiceid; ?>>
              </div>
          </div>
          <div class="form-group row">
              <label for="paymentdate" class="col-sm-3 col-form-label">Date</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="paymentdate" id="paymentdate" placeholder="Date" style=" border-right: none; border-left: none; border-top: none;" required>
              </div>
          </div>
          <div class="form-group row">
              <label for="method" class="col-sm-3 col-form-label">Method</label>
              <div class="col-sm-9">
                  <datalist id="method">
                      <option value="Cash">
                      <option value="Check">
                      <option value="Direct Transfer">
                      <option value="Credit Card">
                      <option value="Paypal">
                  </datalist>
                  <input type="text" list="method" class="form-control" name="method" id="methods" placeholder="Enter a method..." style=" border-right: none; border-left: none; border-top: none;" required>

              </div>
          </div>
          <div class="form-group row">
              <label for="details" class="col-sm-3 col-form-label">Details</label>
              <div class="col-sm-9">
                  <input type="text" class="form-control" name="details" id="details" placeholder="Add details..." style=" border-right: none; border-left: none; border-top: none;">
              </div>
          </div>
          <br>

          <a href="#" class="btn btn-dark p-2" id="btnsave2" style="text-decoration: none; float: left;">
              Add Payment</a>

      </div>
  </form>
