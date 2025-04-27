<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Users</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <?php include 'css.php'?>

    <style>
        .filter-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .stats-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .role-badge {
            width: 100px;
        }
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        /* Make wrapper take full viewport height */
        #wrapper {
            min-height: 100vh;
            position: relative;
        }

        /* Fix sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        /* Fix topbar */
        .topbar {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1000;
            /* Adjust left value to match sidebar width */
            margin-left: 14rem; /* Adjust this value based on your sidebar width */
        }

        /* Adjust content wrapper */
        #content-wrapper {
            min-height: 100vh;
            /* Adjust margin-left to match sidebar width */
            margin-left: 14rem; /* Should match your sidebar width */
        }

        /* Make main content scrollable */
        #content {
            /* Add padding-top to account for fixed topbar */
            padding-top: 4.375rem; /* Adjust based on your topbar height */
            height: 100vh;
            overflow-y: auto;
        }

        /* Ensure container-fluid takes remaining height */
        .container-fluid {
            height: 100%;
            padding: 1.5rem;
        }
    </style>
</head>
<body class="bg-light" id="page-top">

     <!-- Page Wrapper -->
     <div id="wrapper">

        <!-- INCLUDE SIDEBAR HERE --> 
        <?php include 'super_admin_sidebar.php' ?>

          <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- INCLUDE TOP BAR HERE -->
                <nav class="topbar">
                    <?php include 'super_admin_topbar.php' ?>
                </nav>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Main Content -->
                    <div class="main-content">

                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2>User Management</h2>
                            <button class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Add New User
                            </button>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card stats-card" style="border-left-color: #2ecc71;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Total Users</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-0"><?=esc($totalSystemUsers)?></h3>
                                            <i class="fas fa-users text-success fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stats-card" style="border-left-color: #e74c3c;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Active Now</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-0"><?=esc($isUserActive)?></h3>
                                            <i class="fas fa-user-check text-danger fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stats-card" style="border-left-color: #f1c40f;">
                                    <div class="card-body">
                                        <h6 class="text-muted">New This Month</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-0"><?=esc($newUsersForCurrentMonth)?></h3>
                                            <i class="fas fa-user-plus text-warning fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stats-card" style="border-left-color: #3498db;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Tenants Covered</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-0"><?=esc($tenantCount)?></h3>
                                            <i class="fas fa-building text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                        <input type="text" 
                                            class="form-control shadow-none" 
                                            placeholder="Search users..."
                                        >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select shadow-none">
                                        <option value="">Role</option>
                                        <option value="admin">Admin</option>
                                        <option value="agent">Agent</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select shadow-none">
                                        <option value="">Tenant</option>
                                        <?php foreach ($tenants as $tenant): ?>
                                            <option value="<?= htmlspecialchars($tenant->tenant_company_name) ?>">
                                                <?= htmlspecialchars($tenant->tenant_company_name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-select shadow-none">
                                        <option value="">Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-outline-secondary w-100 shadow-none" title="Reset Filters">
                                        <i class="fas fa-undo"></i> Clear Filters  
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle" style="white-space: nowrap;">
                                        <thead>
                                            <tr>
                                                <th class="text-center align-middle" >
                                                    <div class="form-check">
                                                        <input type="checkbox" 
                                                            class="form-check-input position-relative shadow-none" 
                                                            id="selectAllCheckbox"
                                                            style="
                                                                width: 20px; 
                                                                height: 20px; 
                                                                border-radius: 4px; 
                                                                border: 2px solid #6c757d; 
                                                                background-color: transparent;
                                                                cursor: pointer;
                                                                top: -2px;
                                                            "
                                                        >
                                                        <label class="form-check-label" for="selectAllCheckbox"></label>
                                                    </div>
                                                </th>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>Tenant</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Last Active</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($userList as $databaseName => $userData): ?>
                                                <?php foreach ($userData['users'] as $user): ?>
                                                        
                                                    <tr>
                                                        <!-- <td>
                                                            <input type="checkbox" class="form-check-input shadow-none ">
                                                        </td> -->

                                                        <td class="text-center align-middle">
                                                            <div class="form-check">
                                                                <input type="checkbox" 
                                                                    class="form-check-input row-checkbox position-relative shadow-none" 
                                                                    style="
                                                                        width: 20px; 
                                                                        height: 20px; 
                                                                        border-radius: 4px; 
                                                                        border: 2px solid #6c757d; 
                                                                        background-color: transparent;
                                                                        cursor: pointer;
                                                                        top: -2px;
                                                                    "
                                                                >
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="user-avatar me-3 <?= 'bg-' . ['primary', 'success', 'warning', 'danger', 'info'][abs(crc32($user->username) % 5)] ?>">
                                                                    <?php 
                                                                        $names = explode(' ', $user->username ?? '');
                                                                        echo strtoupper(
                                                                            (isset($names[0]) ? substr($names[0], 0, 1) : '') . 
                                                                            (isset($names[1]) ? substr($names[1], 0, 1) : '')
                                                                        );
                                                                    ?>
                                                                </div>
                                                                <div>
                                                                    <div class="fw-bold"><?= $user->username?></div>
                                                                    <small class="text-muted">Created: <?= date('M d, Y', strtotime($user->created_at ?? '')) ?></small>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><?=$user->email?></td>
                                                        <td><?=$userData['company_name']?></td>
                                                        <!-- <td><=$tenantName?></td> -->
                                                        <td>
                                                            <?php
                                                            $role = strtolower(trim($user->role));
                                                            $badgeClass = ($role === 'admin') ? 'bg-primary' : 'bg-secondary';
                                                            ?>
                                                            <span class="badge <?= $badgeClass ?> role-badge">
                                                                <?= ucfirst($role) ?> 
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="status-dot bg-success"></span>
                                                            <span class="status-text">Active</span>
                                                        </td>
                                                        <td>
                                                            <?php if (isset($user->last_active) && $user->last_active !== null && $user->last_active !== '0000-00-00 00:00:00'): ?>
                                                                <?php 
                                                                $relativeTime = get_relative_time($user->last_active);
                                                                $timeClass = (strtotime($user->last_active) > strtotime('-7 days')) ? 'text-dark' : 'text-muted';
                                                                ?>
                                                                <span class="<?= $timeClass ?>"><?= $relativeTime ?></span>
                                                            <?php else: ?>
                                                                <span class="text-danger">Never Logged In</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div class="user-actions">
                                                                <button class="btn btn-outline-primary btn-sm" data-id="<?= $user->id?>"  data-db="<?= $databaseName ?>"  id="btn-edit-user">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-outline-danger btn-sm" data-id="<?= $user->id ?>" data-db="<?= $databaseName ?>" id="btn-delete-user">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div class="text-muted">
                                        Showing 1 to 3 of 3 entries
                                    </div>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination mb-0">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View invoice modal -->
    <div class="modal fade" id="previewmodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">User Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Dynamically loaded content -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php include "js.php"?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
    // Filters section
    $(document).ready(function() {
        // Cache DOM elements
        const $searchInput = $('.filter-section input[type="text"]');
        const $roleSelect = $('.filter-section select:eq(0)');
        const $tenantSelect = $('.filter-section select:eq(1)');
        const $statusSelect = $('.filter-section select:eq(2)');
        const $filterBtn = $('.filter-section .btn-secondary');
        const $resetBtn = $('.filter-section .btn-outline-secondary');
        const $tableRows = $('.table tbody tr');
        const $tableBody = $('.table tbody');


            // Function to check and display "No Data" message
        function checkNoData() {
            const visibleRows = $tableRows.filter(':visible');
            
            // Remove any existing "no data" row
            $tableBody.find('.no-data-row').remove();
            
            // If no rows are visible, add "No Data" message
            if (visibleRows.length === 0) {
                $tableBody.append(`
                    <tr class="no-data-row">
                        <td colspan="8" class="text-center text-muted">
                            No data found 
                        </td>
                    </tr>
                `);
            }
        }

            // Apply filters function
        function applyFilters() {
            $tableRows.each(function() {
                let row = $(this);
                let showRow = true;
                
                // Text search filter
                const searchText = $searchInput.val().toLowerCase();
                const rowText = row.text().toLowerCase();
                if (searchText && !rowText.includes(searchText)) {
                    showRow = false;
                }

                // Role filter
                const roleSelect = $roleSelect.val().toLowerCase();
                const rowRole = row.find('.badge').text().trim().toLowerCase();
                if (roleSelect && rowRole !== roleSelect) {
                    showRow = false;
                }
                
                // Status filter
                const selectedStatus = $statusSelect.val().toLowerCase();
                const rowStatus = row.find('td:eq(5) .status-text').text().trim().toLowerCase();
                if (selectedStatus && rowStatus !== selectedStatus) {
                    showRow = false;
                }
                
                // Tenant filter
                const selectedTenant = $tenantSelect.val().toLowerCase();
                const rowTenant = row.find('td:eq(3)').text().toLowerCase();

                if (selectedTenant) {
                    // Check for exact match or wildcard match
                    const matchesExact = rowTenant === selectedTenant;
                    const matchesWildcard = selectedTenant.includes('*') 
                        ? rowTenant.includes(selectedTenant.replace('*', ''))
                        : false;

                    if (!matchesExact && !matchesWildcard) {
                        showRow = false;
                    }
                }

                // Show/hide row
                row.toggle(showRow);
            });

            // Check and display "No Data" message
            checkNoData();
        }

        // Real-time search
        $searchInput.on('keyup', function() {
            applyFilters();
        });

        // Role select change
        $roleSelect.on('change', function() {
            applyFilters();
        });

        // Reset button click
        $resetBtn.on('click', function() {
            // Clear all filters
            $searchInput.val('');
            $roleSelect.val('');
            $statusSelect.val('');
            $tenantSelect.val('');
            
            // Show all rows and remove "No Data" message
            $tableRows.show();
            $tableBody.find('.no-data-row').remove();
        });

        // Status and Tenant select change
        $statusSelect.add($tenantSelect).on('change', function() {
            applyFilters();
        });
    });

    // EDIT USER HANDLER
    $(document).on('click', '#btn-edit-user', function(e) {
        const userID = $(this).data('id');
        const userTenantDB = $(this).data('db');
        
        // Get the row data - assuming the button is within the table row
        const $row = $(this).closest('tr');
        const rowData = {
            user_id: userID,
            tenant_db: userTenantDB,
            email: $row.find('td:eq(2)').text().trim(),         
            tenant: $row.find('td:eq(3)').text().trim(),    
            role: $row.find('td:eq(4)').text().trim(),    
            // role: 'Agent',    
        };

        $.ajax({
            url: 'super-admin-users/get-user-details', 
            method: 'POST',
            data: rowData,
            success: function(response) {
                $('#previewmodal .modal-body').html(response);
                $('#previewmodal').modal('show');
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An unexpected error occurred';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            }
        });
    });

    // Delete User Handler
    $(document).on('click', '#btn-delete-user', function() {
        const $row = $(this).closest('tr');
        const userName = $row.find('div.fw-bold').text().trim();
        const userID = $(this).data('id');        
        const userTenantDB = $(this).data('db');  

        const confirmModal = `
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <P class="mb-0">Are you sure you want to delete user <strong>${userName}</strong>?</P>
                            <P class="text-muted small mb-0 mt-2">This action cannot be undone.</P>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete User</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        $('#deleteConfirmModal').remove();
        
        // Add new modal to body and show it
        $('body').append(confirmModal);
        const $modal = $('#deleteConfirmModal');
        $modal.modal('show');

        // Handle delete confirmation
        $('#confirmDelete').on('click', function() {
            // Show loading state
            const $button = $(this);
            $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Deleting...');

            // Make AJAX call to delete user
            $.ajax({
                url: 'super-admin-users/delete-user',  // Adjust this URL to match your route
                method: 'POST',
                data: {
                    user_id: userID,
                    tenant_db: userTenantDB
                },
                success: function(response) {
                    $modal.modal('hide');
                    console.log(response);
                    // alert(response);
                    
                    // Remove row with animation
                    $row.fadeOut(400, function() {
                        $(this).remove();
                    });
                    
                    // Show success message
                    showNotification('Success', `User ${userName} has been deleted.`, 'success');
                },
                error: function(xhr, status, error) {
                    // Enable button again
                    $button.prop('disabled', false).html('Delete User');
                    
                    let errorMessage = 'An unexpected error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    // Show error message
                    showNotification('Error', errorMessage, 'danger');
                }
            });
        }); 

        // Utility function to show notifications
        function showNotification(title, message, type = 'info') {
            const toast = `
                <div class="position-fixed top-0 end-0 p-3" style="z-index: 1070">
                    <div class="toast align-items-center text-white bg-${type}" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <strong>${title}</strong><br>
                                ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing toasts
            $('.toast').remove();
            
            // Add and show new toast
            $('body').append(toast);
            $('.toast').toast('show');
        }
    });
    </script>
</body>
</html>