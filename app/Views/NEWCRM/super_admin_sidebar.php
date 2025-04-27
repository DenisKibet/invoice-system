<!-- Sidebar -->
<!-- <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar"> -->
<ul class="navbar-nav  sidebar sidebar-dark accordion"  style ="background-color: #0374da; color:#fff;" id="accordionSidebar">


         <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/super-admin-dashboard">
        <div class="sidebar-brand-text mx-3">Invoice System</div>

    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
     <!-- Nav Item - Dashboard -->
     <li class="nav-item active">
        <a class="nav-link" href="/super-admin-dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Super-Admin Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Manage Tenants
    </div>

    <!-- Nav Item - Invoices -->
    <li class="nav-item active" id="tenants" >
        <a class="nav-link" href="/super-admin-tenants">
            <i class="fas fa-building me-2"></i>
            <span>Tenants</span>
        </a>
    </li>
    <li class="nav-item active" id="invoices">
        <a class="nav-link" href="/super-admin-invoices">
            <i class="fas fa-fw fa-folder"></i>
            <span>Invoices</span>
        </a>
    </li>
    <li class="nav-item active" id="users">
        <a class="nav-link" href="/super-admin-users">
            <i class="fas fa-users me-2"></i>
            <span>Users</span>
        </a>
    </li>

    <li class="nav-item active" id="reports">
        <a class="nav-link" href="/super-admin-reports">
            <i class="fas fa-chart-line me-2"></i>
            <span>Reports</span>
        </a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
         Manage Settings
    </div>
    <!-- Settings pushed to bottom -->
    <ul class="nav flex-column">
        <div class="mt-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/super-admin-settings">
                    <i class="fas fa-cog me-2"></i> 
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link text-danger" href="/logout">
                    <i class="fas fa-sign-out-alt me-2"></i> 
                    <span>Logout</span>
                </a>
            </li>
        </div>
    </ul>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->


</ul>
<!-- <script>
// Add this to your JavaScript file
document.addEventListener('DOMContentLoaded', function() {
    // Get current path
    const currentPath = window.location.pathname;
    
    // Remove any existing active states and red borders
    document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
        item.style.borderLeft = 'none';
    });

    // Map of paths to their corresponding nav item IDs
    const pathToId = {
        '/super-admin-dashboard': 'dashboard',
        '/super-admin-tenants': 'tenants',
        '/super-admin-invoices': 'invoices',
        '/super-admin-users': 'users',
        '/super-admin-reports': 'reports',
        '/super-admin-settings': 'settings'
    };

    // Find the corresponding nav item and add active state
    const currentNavItem = document.querySelector(`a[href="${currentPath}"]`)?.closest('.nav-item');
    if (currentNavItem) {
        currentNavItem.classList.add('active');
        currentNavItem.style.borderLeft = '4px solid red';
//        currentNavItem.style.paddingLeft = 'calc(1rem - 2px)';
    }
});
</script> -->