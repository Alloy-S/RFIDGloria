<?php
include("../conn.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $startDate = isset($_GET["startDate"]) ? $_GET["startDate"] : '1970-01-01';
    $endDate = isset($_GET["endDate"]) ? $_GET["endDate"] : $startDate;
    $query = "SELECT student_id, nama_siswa, grade, class, rfid_tag, plat_mobil, jenis_mobil, driver, tapin_date, tapout_date
    FROM history
    WHERE DATE(tapin_date) >= :startDate
    AND DATE(tapout_date) <= :endDate
    ORDER BY tapin_date DESC;";

    $result = $conn->prepare($query);
    $result->bindParam(':startDate', $startDate);
    $result->bindParam(':endDate', $endDate);
    $result->execute();
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil);
    echo json_encode($result);
}
?>