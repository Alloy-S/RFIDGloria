<?php 
require_once("../conn.php");
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_POST['uid'];

    $stmt = $conn->prepare("SELECT * FROM db_kendaraan WHERE rfid_tag=:uid");
    $stmt->execute([":uid" => $uid]);

    if($stmt->rowCount() >= 1) {
        $dataKendaraan = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("SELECT * FROM tmphistory WHERE UID=:uid");
        $stmt->execute([":uid" => $uid]);

        if($stmt->rowCount() >= 1) {
            $tmpHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $toHistory = $conn->prepare("INSERT INTO history (UID, nama_driver, plat_no, jenis_mobil, nama_murid, entry_date) Values (:uid, :nama_driver, :plat_no, :jenis_mobil, :nama_murid, :entry_date);");
            $toHistory->execute([":uid" => $uid, ":nama_driver" => $tmpHistory[0]["nama_driver"], ":plat_no" => $tmpHistory[0]["plat_no"], ":jenis_mobil" => $tmpHistory[0]["jenis_mobil"], ":nama_murid" => $tmpHistory[0]["nama_murid"], ":entry_date" => $tmpHistory[0]["tap_in"]]);
            $stmt = $conn->prepare("DELETE FROM tmphistory WHERE id=:id");
            $stmt->execute([":id" => $tmpHistory[0]['id']]);
            echo "Berhasil tap out";
            return;
        } {
            echo "belum di jemput";
        }
    } else {
        echo "kendaraan tidak ada";
    }
}


// if ($kendaraan->rowCount() >= 1) {
//     $stmt = $conn->prepare("SELECT id, exit_time FROM history WHERE entry_date BETWEEN concat(current_date(), ' 00:00:00') AND concat(current_date(), ' 23:59:59') AND UID=:uid");
//     $stmt->execute([":uid" => $uid]);
//     $dataKendaraan = $kendaraan->fetchAll(PDO::FETCH_ASSOC);

//     $stmt2 = $conn->prepare("SELECT * FROM murid WHERE student_id=:student_id");
//     $stmt2->execute([":student_id", $dataKendaraan[0]["id_murid"]]);
//     $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     if ($stmt->rowCount() >= 1) {
//         $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         if ($hasil[0]["exit_time"] == null) {
//             $stmt = $conn->prepare("UPDATE history SET `exit_time`= NOW() WHERE id=:id;");
//             $stmt->execute([":id" => $hasil[0]["id"]]);
//             echo "History berhasil Diperbarui";
//         } else {
//             echo "mobil sudah datang tadi";
//         }
//     } else {
//         // $data = $stmt->fetch(PDO::FETCH_ASSOC);
//         // $data = $data['id'];
//         $stmt = $conn->prepare("INSERT INTO history (UID, nama_driver, plat_no, nama_murid) Values (:uid, :nama_driver, :plat_no, :nama_murid);");
//         $stmt->execute([":uid" => $uid]);
//         echo "History berhasil ditambahkan";
//     }
// } else {
//     // $sql = "INSERT INTO tb_entry (UID) Values ('$uid');";
//     // $conn->exec($sql);
//     echo "Tag tidak dikenali";
// }
// echo "succes";
?>