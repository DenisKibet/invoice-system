<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Tenants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'css.php'?>

    <style>
        .tenant-card {
            transition: transform 0.2s;
        }
        .tenant-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .search-bar {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        /* <!-- Additional CSS   FOR FILTERS --> */
        .input-group-text {
            border-right: none;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: #dee2e6;
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,.15);
        }
        
        /* <!-- Additional CSS FOR EDIT AND DELETE--> */
        .modal-content {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .modal .form-control:focus,
        .modal .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-sm {
            font-size: 0.875rem;
            padding: 0.25rem 0.75rem;
        }

        .toast {
            opacity: 0.95;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        
        /* <!-- Additional CSS add tenandt butto--> */
            .btn-primary {
                font-weight: 500;
            }

            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }

            .fas.fa-building {
                color: #495057;
            }

            .modal .form-control:focus,
            .modal .form-select:focus {
                border-color: #80bdff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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

        /* For Get emails modal */
        .email-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .email-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .email-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px;
            margin-bottom: 5px;
            background-color: #fff;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }
        .email-item:hover {
            background-color: #f8f9fa;
        }
        .company-btn {
            margin-bottom: 10px;
            text-align: left;
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
                            <h2 class="mb-0 d-flex align-items-center">
                                <i class="fas fa-building me-3" style="font-size: 1.5rem;"></i>
                                Manage Tenants
                            </h2>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary d-flex align-items-center shadow-none" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#getEmailsModal"
                                        style="transition: all 0.3s ease;">
                                    <i class="fas fa-envelope me-2"></i>
                                    <span>Get Emails</span>
                                </button>
                                <!-- <button class="btn btn-primary d-flex align-items-center shadow-none" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#addTenantModal"
                                        style="transition: all 0.3s ease;">
                                    <i class="fas fa-plus me-2"></i>
                                    <span>Add New Tenant</span> -->
                                </button>
                            </div>
                        </div>

                        <!-- Search and Filter Bar -->
                        <div class="search-bar mb-3">
                            <div class="row g-3">
                                <!-- Search Bar -->
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #fff;">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" 
                                            class="form-control shadow-none" 
                                            id="tenantSearch" 
                                            placeholder="Search tenants..."
                                            style="border-left: none;">
                                        <div class="spinner-border spinner-border-sm text-primary d-none" 
                                            id="searchSpinner" 
                                            role="status" 
                                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); z-index: 4;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Filter -->
                                <div class="col-md-3">
                                    <select class="form-select shadow-none" id="statusFilter">
                                        <option value="">All Statuses</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                                
                                <!-- Sort Options -->
                                <div class="col-md-3">
                                    <select class="form-select shadow-none" id="sortOptions">
                                        <option value="name_asc">Name (A-Z)</option>
                                        <option value="name_desc">Name (Z-A)</option>
                                        <option value="date_desc">Newest First</option>
                                        <option value="date_asc">Oldest First</option>
                                    </select>
                                </div>
                                
                                <!-- Clear Filters Button -->
                                <div class="col-md-2">
                                    <button class="btn btn-outline-secondary w-100 shadow-none" id="clearFilters">
                                        <i class="fas fa-undo me-2"></i>Clear Filters
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- No Results Message -->
                        <div id="noResults" class="alert alert-info mt-4 text-center d-none">
                            <i class="fas fa-info-circle me-2"></i>
                            <span>No tenants found matching your search criteria.</span>
                        </div>

                        <!-- Tenants Grid -->
                        <div class="row">
                        <?php foreach ($allCompanyDetails as $tenantId => $tenantData): ?>
                            <?php foreach ($tenantData['companies'] as $tenant): ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card tenant-card">
                                            <div class="card-body">
                                                <!-- Status Badge -->
                                                <?php
                                                    $status = $tenant->subscription_status ?? 'Active';
                                                    $badgeClass = 'bg-secondary';
                                                    if ($status === 'Active') {
                                                        $badgeClass = 'bg-success';
                                                    } elseif ($status === 'Pending') {
                                                        $badgeClass = 'bg-warning';
                                                    } elseif ($status === 'Inactive') {
                                                        $badgeClass = 'bg-danger';
                                                    }
                                                ?>
                                                <span class="badge <?= $badgeClass ?> status-badge"><?= esc($status) ?></span>
                                                
                                                <h5 class="card-title"><?= esc($tenant->company_name) ?></h5>
                                                <p class="card-text text-muted mb-2">
                                                    <i class="fas fa-envelope me-2" style="cursor: pointer;"></i><?= esc($tenant->email) ?>
                                                </p>
                                                <p class="card-text text-muted mb-3">
                                                    <i class="fas fa-phone me-2"></i><?= esc($tenant->mobile_no) ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                
                                                    <small class="text-muted">Users:2</small>
                                                    <small class="text-muted">Invoices: 8</small>
                                                </div>
                                                <hr>
                                            <!-- Action Buttons -->
                                                <div class="d-flex justify-content-between mt-3">
                                                    <!-- Edit Button -->
                                                    <button class="btn btn-outline-primary btn-sm px-3 d-flex align-items-center" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editTenantModal"
                                                            onclick="editTenant(this)"
                                                            style="transition: all 0.3s ease;">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <button class="btn btn-outline-danger btn-sm px-3 d-flex align-items-center" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#deleteTenantModal"
                                                            onclick="confirmDelete(this)"
                                                            style="transition: all 0.3s ease;">
                                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center">
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
                           
       <!-- Add Tenant Modal -->
       <div class="modal fade" id="getEmailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Tenant Emails</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white d-flex align-items-center" style="background-color: #007bff;">
                                    <i class="fas fa-building me-3"></i>
                                    <h4 class="mb-0">Company Emails</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Company Selector Column -->
                                        <div class="col-md-4 border-end" id="company-list1">
                                            <h5 class="mb-4">Select Company</h5>
                                            <?php foreach ($tenantsList as $company): ?>
                                                <button 
                                                    class="btn btn-outline-primary w-100 company-btn" 
                                                    data-id="<?= htmlspecialchars($company->id) ?>"
                                                    data-db="<?= htmlspecialchars($company->tenant_database_name) ?>">
                                                    <i class="fas fa-building me-2"></i>
                                                    <?= htmlspecialchars($company->tenant_company_name) ?>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>

                                        <!-- Email Details Column -->
                                        <div class="col-md-8">
                                            <h5 class="mb-4" id="selected-company-title">Select a Company</h5>
                                            
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <div class="card email-card" id="company-email-section">
                                                        <div class="card-header bg-info text-white">
                                                            <i class="fas fa-building me-2"></i> Company Email
                                                        </div>
                                                        <input class="hiddenInputToGetId" type="hidden" id="1">
                                                        <div class="card-body" id="company-email-list">
                                                            <!-- Company emails will be dynamically added -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <div class="card email-card" id="admin-email-section">
                                                        <div class="card-header bg-success text-white">
                                                            <i class="fas fa-user-shield me-2"></i> Admin Email
                                                        </div>
                                                        <div class="card-body" id="admin-email-list">
                                                            <!-- Admin emails will be dynamically added -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <div class="card email-card" id="user-email-section">
                                                        <div class="card-header bg-warning text-white">
                                                            <i class="fas fa-users me-2"></i> User Emails
                                                        </div>
                                                        <div class="card-body" id="user-email-list">
                                                            <!-- User emails will be dynamically added -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="card email-card" id="client-email-section">
                                                        <div class="card-header bg-danger text-white">
                                                            <i class="fas fa-envelope me-2"></i> Client Emails
                                                        </div>
                                                        <div class="card-body" id="client-email-list">
                                                            <!-- Client emails will be dynamically added -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="downloadTenantEmails">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                        Download Emails
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Tenant Modal -->
    <div class="modal fade" id="addTenantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Add New Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTenantForm">
                        <div class="mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="newCompanyName" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="newEmail" required >
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="newPhone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="newStatus" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="createTenant()">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                        Add Tenant
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Edit Tenant Modal -->
<div class="modal fade" id="editTenantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">Edit Tenant Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTenantForm">
                    <input type="hidden" id="editTenantId">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="editCompanyName" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="editPhone" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Subscription Start Date</label>
                            <input type="date" class="form-control" id="startDate" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Subscription End Date</label>
                            <input type="date" class="form-control" id="endDate" required>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="editStatus" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Pending">Pending</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveTenantChanges()">
                    <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteTenantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="deleteTenantId">
                    <p class="mb-0">Are you sure you want to delete <strong id="deleteTenantName"></strong>?</p>
                    <p class="text-muted small mb-0 mt-2">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="deleteTenant()">
                        <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                        Delete Tenant
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1070">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong class="ml-2">Success</strong><br>
                    <i class="fas fa-check-circle me-2"></i>
                    <span id="successMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        
        <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>Error</strong><br>
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <span id="errorMessage"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>



    <?php include 'js.php' ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

     <!-- Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  
    <!-- JavaScript for Search Functionality -->
    <script>
        $(document).ready(function() {
            let searchTimeout;
            const searchSpinner = $('#searchSpinner');
            const noResults = $('#noResults');

            // Search functionality with debounce
            $('#tenantSearch').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                searchSpinner.removeClass('d-none');
                
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    filterTenants(searchTerm);
                }, 300);
            });

            // Status filter change
            $('#statusFilter').on('change', function() {
                filterTenants($('#tenantSearch').val().toLowerCase());
            });

            // Sort options change
            $('#sortOptions').on('change', function() {
                filterTenants($('#tenantSearch').val().toLowerCase());
            });

            // Clear filters
            $('#clearFilters').on('click', function() {
                $('#tenantSearch').val('');
                $('#statusFilter').val('');
                $('#sortOptions').val('name_asc');
                filterTenants('');
            });

            function filterTenants(searchTerm) {
                const statusFilter = $('#statusFilter').val().toLowerCase();
                let visibleCount = 0;

                $('.tenant-card').each(function() {
                    const card = $(this).closest('.col-md-4');
                    const tenantName = $(this).find('.card-title').text().toLowerCase();
                    const tenantStatus = $(this).find('.status-badge').text().toLowerCase();
                    
                    const matchesSearch = tenantName.includes(searchTerm);
                    const matchesStatus = !statusFilter || tenantStatus === statusFilter;
                    
                    if (matchesSearch && matchesStatus) {
                        card.show();
                        visibleCount++;
                    } else {
                        card.hide();
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0) {
                    noResults.removeClass('d-none');
                } else {
                    noResults.addClass('d-none');
                }

                // Sort visible cards
                const sortOption = $('#sortOptions').val();
                sortTenants(sortOption);

                // Hide spinner after processing
                searchSpinner.addClass('d-none');
            }

            function sortTenants(sortOption) {
                const container = $('.row:has(.tenant-card)');
                const cards = container.children('.col-md-4').get();

                cards.sort((a, b) => {
                    const nameA = $(a).find('.card-title').text().toLowerCase();
                    const nameB = $(b).find('.card-title').text().toLowerCase();
                    
                    if (sortOption === 'name_asc') return nameA.localeCompare(nameB);
                    if (sortOption === 'name_desc') return nameB.localeCompare(nameA);
                    // Add more sorting options as needed
                    
                    return 0;
                });

                container.append(cards);
            }
        });

        // FOR EDIT AND DELETE SECTION
        // <!-- JavaScript for handling tenant actions -->
        function editTenant(button) {
            const card = $(button).closest('.tenant-card');
            const tenantId = card.data('tenant-id');
            const companyName = card.find('.card-title').text();
            const email = card.find('.card-text:contains("@")').text().trim();
            const phone = card.find('.card-text:contains("+")').text().trim();
            const status = card.find('.status-badge').text().trim();
            console.log(tenantId);

            $('#editTenantId').val(tenantId);
            $('#editCompanyName').val(companyName);
            $('#editEmail').val(email);
            $('#editPhone').val(phone);
            $('#editStatus').val(status);
        }

        function confirmDelete(button) {
            const card = $(button).closest('.tenant-card');
            const tenantId = card.data('tenant-id');
            const companyName = card.find('.card-title').text();
            console.log(tenantId);
            
            $('#deleteTenantId').val(tenantId);
            $('#deleteTenantName').text(companyName);
        }

        function saveTenantChanges() {
            const saveBtn = $('.modal-footer .btn-primary');
            const spinner = saveBtn.find('.spinner-border');
            
            // Show loading state
            saveBtn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Collect form data
            const tenantData = {
                id: $('#editTenantId').val(),
                companyName: $('#editCompanyName').val(),
                email: $('#editEmail').val(),
                phone: $('#editPhone').val(),
                status: $('#editStatus').val()
            };
            // console.log(tenantData);

            // Simulate API call
            setTimeout(() => {
                try {
                    // Update UI
                    const card = $(`.tenant-card[data-tenant-id="${tenantData.id}"]`);
                    card.find('.card-title').text(tenantData.companyName);
                    card.find('.card-text:contains("@")').text(tenantData.email);
                    card.find('.card-text:contains("+")').text(tenantData.phone);
                    card.find('.status-badge').text(tenantData.status);

                    // Show success message
                    $('#successMessage').text('Tenant updated successfully');
                    new bootstrap.Toast($('#successToast')).show();
                    
                    // Close modal
                    $('#editTenantModal').modal('hide');
                } catch (error) {
                    $('#errorMessage').text('Error updating tenant');
                    new bootstrap.Toast($('#errorToast')).show();
                } finally {
                    // Reset loading state
                    saveBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                }
            }, 1000);
        }

        function deleteTenant() {
            const deleteBtn = $('#deleteTenantModal .btn-danger');
            const spinner = deleteBtn.find('.spinner-border');
            const tenantId = $('#deleteTenantId').val();

            // Show loading state
            deleteBtn.prop('disabled', true);
            spinner.removeClass('d-none');

            // Simulate API call
            setTimeout(() => {
                try {
                    // Remove card from UI
                    $(`.tenant-card[data-tenant-id="${tenantId}"]`).closest('.col-md-4').fadeOut(300, function() {
                        $(this).remove();
                    });

                    // Show success message
                    $('#successMessage').text('Tenant deleted successfully');
                    new bootstrap.Toast($('#successToast')).show();
                    
                    // Close modal
                    $('#deleteTenantModal').modal('hide');
                } catch (error) {
                    $('#errorMessage').text('Error deleting tenant');
                    new bootstrap.Toast($('#errorToast')).show();
                } finally {
                    // Reset loading state
                    deleteBtn.prop('disabled', false);
                    spinner.addClass('d-none');
                }
            }, 1000);
        }

        // Add hover effects to buttons
        $(document).ready(function() {
            $('.btn-outline-primary').hover(
                function() { $(this).addClass('btn-primary').removeClass('btn-outline-primary'); },
                function() { $(this).addClass('btn-outline-primary').removeClass('btn-primary'); }
            );
            
            $('.btn-outline-danger').hover(
                function() { $(this).addClass('btn-danger').removeClass('btn-outline-danger'); },
                function() { $(this).addClass('btn-outline-danger').removeClass('btn-danger'); }
            );
        });

        
// <!-- JavaScript for handling add tenant -->
function createTenant() {
    const saveBtn = $('#addTenantModal .btn-primary');
    const spinner = saveBtn.find('.spinner-border');
    
    // Show loading state
    saveBtn.prop('disabled', true);
    spinner.removeClass('d-none');

    // Collect form data
    const tenantData = {
        companyName: $('#newCompanyName').val(),
        email: $('#newEmail').val(),
        phone: $('#newPhone').val(),
        status: $('#newStatus').val()
    };

    // Simulate API call
    setTimeout(() => {
        try {
            // Add new card to UI
            const newCard = `
                <div class="col-md-4 mb-4">
                    <div class="card tenant-card" data-tenant-id="${Date.now()}">
                        <div class="card-body">
                            <span class="badge bg-success status-badge">${tenantData.status}</span>
                            <h5 class="card-title">${tenantData.companyName}</h5>
                            <p class="card-text text-muted mb-2">
                                <i class="fas fa-envelope me-2"></i>${tenantData.email}
                            </p>
                            <p class="card-text text-muted mb-3">
                                <i class="fas fa-phone me-2"></i>${tenantData.phone}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Users:0</small>
                                <small class="text-muted">Invoices: 1</small>
                            </div>
                            ${$('#tenant-actions-template').html()}
                        </div>
                    </div>
                </div>
            `;
            $('.row:has(.tenant-card)').append(newCard);

            // Show success message
            $('#successMessage').text('Tenant added successfully');
            new bootstrap.Toast($('#successToast')).show();
            
            // Clear form and close modal
            $('#addTenantForm')[0].reset();
            $('#addTenantModal').modal('hide');
        } catch (error) {
            $('#errorMessage').text('Error adding new tenant');
            new bootstrap.Toast($('#errorToast')).show();
        } finally {
            // Reset loading state
            saveBtn.prop('disabled', false);
            spinner.addClass('d-none');
        }
    }, 1000);
}


//  Get Emails Modal
 $(document).ready(function() {
        // Sample data - replace with your actual data source
        const companyEmails = [
            {
                companyName: 'Tech Innovations Inc.',
                companyEmail: 'info@techinnovations.com',
                adminEmail: 'admin@techinnovations.com',
                userEmails: [
                    'john.doe@techinnovations.com',
                    'jane.smith@techinnovations.com',
                    'mike.brown@techinnovations.com'
                ],
                clientEmails: [
                    'client1@example.com',
                    'client2@example.com'
                ]
            },
            {
                companyName: 'Global Solutions Ltd.',
                companyEmail: 'contact@globalsolutions.com',
                adminEmail: 'admin@globalsolutions.com',
                userEmails: [
                    'emily.wang@globalsolutions.com',
                    'alex.lee@globalsolutions.com'
                ],
                clientEmails: [
                    'client3@example.com',
                    'client4@example.com',
                    'client5@example.com'
                ]
            }
        ];

        // Function to render company buttons
        function renderCompanyButtons() {
            const companyList = $('#company-list');
            companyList.empty();
            companyEmails.forEach((company, index) => {
                const button = $(`
                    <button class="btn btn-outline-primary w-100 company-btn" data-index="${index}">
                        <i class="fas fa-building me-2"></i> ${company.companyName}
                    </button>
                `);
                companyList.append(button);
            });
        }

        // Function to render email sections
        function renderEmailSections(company) {
            $('#selected-company-title').text(company.companyName);

            // Company Email
            const companyEmailList = $('#company-email-list');
            companyEmailList.empty().append(createEmailItem(company.companyEmail));

            // Admin Email
            const adminEmailList = $('#admin-email-list');
            adminEmailList.empty().append(createEmailItem(company.adminEmail));

            // User Emails
            const userEmailList = $('#user-email-list');
            userEmailList.empty();
            company.userEmails.forEach(email => {
                userEmailList.append(createEmailItem(email));
            });

            // Client Emails
            const clientEmailList = $('#client-email-list');
            clientEmailList.empty();
            company.clientEmails.forEach(email => {
                clientEmailList.append(createEmailItem(email));
            });
        }

        // Function to create email list item with copy functionality
        function createEmailItem(email) {
            return $(`
                <div class="email-item">
                    <span>${email}</span>
                    <button class="btn btn-sm btn-outline-secondary copy-email" data-email="${email}">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            `);
        }

        // Event handler for company button selection
        $(document).on('click', '.company-btn', function () {
            const companyId = $(this).data('id'); 
            const databaseName = $(this).data('db'); // Get the tenant database name


            $.ajax({
                type: 'get',
                url: 'get-tenant-emails', // The route to handle the request
                data: { 
                    companyId: companyId, 
                    tenantDatabase: databaseName 
                }, // Send both parameters
                beforeSend: function () {
                    // console.log('Request is being sent...');
                },
                success: function (data) {
                    // console.log('Response:', data);
                    
                    function renderEmailSections() {
                        // Company Email
                        const companyEmailList = $('#company-email-list');
                        companyEmailList.empty().append(createEmailItem(data.getTenantsEmails.companyEmail[0].email));

                        // Admin Email
                        const adminEmailList = $('#admin-email-list');
                        adminEmailList.empty().append(createEmailItem(data.getTenantsEmails.adminEmail[0].email));

                        // User Emails
                        const userEmailList = $('#user-email-list');
                        userEmailList.empty();
                        // FIXED: Corrected .usersEmailsforEach to .usersEmails.forEach
                        data.getTenantsEmails.usersEmails.forEach(email => {
                            userEmailList.append(createEmailItem(email.email));
                        });

                        // Client Emails
                        const clientEmailList = $('#client-email-list');
                        clientEmailList.empty();
                        // FIXED: Directly use .forEach on clientEmail array
                        data.getTenantsEmails.clientEmail.forEach(email => {
                            clientEmailList.append(createEmailItem(email.email));
                        });
                    }
                    renderEmailSections();
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                },
            });

            // Highlight the selected button
            $('.company-btn').removeClass('active btn-primary').addClass('btn-outline-primary');
            $(this).removeClass('btn-outline-primary').addClass('active btn-primary');
        });



        // Event handler for email copy
        $(document).on('click', '.copy-email', function() {
            const email = $(this).data('email');
            navigator.clipboard.writeText(email).then(() => {
                alert(`Copied: ${email}`);
            });
        });

        // Initial render
        renderCompanyButtons();
    });

    // Dowload Client emails
    $('#downloadTenantEmails').on('click', function (e) { 
        CompanyId = 1;
        // const companyId = $(this).data('id'); // Get thecompany ID
        console.log(companyId);
        return

        $.ajax({
            type: 'get',
            url: 'get-all-email-per=tenant',
            data: CompanyId,
            beforeSend: function () {
                console.log('Request is being sent...');
            },
            success: function(data) {
                console.log(data.message);
            },
        });
    });
    </script>
</body>
</html>
