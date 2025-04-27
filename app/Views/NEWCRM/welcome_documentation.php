<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enterprise Documentation - Invoice Management System</title>
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> -->
    <?php include 'css.php'?>
    <style>
        :root {
            --primary-color: #1a73e8;
            --secondary-color: #f8f9fa;
            --text-primary: #3c4043;
            --text-secondary: #5f6368;
            --sidebar-bg: #ffffff;
            --hover-bg: #f1f3f4;
            --active-bg: #e8f0fe;
            --border-color: #dadce0;
            --header-height: 64px;
            /* ADDED */
            --hover-color: #f1f3f4;
            --text-color: #202124;
        } 

        body {
            font-family: "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !default;
            color: var(--text-color);
            background: #f8f9fa;
            line-height: 1.6;
            /* ADDED */
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        .top-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--header-height);
            background: white;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,0.3), 0 2px 6px 2px rgba(60,64,67,0.15);
            z-index: 1000;
            display: flex;
            align-items: center;
            padding: 0 24px;
        }

        .top-header h1 {
            font-size: 1.25rem;
            font-weight: 500;
            margin: 0;
            color: var(--text-primary);
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            bottom: 0;
            left: 0;
            width: 300px;
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            overflow-y: auto;
            z-index: 100;
            /* ADDED */
            box-shadow: 2px 0 4px rgba(0, 0, 0, 0.05);
            height: 100vh;
            padding: 0;
            overflow-y: auto;
        }

        .nav-section {
            margin: 8px 0;
        }

        .sidebar-link {
            color: var(--text-primary);
            padding: 8px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            border-radius: 0 24px 24px 0;
            margin-right: 16px;
            /* ADDED */
            transition: all 0.2s;
        }

        .sidebar-link:hover {
            background: var(--hover-bg);
            color: var(--primary-color);
            text-decoration: none;
        }

        .sidebar-link.active {
            background: var(--active-bg);
            color: var(--primary-color);
        }

        .sub-nav {
            display: none;
            margin-left: 24px;
            /* ADDED */
            background-color: #fafafa;
        }

        .sub-nav .sidebar-link {
            padding: 6px 24px;
            font-weight: 400;
            font-size: 0.8125rem;
        }

        .toggle-icon {
            font-size: 0.75rem;
            transition: transform 0.2s ease;
            color: var(--text-secondary);
        }

        .toggle-icon.rotated {
            transform: rotate(180deg);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 15%;
            margin-top: var(--header-height);
            /* padding: 40px; */
            max-width: 1200px;
            /* ADDED */
            flex: 1;
            padding: 2rem 3rem;
        }

        .section {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,0.3), 0 1px 3px 1px rgba(60,64,67,0.15);
            padding: 32px;
            margin-bottom: 24px;
            /* ADDED */
            scroll-margin-top: 2rem;
        }

        .section h2 {
            color: var(--primary-color);
            font-size: 1.9rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .list-group-item {
            border-color: var(--border-color);
            padding: 16px;
        }

        /* Buttons */
        .btn {
            border-radius: 4px;
            font-weight: 500;
            text-transform: none;
            letter-spacing: .25px;
            padding: 8px 24px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Code blocks */
        pre {
            background: #f8f9fa;
            border-radius: 4px;
            padding: 16px;
            border: 1px solid var(--border-color);
        }

        /* Search bar */
        .search-box {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
            /* ADDED */
            padding: 1rem;
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
        }

        .search-input {
            width: 100%;
            padding: 8px 16px; 
            border: 1px solid var(--border-color);
            border-radius: 0.3rem;
            font-size: 0.875rem;
            outline: none;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(26, 115, 232, 0.1);
        }
        /* for sign up and login links */
        .navbar {
            padding: 1rem 0;
        }

        .nav-link {
            color: var(--primary-color);
        }

        /* ADDED STYLE FOR THE SIDEBAR */
        .documentation-container {
            display: flex;
            min-height: 100vh;
        }

        .content {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        /* Smooth scrollbar for sidebar */
        .sidebar {
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 3px;
        }

       /* Styles for Customer Support Popup */
        .customer-support {
            position: fixed;
            bottom: 20px;
            right: 20px;
            max-width: 300px;
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            display: none; /* Hidden initially */
            z-index: 1000;
            font-family: Arial, sans-serif;
            cursor: pointer;
        }

        .customer-support p {
            margin: 0;
            font-size: 14px;
        }

        .customer-support .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 16px;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
        
    </style>
</head>
<body>
    <!-- Top Header -->
    <header class="top-header">
        <h1>Invoice Documentation</h1>
        <nav class="navbar navbar-expand-lg  py-3 ml-auto">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link  " href="login" id="loginButton">Back to login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="/" id="signUpButton">Sign Up</a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Search Box -->
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search documentation...">
        </div>

        <nav>
            <div class="nav-section">
                <a href="#getting-started" class="sidebar-link" onclick="scrollToSection('getting-started')">
                    Getting Started 
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </a>
                <div class="sub-nav">
                    <a href="#quick-start" class="sidebar-link">Quick Start Guide</a>
                    <a href="#system-requirements" class="sidebar-link">System Requirements</a>
                    <a href="#account-setup" class="sidebar-link">Account Setup</a>
                    <a href="#authentication" class="sidebar-link">Authentication Guide</a>
                    <a href="#initial-configuration" class="sidebar-link">Initial Configuration</a>
                    <a href="#company-profile" class="sidebar-link">Company Profile Setup</a>
                </div>
            </div>

            <div class="nav-section"  id="scroll">
                <a href="#account-management" class="sidebar-link" onclick="scrollToSection()">
                    Account Management
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </a>
                <div class="sub-nav">
                    <a href="#account-hierarchy" class="sidebar-link">Account Hierarchy</a>
                    <a href="#role-management" class="sidebar-link">Role Management</a>
                    <a href="#permission-sets" class="sidebar-link">Permission Sets</a>
                    <a href="#access-control" class="sidebar-link">Access Control</a>
                    <a href="#compliance-audit" class="sidebar-link">Compliance & Audit</a>
                    <a href="#security-policies" class="sidebar-link">Security Policies</a>
                </div>
            </div>

            <div class="nav-section">
                <a href="#invoice-operations" class="sidebar-link">
                    Invoice Operations
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </a>
                <div class="sub-nav">
                    <a href="#create-invoice" class="sidebar-link">Create Invoice</a>
                    <a href="#invoice-templates" class="sidebar-link">Templates</a>
                    <a href="#bulk-operations" class="sidebar-link">Bulk Operations</a>
                </div>
            </div>

            <div class="nav-section">
                <a href="#customer-portal" class="sidebar-link">
                    Client
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </a>
                <div class="sub-nav">
                    <a href="#customer-management" class="sidebar-link">Create Client</a>
                    <a href="#payment-processing" class="sidebar-link">Client Profiles</a>
                    <a href="#customer-communications" class="sidebar-link">Communications</a>
                </div>
            </div>

            <div class="nav-section">
                <a href="#reporting-analytics" class="sidebar-link">
                    Reporting & Analytics
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </a>
                <div class="sub-nav">
                    <a href="#financial-reports" class="sidebar-link">Financial Reports</a>
                    <a href="#analytics-dashboard" class="sidebar-link">Analytics Dashboard</a>
                    <a href="#export-tools" class="sidebar-link">Export Tools</a>
                </div>
            </div>

            <div class="nav-section">
                <a href="#system-integration" class="sidebar-link">
                    System Integration
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </a>
                <div class="sub-nav">
                    <a href="#third-party" class="sidebar-link">Third-party Integration</a>
                    <a href="#webhooks" class="sidebar-link">Webhooks</a>
                    <a href="#api-documentation" class="sidebar-link">API Documentation</a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <?php 
      

        ?>

        <section id="getting-started" class="section">
            <h2>Getting Started</h2>
            <div class="content">
                <h3>Welcome to Our Multi-tenant Business Management Platform</h3>
                <p>Our cloud-based platform enables businesses to efficiently manage their operations with dedicated secure workspaces. This documentation will guide you through the setup process and help you get started with our platform.</p>

                <div class="list-group mt-4">
                    <div class="list-group-item" id="quick-start">
                        <h4>Quick Start Guide</h4>
                        <p>Follow these simple steps to begin using our platform:</p>
                        <ol>
                            <li>Register your company account</li>
                            <li>Verify your email address</li>
                            <li>Complete your company profile</li>
                            <li>Invite team members (optional)</li>
                            <li>Start using the platform features</li>
                        </ol>
                    </div>

                    <div class="list-group-item" id="system-requirements">
                        <h4>System Requirements</h4>
                        <ul>
                            <li>Modern web browser (Chrome, Firefox, Safari, or Edge - latest versions)</li>
                            <li>Stable internet connection</li>
                            <li>Screen resolution: 1280x720 or higher</li>
                            <li>Cookies enabled for session management</li>
                            <li>JavaScript enabled</li>
                        </ul>
                    </div>

                    <div class="list-group-item" id="account-setup">
                        <h4>Account Setup</h4>
                        <h5>Registration Process</h5>
                        <ol>
                            <li><strong>Basic Information Collection</strong>
                                <ul>
                                    <li>Company name</li>
                                    <li>Your full name</li>
                                    <li>Business email address</li>
                                    <li>Secure password</li>
                                    <li>Password confirmation</li>
                                    <li>Terms of service acceptance</li>
                                </ul>
                            </li>
                            <li><strong>Email Verification</strong>
                                <ul>
                                    <li>Verification link sent to provided email</li>
                                    <li>Link expires in 24 hours</li>
                                    <li>Option to resend verification email</li>
                                </ul>
                            </li>
                            <li><strong>Account Activation</strong>
                                <ul>
                                    <li>Click verification link</li>
                                    <li>Account automatically activated</li>
                                    <li>Redirected to profile completion</li>
                                </ul>
                            </li>
                        </ol>
                    </div>

                    <div class="list-group-item" id="authentication">
                        <h4>Authentication Guide</h4>
                        <h5>Security Features</h5>
                        <ul>
                            <li><strong>Password Requirements</strong>
                                <ul>
                                    <li>Minimum 8 characters</li>
                                    <li>Must include uppercase and lowercase letters</li>
                                    <li>Must contain at least one number</li>
                                    <li>Must include at least one special character</li>
                                    <li>Cannot be similar to company name or email</li>
                                </ul>
                            </li>
                            <li><strong>Session Management</strong>
                                <ul>
                                    <li>Automatic logout after 30 minutes of inactivity</li>
                                    <li>Single active session per user</li>
                                    <li>Secure session handling</li>
                                    <li>Session invalidation on password change</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="list-group-item" id="initial-configuration">
                        <h4>Initial Configuration</h4>
                        <p>After verifying your email, you'll need to:</p>
                        <ol>
                            <li><strong>Complete Company Profile</strong>
                                <ul>
                                    <li>Legal business name</li>
                                    <li>Primary business address</li>
                                    <li>Contact information</li>
                                    <li>Industry selection</li>
                                    <li>Time zone setting</li>
                                </ul>
                            </li>
                            <li><strong>User Setup</strong>
                                <ul>
                                    <li>Update your personal profile</li>
                                    <li>Set communication preferences</li>
                                    <li>Configure notification settings</li>
                                </ul>
                            </li>
                        </ol>
                    </div>

                    <div class="list-group-item" id="company-profile">
                        <h4>Company Profile Setup</h4>
                        <h5>Essential Company Information</h5>
                        <ul>
                            <li><strong>Business Details</strong>
                                <ul>
                                    <li>Legal company name</li>
                                    <li>Company registration number (if applicable)</li>
                                    <li>Business type</li>
                                    <li>Industry sector</li>
                                    <li>Company size</li>
                                </ul>
                            </li>
                            <li><strong>Contact Information</strong>
                                <ul>
                                    <li>Primary business address</li>
                                    <li>Main contact number</li>
                                    <li>Official email address</li>
                                    <li>Website (optional)</li>
                                </ul>
                            </li>
                            <li><strong>Administrator Settings</strong>
                                <ul>
                                    <li>Primary administrator details</li>
                                    <li>Department structure (optional)</li>
                                    <li>Business hours</li>
                                    <li>Preferred contact method</li>
                                </ul>
                            </li>
                        </ul>
                        <div class="mt-4">
                            <h5>Best Practices</h5>
                            <ul>
                                <li>Keep your company information up to date</li>
                                <li>Use official business email domains</li>
                                <li>Maintain accurate contact details</li>
                                <li>Regularly review and update administrator access</li>
                                <li>Document any changes to company structure</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section> 

        <section id="account-management" class="section">
            <h2>Account Management</h2>
            <div class="content">
                <h3>Enterprise Account Management Framework</h3>
                <p>Our comprehensive account management system ensures secure, scalable, and compliant access control across your organization. Implement granular permissions and maintain complete oversight of system usage.</p>

                <div class="list-group mt-4">
                    <div class="list-group-item" id="account-hierarchy">
                        <h4>Account Hierarchy</h4>
                        <!-- <div class="row">
                            <div class="col-md-6"> -->
                                <h5>Organization Structure</h5>
                                <ul>
                                    <li><strong>Enterprise Level</strong>
                                        <ul>
                                            <li>Global policies and settings</li>
                                            <li>Cross-organization reporting</li>
                                            <li>Master data management</li>
                                        </ul>
                                    </li>
                                    <li><strong>Business Units</strong>
                                        <ul>
                                            <li>Department-specific configurations</li>
                                            <li>Specialized workflow rules</li>
                                            <li>Custom approval chains</li>
                                        </ul>
                                    </li>
                                    <li><strong>Team Level</strong>
                                        <ul>
                                            <li>Project-based access</li>
                                            <li>Collaborative workflows</li>
                                            <li>Shared resources</li>
                                        </ul>
                                    </li>
                                </ul>
                            <!-- </div>
                        </div> -->
                    </div>

                    <div class="list-group-item" id="role-management">
                        <h4>Role-Based Access Control (RBAC)</h4>
                        <!-- <div class="row">
                            <div class="col-12"> -->
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Role</th>
                                            <th>Description</th>
                                            <th>Key Responsibilities</th>
                                            <th>Access Level</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>System Administrator</strong></td>
                                            <td>Complete system control and configuration authority</td>
                                            <td>
                                                <ul>
                                                    <li>System-wide configuration management</li>
                                                    <li>Security policy implementation</li>
                                                    <li>User access control</li>
                                                    <li>Integration management</li>
                                                    <li>Audit log monitoring</li>
                                                    <li>Disaster recovery procedures</li>
                                                </ul>
                                            </td>
                                            <td>Full System Access</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Finance Administrator</strong></td>
                                            <td>Financial operations and policy management</td>
                                            <td>
                                                <ul>
                                                    <li>Financial policy configuration</li>
                                                    <li>Template management</li>
                                                    <li>Approval workflow design</li>
                                                    <li>Banking integration setup</li>
                                                    <li>Tax configuration</li>
                                                </ul>
                                            </td>
                                            <td>Finance Module Access</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Finance Manager</strong></td>
                                            <td>Operational financial management</td>
                                            <td>
                                                <ul>
                                                    <li>Invoice template customization</li>
                                                    <li>Financial report generation</li>
                                                    <li>Approval workflow management</li>
                                                    <li>Automated billing configuration</li>
                                                    <li>Revenue analytics</li>
                                                </ul>
                                            </td>
                                            <td>Department Level</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Account Manager</strong></td>
                                            <td>Client relationship and account oversight</td>
                                            <td>
                                                <ul>
                                                    <li>Client account management</li>
                                                    <li>Invoice generation</li>
                                                    <li>Payment tracking</li>
                                                    <li>Client communication</li>
                                                </ul>
                                            </td>
                                            <td>Client Account Level</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Billing Specialist</strong></td>
                                            <td>Day-to-day billing operations</td>
                                            <td>
                                                <ul>
                                                    <li>Invoice creation</li>
                                                    <li>Payment processing</li>
                                                    <li>Basic reporting</li>
                                                    <li>Client support</li>
                                                </ul>
                                            </td>
                                            <td>Limited Access</td>
                                        </tr>
                                    </tbody>
                                </table>
                            <!-- </div>
                        </div> -->
                    </div>

                    <div class="list-group-item" id="permission-sets">
                        <h4>Permission Sets</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Module-Based Permissions</h5>
                                <ul>
                                    <li><strong>Invoice Management</strong>
                                        <ul>
                                            <li>Create/Update/Delete invoices</li>
                                            <li>Template management</li>
                                            <li>Bulk operations</li>
                                        </ul>
                                    </li>
                                    <li><strong>Financial Operations</strong>
                                        <ul>
                                            <li>Payment processing</li>
                                            <li>Refund management</li>
                                            <li>Currency controls</li>
                                        </ul>
                                    </li>
                                    <li><strong>Reporting & Analytics</strong>
                                        <ul>
                                            <li>Report generation</li>
                                            <li>Dashboard access</li>
                                            <li>Data export capabilities</li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item" id="compliance-audit">
                        <h4>Compliance & Audit Controls</h4>
                        <h5>Audit Trail Features</h5>
                        <ul>
                            <li><strong>User Activity Logging</strong>
                                <ul>
                                    <li>Login attempts and sessions</li>
                                    <li>System configuration changes</li>
                                    <li>Data access and modifications</li>
                                    <li>Permission changes</li>
                                </ul>
                            </li>
                            <li><strong>Compliance Reports</strong>
                                <ul>
                                    <li>User access reviews</li>
                                    <li>Permission change history</li>
                                    <li>Security incident logs</li>
                                    <li>Regulatory compliance reports</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="list-group-item" id="security-policies">
                        <h4>Security Policies</h4>
                        <h5>Access Control Policies</h5>
                        <ul>
                            <li><strong>Password Policy</strong>
                                <ul>
                                    <li>Minimum 12 characters</li>
                                    <li>Complex character requirements</li>
                                    <li>90-day rotation</li>
                                    <li>Password history enforcement</li>
                                </ul>
                            </li>
                            <li><strong>Session Management</strong>
                                <ul>
                                    <li>Automatic timeout after 30 minutes</li>
                                    <li>Concurrent session limits</li>
                                    <li>IP-based restrictions</li>
                                    <li>Device authorization</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="invoice-operations" class="section">
            <h2>Invoice Operations</h2>
            <div class="content">
                <h3>Creating Professional Invoices</h3>
                <p>Our system supports multiple invoice generation methods:</p>
                
                <div class="list-group mt-4">
                    <div class="list-group-item" id="create-invoice">
                        <h4>Template-Based Invoice Generation</h4>
                        <p>Leverage our library of industry-specific invoice templates to quickly generate professional-looking documents. Customize the templates with your company branding, logos, and color schemes to reinforce your brand identity. Our system also provides multi-currency support and automatically calculates applicable taxes, ensuring accuracy and consistency across your invoices.</p>
                    </div>
                    <div class="list-group-item" id="invoice-templates">
                        <h4>Versatile Invoice Templates</h4>
                        <p>Our extensive template collection covers a wide range of industries and business models, allowing you to select the perfect format for your needs. Whether you require a simple single-item invoice or a more complex multi-line item template, our system provides the flexibility to adapt to your specific requirements. Easily modify the templates to match your preferred layout, terminology, and content structure.</p>
                    </div>
                    <div class="list-group-item" id="bulk-operations">
                        <h4>Streamlined Bulk Invoice Operations</h4>
                        <p>For businesses with high invoice volumes, our system offers powerful batch processing capabilities to enhance efficiency and productivity. Generate invoices in bulk, schedule recurring invoice creation, and automate the dispatch of invoices to your customers. Our bulk operations features enable you to save time, reduce manual effort, and ensure timely invoice delivery across your client base.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="customer-portal" class="section">
            <h2>Customer Portal</h2>
            <div class="content">
                <h3>Empower Your Customers with Self-Service Features</h3>
                <div class="list-group">
                <div class="list-group-item" id="customer-management">
                    <h4>Comprehensive Customer Management</h4>
                    <ul>
                    <li>Provide customers access to their invoice history</li>
                    <li>Allow online payment processing for outstanding invoices</li>
                    <li>Enable customers to download payment statements</li>
                    <li>Offer a centralized communication center for inquiries</li>
                    </ul>
                </div>
                <div class="list-group-item" id="payment-processing">
                    <h4>Streamlined Payment Processing</h4>
                    <p>Our customer portal integrates with payment gateways, allowing clients to conveniently pay invoices online.</p>
                </div>
                <div class="list-group-item" id="customer-communications">
                    <h4>Effective Customer Communications</h4>
                    <p>Clients can access invoice details, review payment status, and reach out through the central platform.</p>
                </div>
                </div>
            </div>
        </section>

        <section id="reporting-analytics" class="section">
            <h2>Reporting & Analytics</h2>
            <div class="content">
                <h3>Business Intelligence Tools</h3>
                <div class="list-group">
                    <div class="list-group-item" id="financial-reports">
                        <h4>Financial Reports</h4>
                        <ul>
                            <li>Revenue analysis</li>
                            <li>Aging reports</li>
                            <li>Cash flow projections</li>
                            <li>Custom report builder</li>
                        </ul>
                    </div>
                    <div class="list-group-item" id="analytics-dashboard">
                        <h4>Analytics Dashboard</h4>
                        <ul>
                            <li>Revenue analysis</li>
                            <li>Aging reports</li>
                            <li>Cash flow projections</li>
                            <li>Custom report builder</li>
                        </ul>
                    </div>
                    <div class="list-group-item" id="export-tools">
                        <h4>Export Tools</h4>
                        <ul>
                            <li>Revenue analysis</li>
                            <li>Aging reports</li>
                            <li>Cash flow projections</li>
                            <li>Custom report builder</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section id="system-integration" class="section">
            <h2>System Integration</h2>
            <div class="content">
                <div class="list-group">
                    <div class="list-group-item" id="third-party">
                        <h4>Third-party Integration</h4>
                        <ul>
                            <li>Revenue analysis</li>
                            <li>Aging reports</li>
                            <li>Cash flow projections</li>
                            <li>Custom report builder</li>
                        </ul>
                    </div>
                    <div class="list-group-item" id="webhooks">
                        <h4>Webhooks</h4>
                        <ul>
                            <li>Revenue analysis</li>
                            <li>Aging reports</li>
                            <li>Cash flow projections</li>
                            <li>Custom report builder</li>
                        </ul>
                    </div>
                    <h3>API Documentation</h3>

                    <div class="list-group-item" id="api-documentation">
                        <h4>RESTful API Endpoints</h4>
                        <pre>
BASE URL: https://api.enterprise-invoice.com/v1

Authentication:
Bearer Token required for all requests
Content-Type: application/json

Available Endpoints:
GET    /invoices
POST   /invoices
GET    /invoices/{id}
PUT    /invoices/{id}
DELETE /invoices/{id}
                        </pre>
                    </div>
                </div>
            </div>
        </section>
    </div>

   <!-- Customer Support Alert -->
    <div class="customer-support" id="customerSupport">
        <p>Have a question? <strong>We're here to help!</strong> Feel free to ask.</p>
        <button class="close-btn">&times;</button>
    </div>

    <footer>
        <div class="bottom-bar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0 text-dark" style="margin-left: 20%;">© 2024 Invoice System. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <nav class="nav justify-content-md-end justify-content-center mt-3 mt-md-0">
                            <!-- <a class="nav-link text-white px-2" href="#">Privacy Policy</a> -->
                            <a class="nav-link text-dark px-2" href="privacy-policy">Privacy Policy</a>
                            <a class="nav-link text-dark px-2" href="terms-of-service">Terms of Service</a>
                            <a class="nav-link text-dark px-2" href="cookies-policy">Cookie Policy</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- <php include 'welcome_footer.php'?> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // Enhanced search functionality with debounce
        let searchTimeout;
        $('.search-input').on('input', function() {
            clearTimeout(searchTimeout);
            const $input = $(this);
            
            searchTimeout = setTimeout(function() {
                const searchTerm = $input.val().toLowerCase();
                
                $('.nav-section').each(function() {
                    const $section = $(this);
                    const $links = $section.find('.sidebar-link');
                    let hasMatch = false;
                    
                    $links.each(function() {
                        const text = $(this).text().toLowerCase();
                        const matches = text.includes(searchTerm);
                        $(this).toggle(matches);
                        if (matches) hasMatch = true;
                    });
                    
                    // Show/hide entire section based on matches
                    $section.toggle(hasMatch);
                });
            }, 200);
        });

        // Improved sidebar navigation with state management
        $('.nav-section > .sidebar-link').on('click', function(e) {
            e.preventDefault();
            const $navSection = $(this).parent();
            const $subNav = $navSection.find('.sub-nav');
            const $icon = $(this).find('.toggle-icon');

            const id = $(this).data('href');
            // console.log(id);
            // console.log(`#${id}`);
            
            // Smooth toggle animation with state management
            if ($subNav.is(':visible')) {
                $subNav.slideUp(200);
                $icon.removeClass('rotated');
                $navSection.removeClass('expanded');
            } else {
                // Close other sections
                $('.nav-section.expanded').removeClass('expanded')
                    .find('.sub-nav').slideUp(200)
                    .end()
                    .find('.toggle-icon').removeClass('rotated');
                
                // Open clicked section
                $subNav.slideDown(200);
                $icon.addClass('rotated');
                $navSection.addClass('expanded');
            }
        });

        // Improved active section tracking with throttle
        let scrollTimeout;
        $(window).on('scroll', function() {
            if (!scrollTimeout) {
                scrollTimeout = setTimeout(function() {
                    let currentSection = '';
                    const scrollPosition = $(window).scrollTop() + 100;
                    
                    // Find current section
                    $('.section').each(function() {
                        const sectionTop = $(this).offset().top;
                        const sectionBottom = sectionTop + $(this).height();
                        
                        if (scrollPosition >= sectionTop && scrollPosition < sectionBottom) {
                            currentSection = '#' + $(this).attr('id');
                            return false; // Break the loop
                        }
                    });

                    // Update sidebar active states
                    if (currentSection) {
                        $('.sidebar-link').removeClass('active');
                        const $activeLink = $(`a[href="${currentSection}"]`);
                        $activeLink.addClass('active')
                            .closest('.nav-section')
                            .find('> .sidebar-link')
                            .addClass('active');
                        
                        // Ensure sub-nav is visible
                        $activeLink.closest('.sub-nav').slideDown(200);
                        $activeLink.closest('.nav-section')
                            .find('.toggle-icon')
                            .addClass('rotated');
                    }
                    
                    scrollTimeout = null;
                }, 100);
            }
        });

        // Initialize first section as active and expand its nav
        $(window).trigger('scroll');
    });
    $(document).ready(function() {
        // Show the pop-up with a slide-down effect
        $('#customerSupport').slideDown(500);

        // Hide the pop-up automatically after 10 seconds
        setTimeout(function() {
            $('#customerSupport').slideUp(500);
        }, 100000);

        // Close the pop-up when the close button is clicked
        $('.close-btn').on('click', function() {
            $('#customerSupport').slideUp(300);
        });

        // define action to be taken whe the button is clicked
        $('#customerSupport').on('click', function() {
            window.location.href = 'contact-us';
        })
    });
    // Function to handle smooth scrolling to sections
    function scrollToSection(elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            console.log('Scrolled to:', elementId);
        }
    }



    </script>
</body>
</html>