<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Invoice System - profile info </title>
    <?php include 'css.php' ?>
    <style>
        .icon {
            vertical-align: middle;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include 'sidebar.php' ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php include 'topbar.php' ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                    </div>
                    <div class="card-body" style="width: 100%; background-color: #ffffff;">

                        <div class="col-12 card-header" style="color:#1a1a1a; background-color: #e6e6e6;border-radius: 0 12px 12px 0;">
                            <h4> <i class="" style="color:#1a1a1a;vertical-align:middle;"></i>
                                Profile Information</h4>
                        </div>
                            <form>
                                 <form>
                                    <div class="row">
                                        <!-- <div class="col-sm-6 form-group">
                                            <label for="user_id">User ID</label>
                                            <input type="text" class="form-control" id="user_id" value="<?= esc($responseData['user_id']) ?>" readonly>
                                        </div> -->
                                        <div class="col-sm-6 col-lg-12  form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" value="<?= esc($responseData['username']) ?>" >
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" id="email" value="<?= esc($responseData['email']) ?>" >
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            <label for="password">Password </label>
                                            <input type="text" class="form-control" id="password" value="<?= isset($responseData['password']) ? esc($responseData['password']) : '********' ?>" >
                                        </div>
                                    </div>
                                </form>
                                <!-- Add more fields as needed -->

                                <!-- Edit Profile Button -->
                                <a href="#" class="btn btn-dark" id="learnJS" style="background-color:;">Update Profile</a>
                            </form>
                        <?php include 'js.php' ?>
                        <script>
                        </script>
                    </div>

                </div>

            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Invoice system 2024</span>
                    </div>
                </div>
            </footer>

    <?php include 'js.php' ?>
    <script>
        $('#learnJS').on('click', function (e) {
            const number = 42;
            try {
            number = 99;
            } catch (err) {
            console.log(err);
            // Expected output: TypeError: invalid assignment to const 'number'
            // (Note: the exact output may be browser-dependent)
            }

            console.log(number);
            // Expected output: 42

        });
    </script>
</body>
</html>
