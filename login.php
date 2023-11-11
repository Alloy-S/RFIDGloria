<?php
session_start();
require_once('./conn.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gloria Admin</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">
        <!-- Outer Row content here... -->

            <div class="col-lg-6">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Welcome</h1>
                    </div>
                    
                    <?php
                    // Display login error message if set
                    if (isset($_SESSION['login_error'])) {
                        echo "<div class='alert alert-warning mt-4' role='alert'>
                                {$_SESSION['login_error']}
                            </div>";
                        unset($_SESSION['login_error']); // Clear the session variable
                    }
                    ?>
                    
                    <form class="user" method="POST" action="api/login.php">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="username" placeholder="Enter Username..." name="username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password">
                        </div>

                        <button class="btn btn-primary btn-user btn-block" name="submit" type="submit">
                            Login
                        </button>
                    </form>
                    <!-- Additional HTML content if needed... -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
