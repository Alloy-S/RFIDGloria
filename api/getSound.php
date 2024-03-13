<?php
require_once("../conn.php");
header('Content-Type: application/json');

$grade = isset($_GET["grade"]) ? $_GET["grade"] : 'all';

if ($grade == "") {
    $data["status"] = "invalid";
    echo json_encode($data);
    return;
}
$sd = array("1", "2", "3", "4", "5", "6");
$smp = array("7", "8", "9");
$currentDate = date('Y-m-d');
$queryCurrent = "SELECT * FROM sound WHERE DATE(date) = :currentDate AND title <> 'default'";
$stmt = $conn->prepare($queryCurrent);
$stmt->execute([":currentDate" => $currentDate]);
$event = false;
if ($stmt->rowCount() > 0) {
    $event = true;
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $title = $result['title'];
} else {
    $title = "default";
}


$result_query = "SELECT murid.sound FROM live_view AS live INNER JOIN sound AS murid ON live.murid_id=murid.student_id";


if ($grade == 'all') {
    $result_query .= "
        WHERE murid.title = '" . $title . "'
        ORDER BY
        live.entry_date DESC
    ;";
} else {
    if ($grade == 'sd') {
        $result_query .= "
            AND ((live.grade IN (" . implode(',', $sd) . ")) AND (murid.title = '" . $title . "'))
            ORDER BY
            live.entry_date DESC
        ";
    } elseif ($grade == 'smp') {
        $result_query .= "
            AND ((live.grade IN (" . implode(',', $smp) . ")) AND (murid.title = '" . $title . "'))
            ORDER BY
            live.entry_date DESC
        ";
    } else {
        $result_query .= "
            AND ((live.grade NOT IN (" . implode(',', $sd) . ")) AND (live.grade NOT IN (" . implode(',', $smp) . ")) AND (murid.title = '" . $title . "'))
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
$data["status"] = "ok";
$data["grade"] = $grade;
$data["sound"] = $sound;
echo json_encode($result);
