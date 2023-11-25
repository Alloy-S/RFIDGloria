<?php
require_once("../conn.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_POST['uid'];

    $kendaraan = $conn->prepare("SELECT * from db_kendaraan WHERE rfid_tag=:rfid_tag");
    $kendaraan->execute([":rfid_tag" => $uid]);

    if ($kendaraan->rowCount() >= 1) {
        $dataKendaraan = $kendaraan->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($dataKendaraan[0]["id_murid"]);
        $murid = $conn->prepare("SELECT * FROM murid WHERE student_id=:student_id");
        $murid->execute([":student_id" => $dataKendaraan[0]["id_murid"]]);

        
        if ($murid->rowCount() >= 1) {
            $dataMurid = $murid->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $conn->prepare("INSERT INTO tmphistory (UID, nama_driver, plat_no, nama_murid) Values (:uid, :nama_driver, :plat_no, :nama_murid);");
            $stmt->execute([":uid" => $uid, ":nama_driver" => $dataKendaraan[0]["driver"], ":plat_no" => $dataKendaraan[0]["plat_mobil"], ":nama_driver" => $dataKendaraan[0]["driver"], ":nama_murid" => $dataMurid[0]["name"]]);
            echo "tap in berhasil ditambahkan";
        } else {
            echo "murid tidak dikenali";
        }
    } else {
        // $sql = "INSERT INTO tb_entry (UID) Values ('$uid');";
        // $conn->exec($sql);
        echo "Tag tidak dikenali";
    }
}
