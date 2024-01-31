<?php 
require "../conn.php";
$stmt = $conn->prepare("UPDATE tb_entry SET `UID`=:newUID WHERE id=:id");
$stmt->execute([":newUID" => "", ":id" => 1]);

?>