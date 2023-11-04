<?php 
require_once("../conn.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_POST['uid'];

    $stmt = $conn->prepare("SELECT * from db_kendaraan WHERE rfid_tag=:rfid_tag");
    $stmt->execute([":rfid_tag" => $uid]);

    if ($stmt->rowCount() >= 1) {

        
        // $data = $stmt->fetch(PDO::FETCH_ASSOC);
        // $data = $data['id'];
        $stmt = $conn->prepare("INSERT INTO history (UID) Values (:uid);");
        $stmt->execute([":uid" => $uid]);
        echo "History berhasil ditambahkan";
    } else {
        // $sql = "INSERT INTO tb_entry (UID) Values ('$uid');";
        // $conn->exec($sql);
        echo "Tag tidak dikenali";
    }
    
    
}


?>