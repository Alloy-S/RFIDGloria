<?php
include("../conn.php");
    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $uid = $_POST["uid"];
    $stmt = $conn->prepare("SELECT id,entry_date from live_view WHERE uid=:rfid_tag");
    $stmt->execute([":rfid_tag" => $uid]);
    $result = $stmt->fetch();
    var_dump ($result);

    if ($stmt->rowCount() >= 1) {
        $stmt = $conn->prepare("INSERT INTO history (UID,entry_date,exit_time) Values (:uid,:ed,NOW());");
        $stmt->execute([":uid" => $uid,":ed" => $result["entry_date"]]);
        $stmt = $conn->prepare("DELETE FROM `live_view` WHERE id = :id");
        $stmt->execute(["id" => $result["id"]]);
        echo "History berhasil ditambahkan";
    } else {
        // $sql = "INSERT INTO tb_entry (UID) Values ('$uid');";
        // $conn->exec($sql);
        echo "Tag tidak dikenali";
    }
}
?>