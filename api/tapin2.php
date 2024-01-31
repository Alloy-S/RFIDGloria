<?php 
    $uid = $_POST["uid"];
    $stmt = $conn->prepare("SELECT c.grade,c.student_id from db_kendaraan AS a JOIN murid_to_kendaraan AS b ON a.id = b.id_kendaraan JOIN murid AS c ON b.id_murid = c.student_id WHERE a.rfid_tag = :id");
    $stmt->execute([":id" => $uid]);
    $kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($kelas as $row) {
        $valid = false;
        $grade = $row['grade'];
        if ($grade >= 1 && $grade <= 3) {
            if ($currentLocalTime >= reset($time2) && $currentLocalTime <= end($time2)) {
                $valid = true;
                $murid_id = $row["student_id"];
            }
        } else if ($grade >= 4 && $grade <= 6) {
            if ($currentLocalTime >= reset($time3) && $currentLocalTime <= end($time3)) {
                $valid = true;
                $murid_id = $row["student_id"];
            }
        } else if ($grade >= 7 && $grade <= 9) {
            if ($currentLocalTime >= reset($time4) && $currentLocalTime <= end($time4)) {
                $valid = true;
                $murid_id = $row["student_id"];
            }
        } else {
            if ($currentLocalTime >= reset($time1) && $currentLocalTime <= end($time1)) {
                $valid = true;
                $murid_id = $row["student_id"];
            }
        }
        if ($valid) {
            $stmt = $conn->prepare("INSERT INTO `live_view`(`UID`,`murid_id`) VALUES (:uid,:murid_id)");
            $stmt->execute([":uid" => $randomUID, ":murid_id" => $murid_id]);
        }
    }
?>
