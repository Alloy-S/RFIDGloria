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

    <title>Gloria Admin </title>

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

        .modal {
            display: none;
            position: fixed;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 80%;
            max-height: 80%;
        }

        .close {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 30px;
            color: white;
            cursor: pointer;
        }
    </style>



</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require "./sidebar.php"; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 style="color:#0352A3;font-size:3em;font-weight:bold" class="h3 mb-3 my-5 text-center">Kontrol Penjemputan</h1>

                    <!-- DataTales Example -->
                    <div class="dropdown mb-4 d-flex justify-content-end">
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            All
                        </button>
                        <div class="dropdown-menu animated--fade-in filter" aria-labelledby="dropdownFilter">
                            <a class="dropdown-item" href="#">All</a>
                            <a class="dropdown-item" href="#">TK</a>
                            <a class="dropdown-item" href="#">SD</a>
                            <a class="dropdown-item" href="#">SMP</a>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataHistory" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Id Murid</th>
                                            <th>Kelas</th>
                                            <th>Murid</th>
                                            <th>Kendaraan</th>
                                            <th>No. Plat</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include "footer.php" ?>
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

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- datatable pagination -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="./js/demo/datatables-demo.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var grade = "all";
        $(document).ready(function() {
            var table = $('#dataHistory').DataTable({
                ajax: {
                    url: "./api/dataLiveControl.php",
                    method: "POST",
                    data: function(d) {
                        d.grade = grade;
                    }
                },
                order: ([0, 'asc']),
                dataSrc: "data",
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        'data': "id_murid",
                    },
                    {
                        'data': "kelas",
                    },
                    {
                        'data': "murid",
                    },
                    {
                        'data': "jenis_mobil",
                    },
                    {
                        'data': "plat_mobil",
                    },
                    {
                        'data': "status",
                    },
                    {
                        data: null,
                        defaultContent: '<div class="d-flex flex-column align-items-center"><button class="btn btn-primary mb-1 complete"><i class="fas fa-check"></i> Complete</button><button class="btn btn-danger remove"><i class="fas fa-trash"></i> Remove</button></div>',
                        targets: -1
                    },
                ],

            });

            table.on('click', '.complete', function(e) {
                let data = table.row(e.target.closest('tr')).data();
                console.log(data);
                $.ajax({
                    url: "./api/ManualControl.php",
                    dataType: "json",
                    type: "POST",
                    data: {
                        method: "complete",
                        id_murid: data["id_murid"],
                    },
                    success: function(data) {
                        if (data == "200") {
                            console.log("berhasil di proses");
                            Swal.fire({
                                title: "Success",
                                text: "Permintaan berhasil",
                                icon: "success"
                            });
                            table.ajax.reload();
                        } else {
                            console.log(data);
                            Swal.fire({
                                title: "Failed",
                                text: "Terjadi kesalahan",
                                icon: "error"
                            });
                        }
                    },

                });
                // alert(data["id_murid"] + "'s salary is: " + data["murid"]);
            });

            table.on('click', '.remove', function(e) {
                let data = table.row(e.target.closest('tr')).data();
                $.ajax({
                    url: "./api/ManualControl.php",
                    dataType: "json",
                    type: "POST",
                    data: {
                        method: "remove",
                        id_murid: data["id_murid"],
                    },
                    success: function(data) {
                        if (data == "200") {
                            console.log("berhasil di proses");
                            Swal.fire({
                                title: "Success",
                                text: "Permintaan berhasil",
                                icon: "success"
                            });
                            table.ajax.reload();
                        } else {
                            console.log(data);
                            Swal.fire({
                                title: "Failed",
                                text: "Terjadi kesalahan",
                                icon: "error"
                            });
                        }
                    },

                });
                // alert(data["id_murid"] + "'s salary is: " + data["murid"]);
            });

            $('.filter a.dropdown-item').on('click', function() {
                // console.log($(this).text());

                grade = $(this).text().toLowerCase();
                $("#dropdownFilter").text($(this).text());
                // console.log(grade);
                table.ajax.reload();

            });
        });
    </script>
</body>



</html>