<div class="tab-content" id="myTabContent" style="background-color: #ffffff;">
    <div class="tab-pane card fade show active" id="userdets" role="tabpanel" aria-labelledby="userdets-tab">
        <div class="row p-3">
            <div class="col-sm-12 col-lg-6 mb-3 addStuffInput">
                <label for="cname">Stuff Name:</label><br />
                <div id="prefetch"><input id="autouser2" class="itemName input-lg typeahead w3-card-2 form-control" type="text" name="StuffName" value="<?= esc($userDetails['username'] ?? '') ?>" placeholder="Stuff Name" /></div>
            </div>

            <div class="col-lg-6 col-sm-12 addStuffInput">
                <label for="mobile">Mobile:</label><br />
                <input id="usermobile" type="text" class="form-control w3-card-2" name="MobileNumber" value="<?= esc($userDetails['mobile'] ?? '') ?>" placeholder="Mobile Number" /><br />
            </div>

            <div class="col-lg-6 col-sm-12 addStuffInput">
                <label for="email">Email Address:</label><br />
                <input id="useremail2" type="text" class="form-control w3-card-2" name="EmailAddress" value="<?= esc($userDetails['email'] ?? '') ?>" placeholder="Email Address" /><br />
            </div>

            <div class="col-lg-6 col-sm-12 addStuffInput">
                <label for="ad_email">Additional Email:</label><br />
                <input type="text" class="w3-card-2 form-control" placeholder="Additional email address" value="<?= esc($userDetails['additional_email'] ?? '') ?>" name="ad_email" id="ad_email" /><br />
            </div>
            <div class="col-12 mb-3 addStuffInput">
                <label for="password_reset">User Password:</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="********" disabled>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="resetPasswordBtn">Reset Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#Viewdets #resetPasswordBtn').click(function() {
        if (confirm('Are you sure you want to send a password reset link to this user?')) {
            $.ajax({
                url: '/resetUserPassword',
                type: 'POST',
                data: { userId: <?= $userDetails['id'] ?> },
                success: function(response) {
                    console.log(response);
                    
                    if (response.success) {
                        alert('Password reset link has been sent to the user\'s email.');
                    } else {
                        alert('Failed to send password reset link: ' + response.error);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while sending the password reset link. Please try again.');
                    console.error(error);
                }
            });
        }
    });
});
</script>