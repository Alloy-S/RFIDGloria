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

    <style>

        * {
            color: white;
        }

        .container {
            position: absolute;
            margin: 0 50vw;
            transform: translate(-50%, 0);
        }

        .form-group input {
            background: transparent;
            border: none;
            border-bottom: 3px solid white;
            width: 100%;
            transition: border 0.3s;
            padding: 5px;
        }

        .form-group input:focus {
            background: transparent;
            outline: none;
            border: none;
            border-bottom: 3px solid #f0ad4e;
            box-shadow: none;
        }

        ::placeholder {
            color: white;
        }

        .bg-login-image {
            background: url(./img/login-person.png);
            background-position: bottom;
            background-size: 100%;
        }

        /* a, a:active, a:visited, a:hover {
            color: white;
            float: right;
        } */

    </style>

</head>

<body class="bg-gradient-primary">

<div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <img class="col my-5" src="img/icon-profile-login.png" alt="icon profile login">
                                <h1 class="h1 mb-4">WELCOME</h1>
                            </div>
                            <form class="user my-5" method="POST" action="api/login.php">
                                <div class="form-group mb-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="mb-4" id="username" name="username">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="mb-4" id="password" name="password">
                                </div>

                                <!-- Forgot Password
                                <div class="text-right">
                                    <a class="mb-4" href="forgot_password.php">Forgot Password?</a>
                                </div> -->

                                <div class="form-group my-4">
                                    <button class="btn btn-warning btn-lg btn-block my-5" name="submit" type="submit">
                                        LOGIN
                                    </button>
                                </div>
                            </form>

                            <?php
                                // Display login error message if set
                                if (isset($_SESSION['login_error'])) {
                                    echo "<div class='alert alert-danger mt-4' role='alert'>
                                            {$_SESSION['login_error']}
                                        </div>";
                                    unset($_SESSION['login_error']); // Clear the session variable
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-1"></div>
                    <div class="col-lg-5 d-none d-lg-block bg-login-image"></div>
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
