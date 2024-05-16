<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
        echo json_encode(array('error' => 'This endpoint can only be accessed via AJAX'));
        exit;
    }
    $url = 'http://localhost:8080/rfid_gloria/RFIDGloria/api/getAllSiswa.php';

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);


    if ($response === false) {
        echo json_encode(array('error' => 'Curl error: ' . curl_error($curl)));
    } else {
        $responseData = json_decode($response, true);
        if ($responseData === null) {
            echo json_encode(array('error' => 'Error decoding JSON response'));
        } else {
            header('Content-Type: application/json');
            echo json_encode($responseData);
        }
    }
}
