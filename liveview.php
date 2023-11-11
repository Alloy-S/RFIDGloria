<?php
// require("./conn.php");

// $stmt = $conn->prepare("SELECT * FROM history");
// $stmt = $conn->prepare("SELECT db_kendaraan.murid, db_kendaraan.jenis_mobil, db_kendaraan.plat_mobil, history.entry_date, history.exit_time FROM history INNER JOIN db_kendaraan ON history.UID=db_kendaraan.rfid_tag ORDER BY history.entry_date DESC;");
// $stmt->execute();
// $rows = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Liveview</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- JQUERY -->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <style>

        .logo-gloria {
            border-radius: 50%;
        }

        .table th {
            background-color: #0352A3;
            color: #FFFFFF;
        }

        .container-fluid {
            position: absolute;
            top: 50vh;
            left: 50vw;
            transform: translate(-50%, -50%);
        }

        body {
            background-color: #68B3FF;
        }

        .header-footer {
            color: white;
            margin: 0;
        }

        #footer {
            position: absolute;
            bottom: 0;
            left: 50vw;
            transform: translate(-50%, 0);
        }

    </style>

    

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- header -->
                <header class="row col-lg-12 bg-gradient-primary justify-content-center header-footer" id="header">
                    <h1 class="m-5">Tabel Penjemputan Siswa/Siswi</h1>
                </header>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataHistory" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Kendaraan</th>
                                            <th>Plat No</th>
                                            <th>Waktu Datang</th>
                                            <th>Waktu Pergi</th>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

                <!-- header -->
                <footer class="row col-lg-12 bg-gradient-primary justify-content-center header-footer" id="footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-5">
                            <span>Copyright &copy; IT PCU 2023</span>
                        </div>
                    </div>
                </footer>

            </div>
            <!-- End of Main Content -->

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

    <!-- datatable pagination -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="./js/demo/datatables-demo.js"></script>

    
</body>

<script>
        $(document).ready(function() {
            var table = $('#dataHistory').DataTable({
                ajax: "./api/dataHistory.php",
                method: "GET",
                order: ([0, 'asc']),
                dataSrc: "data",
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        'data': 'murid'
                    },
                    {
                        'data': "jenis_mobil",
                    },
                    {
                        'data': "plat_mobil",
                    },
                    {
                        'data': "entry_date",
                    },
                    {
                        'data': "exit_time"
                    }
                ]
            });
        });
    </script>

</html>