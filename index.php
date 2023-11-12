<?php
require './session.php';
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

    <title>Gloria Admin </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <script src="animation_dashboard.js"></script>

    <style>
        .logo-gloria {
           border-radius: 50%; 
        }

        .header {
            color: #0352A3;
            font-size: 6em;
            font-weight: bold;
        }

        .container-fluid {
            animation: 1.5s anim-lineUP ease-in;
        }

        #admin {
            font-size: 3em;
            background-color: #0352A3;
            color: white;
            padding: 0 0.5em;
        }

        #welcome {
            font-size: 4em;
            letter-spacing: 0.05em;
        }

        .bg-dashboard-image {
            background: url(./img/welcome-person.png);
            background-position: center;
            background-size: 100%;
            background-repeat: no-repeat;
            animation: 2s anim-lineUP ease-out;
        }

        @keyframes anim-lineUP {
            0% {
                opacity: 0;
                transform: translateY(10%);
            }
            20% {
                opacity: 0;
            }
            50% {
                opacity: 1;
                transform: translateY(0%);
            }
            100% {
                opacity: 1;
                transform: translateY(0%);
            }
        }


    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php require"./sidebar.php"; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->

            <div class="row mt-5" id="content">
                <div class="col-lg-7">
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                            <div class="text-center mt-5 mx-4" id="text">
                                <span class="header">Hello, </span>
                                <span class="header" id="admin">Admin</span>
                                <div class="header word" id="welcome"></div>
                            </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                
                
                <div class="col-lg-5 d-none d-lg-block bg-dashboard-image"></div>

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; IT PCU 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

<script>
    $(document).ready(function () {
    wordflick();
    });
</script>

</html>