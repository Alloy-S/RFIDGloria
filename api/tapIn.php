<?php
include("../conn.php");
include("./sendMessage.php");
header('Access-Control-Allow-Origin: *');  
header('Access-Control-Allow-Methods: *'); 
header('Access-Control-Allow-Headers: Content-Type');
// echo $_SERVER["REQUEST_METHOD"]; 
$data = json_decode(file_get_contents("php://input"), true);
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // $uid = array("50:b7:e4:a4:", "ghjkgfaukgf", "coba", "d2:8e:50:96:");
    // $randomUID = $uid[array_rand($uid)];
    // $stmt = $conn->prepare("SELECT * FROM jam_operasional");
    // $stmt->execute();
    // $hasil = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // echo "Randomly chosen UID: $randomUID\n";
    // date_default_timezone_set('Asia/Jakarta');
    // $currentLocalTime = date('H:i:s');
    // $time1 = array($hasil[0]["jam awal"], $hasil[0]["jam akhir"]);
    // $time2 = array($hasil[1]["jam awal"], $hasil[1]["jam akhir"]);
    // $time3 = array($hasil[2]["jam awal"], $hasil[2]["jam akhir"]);
    // $time4 = array($hasil[3]["jam awal"], $hasil[3]["jam akhir"]);
    // echo "Current local time: $currentLocalTime\n";

    $uid = $data["uid"];
    // $uid = "50:b7:e4:a4:";
    $stmt = $conn->prepare("SELECT b.id_murid from db_kendaraan AS a JOIN murid_to_kendaraan AS b ON a.id = b.id_kendaraan WHERE a.rfid_tag = :id");
    $stmt->execute([":id" => $uid]);
    $kelas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($kelas);
    // var_dump($time4);
    // echo ($currentLocalTime);
    // $kelas = $kelas[0];
    // echo (is_array($kelas));
    // var_dump($kelas[0]);
    // echo ($currentLocalTime >= $time4[0]);
    // $stmt = $conn->prepare("SELECT * FROM history WHERE entry_date BETWEEN concat(current_date(), ' 00:00:00') AND concat(current_date(), ' 23:59:59') AND UID=:uid");
    // $stmt->execute([":uid" => $randomUID]);
    // if($stmt->rowCount() < 1){

    $TotalStudent = count($kelas);
    $count = [];
    $data = [];
    foreach ($kelas as $row) {
        $valid = false;
        $murid_id = $row['id_murid'];
        $stmt = $conn->prepare("SELECT * FROM `live_view` WHERE murid_id = :murid_id");
        $stmt->execute([':murid_id' => $murid_id]);
        // echo $stmt->rowCount();
        if ($stmt->rowCount() == 0) {
            $stmt2 = $conn->prepare("SELECT * FROM `history` WHERE student_id = :murid_id AND DATE(tapin_date) = CURDATE()");
            $stmt2->execute([':murid_id' => $murid_id]);
            if ($stmt2->rowCount() == 0) {
                $url = 'http://localhost/RFIDGloria/api/getMurid.php';
                // $url = 'http://localhost:8080/rfid_gloria/RFIDGloria/api/getMurid.php';

                $dataPost = array(
                    'id' => $murid_id
                );
                $curl = curl_init($url);

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($dataPost));

                $response = curl_exec($curl);

                if ($response === false) {
                    echo json_encode(array('error' => 'Curl error: ' . curl_error($curl)));
                } else {

                    $responseData = json_decode($response, true);


                    if ($responseData === null) {
                        echo json_encode(array('error' => 'Error decoding JSON response'));
                    } else {
                        header('Content-Type: application/json');

                        $class = $responseData['class'];
                        $grade = $responseData['grade'];
                        $name = $responseData['name'];
                        $studentRfid = $responseData['rfid_card'];

                        $stmt = $conn->prepare("INSERT INTO `live_view`(`UID`,`murid_id`,`class`,`grade`,`student_name`, `student_rfid`) VALUES (:uid,:murid_id,:class,:grade,:name,:studentRfid)");
                        $stmt->execute([":uid" => $uid, ":murid_id" => $murid_id, ":class" => $class, ":grade" => $grade, ":name" => $name, ":studentRfid" => $studentRfid]);
                        // echo "Success add to table";
                        array_push($count, $murid_id);

                        // echo json_encode(array('class' => $class, 'name' => $name));
                    }
                }
            } else {
                $data["error"] = "Already in history";
            }
        } else {
            $data["error"] = "Already in Table";
        }
    }

    if ($TotalStudent === count($count)) {
        $data["status"] = "ok";
        $data["entry"] = $count;
    }
    echo json_encode($data);
    return;
}
$data["error"] = "HARUS MENGGUNAKAN POST";
echo json_encode($data);
