

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Dashboard - Invoice System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <?php include 'css.php'?>

    <style>
        .stat-card {
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }

                /* ? */
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
        .tenant-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
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

                        <!-- Stats Cards -->
                        <div class="row g-4 mb-4">
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="card stat-card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                                <i class="fas fa-building fa-lg"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-muted">Total Tenants</h6>
                                                <h3 class="mb-0"><?= esc($tenantCount) ?></h3>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="card stat-card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-users fa-lg"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-muted">Total Users</h6>
                                                <h3 class="mb-0"><?= $totalSystemUsers?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="card stat-card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-info bg-opacity-10 text-info">
                                                <i class="fas fa-file-invoice fa-lg"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-muted">Total Invoices</h6>
                                                <h3 class="mb-0"><?= esc($totalInvoices)?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="card stat-card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                                <i class="fas fa-pound-sign fa-lg"></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-muted">Total Revenue</h6>
                                                <h3 class="mb-0"> £<?= htmlspecialchars(number_format($totalRevenue ,2, '.', ',')) ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tenants Table -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white py-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="mb-0">Recent Tenants</h5>
                                    </div>
                                    <!-- <div class="col text-end">
                                        <button class="btn btn-primary btn-sm">View All</button>
                                    </div> -->
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle tenant-list">
                                            <thead>
                                                <tr>
                                                    <th>Company Name</th>
                                                    <th>Admin Name</th>
                                                    <th>Database</th>
                                                    <th>Users</th>
                                                    <th>Invoices</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($tenants as $tenant): ?>
                                                <tr>
                                                    <td><?= esc($tenant->tenant_company_name) ?></td>
                                                    <td><?= esc($tenant->username) ?></td>
                                                    <td><?= esc($tenant->tenant_database_name) ?></td>
                                                    <td>
                                                        <?php
                                                        // Find the total users count for this company
                                                        $totalUsersForCompany = 0;
                                                        foreach ($totalUsersCountPerCompany as $companyData) {
                                                            if ($companyData->tenant_company_name === $tenant->tenant_company_name) {
                                                                $totalUsersForCompany = $companyData->total_users;
                                                                break;
                                                            }
                                                        }
                                                        echo esc($totalUsersForCompany);
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        // Fetch the invoice count for this tenant using tenant_database_name as the key
                                                        $invoiceCount = isset($totalInvoiceCountPerCompany[$tenant->tenant_database_name]) 
                                                                        ? $totalInvoiceCountPerCompany[$tenant->tenant_database_name] 
                                                                        : 0;
                                                        ?>
                                                        <?= esc($invoiceCount) ?>
                                                    </td>
                                                        <!-- Subscription Status -->
                                                        <?php
                                                            // Get the subscription status for the current tenant
                                                            $status = $EachCompanyCurrentStatus[$tenant->tenant_company_name]['subscription_status'] ?? 'N/A';

                                                            // Define status color mapping
                                                            $statusColorMap = [
                                                                'active' => 'bg-success',
                                                                'pending' => 'bg-warning',
                                                                'inactive' => 'bg-secondary',
                                                                'suspended' => 'bg-danger',
                                                                'cancelled' => 'bg-danger',
                                                                'expired' => 'bg-warning',
                                                                'archived' => 'bg-dark',
                                                                'default' => 'bg-light text-dark'
                                                            ];

                                                            // Get the appropriate background class
                                                            $statusClass = $statusColorMap[$status] ?? $statusColorMap['default'];
                                                        ?>
                                                    <td>
                                                        <span class="badge <?= $statusClass ?>">
                                                            <?= ucfirst($status) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="tenant-actions">
                                                            <button class="btn btn-outline-primary btn-sm view-company" data-id="<?=$tenant->id?>"><i class="fas fa-eye"></i></button>
                                                            <button class="btn btn-outline-secondary btn-sm edit-company" data-id="<?=$tenant->id?>"><i class="fas fa-edit"></i></button>
                                                            <button class="btn btn-outline-danger btn-sm delete-company" data-id="<?=$tenant->id?>"><i class="fas fa-trash-alt"></i> </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Modal for Viewing Company Details -->
    <div class="modal fade" id="viewCompanyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><span id="tenantHeaderName"></span> - Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Name</th>
                                    <td id="companyName"></td>
                                </tr>
                                <tr>
                                    <th>Admin</th>
                                    <td id="companyAdmin"></td>
                                </tr>
                                <tr>
                                    <th>Database</th>
                                    <td id="companyDatabase"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Subscription Overview</h6>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span id="companyStatus" class="badge"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Users</th>
                                    <td id="companyUsers"></td>
                                </tr>
                                <tr>
                                    <th>Total Invoices</th>
                                    <td id="companyInvoices"></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <h6>Detailed Subscription Information</h6>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody id="subscriptionDetailsBody">
                            <!-- Dynamically populated rows will go here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit <span id="companytHeaderName"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editCompanyForm">
                        <input type="hidden" id="editTenantId" name="tenant_id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="editCompanyName" name="company_name" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Admin Username</label>
                                <input type="text" class="form-control" id="editAdminUsername" name="admin_username" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Database Name</label>
                                <input type="text" class="form-control" id="editDatabaseName" name="database_name" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Invoices</label>
                                <input type="text" class="form-control" id="ediTotalInvoices" name="total_inovices" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Total Users</label>
                                <input type="text" class="form-control" id="editTotalUsers" name="total_users" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subscription Status</label>
                                <select class="form-select" id="editSubscriptionStatus" name="subscription_status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="pending">Pending</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="archived">Archived</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCompanyChanges">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <?php include 'js.php'?>
    <script>
        // Nav-bar search 
        $(document).ready(function() {
            $('input[type="search"]').on('input', function() {
                let searchText = $(this).val().trim();
                console.log('SearchText is: ',searchText);
                
              $('#dashboardmodal').modal('show')
            });
        });


       $(document).ready(function() {
        $('.view-company').on('click', function(e) {
            e.preventDefault();

            var tenantId = $(this).data('id');
            var $row = $(this).closest('tr');
            var tenantDB = $row.find('td:nth-child(3)').text().trim();

            var tenantDetails = $row.find('td').map(function() {
                return $(this).text().trim();
            }).get();

            $.ajax({
                url: 'view-tenant-details',
                method: 'POST',
                data: {
                    id: tenantId,
                    database: tenantDB,
                    tenantDetails: tenantDetails,
                },
                success: function(response) {
                    // Basic Information
                    $('#tenantHeaderName').text(response.company_name);
                    $('#companyName').text(response.company_name);
                    $('#companyAdmin').text(response.admin_username);
                    $('#companyDatabase').text(response.database_name);

                    // Status Badge
                    var statusClass = response.subscription_status === 'Active' ? 'bg-success' : 
                                    response.subscription_status === 'Pending' ? 'bg-warning' : 'bg-secondary';
                    $('#companyStatus')
                        .text(response.subscription_status)
                        .removeClass()
                        .addClass('badge ' + statusClass);

                    $('#companyUsers').text(response.total_users);
                    $('#companyInvoices').text(response.total_invoices);

                    // Populate Subscription Details Table
                    var $subscriptionBody = $('#subscriptionDetailsBody');
                    $subscriptionBody.empty();

                    // Check if subscription details exist
                    if (response.subscriptions && response.subscriptions.length > 0) {
                        response.subscriptions.forEach(function(sub) {
                            var paymentStatusClass = sub.status === 'completed' ? 'bg-success' : 
                                                    sub.status === 'pending' ? 'bg-warning' : 'bg-secondary';
                            
                            var row = `
                                <tr>
                                    <td>${sub.plan_name}</td>
                                    <td>${sub.start_date}</td>
                                    <td>${sub.end_date}</td>
                                    <td>${sub.subscription_duration}</td>
                                    <td>
                                        <span class="badge ${paymentStatusClass}">
                                            ${sub.status}
                                        </span>
                                    </td>
                                </tr>
                            `;
                            $subscriptionBody.append(row);
                        });
                    } else {
                        $subscriptionBody.html(`
                            <tr>
                                <td colspan="5" class="text-center">No subscription details available</td>
                            </tr>
                        `);
                    }

                    // Show the modal
                    $('#viewCompanyModal').modal('show');
                },
                error: function() {
                    alert('Failed to load company details');
                }
            });
        });
            // Edit tenant
            $('.edit-company').on('click', function (e) {
                e.preventDefault();

                var tenantId = $(this).data('id');
                var $row = $(this).closest('tr');
                var tenantDB = $row.find('td:nth-child(3)').text().trim();
                
                // Map all cell values in the row to an array
                var tenantDetails = $row.find('td').map(function() {
                    return $(this).text().trim();
                }).get();

                // console.log(tenantDetails);
                // return 

                $.ajax({
                    url: '/edit-tenant-details',
                    method: 'POST', 
                    data: {
                        id: tenantId,
                        database: tenantDB,
                        tenantDetails: tenantDetails,
                    },
                    success: function (response) {
                        // console.log(response);
                        $('#editTenantId').val(response.tenant_id);
                        $('#companytHeaderName').text(response.company_name);
                        $('#editCompanyName').val(response.company_name);
                        $('#editAdminUsername').val(response.admin_username);
                        $('#editDatabaseName').val(response.database_name);
                        $('#ediTotalInvoices').val(response.total_invoices);
                        $('#editTotalUsers').val(response.total_users);
                        $('#editSubscriptionStatus').val(response.subscription_status);

                        $('#editCompanyModal').modal('show'); 
                    },
                    error: function (xhr) {
                        alert('Failed to fetch tenant details');
                    },
                });
            });

            // Save changes button handler
            $('#saveCompanyChanges').on('click', function() {
                const $button = $(this);
                const $spinner = $button.find('.spinner-border');
                
                $spinner.removeClass('d-none');
                $button.prop('disabled', true);
                formData = $('#editCompanyForm').serialize();
                console.log(formData);
                // return 

                $.ajax({
                    url: 'save-updated-tenant-details',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        // if(response.success) {
                            $('#editCompanyModal').modal('hide');
                            // Optionally refresh the table or update the row
                            location.reload();
                        // } else {
                        //     alert('Failed to update tenant details');
                        // }
                    },
                    error: function() {
                        alert('Error updating tenant details');
                    },
                    complete: function() {
                        $spinner.addClass('d-none');
                        $button.prop('disabled', false);
                    }
                });
            });

            // delete company handler
            $('.delete-company').on('click', function (e) { 
                var tenantId = $(this).data('id');
                var $row = $(this).closest('tr');
                var tenantDB = $row.find('td:nth-child(3)').text().trim(); // Selecting the database name column

                console.log('tenantId', tenantId);
                console.log('tenantDB', tenantDB);
                // return

                if (confirm('Are you sure you want to delete this Tenant?')) {

                    $.ajax({
                        url: 'delete-tenant-details',
                        method: 'POST',
                        data: {
                            id: tenantId,
                            database: tenantDB
                        },
                        beforeSend: function() {
                            console.log('Sending tenant-id to server for deletion...');
                            // Optional: Disable button or show loading indicator
                        },
                        success: function(response) {
                            console.log(response);
                            // Remove the row from the UI
                            $row.remove();
                            alert('Tenant deleted successfully');
                        },
                        error: function(xhr, status, error) {
                            console.error('Deletion failed:', error);
                            alert('Failed to delete tenant');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>