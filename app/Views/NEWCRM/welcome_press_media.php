<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Press & Media</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <?php include 'css.php'?>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .about-header {
            background-color: #1a1a1a;
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
        }
        .section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        h1, h2 {
            color: #007bff;
        }
        a {
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'welcome_topbar.php'?>
    <!-- Header -->
    <div class="about-header">
        <div class="container">
            <h1 class="display-4">Press & Media</h1>
            <p class="lead">Welcome to our Press & Media Center. Here you can find the latest news, press releases, and media resources.</p>
        </div>
    </div>

    <div class="container mt-5">
        <!-- Section: Latest Press Releases -->
        <div class="section">
            <h2>Latest Press Releases</h2>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <h5>New Product Launch</h5>
                    <p>We are excited to announce the launch of our new product. <a href="#">Read more...</a></p>
                </li>
                <li class="list-group-item">
                    <h5>Partnership Announcement</h5>
                    <p>We have partnered with XYZ Company to enhance our service offerings. <a href="#">Read more...</a></p>
                </li>
                <li class="list-group-item">
                    <h5>Award Recognition</h5>
                    <p>We are proud to be recognized as the Best Company of the Year. <a href="#">Read more...</a></p>
                </li>
            </ul>
        </div>

        <!-- Section: Media Resources -->
        <div class="section">
            <h2>Media Resources</h2>
            <p>Below are some resources that may be useful for journalists and media representatives:</p>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Company Logo:</strong> <a href="#">Download Logo</a>
                </li>
                <li class="list-group-item">
                    <strong>Product Images:</strong> <a href="#">Download Images</a>
                </li>
                <li class="list-group-item">
                    <strong>Executive Bios:</strong> <a href="#">Download Bios</a>
                </li>
            </ul>
        </div>

        <!-- Section: Contact Media Relations -->
        <div class="section">
            <h2>Contact Media Relations</h2>
            <p>If you have any inquiries or need further information, please contact our Media Relations team:</p>
            <p>Email: <a href="mailto:media@example.com">media@example.com</a></p>
            <p>Phone: <strong>(123) 456-7890</strong></p>
        </div>

        <!-- Section: Follow Us -->
        <div class="section">
            <h2>Follow Us</h2>
            <p>Stay updated with our latest news and updates by following us on social media:</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Facebook</a></li>
                <li class="list-inline-item"><a href="#">Twitter</a></li>
                <li class="list-inline-item"><a href="#">LinkedIn</a></li>
                <li class="list-inline-item"><a href="#">Instagram</a></li>
            </ul>
        </div>
    </div>
    <?php include 'welcome_footer.php'?>
    <?php include 'js.php'?>
</body>
</html>
