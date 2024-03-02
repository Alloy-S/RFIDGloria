<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $result = $conn->prepare("SELECT * FROM sound WHERE student_id = :id");
    $result->execute([":id" => $id]);
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil);
    echo json_encode($result);
}
