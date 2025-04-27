 <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4" style="margin: 0; padding: 0;">
    <div class="container-fluid"  style="padding-top: 0; padding-bottom: 0;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarContent">
            <form class="d-flex me-auto">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="search" class="form-control border-start shadow-none" placeholder="Search...">
                </div>
            </form>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link position-relative me-3" href="#">
                        <i class="fas fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            3
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <img src="<?= base_url('assets/images/blank-profile.png')?>" class="rounded-circle img-fluid" style="width: 20px;" alt="Admin">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="super-admin-settings"><i class="fas fa-cog me-2"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>