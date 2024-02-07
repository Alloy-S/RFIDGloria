<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $conn->prepare("SELECT student_id, nama_siswa, grade, class, rfid_tag, plat_mobil, jenis_mobil, driver, tapin_date, tapout_date FROM history ORDER BY tapin_date DESC;");
    $result->execute();
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil);
    echo json_encode($result);
}

?>