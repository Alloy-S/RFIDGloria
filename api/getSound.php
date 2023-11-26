<?php 
require_once("../conn.php");

$stmt = $conn->prepare("SELECT kendaraan.sound FROM tmphistory tmp INNER JOIN db_kendaraan kendaraan ON tmp.UID=kendaraan.rfid_tag LIMIT 3");
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sound = [];
foreach($data as $row) {
    $sound[] = $row['sound'];
}

$sounds["sound"] = $sound;
echo json_encode($sounds);

?>