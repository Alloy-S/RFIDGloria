<?php
require("./conn.php");

$stmt = $conn->prepare("UPDATE tb_entry SET `UID`=:newUID WHERE id=:id");
$stmt->execute([":newUID" => "", ":id" => 1]);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font awesome  -->
    <link rel="stylesheet" href="./vendor/fontawesome-free.6.4.2-web/css/all.min.css">
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .logo-gloria {
            border-radius: 50%;
        }

        .custom-file-button input[type=file] {
            margin-left: -2px !important;
        }

        .custom-file-button input[type=file]::-webkit-file-upload-button {
            display: none;
        }

        .custom-file-button input[type=file]::file-selector-button {
            display: none;
        }

        .custom-file-button label {
            color: #0352A3;
            cursor: pointer;
        }

        .loader {
            border: 4px solid #f3f3f3;
            border-radius: 50%;
            border-top: 4px solid blue;
            border-bottom: 4px solid blue;
            width: 30px;
            height: 30px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            margin-inline: auto;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include "sidebar.php" ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Begin Page Content -->

            <!-- Main Content -->
            <div class="container-fluid" style="padding-inline:4em;margin-top:6em;">
                <h1 style="color:#0352A3;font-size:3em;font-weight:bold">Tambah Kendaraan</h1>
                <form id="submit-kendaraan" action="./api/addKendaraan.php" enctype="multipart/form-data" method="POST">
                    <div class="col-12 mb-3">
                        <label for="jenis_mobil" class="form-label">Jenis Mobil</label>
                        <input type="text" class="form-control" id="jenis_mobil" name="jenis" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="plat_mobil" class="form-label">Plat Mobil</label>
                        <input type="text" class="form-control" id="plat_mobil" name="plat" required>
                    </div>
                    <!-- <div class="col-12 mb-3">
                        <label for="rfid_tag" class="form-label">RFID Tag</label>
                        <input type="text" class="form-control" id="rfid_tag" name="rfid" readonly>
                    </div> -->
                    <div class="col-12 mb-3">
                        <label for="rfid_tag" class="form-label">Car RFID Tag</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="rfid_tag" name="rfid">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="scanRfid1" data-toggle="modal" data-target="#rfidModal">Scan</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12 mb-3">
                        <label for="studentCard" class="form-label">Student Card</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="studentCard" name="studentCard" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="scanRfid2" data-toggle="modal" data-target="#rfidModal">Scan</button>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-12 mb-3">
                        <label for="driver" class="form-label">Driver</label>
                        <input type="text" class="form-control" id="driver" name="driver" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="murid" class="form-label">Id Murid</label>
                        <input type="text" class="form-control" id="murid" name="murid" required>
                        <span>Untuk 2 atau lebih murid silahkan pisahkan dengan koma (c14210151,c14210093)</span>
                    </div>
                    <div class="input-group custom-file-button col-12 mb-3">
                        <label class="input-group-text" for="inputGroupFile"><span class="mr-2">
                                <i class="fa-solid fa-upload" style="color: #0352a3;"></i>
                            </span>Upload Foto</label>
                        <input type="file" class="form-control" id="inputGroupFile" name="foto_mobil" required>
                    </div>
                    <div class="col-4 col-lg-2 mb-3">
                        <img id="preview" src="" class="w-100">
                    </div>
                    <div class="col-4 col-lg-2 mb-3">
                        <button type="submit" class="submit-btn btn btn-primary w-100">Confirm</button>
                    </div>
                </form>

            </div>
            <!-- End of Main Content  -->

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

    <!-- Modal -->
    <div class="modal fade" id="rfidModal" tabindex="-1" aria-labelledby="rfidModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scan RFID</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
                        <dotlottie-player src="https://lottie.host/e76b14b4-c5c1-4645-b41c-0d352f45bfbc/oc4To4iLOW.json" background="#fff" speed="1" style="width: 300px; height: 300px" direction="1" playMode="normal" loop autoplay></dotlottie-player>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    <!-- datatable pagination -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="./js/demo/datatables-demo.js"></script>

    <!-- ajax -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
</body>

<script>
    $(document).ready(function() {
        $("#submit-kendaraan").on("submit", function(e) {
            e.preventDefault();
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
                    $('.submit-btn').html('<div class="loader"></div>');
                    $.ajax({
                        url: "./api/addKendaraan.php",
                        type: "POST",
                        dataType: "JSON",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false
                    }).done((data) => {
                        $('.submit-btn').html('Confirm');
                        if (!data.success) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!!',
                                text: data.pesan
                            })
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!!',
                                text: data.pesan
                            }).then(() => {
                                window.location.href = './list_kendaraan.php';
                            })
                        }
                    })
                }
            })
        })
    })

    var rfidReciveMode = 0;

    setInterval(function() {
        if (($("#rfidModal").data('bs.modal') || {})._isShown) {
            // console.log("modal open");
            $.ajax({
                url: "./api/getUID.php",
                type: 'GET',
                success: function(res) {
                    console.log(res);
                    if (res != "") {
                        if (rfidReciveMode == 0) {
                            $("#rfid_tag").val(res);
                        } else {
                            $("#studentCard").val(res);
                        }

                        $('#rfidModal').modal('hide');
                        // $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }

                }
            });
        }
    }, 1000);

    $("#scanRfid1").on("click", function() {
        console.log("click");
        $.ajax({
            url: "./api/clearRfid.php",
            type: "GET",
            success: function(res) {
                $("#rfid_tag").val("");
                rfidReciveMode = 0;
            }
        });
    });

    $("#scanRfid2").on("click", function() {
        console.log("click");
        $.ajax({
            url: "./api/clearRfid.php",
            type: "GET",
            success: function(res) {
                $("#studentCard").val("");
                rfidReciveMode = 1;
            }
        });
    });

    $("#inputGroupFile").on("change", function() {
        const selectedImage = this.files[0];

        if (selectedImage) {
            const reader = new FileReader();

            reader.onload = function() {
                $("#preview").attr("src", reader.result);
            };

            reader.readAsDataURL(selectedImage);
        } else {
            $("#preview").attr("src", "");
        }
    });
</script>

</html>