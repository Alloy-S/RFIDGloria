<?php 
require "../conn.php";

$stmt = $conn->prepare("SELECT UID FROM tb_entry WHERE id=1");
$stmt->execute();

$rows = $stmt->fetch(PDO::FETCH_ASSOC);
echo $rows['UID'];
?>