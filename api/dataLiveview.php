<?php
include("../conn.php");
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $result = $conn->prepare("SELECT
    db_kendaraan.murid,
    db_kendaraan.jenis_mobil,
    db_kendaraan.plat_mobil,
    IF(history.exit_time IS NULL,
            CASE
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) < 60 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date))), ' second')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) < 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date)) / 60), ' minute')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) >= 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date)) / 3600), ' hour')
                -- WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) >= 86400 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date)) / 86400), ' day')
                ELSE 'Has arrived'
            END, 
            CASE
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) < 60 THEN CONCAT('Already left since ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time))), ' second ago')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) < 3600 THEN CONCAT('Already left since ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time)) / 60), ' minute ago')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) >= 3600 THEN CONCAT('Already left since ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time)) / 3600), ' hour ago')
                -- WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) >= 86400 THEN CONCAT('Already left since ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time)) / 86400), ' day ago')
                ELSE 'Has left' 
            END
    ) AS status
FROM
    history
INNER JOIN
    db_kendaraan ON history.UID = db_kendaraan.rfid_tag
WHERE 
    DATE(history.entry_date) = CURRENT_DATE
ORDER BY
    history.entry_date DESC
LIMIT 10;
;
");
    $result->execute();
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil);
    echo json_encode($result);
}

?>