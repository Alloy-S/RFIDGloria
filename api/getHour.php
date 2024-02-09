<?php
include("../conn.php");
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $id = $_POST['id'];
    $data = ["awal" => null, "akhir" => null];
    $stmt = $conn->prepare("SELECT * FROM jam_operasional WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $data['awal'] = $result['jam awal'];
    $data['akhir'] = $result['jam akhir'];
    die(json_encode($data));
}
