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

        .wrapper-table {
            box-shadow: -2px 1px 14px -4px rgba(0, 0, 0, 0.6);
            -webkit-box-shadow: -2px 1px 14px -4px rgba(0, 0, 0, 0.6);
            -moz-box-shadow: -2px 1px 14px -4px rgba(0, 0, 0, 0.6);
        }

        .modal {
            display: none;
            position: fixed;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
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

        <!-- modal list murid -->
        <!-- Button trigger modal -->

        <!-- Modal List Murid-->


        <?php include "sidebar.php" ?>
        <div class="modal fade" id="modalListMurid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" style="color: #000000">
                            List Murid
                        </h5>
                    </div>
                    <div class="modal-body">
                        <p id="mobilId">Veloz (haha)</p>
                        <ul id="listMurid">
                            <li>Test</li>
                            <li>Test</li>
                            <li>Test</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Header -->
                <h1 style="color:#0352A3;font-size:3em;font-weight:bold" class="text-center my-5">Daftar Mobil</h1>

            </div>
            <!-- Wrapper table -->
            <div class="wrapper-table mx-4 px-5 py-3 mb-5">
                <table class='table table-striped' id="dataMobil" style="overflow-x: auto;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Mobil</th>
                            <th>Plat Mobil</th>
                            <th>Rfid Tag</th>
                            <th>Driver</th>
                            <th>Murid</th>
                            <th>Foto</th>
                            <th>Action</th>
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
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
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
        var table = $('#dataMobil').DataTable({
            ajax: "./api/dataMobil.php",
            method: "GET",
            order: ([0, 'asc']),
            dataSrc: "data",
            columnDefs: [{
                    "width": "14%",
                    "targets": 7
                },
                {
                    "width": "10%",
                    "targets": 6
                },
                {
                    "width": "5%",
                    "targets": 0
                }
            ],
            columns: [{
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    'data': 'jenis_mobil'
                },
                {
                    'data': "plat_mobil",
                },
                {
                    'data': "rfid_tag",
                },
                {
                    'data': "driver",

                },
                {
                    'data': "id",
                    "render": function(data, type, row, meta) {
                        return `<button type="button" onclick="checkMurid(event)" data-params='[${data}, "${row.jenis_mobil}", "${row.plat_mobil}"]' class="btn btn-primary">
                                View
                                </button>`;

                    }
                },
                {
                    'data': "foto",
                    "render": function(data, type, row, meta) {
                        return `<button type="button" class="btn btn-primary" onclick="viewFoto('${data}')"> View Foto
                            </button>`;

                    }
                },
                {
                    'data': "id",
                    "render": function(data, type, row, meta) {
                        return `<a href = ./edit_kendaraan.php?id=${data}><button type="button" class="btn btn-primary"><span class="mr-2"><i class="fas fa-edit" style="color: #ffffff;"></i></span>Edit
                            </button></a> <button type="button" class="btn btn-warning" onclick="deleteKendaraan(${data})"><span class="mr-2"><i class="fas fa-trash" style="color: #ffffff;"></i></span>Delete
                            </button>`;

                    }
                }
            ]
        });
    })

    function viewFoto(url) {
        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("modalImage");
        modal.style.display = "block";
        modalImg.src = "./upload_foto/" + url;
    }

    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    function checkMurid(id) {
        const modalMurid = $('#modalListMurid');
        const bodyModalMobil = modalMurid.find('#mobilId');
        const ul = modalMurid.find('#listMurid');
        var paramsString = event.target.getAttribute('data-params');

        // Mengonversi string JSON menjadi array JavaScript
        var parameterArray = JSON.parse(paramsString);

        // Sekarang, parameterArray adalah array yang berisi semua parameter
        // console.log(parameterArray);
        bodyModalMobil.html(`<p>${parameterArray[1]} (${parameterArray[2]})</p>`);
        modalMurid.modal({
            backdrop: false
        });
        // const bodyModal = modalMurid.querySelector('.modal-body');
        $.ajax({
            url: "./api/checkMurid.php",
            type: "POST",
            data: {
                id: parameterArray[0]
            }
        }).done((data) => {
            var li = ''
            data.data.forEach(element => {
                li += `<li>${element.name} (${element.student_id})</li>`
            });
            ul.html(li)
            modalMurid.modal('show');

        })
    }

    function deleteKendaraan(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "./api/deleteDataKendaraan.php",
                    type: "POST",
                    data: {
                        id: id
                    }
                }).done((data) => {
                    if (data != "success") {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!!',
                            text: "Gagal menghapus data"
                        })
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!!',
                            text: "Berhasil menghapus data"
                        })
                        $('#dataMobil').DataTable().ajax.reload(null, false);
                    }
                })
            }
        })
    }
</script>

</html>