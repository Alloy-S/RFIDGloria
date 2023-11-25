<?php
include("../conn.php");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $data = ["success" => false, "pesan" => ""];
    $jenis = $_POST['jenis'];
    $plat = $_POST['plat'];
    $rfid = $_POST['rfid'];
    $driver = $_POST['driver'];
    $murid = $_POST['murid'];
    $namaFile = $_FILES["foto_mobil"]['name'];
    $errorFile = $_FILES["foto_mobil"]['error'];
    $sizeFile = $_FILES["foto_mobil"]['size'];
    $penyimpananFile = $_FILES["foto_mobil"]['tmp_name'];
    $namaFile = explode(".", $namaFile);
    $allowed_foto = array('jpg', 'jpeg', 'png', 'heic');
    $stmt_cek = $conn->prepare("SELECT * FROM db_kendaraan WHERE rfid_tag = :rfid");
    $stmt_cek->execute([":rfid" => $rfid]);
    // if ($stmt_cek->rowCount() >= 1) {
    //     $data['pesan'] = "RFID sudah terdaftar!!";
    //     die(json_encode($data));
    // }
    $stmt_cek = $conn->prepare("SELECT * FROM db_kendaraan AS A 
    JOIN murid_to_kendaraan AS B ON A.id = B.id_kendaraan 
    WHERE a.plat_mobil = :plat AND B.id_murid = :murid");
    $stmt_cek->execute([":plat" => $plat,":murid"=> $murid]);
    if ($stmt_cek->rowCount() >= 1) {
        $data['pesan'] = "Tidak bisa mendaftarkan kendaraan dengan id murid yang sama";
        die(json_encode($data));
    }
    if ($errorFile === 4) {
        $data['pesan'] = "Foto Mobil harus diisi!!";
        die(json_encode($data));
    }
    if (in_array(strtolower(end($namaFile)), $allowed_foto)) {
        if ($sizeFile > 5_000_000) {
            $data['pesan'] = "Size image maximal 5MB!!";
            die(json_encode($data));
        }
        $namabukti = $plat . "_" . uniqid('', true) . "." . strtolower(end($namaFile));
        $fileDestination = "../upload_foto/" . $namabukti;
        if (!(move_uploaded_file($penyimpananFile, $fileDestination))) {
            $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
            die(json_encode($data));
        }

        $file = uniqid('', true) . "" . ".wav";
        $text = "siswa " . $murid . " Kelas 11A telah di jemput. harap bersiap di lobby utara.";
        $text = str_replace(" ", "+", $text);
        $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
        file_put_contents($file, $current);

        // $stmt = $conn->prepare("INSERT INTO `db_kendaraan`(`jenis_mobil`, `plat_mobil`, `rfid_tag`, `driver`, `foto`, `sound`) VALUES (:jenis,:plat,:rfid,:driver,:foto,:sound)");
        $stmt = $conn->prepare("INSERT INTO `db_kendaraan`(`jenis_mobil`, `plat_mobil`, `rfid_tag`, `driver`, `foto`, `sound`) VALUES (:jenis,:plat,:rfid,:driver,:foto,:sound)");
        $stmt->execute([":jenis" => $jenis, ":plat" => $plat, ":rfid" => $rfid, ":driver" => $driver, ":foto" => $namabukti, ":sound" => $file]);
        $insertId = $conn->lastInsertId();
        $stmt2 = $conn->prepare("INSERT INTO `murid_to_kendaraan`(`id_murid`, `id_kendaraan`) VALUES (:id_murid,:id_kendaraan)");
        $stmt2->execute([":id_murid" => $murid,":id_kendaraan" => $insertId]);
        if ($stmt->rowCount() > 0) {
            // rfid
            $stmt = $conn->prepare("UPDATE tb_entry SET `UID`=:newUID WHERE id=:id");
            $stmt->execute([":newUID" => "", ":id" => 1]);


            $data['pesan'] = "Berhasil mendaftarkan Kendaraan";
            $data['success'] = true;
            die(json_encode($data));
        } else {
            $data['pesan'] = "Maaf ada kesalahan, silahkan tunggu beberapa saat";
            die(json_encode($data));
        }
    } else {
        $data['pesan'] = "Extension file harus berupa 'jpg', 'jpeg', 'png', 'heic' !!!";
        die(json_encode($data));
    }
}
