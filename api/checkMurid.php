<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kendaraan = $_POST['id'];
    $result = $conn->prepare("SELECT b.name,b.student_id FROM murid_to_kendaraan AS a JOIN murid AS b on a.id_murid = b.student_id WHERE a.id_kendaraan = $id_kendaraan");
    $result->execute();
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil);
    echo json_encode($result);
}
