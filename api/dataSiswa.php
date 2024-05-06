<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // $result = $conn->prepare("SELECT * FROM murid");
    // $result->execute();
    // $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    // $result = array("data" => $hasil);
    // echo json_encode($result);
    $url = 'http://localhost/RFIDGloria/api/getAllSiswa.php';

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);

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

            // echo json_encode(array('class' => $class, 'name' => $name));
        }
    }
}
