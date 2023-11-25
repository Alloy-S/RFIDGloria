<?php 

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
?>