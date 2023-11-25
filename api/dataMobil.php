<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $conn->prepare("SELECT a.jenis_mobil, a.plat_mobil, a.rfid_tag, a.driver, a.foto, b.name FROM db_kendaraan AS a JOIN murid AS b ON a.id_murid = b.student_id ");
    $result->execute();
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil);
    echo json_encode($result);
}

?>