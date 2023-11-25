<?php
include("../conn.php");
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $uid = array("50:b7:e4:a4:","ghjkgfaukgf","coba","d2:8e:50:96:");
    $randomUID = $uid[array_rand($uid)];

    // echo "Randomly chosen UID: $randomUID\n";
    $valid = false;

    date_default_timezone_set('Asia/Jakarta');

    $currentLocalTime = date('H:i:s');
    $time1 = array(date("10:00:00"),date("10:30:00"));
    $time2 = array(date("12:00:00"),date("12:30:00"));
    $time3 = array(date("13:00:00"),date("13:30:00"));
    $time4 = array(date("15:00:00"),date("15:30:00"));
    // echo "Current local time: $currentLocalTime\n";

    $uid = $_POST["uid"];
    $stmt = $conn->prepare("SELECT b.grade from db_kendaraan AS a JOIN murid AS b ON a.id_murid = b.student_id WHERE a.rfid_tag = :id");
    $stmt->execute([":id" => $uid]);
    $kelas = $stmt->fetch();
    $kelas = $kelas[0];
    // echo ($kelas);
    // echo ($currentLocalTime >= $time4[0]);
    $stmt = $conn->prepare("SELECT * FROM history WHERE entry_date BETWEEN concat(current_date(), ' 00:00:00') AND concat(current_date(), ' 23:59:59') AND UID=:uid");
    $stmt->execute([":uid" => $randomUID]);
    if($stmt->rowCount() < 1){
        if($kelas >= 1 && $kelas <= 3){
            if($currentLocalTime >= reset($time2) && $currentLocalTime <= end($time2)){
                $valid = true;
            }
        }else if($kelas >= 4 && $kelas <= 6){
            if($currentLocalTime >= reset($time3) && $currentLocalTime <= end($time3)){
                $valid = true;
            }
        }else if($kelas >= 7 && $kelas <=9){
            if($currentLocalTime >= reset($time4) && $currentLocalTime <= end($time4)){
                $valid = true;
            }
        }else{
            if($currentLocalTime >= reset($time1) && $currentLocalTime <= end($time1)){
                $valid = true;
            }
        }
    }
    if($valid){
        $stmt = $conn->prepare("INSERT INTO `live_view`(`UID`) VALUES (:uid)");
        $stmt->execute([":uid" => $randomUID]);
    }
}
?>