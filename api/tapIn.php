<?php
include("../conn.php");
include("./sendMessage.php");
// echo $_SERVER["REQUEST_METHOD"]; 
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // $uid = array("50:b7:e4:a4:", "ghjkgfaukgf", "coba", "d2:8e:50:96:");
    // $randomUID = $uid[array_rand($uid)];
    $stmt = $conn->prepare("SELECT * FROM jam_operasional");
    $stmt->execute();
    $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo "Randomly chosen UID: $randomUID\n";
    date_default_timezone_set('Asia/Jakarta');
    $currentLocalTime = date('H:i:s');
    $time1 = array($hasil[0]["jam awal"], $hasil[0]["jam akhir"]);
    $time2 = array($hasil[1]["jam awal"], $hasil[1]["jam akhir"]);
    $time3 = array($hasil[2]["jam awal"], $hasil[2]["jam akhir"]);
    $time4 = array($hasil[3]["jam awal"], $hasil[3]["jam akhir"]);
    // echo "Current local time: $currentLocalTime\n";

    $uid = $_POST["uid"];
    // $uid = "50:b7:e4:a4:";
    $stmt = $conn->prepare("SELECT c.grade,c.student_id from db_kendaraan AS a JOIN murid_to_kendaraan AS b ON a.id = b.id_kendaraan JOIN murid AS c ON b.id_murid = c.student_id WHERE a.rfid_tag = :id");
    $stmt->execute([":id" => $uid]);
    $kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($time4);
    // echo ($currentLocalTime);
    // $kelas = $kelas[0];
    // echo (is_array($kelas));
    // var_dump($kelas[0]);
    // echo ($currentLocalTime >= $time4[0]);
    // $stmt = $conn->prepare("SELECT * FROM history WHERE entry_date BETWEEN concat(current_date(), ' 00:00:00') AND concat(current_date(), ' 23:59:59') AND UID=:uid");
    // $stmt->execute([":uid" => $randomUID]);
    // if($stmt->rowCount() < 1){
    foreach ($kelas as $row) {
        $valid = false;
        $grade = $row['grade'];
        $murid_id = $row['student_id'];
        $stmt = $conn->prepare("SELECT * FROM `live_view` WHERE murid_id = :murid_id");
        $stmt->execute([':murid_id' => $row['student_id']]);
        if ($stmt->rowCount() == 0) {
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
                // echo 'uhuy';
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
                $stmt->execute([":uid" => $uid, ":murid_id" => $murid_id]);
                
                // sendMessage($murid_id, $conn);

            } else {
                echo "$murid_id invalid";
            }
        } else {
            echo "Already in Table";
            return;
        }
        echo "$murid_id ok";
    }
    echo "ok";
    return;
}
echo "HARUS MENGGUNAKAN POST";
