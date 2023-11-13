<?php
include("../conn.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $limit = 2; 
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;

    $offset = ($page - 1) * $limit;

    // Count total data without limit
    $total_data = $conn->query("SELECT COUNT(*) FROM history
        INNER JOIN db_kendaraan ON history.UID = db_kendaraan.rfid_tag
        WHERE DATE(history.entry_date) = CURRENT_DATE")->fetchColumn();

    $total_pages = ceil($total_data / $limit);

    $result = $conn->prepare("SELECT
        db_kendaraan.murid,
        db_kendaraan.jenis_mobil,
        db_kendaraan.plat_mobil,
        IF(history.exit_time IS NULL,
            CASE
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) < 60 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date))), ' second')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) < 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date)) / 60), ' minute')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date) >= 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.entry_date)) / 3600), ' hour')
                ELSE 'Has arrived'
            END, 
            CASE
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) < 60 THEN CONCAT('Already left since ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time))), ' second ago')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) < 3600 THEN CONCAT('Already left since ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time)) / 60), ' minute ago')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time) >= 3600 THEN CONCAT('Already left since ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(history.exit_time)) / 3600), ' hour ago')
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
        LIMIT $offset, $limit
    ;");

    $result->execute();
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil, "total_pages" => $total_pages);
    echo json_encode($result);
}
?>
