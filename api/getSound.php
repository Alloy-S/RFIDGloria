<?php
require_once("../conn.php");
header('Content-Type: application/json');

$grade = isset($_GET["grade"]) ? $_GET["grade"] : 'all';


$grade = isset($_GET["grade"]) ? $_GET["grade"] : 'all';

$sd = array("1", "2", "3", "4", "5", "6");
$smp = array("7", "8", "9");

$result_query = "SELECT murid.sound FROM live_view AS live INNER JOIN murid_to_kendaraan AS murid ON live.murid_id=murid.id_murid JOIN murid AS siswa ON murid.id_murid=siswa.student_id";


if ($grade == 'all') {
    $result_query .= "
        ORDER BY
        live.entry_date DESC
    ;";

} else {
    if ($grade == 'sd') {
        $result_query .= "
            AND (siswa.grade IN (" . implode(',', $sd) . "))
            ORDER BY
            live.entry_date DESC
        ";

    } elseif ($grade == 'smp') {
        $result_query .= "
            AND (siswa.grade IN (" . implode(',', $smp) . "))
            ORDER BY
            live.entry_date DESC
        ";

    } else {
        $result_query .= "
            AND ((siswa.grade NOT IN (" . implode(',', $sd) . ")) AND (siswa.grade NOT IN (" . implode(',', $smp) . ")))
            ORDER BY
            live.entry_date DESC
        ";
    }
}

$result_query .= "LIMIT 3;";


$stmt = $conn->prepare($result_query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sound = [];
foreach ($result as $row) {
    $sound[] = $row['sound'];
}
$data["grade"] = $grade;
$data["sound"] = $sound;
echo json_encode($data);
