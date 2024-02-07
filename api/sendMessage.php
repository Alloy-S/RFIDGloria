<?php

function sendMessage($target, $conn)
{
    $token = 'svAo7zEm6PEz-s-yzuxH';
    $stmt = $conn->prepare("SELECT a.name, a.phone, a.grade, a.class, c.plat_mobil, c.driver, c.jenis_mobil  FROM murid AS a JOIN murid_to_kendaraan AS b ON a.student_id = b.id_murid JOIN db_kendaraan AS c ON b.id_kendaraan = c.id WHERE student_id=:murid_id");
    $stmt->execute([":murid_id" => $target]);

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $phone = $result[0]['phone'];
        $name = $result[0]['name'];
        $grade = $result[0]['grade'];
        $class = $result[0]['class'];
        $platMobil = $result[0]['plat_mobil'];
        $driver = $result[0]['driver'];
        $jenisMobil = $result[0]['jenis_mobil'];

        $massage = "_Pesan Otomatis_\nAnda Telah Dijemput\n\n*Data Penjemput:*\nNama: $driver\nPlat Mobil: $platMobil\nJenis Mobil: $jenisMobil\n\nSampai Berjumpa Besok,\nHati-Hati di Jalan";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $phone,
                'message' => $massage,
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            echo $error_msg;
        }
        echo $response;
    }
}
