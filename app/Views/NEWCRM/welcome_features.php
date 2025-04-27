<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice System - Features</title>
    <?php include 'css.php' ?>

    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"> -->
    <style>
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            border: none;
            border-radius: 15px;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .feature-icon {
            font-size: 2rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        .hero-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 5rem 0;
            margin-bottom: 3rem;
        }

        .notify-btn {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .notify-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.2);
        }
    </style>
</head>
<body>
<?php include 'welcome_topbar.php'?>

    <div class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 mb-3 fw-bold text-primary">Invoice System</h1>
            <p class="lead mb-4 text-muted">We're building an advanced invoice management system designed to handle multiple tenants with ease, efficiency, and security.</p>
            <button class="btn btn-primary btn-lg notify-btn">
                <i class="fas fa-bell me-2"></i>Notify Me
            </button>
        </div>
    </div>

    <div class="container mb-5">
        <h2 class="text-center mb-5 fw-bold">Upcoming Features</h2>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm p-4">
                    <div class="card-body text-center">
                        <i class="fas fa-shield-alt feature-icon"></i>
                        <h5 class="card-title fw-bold">Secure Tenant Isolation</h5>
                        <p class="card-text text-muted">Tenant-specific data isolation ensuring complete security and privacy</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm p-4">
                    <div class="card-body text-center">
                        <i class="fas fa-robot feature-icon"></i>
                        <h5 class="card-title fw-bold">Automated Processing</h5>
                        <p class="card-text text-muted">Automated invoice generation and delivery system</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm p-4">
                    <div class="card-body text-center">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h5 class="card-title fw-bold">Analytics Dashboard</h5>
                        <p class="card-text text-muted">Comprehensive reporting and real-time analytics</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm p-4">
                    <div class="card-body text-center">
                        <i class="fas fa-paint-brush feature-icon"></i>
                        <h5 class="card-title fw-bold">Custom Templates</h5>
                        <p class="card-text text-muted">Customizable templates for personalized invoices</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm p-4">
                    <div class="card-body text-center">
                        <i class="fas fa-plug feature-icon"></i>
                        <h5 class="card-title fw-bold">Easy Integration</h5>
                        <p class="card-text text-muted">Seamless integration with popular accounting software</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="card feature-card shadow-sm p-4">
                    <div class="card-body text-center">
                        <i class="fas fa-users-cog feature-icon"></i>
                        <h5 class="card-title fw-bold">Role-based Access</h5>
                        <p class="card-text text-muted">Flexible role-based access control for tenant users</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'welcome_footer.php'?>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> -->
    <?php include 'js.php' ?>
</body>
</html>