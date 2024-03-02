<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = ['success' => false];
    $student_id = $_POST['student_id'];
    $title = $_POST['title_sound'];
    $sound = $_POST['suara'];
    $date = $_POST['date'];
    $file = uniqid('', true) . "" . ".wav";
    $text = $sound;
    $text = str_replace(" ", "+", $text);
    $filename = "../sound/" . $file;
    $current = file_get_contents("https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=" . $text . "&tl=id-ID");
    file_put_contents($filename, $current);
    $stmt = $conn->prepare("INSERT INTO `sound`(`student_id`, `title`, `sound`,`date`) VALUES (:student_id,:title,:sound,:datee)");
    $stmt->execute([":student_id" => $student_id, ":title" => $title, ":sound" => $file, ":datee" => $date]);
    if ($stmt->rowCount() > 0) {
        $data['success'] = true;
    }
    echo json_encode($data);
}
