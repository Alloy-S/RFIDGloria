<?php
require_once("../conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $query = "SELECT name,grade,class,rfid_card FROM murid WHERE student_id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result);
}
