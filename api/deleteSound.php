<?php
include("../conn.php");
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $id = $_POST["id"];
    $stmt_cek = $conn->prepare("DELETE FROM `sound` WHERE id = :id");
    $stmt_cek->execute([":id" => $id]);
    if ($stmt_cek->rowCount() > 0) {
        echo "success";
        die();
    }
    echo "failed";
}
