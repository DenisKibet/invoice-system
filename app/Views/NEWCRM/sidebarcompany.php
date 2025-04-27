<!-- Sidebar -->
<ul class="navbar-nav  sidebar sidebar-dark accordion"  style ="background-color: #0374da;" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <div class="sidebar-brand-text mx-3">INVOICE SYSTEM</div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Manage Records
    </div>

     <!-- Nav Item - Create Records Collapse Menu -->
     <?php $session = session();
        $hasReachedFreeLimit = $session->get("has_reached_free_limit");
        $isSubscriptionActive = $session->get("is_subscription_active");
        $showAlert = $hasReachedFreeLimit && $isSubscriptionActive;
    ?>
     <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCreate" aria-expanded="true" aria-controls="collapseCreate">
            <i class="fas fa-fw fa-plus"></i>
            <span>Create</span>
        </a>
        <div id="collapseCreate" class="collapse" aria-labelledby="headingCreate" data-parent="#accordionSidebar" style="margin: 0;border-radius:0;background: #fff;">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/NewInvoice" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-file"></i> New Invoice</a>
                <a class="collapse-item" href="/CreateClient" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-user"></i> Add Client</a>
                <?php if($session->get("user_role") !== 'agent') { ?>
                    <a class="collapse-item" href="/create-agent" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-user"></i> Add User/Agent</a>
                <?php } ?>
                <a class="collapse-item" href="/creatItem" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-list"></i> Add Item</a>
                <a class="collapse-item" href="/CreateQuotation" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-question"></i> New Estimate</a>
            </div>
        </div>
    </li>
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
        </a>
        <div id="collapseSettings" class="collapse" aria-labelledby="headingSettings" data-parent="#accordionSidebar" style="margin: 0;border-radius:0;background: #fff;">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/setComment" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-comment"></i>Add Set up Comment</a>
                <a class="collapse-item" href="/setUpTerms" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-cogs"></i> Add Set Up Terms</a>
                <a class="collapse-item" href="/setUpInvoiceComment" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa fa-envelope"></i> Add Invoice Statement</a>
                <a class="collapse-item" href="/paymentInstruction" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-money-check-alt"></i> Set Up Payment Instruction</a>
                <?php  $companyDetailsModel = new \App\Models\CompanyDetailsModel();
                        $companyDetails = $companyDetailsModel->find();
                        if (!$companyDetails)  {?>
                <a class="collapse-item" href="/companyDetails" <?php if ($showAlert) echo 'onclick="showSubscriptionAlert(event)"'; ?>><i class="fas fa-fw fa-address-card"></i> Add Company Details</a>
                <?php }?>
            </div>
        </div>
    </li>

   <li class="nav-item active" id="invoices" >
        <a class="nav-link" href="/InvoiceList">
            <i class="fas fa-fw fa-folder"></i>
            <span>Invoices</span>
        </a>
    </li>

    <li class="nav-item active" id="estimate">
        <a class="nav-link" href="/quoteList">
            <i class="fas fa-fw fa-calculator"></i>
            <span>Estimates</span>
        </a>
    </li>

    <li class="nav-item active" id="items">
        <a class="nav-link" href="/ItemList">
            <i class="fas fa-fw fa-list"></i>
            <span>Items</span>
        </a>
    </li>

    <li class="nav-item active" id="items" style="border-left: 4px solid red; padding-left: calc(1rem - 2px);">
        <a class="nav-link" href="/companyList">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Company Details</span>
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar" style="margin: 0;border-radius:0;background: #fff;">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header" style="color:#2489b5;"><b>Users</b></h6>
                <!-- set up condition for only admin to view -->
                <a class="collapse-item" href="/clientList"><i class="fa fa-address-book" aria-hidden="true"></i> Client
                    Profiles</a>
                <a class="collapse-item" href="/stafflist"><i class="fa fa-archive" aria-hidden="true"></i> Staff
                    List</a>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Account Management
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Accounts</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar" style="margin: 0;border-radius:0;background: #fff;">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/financials"><i class="fas fa-fw fa-money-bill-wave"></i> Financials</a>
                <a class="collapse-item" href="/reportlist"><i class="fas fa-chart-line me-2"></i> Report</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

     <!-- Heading -->
    <div class="sidebar-heading">
        Logout
    </div>

    <div class="">
    <!-- <div class="mt-auto"> -->
        <li class="nav-item">
            <a class="nav-link text-danger" href="/logout">
                <i class="fas fa-sign-out-alt me-2"></i> 
                <span>Logout</span>
            </a>
        </li>
    </div>
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->

</ul>

<div class="modal fade" id="subscriptionModal" tabindex="-1" role="dialog" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow border-0 bg-white">
            <div class="modal-body p-4 text-dark">
                <div class="position-absolute top-0 end-0 p-3">
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>    

                <div class="text-center my-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger rounded-circle mb-3" style="width: 64px; height: 64px;">
                        <i class="fas fa-exclamation text-white fs-4"></i>
                    </div>
                    <h4 class="fs-4 mb-3">Your invoice system plan has expired</h4>
                    <p class="text-muted">Subscribe now to one of our new plans and unlock premium features</p>
                </div>

                <div class="row row-cols-1 row-cols-md-2 g-3 my-4">
                    <div class="col mt-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check text-success me-3"></i>
                            <span>Unlimited clients</span>
                        </div>
                    </div>
                    <div class="col mt-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check text-success me-3"></i>
                            <span>Unlimited extra users</span>
                        </div>
                    </div>
                    <div class="col mt-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check text-success me-3"></i>
                            <span>Unlimited estimates</span>
                        </div>
                    </div>
                    <div class="col mt-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check text-success me-3"></i>
                            <span>Premium support</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-5">
                    <button type="button" class="btn btn-primary py-2 shadow-none" id="getBasicPlan">
                        Get Basic Plan for £19/month
                    </button>
                    <a href="/plans-list" class="btn btn-outline-primary py-2 ms-3 shadow-none" id="viewAllPlans">
                        View all plans <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Minimal required custom CSS -->
<style>
    .modal-dialog {
    max-width: 460px;
    }

    .btn-primary {
    background-color: #6C63FF;
    border: none;
    }

    .btn-primary:hover {
    background-color: #5a52e8;
    }
</style>


<?php include 'js.php'?>
<script>
    function showSubscriptionModal(event) {
        event.preventDefault(); 
        $('#subscriptionModal').modal('show');
    }

    // Update all relevant links to use the new function
    document.querySelectorAll('a[onclick="showSubscriptionAlert(event)"]').forEach(link => {
        link.setAttribute('onclick', 'showSubscriptionModal(event)');
    });
    $(document).ready(function() {

        $('#getBasicPlan').on('click', function(e) {            
            var planData = {
                planName: 'Basic',
                duration: 'monthly',
                price: 19
            };

            $.ajax({
                method: 'POST',
                url: '/initiate-plan-payment',
                data: JSON.stringify(planData),
                contentType: 'application/json',
                success: function(response) {
                    if (response.paymentUrl) {
                        window.location.href = response.paymentUrl;
                    } else {
                        console.log('Unexpected response:', response);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Failed: ' + error);
                }
            });
        });
    });
</script>
<!-- End of Sidebar -->
