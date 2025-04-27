<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enhanced Navbar with Hover Effect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            padding: 1rem 0;
        }

        .navbar-brand img {
            max-height: 40px;
        }

        .nav-link {
            color: #333;
            position: relative;
            transition: color 0.3s ease;
            margin: 0 0.5rem;
            font-weight: 500;
        }

        .nav-link:not(.btn-primary)::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            background-color: #0d6efd;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }

        .nav-link:not(.btn-primary):hover {
            color: #0d6efd;
        }

        .nav-link:not(.btn-primary):hover::after {
            width: 100%;
        }

        .navbar-nav .nav-link {
            padding: 0.5rem 0;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="<?= base_url('assets/images/logo-holder.png') ?>" alt="Website Logo">
                <!-- <img src="<?php print base_url(); ?>assets/images/logo-holder.png" /> -->
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="features">Features</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="resouces">Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pricing">Pricing</a>
                    </li> -->
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-dark px-3 py-2" href="login" id="loginButton">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-dark px-3 py-2" href="/" id="signUpButton">Sign Up</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>