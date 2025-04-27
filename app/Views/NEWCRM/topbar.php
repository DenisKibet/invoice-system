<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <div class="text-center">
        <?php 
            $companyDetailsModel = new \App\Models\CompanyDetailsModel();
            $companyDetails = $companyDetailsModel->first();
            $logoPath = $companyDetails->logo_path ?? ''; // alternative logo for black {assets/images/logo-holder.png}
        ?>
        <a href="/dashboard">
            <img src="<?= base_url($logoPath) ?>" class="img-fluid" style="height: 40px;" alt="" />
        </a>
    </div>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small"> 
                    <?php
                         echo  session()->get('username') ?? 'Anonymous';
                    ?>
				</span>
                <img class="img-profile rounded-circle" src="/CRM/img/login.png">
                <!-- <span class="material-icons icon text-gray-600">account_circle</span> -->
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                <!-- <a class="dropdown-item" href="/Logout" data-toggle="modal" data-target="#logoutModal"> -->
                <a class="dropdown-item" href="/logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->
