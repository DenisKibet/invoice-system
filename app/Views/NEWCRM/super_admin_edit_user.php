<form id="edit-user-form">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="tenant">Company Name</label>
                <input type="text" class="form-control" id="tenant" name="tenant" value="<?=$tenant?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user->username ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $email?>">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" value="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="admin" <?= strtolower($role) === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="manager" <?= strtolower($role) === 'manager' ? 'selected' : '' ?>>Manager</option>
                    <option value="agent" <?= strtolower($role) === 'agent' ? 'selected' : '' ?>>Agent</option>
                </select>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="active" <?= $user->status == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $user->status == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep the same password">
            </div>
        </div>
    </div>
<!-- <button type="submit" class="btn btn-primary shadow-none">Update User</button> -->
</form>
