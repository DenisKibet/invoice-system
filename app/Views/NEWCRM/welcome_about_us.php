<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Invoice System</title>
    <?php include 'css.php'?>
    <style>
        body {
            color: #333;
            line-height: 1.6;
        }

        .about-header {
            background-color: #1a1a1a;
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
        }

        .section-title {
            color: #1a1a1a;
            font-size: 1.5rem;
            font-weight: 600;
            margin: 2rem 0 1rem 0;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: #0d6efd;
        }

        .about-content {
            margin-bottom: 4rem;
        }

        .about-section {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .team-member {
            text-align: center;
            margin-bottom: 2rem;
        }

        .team-member img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .team-member h4 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .team-member p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <?php include 'welcome_topbar.php'?>
    <!-- Header -->
    <div class="about-header">
        <div class="container">
            <h1 class="display-4">About Invoice System</h1>
            <p class="lead">Learn more about our company and our mission to revolutionize invoicing.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container about-content">
        <div class="about-section">
            <h2 class="section-title">Our Story</h2>
            <p>Invoice System was founded in 2024 with a mission to simplify the invoicing process for businesses of all sizes. We recognized the pain points that companies faced in managing their billing and decided to create a cutting-edge solution to streamline this critical aspect of operations.</p>
            <p>Our team of experienced professionals has worked tirelessly to develop an intuitive, feature-rich platform that helps our clients save time, reduce errors, and get paid faster. We are committed to continuously improving our product and providing exceptional customer support.</p>
        </div>

        <div class="about-section">
            <h2 class="section-title">Our Team</h2>
            <div class="row">
                <div class="col-md-4 team-member">
                    <img src="/api/placeholder/150/150" alt="Steve Arnold">
                    <h4>Steve Arnold</h4>
                    <p>Co-Founder & CEO</p>
                </div>
                <div class="col-md-4 team-member">
                    <img src="/api/placeholder/150/150" alt="Barrack Obama">
                    <h4>Barrack Obama</h4>
                    <p>Co-Founder & CTO</p>
                </div>
                <div class="col-md-4 team-member">
                    <img src="/api/placeholder/150/150" alt="Michael Johnson">
                    <h4>Michael Johnson</h4>
                    <p>Head of Product</p>
                </div>
            </div>
        </div>

        <div class="about-section">
            <h2 class="section-title">Our Values</h2>
            <ul>
                <li>Commitment to customer success</li>
                <li>Continuous innovation and improvement</li>
                <li>Integrity and transparency in all our dealings</li>
                <li>Fostering a collaborative and inclusive work environment</li>
                <li>Giving back to the communities we serve</li>
            </ul>
        </div>
    </div>

    <?php include 'welcome_footer.php'?>
</body>
</html>