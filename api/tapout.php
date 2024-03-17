<?php
require_once("../conn.php");
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uid = $_POST['uid'];

    $stmt = $conn->prepare("SELECT * FROM live_view  WHERE student_rfid=:uid");
    $stmt->execute([":uid" => $uid]);

    if ($stmt->rowCount() >= 1) {
        $dataLive = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dataLive = $dataLive[0];

        // echo $studentId;
        // $stmt = $conn->prepare("SELECT * FROM live_view WHERE murid_id=:studentId");
        // $stmt->execute([":studentId" => $studentId]);

            $stmt = $conn->prepare("SELECT b.id, a.jenis_mobil, a.plat_mobil, a.rfid_tag, a.driver, b.entry_date FROM db_kendaraan AS a JOIN live_view AS b ON a.rfid_tag = b.UID WHERE b.id = :id;");
            $stmt->execute([":id" => $dataLive['id']]);
            // $tmpHistory = $tmpHistory->fetchAll(PDO::FETCH_ASSOC);
            // echo json_encode($tmpHistory);

            if ($stmt->rowCount() > 0) {
                $tmpHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // echo $tmpHistory[0]["student_id"];
                $toHistory = $conn->prepare("INSERT INTO history (student_id, nama_siswa, grade, class, rfid_tag, plat_mobil, jenis_mobil, driver, tapin_date) Values (:student_id, :nama_siswa, :grade, :class, :rfid_tag, :plat_mobil, :jenis_mobil, :driver, :tapin_date);");
                $toHistory->execute([
                    ":student_id" => $dataLive["murid_id"],
                    ":nama_siswa" => $dataLive["student_name"],
                    ":grade" => $dataLive["grade"],
                    ":class" => $dataLive["class"],
                    ":rfid_tag" => $dataLive["student_rfid"],
                    ":plat_mobil" => $tmpHistory[0]["plat_mobil"],
                    ":jenis_mobil" => $tmpHistory[0]["jenis_mobil"],
                    ":driver" => $tmpHistory[0]["driver"],
                    ":tapin_date" => $dataLive["entry_date"]
                ]);
                $stmt = $conn->prepare("DELETE FROM live_view WHERE id=:id");
                $stmt->execute([":id" => $tmpHistory[0]['id']]);
                echo "200";
                // echo "delete" . $Kendaraan['id_kendaraan'];
                return;
            }
            echo "404";
            return;
        }
        echo "404";
        return;
    }
    echo "403";