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

        .header-footer {
            color: white;
            margin: 0;
        }

        #footer {
            position: fixed;
            bottom: 0;
        }

        @media (max-width: 768px) {
            #footer {
                position: static;
            }
        }

        #grade {
            color: white;
            border: none;
            font-size: 30px;
            font-weight: bold;
        }

        #grade>option {
            font-size: 15px;
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
                <header class="row col-lg-12 bg-gradient-primary justify-content-center header-footer sticky-top" id="header">
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                        <div class="sidebar-brand-icon m-4">
                            <img src="./img/logo.jpg" alt="" width="40" class="logo-gloria">
                        </div>
                    </a>
                    <h2 style="font-size:3em;font-weight:bold" class="p-5">Tabel Penjemputan Siswa/Siswi</h1>
                        <!-- Opsi Liveview -->
                        <select name="grade" id="grade" class="bg-gradient-primary" onchange="reloadTable()">
                            <option value="all" selected>All</option>
                            <option value="tk">TK</option>
                            <option value="sd">SD</option>
                            <option value="smp">SMP</option>
                        </select>
                </header>

                <!-- Begin Page Content -->
                <div class="row container-fluid justify-content-center m-0">
                    <div class="wd-flex card col-lg-12 apper-table m-4">
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataLiveview" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <!-- <th>No</th> -->
                                        <th>Id Murid</th>
                                        <th>Kelas</th>
                                        <th>Murid</th>
                                        <th>Kendaraan</th>
                                        <th>No. Plat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

                <!-- footer -->
                <footer class="row col-lg-12 bg-gradient-primary justify-content-center header-footer sticky-bottom" id="footer">
                    <div class="container">
                        <div class="copyright text-center my-4">
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
    var page = 1;
    var total_pages = 1;

    $(document).ready(function() {
        // Variable Initialization
        var defaultGrade = "all";
        var lastPageChangeTime = new Date();

        // Modifying Selection State for Grade
        var urlParams = new URLSearchParams(window.location.search);
        var gradeParam = urlParams.get('grade');

        var selectedGrade = gradeParam || defaultGrade;
        $('#grade').val(selectedGrade);

        let playSound = false;
        getSound();


        function getSound() {
            console.log("get sound");
            $.ajax({
                url: "./api/getSound.php",
                dataType: "json",
                type: "GET",
                data: {
                    grade: $('#grade').val(),
                },
                success: function(data) {
                    console.log(data["sound"]);
                    var sounds = [];
                    data["sound"].forEach(element => {
                        sounds.push(new Audio("./sound/" + element));
                    });

                    console.log(sounds);
                    play_sound_queue(sounds);
                }
            })
        }


        function play(audio, callback) {
            setTimeout(function() {
                audio.play();
                console.log(audio.currentSrc);
                if (callback) {
                    //When the audio object completes it's playback, call the callback
                    //provided      
                    audio.addEventListener('ended', callback);
                }
            }, 2000);

        }

        //Changed the name to better reflect the functionality
        function play_sound_queue(sounds) {
            var index = 0;

            function recursive_play() {
                //If the index is the last of the table, play the sound
                //without running a callback after       
                console.log(index)
                console.log($('#grade').val());
                // console.log(sounds[index].currentSrc);


                if (sounds.length == 0) {
                    console.log("empty");
                    setTimeout(function() {
                        getSound();
                    }, 2000);
                } else if (index + 1 === sounds.length) {
                    // console.log(index);
                    play(sounds[index], function() {
                        getSound();
                    });
                } else {
                    //Else, play the sound, and when the playing is complete
                    //increment index by one and play the sound in the 
                    //indexth position of the array
                    play(sounds[index], function() {
                        index++;
                        // console.log(index);
                        recursive_play();
                    });
                }
            }

            //Call the recursive_play for the first time
            recursive_play();
        }

        // Table initialization
        var table = $('#dataLiveview').DataTable({
            ajax: {
                url: "./api/dataLiveview.php",
                method: "GET",
                data: function(d) {
                    // Send the current page as a parameter
                    d.page = page;

                    // Send the grade value
                    d.grade = $('#grade').val();
                },
                dataSrc: function(json) {
                    total_pages = json.total_pages;
                    return json.data;
                }
            },
            order: ([0, 'asc']),
            columns: [
                // {
                //     render: function (data, type, row, meta) {
                //         return meta.row + meta.settings._iDisplayStart + 1;
                //     }
                // },
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
                }
            ],
            paging: false,
            searching: false,
            info: false,
            initComplete: function(settings, json) {
                // Auto-refresh the DataTable continuously (1-second interval)
                setInterval(function() {
                    console.log("Current Page:", page);

                    var currentTime = new Date();
                    var timeDifference = currentTime - lastPageChangeTime;

                    // Auto-refresh data every 0.001 second
                    if (timeDifference >= 5000) {
                        table.ajax.reload(null, false);
                    }

                    // Change page every 5 seconds & check if 5 seconds have passed since the last page change
                    if (timeDifference >= 5000) {
                        // Add a fade-out effect before reloading
                        $('#dataLiveview').fadeOut(500, function() {
                            table.ajax.reload(null, false);
                            table.ajax.reload(function() {
                                // Log after reload
                                console.log("Reloaded. Current Page:", page);
                                // Add a fade-in effect after reloading
                                $('#dataLiveview').fadeIn(500);
                                table.ajax.reload(null, false);
                            }, false);
                        });

                        page++;
                        if (page > total_pages) {
                            page = 1;
                        }

                        // Update the last page change time
                        lastPageChangeTime = new Date();
                    }
                }, 1000);

            }
        });
    });

    function reloadTable() {
        var selectedGrade = $('#grade').val();

        // Update the URL in the address bar
        var newUrl = window.location.protocol + '//' + window.location.host + window.location.pathname + '?grade=' + selectedGrade;
        window.history.pushState({
            path: newUrl
        }, '', newUrl);

        // Reset DataTable with page=1
        page = 1;
        reloadTable
    }
</script>

</html>