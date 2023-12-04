<?php
include("../conn.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $data = ["success" => false, "pesan" => ""];
    $selected_input = $_POST["select_grade"];
    $awal = $_POST["awal"];
    $akhir = $_POST["akhir"];
    if($selected_input == "0"){
        $data["pesan"] = "Kelas tidak valid";
        die(json_encode($data));
    }
    if($awal > $akhir){
        $data["pesan"] = "Jam awal harus lebih kecil dari jam akhir";
        die(json_encode($data));
    }
    $stmt = $conn->prepare("UPDATE `jam_operasional` SET `jam awal`=:jam_awal,`jam akhir`=:jam_akhir WHERE id=:id");
    $stmt->execute([":jam_awal" => $awal,":jam_akhir" => $akhir,":id" => $selected_input]);
    if($stmt->rowCount() > 0){
        $data["pesan"] = "Berhasil mengupdate database";
        $data["success"] = true;
        die(json_encode($data));    
    } 

}
