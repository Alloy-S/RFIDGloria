<?php
require_once("./conn.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_POST['uid'];

    $stmt = $conn->prepare("SELECT * from tb_entry WHERE id=:id");
    $stmt->execute([":id" => 1]);

    if ($stmt->rowCount() >= 1) {
        $stmt = $conn->prepare("UPDATE tb_entry SET `UID`=:newUID WHERE id=:id");
        $stmt->execute([":newUID" => $uid, ":id" => 1]);
    } else {
        $sql = "INSERT INTO tb_entry (UID) Values ('$uid');";
        $conn->exec($sql);
    }
    
    echo "New record created successfully";
}
