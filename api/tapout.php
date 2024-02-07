<?php
require_once("../conn.php");
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_POST['uid'];

    $stmt = $conn->prepare("SELECT * FROM murid  WHERE rfid_card=:uid");
    $stmt->execute([":uid" => $uid]);

    if ($stmt->rowCount() >= 1) {
        $dataSiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $studentId = $dataSiswa[0]['student_id'];

        // echo $studentId;
        $stmt = $conn->prepare("SELECT * FROM live_view WHERE murid_id=:studentId");
        $stmt->execute([":studentId" => $studentId]);

        if ($stmt->rowCount() >= 1) {
            $listKendaraan = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $conn->prepare("SELECT b.id,c.student_id, c.name, c.grade, c.class, a.jenis_mobil, a.plat_mobil, a.rfid_tag, a.driver, b.entry_date FROM db_kendaraan AS a JOIN live_view AS b ON a.rfid_tag = b.UID JOIN murid AS c ON b.murid_id = c.student_id WHERE b.id = :id;");
            $stmt->execute([":id" => $listKendaraan[0]['id']]);
            // $tmpHistory = $tmpHistory->fetchAll(PDO::FETCH_ASSOC);
            // echo json_encode($tmpHistory);

            if ($stmt->rowCount() > 0) {
                $tmpHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // echo $tmpHistory[0]["student_id"];
                $toHistory = $conn->prepare("INSERT INTO history (student_id, nama_siswa, grade, class, rfid_tag, plat_mobil, jenis_mobil, driver, tapin_date) Values (:student_id, :nama_siswa, :grade, :class, :rfid_tag, :plat_mobil, :jenis_mobil, :driver, :tapin_date);");
                $toHistory->execute([
                    ":student_id" => $tmpHistory[0]["student_id"],
                    ":nama_siswa" => $tmpHistory[0]["name"],
                    ":grade" => $tmpHistory[0]["grade"],
                    ":class" => $tmpHistory[0]["class"],
                    ":rfid_tag" => $tmpHistory[0]["rfid_tag"],
                    ":plat_mobil" => $tmpHistory[0]["plat_mobil"],
                    ":jenis_mobil" => $tmpHistory[0]["jenis_mobil"],
                    ":driver" => $tmpHistory[0]["driver"],
                    ":tapin_date" => $tmpHistory[0]["entry_date"]
                ]);
                $stmt = $conn->prepare("DELETE FROM live_view WHERE id=:id");
                $stmt->execute([":id" => $tmpHistory[0]['id']]);
                echo "200";
                // echo "delete" . $Kendaraan['id_kendaraan'];
            }



            // echo json_encode($listKendaraan);
            return;
        }
        echo "200";
        return;
    }
    echo "400";
}

