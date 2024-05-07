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
$notTk = array("1", "2", "3", "4", "5", "6", "7", "8", "9");
$currentDate = date('Y-m-d');
$currentDayName = date("l");

// $result_query = "SELECT murid.sound FROM live_view AS live INNER JOIN sound AS murid ON live.murid_id=murid.student_id";
$result_query = "SELECT murid_id FROM live_view";


if ($grade == 'all') {
    $result_query .= "
        ORDER BY
        entry_date DESC
    ";
} else {
    if ($grade == 'sd') {
        $grades = implode(',', $sd); // Convert array to comma-separated string
        $result_query .= "
            WHERE grade IN ($grades) 
            ORDER BY
            entry_date DESC
        ";
    } elseif ($grade == 'smp') {
        $grades = implode(',', $smp); // Convert array to comma-separated string
        $result_query .= "
            WHERE grade IN ($grades) 
            ORDER BY
            entry_date DESC
        ";
    } else {
        $grades = implode(',', $notTk); // Convert array to comma-separated string
        $result_query .= "
            WHERE grade NOT IN ($grades) 
            ORDER BY
            entry_date DESC
        ";
    }
}

$result_query .= "LIMIT 3;";


$stmt = $conn->prepare($result_query);
$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sound = [];
foreach ($result as $row) {
    // $sound = $row['sound'];
    // $query = "SELECT sound FROM sound WHERE student_id = :student_id AND title <> 'default' AND title <> :current_day AND DATE(date) = :currentDate";
    // $stmt = $conn->prepare($query);
    // $stmt->execute([':student_id' => $row['murid_id'], ':current_day' => $currentDayName, ":currentDate" => $currentDate]);
    // if ($stmt->rowCount() > 0) {
    //     $rowSound = $stmt->fetch(PDO::FETCH_ASSOC);
    //     array_push($sound, $rowSound['sound']);
    // } else {
    //     $query = "SELECT sound FROM sound WHERE student_id = :student_id AND  title = :current_day";
    //     $stmt = $conn->prepare($query);
    //     $stmt->execute([':student_id' => $row['murid_id'], ':current_day' => $currentDayName]);
    //     if ($stmt->rowCount() > 0) {
    //         $rowSound = $stmt->fetch(PDO::FETCH_ASSOC);
    //         array_push($sound, $rowSound['sound']);
    //     } else {
    //         $query = "SELECT sound FROM sound WHERE student_id = :student_id AND  title = 'default'";
    //         $stmt = $conn->prepare($query);
    //         $stmt->execute([':student_id' => $row['murid_id']]);
    //         $rowSound = $stmt->fetch(PDO::FETCH_ASSOC);
    //         array_push($sound, $rowSound['sound']);
    //     }
    // }
    $query = "SELECT 
            CASE 
                WHEN title <> 'default' AND title <> :current_day AND DATE(date) = :currentDate THEN sound 
                WHEN title = :current_day THEN sound 
                ELSE (SELECT sound FROM sound WHERE student_id = :student_id AND title = 'default') 
            END AS sound 
          FROM sound 
          WHERE student_id = :student_id 
          AND (title <> 'default' OR title = :current_day OR title = 'default') 
          ORDER BY 
            CASE 
                WHEN title <> 'default' AND title <> :current_day AND DATE(date) = :currentDate THEN 1 
                WHEN title = :current_day THEN 2 
                ELSE 3 
            END 
          LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':student_id' => $row['murid_id'],
        ':current_day' => $currentDayName,
        ':currentDate' => $currentDate
    ]);

    $rowSound = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($rowSound) {
        array_push($sound, $rowSound['sound']);
    }
}
$data["status"] = "ok";
$data["grade"] = $grade;
$data["sound"] = $sound;
echo json_encode($data);
