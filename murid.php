<?php
require("./conn.php");

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <!-- font awesome  -->
    <link rel="stylesheet" href="./vendor/fontawesome-free.6.4.2-web/css/all.min.css">
    <style>
        .logo-gloria {
            border-radius: 50%;
        }

        .table th {
            background-color: #0352A3;
            color: #FFFFFF;
        }

        .table tr {
            color: #000000;
        }

        #dataSiswa {
            width: 100% !important;
        }


        .wrapper-table {
            box-shadow: -2px 1px 14px -4px rgba(0, 0, 0, 0.6);
            -webkit-box-shadow: -2px 1px 14px -4px rgba(0, 0, 0, 0.6);
            -moz-box-shadow: -2px 1px 14px -4px rgba(0, 0, 0, 0.6);
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- modal list murid -->
        <!-- Button trigger modal -->

        <!-- Modal List Murid-->


        <?php include "sidebar.php" ?>
        <div class="modal fade" id="modalListSound" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color: #000000">
                            List Sound
                        </h5>
                    </div>
                    <div class="modal-body" id="modal-body-sound">
                        <ul id="listSound" class="p-0">
                            <li>Test</li>
                            <li>Test</li>
                            <li>Test</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" id="addSound" data-dismiss="modal">
                            Add Sound
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalAddSound" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="./api/addSound.php" id="submit-sound" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel" style="color: #000000">
                                Add Sound
                            </h5>
                        </div>
                        <div class="modal-body" id="modal-body-sound">
                            <label for="student_id">Student id</label>
                            <input type="text" class="form-control mb-3" id="student_id" name="student_id" readonly>
                            <label for="title_sound">Title</label>
                            <input type="text" class="form-control mb-3" id="title_sound" name="title_sound" required>
                            <label for="suara">Sound</label>
                            <input type="text" class="form-control mb-3" id="suara" name="suara" required>
                            <label for="suara">Date used</label>
                            <input type="date" class="form-control mb-3" id="date" name="date" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Header -->
                <h1 style="color:#0352A3;font-size:3em;font-weight:bold" class="text-center my-5">Daftar Siswa</h1>

            </div>
            <!-- Wrapper table -->
            <div class="wrapper-table mx-4 px-5 py-3 mb-5">
                <table class='table table-striped' id="dataSiswa" style="overflow-x: auto;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Student Id</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Class</th>
                            <th>Phone</th>
                            <th>Sound</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- End of Wrapper table  -->

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

    <!-- datatable pagination -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="./js/demo/datatables-demo.js"></script>

</body>

<script>
    $(document).ready(function() {
        var table = $('#dataSiswa').DataTable({
            ajax: "./api/dataSiswa.php",
            method: "GET",
            order: ([0, 'asc']),
            dataSrc: "data",
            columns: [{
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    'data': 'student_id'
                },
                {
                    'data': "name",
                },
                {
                    'data': "grade",
                },
                {
                    'data': "class",

                },
                {
                    'data': "phone",

                },
                {
                    'data': "student_id",
                    "render": function(data, type, row, meta) {
                        return `<button type="button" onclick="checkSound('${data}')" class="btn btn-primary">
                                View
                                </button>`;

                    }
                }
            ]
        });
        $('#addSound').on('click', function() {
            $('#student_id').val($(this).data('id'));
            $('#title_sound').val("");
            $('#suara').val("");
            $('#date').val("");
            $('#modalListSound').modal('hide');
            $('#modalAddSound').modal('show');
        })

        $("#submit-sound").on("submit", function(e) {
            console.log('check')
            e.preventDefault();
            $.ajax({
                url: "./api/addSound.php",
                type: "POST",
                dataType: "JSON",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false
            }).done((data) => {
                if (!data.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!!',
                        text: "Gagal memasukkan sound"
                    })
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!!',
                        text: "Berhasil memasukkan sound"
                    }).then(() => {
                        $('#modalAddSound').modal('hide');
                    })
                }
            })
        })
    })

    function checkSound(data) {
        $("#addSound").data('id', data);
        const modalMurid = $('#modalListSound');
        const bodyModalSound = modalMurid.find('#mobil-body-sound');
        const ul = modalMurid.find('#listSound');
        const idMurid = data;

        // Mengonversi string JSON menjadi array JavaScript

        // Sekarang, parameterArray adalah array yang berisi semua parameter
        // console.log(parameterArray);
        modalMurid.modal({
            backdrop: false
        });
        $.ajax({
            url: "./api/checkSound.php",
            type: "POST",
            data: {
                id: data
            }
        }).done((data) => {
            var li = ''
            data.data.forEach(element => {
                if (element.title == "default") {
                    li += `<li class="d-flex justify-content-between" style="color: #000000;">${element.title}</li> <hr>`
                } else {
                    li += `<li class="d-flex justify-content-between align-items-center" style="color: #000000;">${element.title} (${element.date})<button class="btn btn-danger" onclick="deleteSound('${element.id}', '${idMurid}')">Delete</button></li> <hr>`
                }
            });
            ul.html(li)
            modalMurid.modal('show');
        })
    }

    function deleteSound(id, data) {
        $.ajax({
            url: "./api/deleteSound.php",
            type: "POST",
            data: {
                id: id
            }
        }).done((response) => {
            if (response == 'success') {
                checkSound(data);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed!!',
                    text: "Terjadi kesalahan dalam menghapus data."
                })
            }
        })
    }
</script>

</html>