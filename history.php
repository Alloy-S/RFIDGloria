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
                    <h1 style="color:#0352A3;font-size:3em;font-weight:bold" class="h3 mb-3 my-5 text-center">Riwayat Penjemputan</h1>


                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="">
                                <div id="infoSection"></div>
                                <div class="row">
                                    <div class="col-12 form-floating input-group-md mb-3 px-3">
                                        <label for="start-date">Start Date: </label>
                                        <input type="date" class="form-control" id="start-date" name="start-date">
                                    </div>
                                    <div class="col-12 form-floating input-group-md mb-3 px-3">
                                        <label for="end-date">End Date: </label>
                                        <input type="date" class="form-control" id="end-date" name="end-date">
                                    </div>
                                    <button type="button" class="col-1 btn btn-primary mt-3 mx-3" id="showHistoryBtn">Send</button>
                                </div>
                            </form>
                            <div class="alert alert-info mt-4 mx-1 mb-0">Maximum range of history data to be shown is 7 days</div>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataHistory" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>student id</th>
                                            <th>nama siswa</th>
                                            <th>grade</th>
                                            <th>Class</th>
                                            <th>Rfid Tag</th>
                                            <th>Plat Mobil</th>
                                            <th>Jenis Mobil</th>
                                            <th>Driver</th>
                                            <th>Tapin Date</th>
                                            <th>Tapout Date</th>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>

                            <div class="row justify-content-end px-3 pt-4 pb-2" id="downloadLaporanButton"></div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

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

    <!-- datatable pagination -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="./js/demo/datatables-demo.js"></script>

    
</body>

<script>
    $(document).ready(function() {
            var table;
            var dataCount = 0;
            var buttonAdded = false;

            function destroyDataTable() {
                if ($.fn.DataTable.isDataTable('#dataHistory')) {
                    $('#dataHistory').DataTable().destroy();
                }
            }

            function initializeDataTable(data) {
                table = $('#dataHistory').DataTable({
                data: data,
                order: ([0, 'asc']),
                columns: [{
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            'data': "student_id",
                        },
                        {
                            'data': "nama_siswa",
                        },
                        {
                            'data': "grade",
                        },
                        {
                            'data': "class",
                        },
                        {
                            'data': 'rfid_tag'
                        },
                        {
                            'data': "plat_mobil",
                        },
                        {
                            'data': "jenis_mobil"
                        },
                        {
                            'data': "driver"
                        },
                        {
                            'data': "tapin_date"
                        },
                        {
                            'data': "tapout_date"
                        }
                    ]
                });
            }

            function showHistory(startDate, endDate) {
                // Destroy existing DataTable instance
                destroyDataTable();

                // Fetch data from API and initialize DataTable
                $.ajax({
                    url: './api/dataHistory.php',
                    method: 'GET',
                    data: {
                        startDate: startDate,
                        endDate: endDate
                    },
                    success: function(response) {
                        // Check if data is available
                        if (response && response.data) {
                            // Initialize DataTable with fetched data
                            initializeDataTable(response.data);
                            
                            // Count data
                            dataCount = table.rows().count();
                            
                            // Add or remove download button based on dataCount
                            if (dataCount > 0) {
                                if (!buttonAdded) {
                                    $('#downloadLaporanButton').append('<button class="btn btn-primary" id="downloadBtn">Download Laporan</button>');
                                    buttonAdded = true;
                                }
                            } else {
                                $('#downloadBtn').remove(); // Remove the download button
                                buttonAdded = false;
                            }

                            // Event listener for download button click
                            $('#downloadBtn').click(function() {
                                var startDate = document.getElementById('start-date').value;
                                var endDate = document.getElementById('end-date').value;
                                
                                downloadReport(startDate, endDate)
                                
                            });
                            
                        } else {
                            console.error('No data available');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }

            // Set current date as max in the input
            document.getElementById('start-date').setAttribute('max', new Date().toLocaleDateString('fr-ca'));
            document.getElementById('end-date').setAttribute('max', new Date().toLocaleDateString('fr-ca'));
    
    
            // Function to download the report
            function downloadReport(startDate, endDate) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', `./api/downloadLaporan.php?start-date=${startDate}&end-date=${endDate}`, true);
                xhr.responseType = 'blob';
    
                // Handling response
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4) {
                        if (xhr.status == 200) {
                            var blob = new Blob([xhr.response], { type: 'application/xls' });
    
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = `Riwayat_Penjemputan_${startDate}-${endDate}.csv`;
    
                            document.body.appendChild(link);
    
                            link.click();
                            document.body.removeChild(link);
                        } else {
                            console.error('Error downloading xls');
                        }
                    }
                };
    
                // Send the request
                xhr.send();
            }

            // Event listener for show history button click
            $('#showHistoryBtn').click(function() {
                var startDate = document.getElementById('start-date').value;
                var endDate = document.getElementById('end-date').value;
                
                if(new Date(startDate) <= new Date(endDate)) {
                    if(new Date(startDate) <= new Date() && new Date(endDate) <= new Date()) {
                        var range = Math.round((new Date(endDate).getTime() - new Date(startDate).getTime()) / (1000 * 3600 * 24));
            
                        if(0 <= range && range <= 7) {
                            showHistory(startDate, endDate);

                        } else {
                            document.getElementById('infoSection').className += 'alert alert-danger';
                            document.getElementById('infoSection').textContent = 'Maximum range is a week of report!';
                        }
                    } else {
                        document.getElementById('infoSection').className += 'alert alert-warning';
                        document.getElementById('infoSection').textContent = `Date maximum is current date (${  new Date().toLocaleDateString()})!`;
                    }
                } else {
                    document.getElementById('infoSection').className += 'alert alert-danger';
                    document.getElementById('infoSection').textContent = `Start Date must be less than End Date!`;
                }
                
            });
            
            
    });
</script>

</html>