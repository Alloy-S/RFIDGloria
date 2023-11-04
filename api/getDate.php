<?php
require "../conn.php";

$result = $conn->prepare("SELECT * FROM history WHERE entry_date BETWEEN concat(current_date(), ' 00:00:00') AND concat(current_date(), ' 23:59:59')");
$result->execute();
$hasil = $result->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($hasil);
