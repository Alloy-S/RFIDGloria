<?php 
require_once("./conn.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_POST['uid'];
    
    $sql = "INSERT INTO tb_entry (UID) Values ('$uid');";

    $conn->exec($sql);
    echo "New record created successfully";
}

?>