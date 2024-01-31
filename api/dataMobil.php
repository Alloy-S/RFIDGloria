<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $conn->prepare("SELECT a.id, a.jenis_mobil, a.plat_mobil, a.rfid_tag, a.driver, a.foto, c.name 
    FROM db_kendaraan AS a 
    JOIN murid_to_kendaraan AS b ON a.id = b.id_kendaraan 
    JOIN murid AS c ON b.id_murid = c.student_id
    GROUP BY b.id_kendaraan");
    $result->execute();
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil);
    echo json_encode($result);
}
