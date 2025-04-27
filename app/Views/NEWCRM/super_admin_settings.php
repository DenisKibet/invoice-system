<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SuperAdmin Settings - Enhanced</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <?php include "css.php"?>
    
    <style>
        .settings-container {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        .nav-tabs .nav-link {
            color: #6c757d;
            border: none;
            padding: 1rem 1.5rem;
            transition: all 0.3s;
            border-bottom: 2px solid transparent;
        }
        
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            background: transparent;
        }
        
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: #0d6efd;
        }
        
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(13,110,253,0.15);
        }
        
        .btn-save {
            padding: 0.5rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .status-badge {
            padding: 0.35rem 0.8rem;
            border-radius: 50px;
            font-size: 0.85rem;
        }
        
        .form-check-input {
            width: 2.5em;
            height: 1.25em;
        }
        
        .settings-header {
            background: white;
            padding: 1rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #344767;
            margin-bottom: 1.5rem;
        }
        
        .help-text {
            font-size: 0.875rem;
            color: #6c757d;
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

                        <!-- Settings Header -->
                        <div class="settings-header d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h1 class="h3 mb-1">Settings</h1>
                                <p class="text-muted mb-0">Manage your platform settings and configurations</p>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <span class="status-badge bg-success bg-opacity-10 text-success">
                                    <i class="fas fa-circle fs-xs me-2"></i>All systems operational
                                </span>
                                <button class="btn btn-primary btn-save" id="saveSettings">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>

                        <!-- Settings Navigation -->
                        <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general">
                                    <i class="fas fa-cog me-2"></i>General
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="security-tab" data-bs-toggle="tab" href="#security">
                                    <i class="fas fa-shield-alt me-2"></i>Security
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="notifications-tab" data-bs-toggle="tab" href="#notifications">
                                    <i class="fas fa-bell me-2"></i>Notifications
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="billing-tab" data-bs-toggle="tab" href="#billing">
                                    <i class="fas fa-credit-card me-2"></i>Billing
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="integrations-tab" data-bs-toggle="tab" href="#integrations">
                                    <i class="fas fa-plug me-2"></i>Integrations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="backup-tab" data-bs-toggle="tab" href="#backup">
                                    <i class="fas fa-database me-2"></i>Backup & Restore
                                </a>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content" id="settingsTabContent">
                            <!-- General Settings -->
                            <div class="tab-pane fade show active" id="general">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Platform Settings -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Platform Settings</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <label class="form-label">Platform Name</label>
                                                    <input type="text" class="form-control" value="MultiTenant Platform">
                                                    <div class="help-text mt-2">This name will be displayed across the platform.</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-4">
                                                        <label class="form-label">Default Language</label>
                                                        <select class="form-select">
                                                            <option value="en">English (US)</option>
                                                            <option value="es">Español</option>
                                                            <option value="fr">Français</option>
                                                            <option value="de">Deutsch</option>
                                                            <option value="it">Italiano</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <label class="form-label">Timezone</label>
                                                        <select class="form-select">
                                                            <option value="UTC">UTC (GMT+0)</option>
                                                            <option value="EST">Eastern Time (GMT-5)</option>
                                                            <option value="PST">Pacific Time (GMT-8)</option>
                                                            <option value="CET">Central European Time (GMT+1)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">Default Date Format</label>
                                                    <select class="form-select">
                                                        <option value="MM/DD/YYYY">MM/DD/YYYY</option>
                                                        <option value="DD/MM/YYYY">DD/MM/YYYY</option>
                                                        <option value="YYYY-MM-DD">YYYY-MM-DD</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Maintenance Settings -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Maintenance</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                                    <label class="form-check-label" for="maintenanceMode">
                                                        Enable Maintenance Mode
                                                    </label>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">Maintenance Message</label>
                                                    <textarea class="form-control" rows="3">We're currently performing scheduled maintenance. We'll be back shortly.</textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Start Date</label>
                                                        <input type="datetime-local" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">End Date</label>
                                                        <input type="datetime-local" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <!-- System Status -->
                                        <!-- <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">System Status</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>CPU Usage</span>
                                                    <span class="text-success">45%</span>
                                                </div>
                                                <div class="progress mb-4" style="height: 8px;">
                                                    <div class="progress-bar bg-success" style="width: 45%"></div>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Memory Usage</span>
                                                    <span class="text-warning">65%</span>
                                                </div>
                                                <div class="progress mb-4" style="height: 8px;">
                                                    <div class="progress-bar bg-warning" style="width: 65%"></div>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Storage Usage</span>
                                                    <span class="text-danger">82%</span>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-danger" style="width: 82%"></div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">System Status</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- CPU Usage -->
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>CPU Usage</span>
                                                    <span class="<?= $cpu['status']['class'] ?>"><?= $cpu['percentage'] ?>%</span>
                                                </div>
                                                <div class="progress mb-4" style="height: 8px;">
                                                    <div class="progress-bar <?= $cpu['status']['bar_class'] ?>" style="width: <?= $cpu['percentage'] ?>%"></div>
                                                </div>

                                                <!-- Memory Usage -->
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Memory Usage</span>
                                                    <span class="<?= $memory['status']['class'] ?>"><?= $memory['percentage'] ?>%</span>
                                                </div>
                                                <div class="progress mb-4" style="height: 8px;">
                                                    <div class="progress-bar <?= $memory['status']['bar_class'] ?>" style="width: <?= $memory['percentage'] ?>%"></div>
                                                </div>
                                                
                                                <!-- Storage Usage -->
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Storage Usage</span>
                                                    <span class="<?= $storage['status']['class'] ?>"><?= $storage['percentage'] ?>%</span>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar <?= $storage['status']['bar_class'] ?>" style="width: <?= $storage['percentage'] ?>%"></div>
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <!-- Quick Actions -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Quick Actions</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-grid gap-2">
                                                    <!-- Cache Clear Button -->
                                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#clearCacheModal">
                                                        <i class="fas fa-sync-alt me-2"></i>Clear Cache
                                                    </button>
                                                    <!-- <button class="btn btn-outline-primary">
                                                        <i class="fas fa-sync-alt me-2"></i>Clear Cache
                                                    </button> -->
                                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#downloadSystemLogs">
                                                        <i class="fas fa-download me-2"></i>Download Logs
                                                    </button>
                                                    <button class="btn btn-outline-warning">
                                                        <i class="fas fa-envelope me-2"></i>Test Email
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Security Settings -->
                            <div class="tab-pane fade" id="security">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Authentication Settings -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Authentication Settings</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <label class="form-label">Password Policy</label>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                        <label class="form-check-label">Require uppercase letters</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                        <label class="form-check-label">Require numbers</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                        <label class="form-check-label">Require special characters</label>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="form-label">Minimum Password Length</label>
                                                        <input type="number" class="form-control" value="12">
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-4">
                                                    <label class="form-label">Session Settings</label>
                                                    <div class="mb-3">
                                                        <select class="form-select">
                                                            <option>30 minutes</option>
                                                            <option>1 hour</option>
                                                            <option>2 hours</option>
                                                            <option>4 hours</option>
                                                        </select>
                                                        <div class="help-text mt-2">Session timeout duration</div>
                                                    </div>
                                                </div>

                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <label class="form-check-label">Force SSL/HTTPS</label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Two-Factor Authentication -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Two-Factor Authentication</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" id="enable2FA">
                                                        <label class="form-check-label" for="enable2FA">
                                                            Enable Two-Factor Authentication
                                                        </label>
                                                    </div>
                                                    <div class="help-text mb-3">
                                                        When enabled, users will be required to provide a verification code in addition to their password.
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" checked>
                                                                <label class="form-check-label">Allow SMS Authentication</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox" checked>
                                                                <label class="form-check-label">Allow Authenticator Apps</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <!-- Security Status -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Security Status</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-shield-alt text-success me-2"></i>
                                                    <span>Firewall Status: Active</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-lock text-success me-2"></i>
                                                    <span>SSL Certificate: Valid</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-clock text-warning me-2"></i>
                                                    <span>Last Security Scan: 2 days ago</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Recent Security Events -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Recent Security Events</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <small class="text-muted">Today 10:23 AM</small>
                                                    <div>Failed login attempt - IP: 192.168.1.100</div>
                                                </div>
                                                <div class="mb-3">
                                                    <small class="text-muted">Yesterday 3:45 PM</small>
                                                    <div>Password changed - User: admin@example.com</div>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Yesterday 11:15 AM</small>
                                                    <div>New device logged in - Location: New York, US</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notifications Settings -->
                            <div class="tab-pane fade" id="notifications">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Email Notifications -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Email Notifications</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                        <label class="form-check-label">Security Alerts</label>
                                                    </div>
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                        <label class="form-check-label">System Updates</label>
                                                    </div>
                                                    <div class="form-check form-switch mb-3">
                                                        <input class="form-check-input" type="checkbox">
                                                        <label class="form-check-label">Marketing Updates</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Webhook Notifications -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Webhook Notifications</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Webhook URL</label>
                                                    <input type="url" class="form-control" placeholder="https://example.com/webhook">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Secret Key</label>
                                                    <input type="password" class="form-control" value="********">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <!-- Notification Schedule -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Notification Schedule</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Quiet Hours</label>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="time" class="form-control" value="22:00">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="time" class="form-control" value="07:00">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-check form-switch mb-3">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <label class="form-check-label">Enable Weekend Mode</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Billing Settings -->
                            <div class="tab-pane fade" id="billing">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Current Plan -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Current Plan</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-4">
                                                    <div>
                                                        <h6 class="mb-1">Enterprise Plan</h6>
                                                        <p class="text-muted mb-0">Billed annually</p>
                                                    </div>
                                                    <span class="badge bg-success">Active</span>
                                                </div>
                                                <div class="progress mb-3" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" style="width: 75%"></div>
                                                </div>
                                                <small class="text-muted">Usage: 75% of your plan limits</small>
                                                <hr class="my-4">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <button class="btn btn-outline-primary">Upgrade Plan</button>
                                                    <button class="btn btn-link text-danger">Cancel Subscription</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Payment Methods -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Payment Methods</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fab fa-cc-visa fa-2x me-3 text-primary"></i>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Visa ending in 4242</h6>
                                                        <small class="text-muted">Expires 12/2024</small>
                                                    </div>
                                                    <div class="dropdown">
                                                        <button class="btn btn-link" data-bs-toggle="dropdown">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><a class="dropdown-item text-danger" href="#">Remove</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <button class="btn btn-outline-primary">
                                                    <i class="fas fa-plus me-2"></i>Add Payment Method
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Billing History -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Billing History</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Description</th>
                                                                <th>Amount</th>
                                                                <th>Status</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Oct 1, 2023</td>
                                                                <td>Enterprise Plan - Annual</td>
                                                                <td>$1,999.00</td>
                                                                <td><span class="badge bg-success">Paid</span></td>
                                                                <td><a href="#" class="btn btn-sm btn-link">Download</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Sep 1, 2023</td>
                                                                <td>Enterprise Plan - Annual</td>
                                                                <td>$1,999.00</td>
                                                                <td><span class="badge bg-success">Paid</span></td>
                                                                <td><a href="#" class="btn btn-sm btn-link">Download</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <!-- Billing Summary -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Billing Summary</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Next billing date</span>
                                                    <strong>Nov 1, 2023</strong>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3">
                                                    <span>Plan</span>
                                                    <strong>Enterprise</strong>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Amount due</span>
                                                    <strong>$1,999.00</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Integrations Settings -->
                            <div class="tab-pane fade" id="integrations">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Available Integrations -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Available Integrations</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Slack Integration -->
                                                <div class="d-flex align-items-center mb-4">
                                                    <img src="/api/placeholder/48/48" alt="Slack" class="me-3">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Slack</h6>
                                                        <p class="text-muted mb-0">Connect your Slack workspace for notifications</p>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" checked>
                                                    </div>
                                                </div>

                                                <!-- GitHub Integration -->
                                                <div class="d-flex align-items-center mb-4">
                                                    <img src="/api/placeholder/48/48" alt="GitHub" class="me-3">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">GitHub</h6>
                                                        <p class="text-muted mb-0">Connect your GitHub repositories</p>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </div>

                                                <!-- Google Workspace Integration -->
                                                <div class="d-flex align-items-center">
                                                    <img src="/api/placeholder/48/48" alt="Google Workspace" class="me-3">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1">Google Workspace</h6>
                                                        <p class="text-muted mb-0">Connect your Google Workspace account</p>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- API Access -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">API Access</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <label class="form-label">API Key</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" value="sk_test_51H94dK..." readonly>
                                                        <button class="btn btn-outline-secondary">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">Webhook URL</label>
                                                    <input type="url" class="form-control" placeholder="https://your-domain.com/webhook">
                                                </div>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-sync-alt me-2"></i>Regenerate API Key
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <!-- Integration Status -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Integration Status</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                    <span>Slack - Connected</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                                    <span>GitHub - Not Connected</span>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                                    <span>Google Workspace - Not Connected</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Backup & Restore Settings -->
                            <div class="tab-pane fade" id="backup">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <!-- Backup Settings -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Backup Settings</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <label class="form-label">Backup Frequency</label>
                                                    <select class="form-select">
                                                        <option value="daily">Daily</option>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="monthly">Monthly</option>
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label">Retention Period</label>
                                                    <select class="form-select">
                                                        <option value="7">7 days</option>
                                                        <option value="30">30 days</option>
                                                        <option value="90">90 days</option>
                                                        <option value="365">1 year</option>
                                                    </select>
                                                </div>
                                                <div class="form-check form-switch mb-4">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <label class="form-check-label">Enable automatic backups</label>
                                                </div>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cloud-download-alt me-2"></i>Create Backup Now
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Backup History -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Backup History</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Size</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Oct 10, 2023 09:00 AM</td>
                                                                <td>2.5 GB</td>
                                                                <td><span class="badge bg-success">Completed</span></td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-outline-primary me-2">
                                                                        <i class="fas fa-download"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-outline-danger">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Oct 9, 2023 09:00 AM</td>
                                                                <td>2.3 GB</td>
                                                                <td><span class="badge bg-success">Completed</span></td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-outline-primary me-2">
                                                                        <i class="fas fa-download"></i>
                                                                    </button>
                                                                    <button class="btn btn-sm btn-outline-danger">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <!-- Storage Status -->
                                        <div class="card mb-4">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Storage Status</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <h6 class="mb-2">Backup Storage Used</h6>
                                                    <div class="progress mb-2" style="height: 8px;">
                                                        <div class="progress-bar bg-primary" style="width: 65%"></div>
                                                    </div>
                                                    <small class="text-muted">65% of 100GB used</small>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Total Storage</span>
                                                    <span>100 GB</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span>Used Storage</span>
                                                    <span>65 GB</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span>Available Storage</span>
                                                    <span>35 GB</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quick Actions -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="section-title mb-0">Quick Actions</h5>
                                            </div>
                                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-outline-primary">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>Upload Backup
                                    </button>
                                    <button class="btn btn-outline-info">
                                        <i class="fas fa-sync me-2"></i>Sync Now
                                    </button>
                                    <button class="btn btn-outline-danger">
                                        <i class="fas fa-trash-alt me-2"></i>Clear All Backups
                                    </button>
                                    <button class="btn btn-outline-secondary">
                                        <i class="fas fa-download me-2"></i>Export Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Toast Notifications Container -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Settings saved successfully!
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to proceed with this action?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmAction">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Clear Cache Modal -->
<div class="modal fade" id="clearCacheModal" tabindex="-1" aria-labelledby="clearCacheModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="clearCacheModalLabel">Confirm Cache Clearing</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to clear the application cache?</p>
                <p class="text-muted small mb-0 mt-2">This may temporarily affect performance including loging you out.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= site_url('clear-cache') ?>" class="btn btn-danger">Clear Cache</a>
            </div>
        </div>
    </div>
</div> 

<!-- Confirmation Download Application Logs Modal -->
<div class="modal fade" id="downloadSystemLogs" tabindex="-1" aria-labelledby="downloadSystemLogsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-dark">
                <h5 class="modal-title" id="downloadSystemLogsLabel">Confirm Download System Logs</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to download the application logs?</p>
                <p class="text-muted small mb-0 mt-2">This is very confidential document, keep it safe.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= site_url('download-logs') ?>" class="btn btn-info">Download Logs</a>
            </div>
        </div>
    </div>
</div> 


<!-- Confirmation Download Application Logs Modal -->
<div class="modal fade" id="downloadSystemLogs" tabindex="-1" aria-labelledby="downloadSystemLogsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-dark">
                <h5 class="modal-title" id="downloadSystemLogsLabel">Confirm Download System Logs</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to download the application logs?</p>
                <p class="text-muted small mb-0 mt-2">This is very confidential document, keep it safe.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="<?= site_url('download-logs') ?>" class="btn btn-info">Download Logs</a>
            </div>
        </div>
    </div>
</div> 


<!-- Loading Spinner Overlay -->
<div class="position-fixed top-0 start-0 w-100 h-100 d-none" id="loadingOverlay" style="background: rgba(0,0,0,0.5); z-index: 1060;">
    <div class="position-absolute top-50 start-50 translate-middle">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize all tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Save Settings Button Click Handler
    document.getElementById('saveSettings').addEventListener('click', function() {
        // Add your save logic here
        alert('Settings saved successfully!');
    });



<!-- Initialize Bootstrap Components -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize all popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Handle form submissions
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            showLoadingOverlay();
            
            // Simulate form submission delay
            setTimeout(() => {
                hideLoadingOverlay();
                showSuccessToast();
            }, 1000);
        });
    });

    // Helper functions
    function showLoadingOverlay() {
        document.getElementById('loadingOverlay').classList.remove('d-none');
    }

    function hideLoadingOverlay() {
        document.getElementById('loadingOverlay').classList.add('d-none');
    }

    function showSuccessToast() {
        var toast = new bootstrap.Toast(document.getElementById('successToast'));
        toast.show();
    }

    // Handle dangerous actions
    document.querySelectorAll('.btn-outline-danger').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();
        });
    });
});

</body>
</html>