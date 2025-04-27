<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - Invoices</title>
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
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .status-badge {
            width: 85px;
        }
        .invoice-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
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
                            <h2>Invoice Management</h2>
                            <button class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Invoice
                            </button>
                        </div>

                        <!-- Statistics Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card stats-card" style="border-left-color: #2ecc71;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Paid Invoices (<?= $totalPaidInvoiceCount['count'] ?>)</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-0">
                                                <?php  echo '£' . number_format($totalPaidInvoiceCount['total_paid'], 2, '.', ','); ?>
                                            </h3>
                                            <i class="fas fa-check-circle text-success fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stats-card" style="border-left-color: #e74c3c;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Overdue (<?= $totalOverdueInvoice['count'] ?>)</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-0">
                                                <?php  echo '£' . number_format($totalOverdueInvoice['total_amount'], 2, '.', ','); ?>
                                            </h3>
                                            <i class="fas fa-exclamation-circle text-danger fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stats-card" style="border-left-color: #f1c40f;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Partially Paid (<?= $totalPartiallyPaidInvoice['count'] ?>)</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-0">
                                                <?php  echo '£' . number_format($totalPartiallyPaidInvoice['total_amount'], 2, '.', ','); ?>
                                            </h3>
                                            <i class="fas fa-clock text-warning fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card stats-card" style="border-left-color: #3498db;">
                                    <div class="card-body">
                                        <h6 class="text-muted">Total Invoices</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="mb-0"><?= esc($totalInvoices)?></h3>
                                            <i class="fas fa-file-invoice text-primary fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Section -->
                        <div class="filter-section">
                            <div class="row">
                                <div class="col-md-3">
                                    Quick Search
                                    <div class="input-group">
                                        <span class="input-group-text" style="background: #fff;">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" 
                                            class="form-control shadow-none" 
                                            placeholder="Search invoices..."
                                        >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    Status
                                    <select class="form-select shadow-none">
                                        <option value="">All Status</option>
                                        <option value="paid">Paid</option>
                                        <option value="Partially Paid">Partially Paid</option>
                                        <option value="overdue">Overdue</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    Tenant 
                                    <select class="form-select shadow-none">
                                        <option value="">All Tenants</option>
                                        <?php foreach ($tenants as $tenant): ?>
                                            <option value="<?= htmlspecialchars($tenant->tenant_company_name) ?>">
                                                <?= htmlspecialchars($tenant->tenant_company_name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                        <option value="acme">Acme Corp</option>
                                        <option value="techstart">TechStart Inc</option>
                                        <option value="global">Global Services</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    Date From:
                                    <input type="date" class="form-control shadow-none" placeholder="Date From">
                                </div>
                                <div class="col-md-2">
                                    Date From
                                    <input type="date" class="form-control shadow-none" placeholder="Date To">
                                </div>
                                <div class="col-md-1">
                                    Reset 
                                    <button class="btn btn-outline-secondary w-100" title="Reset Filters">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Table -->
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Invoice #</th>
                                            <th>Tenant</th>
                                            <th>Date</th>
                                            <th>Due Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($singleInvoiceDetails as $databaseName => $tenantData): ?>
                                            <?php foreach ($tenantData['invoices'] as $invoice): ?>
                                                <tr>
                                                    <td><?= esc($invoice->invoice_no) ?></td>
                                                    <td><?= esc($tenantData['company_name']) ?></td>
                                                    <td><?= esc($invoice->invoice_date) ?></td>
                                                    <td><?= esc($invoice->due_date) ?></td>
                                                    <td>£<?= number_format($invoice->total, 2) ?></td>
                                                    <td>
                                                        <span class="badge bg-success status-badge">Paid</span>
                                                    </td>
                                                    <td class="invoice-actions">
                                                        <button class="btn btn-outline-primary btn-sm" data-db="<?=$databaseName?>">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button class="btn btn-outline-secondary btn-sm" data-db="<?=$databaseName?>">
                                                            <i class="fas fa-download"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger btn-sm" data-db="<?=$databaseName?>">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                        <?php if (empty(array_filter($singleInvoiceDetails))): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No invoices found</td>
                                            </tr>
                                        <?php endif; ?>
                                            <tr>
                                                <td>INV-2024-002</td>
                                                <td>TechStart Inc.</td>
                                                <td>2024-08-20</td>
                                                <td>2024-09-20</td>
                                                <td>£2,750.00</td>
                                                <td>
                                                    <span class="badge bg-warning status-badge">Partially paid</span>
                                                </td>
                                                <td class="invoice-actions">
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>INV-2024-003</td>
                                                <td>Global Services LLC</td>
                                                <td>2024-10-10</td>
                                                <td>2024-12-10</td>
                                                <td>£3,500.00</td>
                                                <td>
                                                    <span class="badge bg-danger status-badge">Overdue</span>
                                                </td>
                                                <td class="invoice-actions">
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>INV-2024-004</td>
                                                <td>Global Services LLC</td>
                                                <td>2024-01-10</td>
                                                <td>2024-02-10</td>
                                                <td>£3,500.00</td>
                                                <td>
                                                    <span class="badge bg-secondary status-badge">Pending</span>

                                                </td>
                                                <td class="invoice-actions">
                                                    <button class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            

                                <!-- Pagination -->
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <div class="text-muted">
                                        Showing 1 to 4 of 4 entries
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
    <div class="modal" id="previewmodal" tabindex="-1" role="dialog" style="color:black;">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invoice System</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be dynamically loaded here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div

    <?php include 'js.php'?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
   $(document).ready(function() {
        // Cache DOM elements
        const $searchInput = $('.filter-section input[type="text"]');
        const $statusSelect = $('.filter-section select:eq(0)');
        const $tenantSelect = $('.filter-section select:eq(1)');
        const $dateFrom = $('.filter-section input[type="date"]:eq(0)');
        const $dateTo = $('.filter-section input[type="date"]:eq(1)');
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
                        <td colspan="7" class="text-center text-muted">
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
                
                // Status filter
                const selectedStatus = $statusSelect.val().toLowerCase();
                const rowStatus = row.find('.status-badge').text().toLowerCase();
                if (selectedStatus && rowStatus !== selectedStatus) {
                    showRow = false;
                }

                // Tenant filter
                const selectedTenant = $tenantSelect.val().toLowerCase();
                const rowTenant = row.find('td:eq(1)').text().toLowerCase();

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

                // Date range filter
                const dateFrom = $dateFrom.val();
                const dateTo = $dateTo.val();
                const rowDate = row.find('td:eq(2)').text(); // Invoice date column

                if (dateFrom && rowDate < dateFrom) {
                    showRow = false;
                }
                if (dateTo && rowDate > dateTo) {
                    showRow = false;
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

        // Filter button click
        $filterBtn.on('click', function() {
            applyFilters();
        });

        // Reset button click
        $resetBtn.on('click', function() {
            // Clear all filters
            $searchInput.val('');
            $statusSelect.val('');
            $tenantSelect.val('');
            $dateFrom.val('');
            $dateTo.val('');
            
            // Show all rows and remove "No Data" message
            $tableRows.show();
            $tableBody.find('.no-data-row').remove();
        });

        // Status and Tenant select change
        $statusSelect.add($tenantSelect).on('change', function() {
            applyFilters();
        });

        // Date inputs change
        $dateFrom.add($dateTo).on('change', function() {
            applyFilters();
        });
    });


    // FOR TABLE VIEW, DOWNLOAD AND DELETE INVOICE.
    $(document).ready(function() {
        // View Invoice
        $('.invoice-actions .btn-outline-primary').on('click', function() {
        const $row = $(this).closest('tr');
        const invoiceNumber = $row.find('td:eq(0)').text().trim();
        const dbName = $(this).data('db');
        
        // Show loading state
        const $button = $(this);
        const $icon = $button.find('i');
        $button.prop('disabled', true);
        $icon.removeClass('fa-download').addClass('fa-spinner fa-spin');

        $.ajax({
            url: `/super-admin-invoices/view`,
            method: 'POST',
            data: {
                invoice_number: invoiceNumber,
                database_name: dbName
            },
            success: function(response) {
                $('#previewmodal .modal-body').html(response);
                $('#previewmodal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error fetching invoice:", error);
                alert('Failed to load invoice. Please try again.');
            },
            complete: function() {
                // Restore button state
                $button.prop('disabled', false);
                $icon.removeClass('fa-spinner fa-spin').addClass('fa-download');
            }
        });
        
        // Download Invoice
        $('.invoice-actions .btn-outline-secondary').on('click', function() {
            const $row = $(this).closest('tr');
            const invoiceNumber = $row.find('td:eq(0)').text().trim(); // Added trim()
            const dbName = $(this).data('db');
            
            // Show loading state
            const $button = $(this);
            const $icon = $button.find('i');
            $button.prop('disabled', true);
            $icon.removeClass('fa-download').addClass('fa-spinner fa-spin');

            // Trigger download
            $.ajax({
                url: `/super-admin-invoices/download`,
                method: 'POST',
                data: {
                    invoice_number: invoiceNumber,
                    database_name: dbName
                },
                xhr: function() {
                    // Custom XMLHttpRequest to handle download progress
                    const xhr = new window.XMLHttpRequest();
                    xhr.responseType = 'blob';
                    return xhr;
                },
                success: function(response, status, xhr) {
                    // Create a temporary link to trigger download
                    const filename = xhr.getResponseHeader('Content-Disposition')
                        .split('filename=')[1]
                        .replace(/"/g, '');
                    
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(new Blob([response], {type: 'application/pdf'}));
                    link.download = filename;
                    link.click();

                    // Show success notification
                    showNotification('Success', `Invoice ${invoiceNumber} downloaded successfully.`, 'success');
                },
                error: function(xhr, status, error) {
                    let errorMessage = 'Failed to download invoice.';
                    
                    // More detailed error handling
                    switch(xhr.status) {
                        case 400:
                            errorMessage = 'Invalid invoice or database information.';
                            break;
                        case 404:
                            errorMessage = 'Invoice not found.';
                            break;
                        case 500:
                            errorMessage = 'Server error occurred.';
                            break;
                    }

                    // Show error notification
                    showNotification('Error', errorMessage, 'danger');
                },
                complete: function() {
                    // Reset button state
                    $button.prop('disabled', false);
                    $icon.removeClass('fa-spinner fa-spin').addClass('fa-download');
                }
            });
        });
    });

    // DELETE INVOICE
    $('.invoice-actions .btn-outline-danger').on('click', function() {
        const $row = $(this).closest('tr');
        const invoiceNumber = $row.find('td:eq(0)').text().trim();
        const dbName = $(this).data('db');
        
        // Create and show confirmation modal
        const confirmModal = `
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">Confirm Deletion</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">Are you sure you want to delete invoice <strong>${invoiceNumber}</strong>?</p>
                            <p class="text-muted small mb-0 mt-2">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete Invoice</button>
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
        $('#confirmDelete').off('click').on('click', function() {
            // Show loading state
            const $button = $(this);
            $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Deleting...');

            // Perform delete operation
            $.ajax({
                url: `super-admin-invoices/delete`,
                method: 'POST',
                data: {
                    invoice_number: invoiceNumber,
                    database_name: dbName
                },
                success: function(response) {
                    // Hide modal
                    $modal.modal('hide');
                    
                    // Remove row with animation
                    $row.fadeOut(400, function() {
                        $(this).remove();
                    });
                    
                    // Show success message
                    showNotification('Success', `Invoice ${invoiceNumber} has been deleted.`, 'success');
                },
                error: function(xhr, status, error) {
                    console.error("Error deleting invoice:", error);
                    showNotification('Error', 'Failed to delete invoice. Please try again.', 'danger');
                    
                    // Restore button state
                    $button.prop('disabled', false).html('Delete Invoice');
                }
            });
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