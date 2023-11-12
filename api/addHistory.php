<?php
require_once("../conn.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_POST['uid'];

    $stmt = $conn->prepare("SELECT * from db_kendaraan WHERE rfid_tag=:rfid_tag");
    $stmt->execute([":rfid_tag" => $uid]);

    if ($stmt->rowCount() >= 1) {
        $stmt = $conn->prepare("SELECT id, exit_time FROM history WHERE entry_date BETWEEN concat(current_date(), ' 00:00:00') AND concat(current_date(), ' 23:59:59') AND UID=:uid");
        $stmt->execute([":uid" => $uid]);

        if ($stmt->rowCount() >= 1) {
            $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($hasil[0]["exit_time"] == null) {
                $stmt = $conn->prepare("UPDATE history SET `exit_time`= NOW() WHERE id=:id;");
                $stmt->execute([":id" => $hasil[0]["id"]]);
                echo "History berhasil Diperbarui";
            } else {
                echo "mobil sudah datang tadi";
            }
        } else {
            // $data = $stmt->fetch(PDO::FETCH_ASSOC);
            // $data = $data['id'];
            $stmt = $conn->prepare("INSERT INTO history (UID) Values (:uid);");
            $stmt->execute([":uid" => $uid]);
            echo "History berhasil ditambahkan";
        }
    } else {
        // $sql = "INSERT INTO tb_entry (UID) Values ('$uid');";
        // $conn->exec($sql);
        echo "Tag tidak dikenali";
    }
}
