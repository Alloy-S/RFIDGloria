<?php
include("../conn.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $limit = 2; 
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $grade = isset($_GET["grade"]) ? $_GET["grade"] : 'all';

    $sd = array("1", "2", "3", "4", "5", "6");
    $smp = array("7", "8", "9");

    $offset = ($page - 1) * $limit;

    if ($grade == 'all') {
        $total_data = $conn->query("SELECT COUNT(*) FROM live_view WHERE DATE(entry_date) = CURRENT_DATE")->fetchColumn();
    } else {
        if ($grade == 'sd') {
            $total_data = $conn->query("SELECT COUNT(*)
            FROM db_kendaraan AS a
            JOIN murid_to_kendaraan AS b
            ON a.id = b.id_kendaraan
            JOIN murid AS c
            ON b.id_murid = c.student_id
            JOIN live_view AS d
            ON a.rfid_tag = d.UID
            WHERE DATE(entry_date) = CURRENT_DATE
            AND (c.grade IN (" . implode(',', $sd) . "))")->fetchColumn();
        } elseif ($grade == 'smp') {
            $total_data = $conn->query("SELECT COUNT(*)
            FROM db_kendaraan AS a
            JOIN murid_to_kendaraan AS b
            ON a.id = b.id_kendaraan
            JOIN murid AS c
            ON b.id_murid = c.student_id
            JOIN live_view AS d
            ON a.rfid_tag = d.UID
            WHERE DATE(entry_date) = CURRENT_DATE
            AND (c.grade IN (" . implode(',', $smp) . "))")->fetchColumn();
        } else {
            $total_data = $conn->query("SELECT COUNT(*)
            FROM db_kendaraan AS a
            JOIN murid_to_kendaraan AS b
            ON a.id = b.id_kendaraan
            JOIN murid AS c
            ON b.id_murid = c.student_id
            JOIN live_view AS d
            ON a.rfid_tag = d.UID
            WHERE DATE(entry_date) = CURRENT_DATE
            AND ((c.grade NOT IN (" . implode(',', $sd) . ")) AND (c.grade NOT IN (" . implode(',', $smp) . ")))")->fetchColumn();
        }
    }

    // Count total data without limit
    //$total_data = $conn->query("SELECT COUNT(*) FROM live_view WHERE entry_date = CURRENT_DATE")->fetchColumn();

    $total_pages = ceil($total_data / $limit);

    if ($grade == 'all') {
        $result = $conn->prepare("SELECT
            c.student_id AS id_murid,
            CONCAT(c.grade,' ',c.class) AS kelas,
            c.name AS murid,
            a.jenis_mobil AS jenis_mobil,
            a.plat_mobil AS plat_mobil,
            (CASE
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 60 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date))), ' second')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 60), ' minute')
                WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 3600), ' hour')
                ELSE 'Has arrived'
            END
            ) AS status
            FROM db_kendaraan AS a
            JOIN murid_to_kendaraan AS b
            ON a.id = b.id_kendaraan
            JOIN murid AS c
            ON b.id_murid = c.student_id
            JOIN live_view AS d
            ON a.rfid_tag = d.UID
            WHERE 
            DATE(d.entry_date) = CURRENT_DATE
            ORDER BY
            d.entry_date DESC
            LIMIT $offset, $limit
        ;");
    } else {
        if ($grade == 'sd') {
            $result = $conn->prepare("SELECT
                c.student_id AS id_murid,
                CONCAT(c.grade,' ',c.class) AS kelas,
                c.name AS murid,
                a.jenis_mobil AS jenis_mobil,
                a.plat_mobil AS plat_mobil,
                (CASE
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 60 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date))), ' second')
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 60), ' minute')
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 3600), ' hour')
                    ELSE 'Has arrived'
                END
                ) AS status
                FROM db_kendaraan AS a
                JOIN murid_to_kendaraan AS b
                ON a.id = b.id_kendaraan
                JOIN murid AS c
                ON b.id_murid = c.student_id
                JOIN live_view AS d
                ON a.rfid_tag = d.UID
                WHERE 
                DATE(d.entry_date) = CURRENT_DATE
                AND (c.grade IN (" . implode(',', $sd) . "))
                ORDER BY
                d.entry_date DESC
                LIMIT $offset, $limit
            ;");
        } elseif ($grade == 'smp') {
            $result = $conn->prepare("SELECT
                c.student_id AS id_murid,
                CONCAT(c.grade,' ',c.class) AS kelas,
                c.name AS murid,
                a.jenis_mobil AS jenis_mobil,
                a.plat_mobil AS plat_mobil,
                (CASE
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 60 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date))), ' second')
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 60), ' minute')
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 3600), ' hour')
                    ELSE 'Has arrived'
                END
                ) AS status
                FROM db_kendaraan AS a
                JOIN murid_to_kendaraan AS b
                ON a.id = b.id_kendaraan
                JOIN murid AS c
                ON b.id_murid = c.student_id
                JOIN live_view AS d
                ON a.rfid_tag = d.UID
                WHERE 
                DATE(d.entry_date) = CURRENT_DATE
                AND (c.grade IN (" . implode(',', $smp) . "))
                ORDER BY
                d.entry_date DESC
                LIMIT $offset, $limit
            ;");
        } else {
            $result = $conn->prepare("SELECT
                c.student_id AS id_murid,
                CONCAT(c.grade,' ',c.class) AS kelas,
                c.name AS murid,
                a.jenis_mobil AS jenis_mobil,
                a.plat_mobil AS plat_mobil,
                (CASE
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 60 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date))), ' second')
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 60), ' minute')
                    WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 3600), ' hour')
                    ELSE 'Has arrived'
                END
                ) AS status
                FROM db_kendaraan AS a
                JOIN murid_to_kendaraan AS b
                ON a.id = b.id_kendaraan
                JOIN murid AS c
                ON b.id_murid = c.student_id
                JOIN live_view AS d
                ON a.rfid_tag = d.UID
                WHERE 
                DATE(d.entry_date) = CURRENT_DATE
                AND ((c.grade NOT IN (" . implode(',', $sd) . ")) AND (c.grade NOT IN (" . implode(',', $smp) . ")))
                ORDER BY
                d.entry_date DESC
                LIMIT $offset, $limit
            ;");
        }
    }

    // $result = $conn->prepare("SELECT
    //     c.student_id AS id_murid,
    //     CONCAT(c.grade,' ',c.class) AS kelas,
    //     c.name AS murid,
    //     a.jenis_mobil AS jenis_mobil,
    //     a.plat_mobil AS plat_mobil,
    //     (CASE
    //         WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 60 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date))), ' second')
    //         WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 60 AND UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) < 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 60), ' minute')
    //         WHEN UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date) >= 3600 THEN CONCAT('Waiting for ', FLOOR((UNIX_TIMESTAMP(CURRENT_TIMESTAMP) - UNIX_TIMESTAMP(d.entry_date)) / 3600), ' hour')
    //         ELSE 'Has arrived'
    //     END
    //     ) AS status
    //     FROM db_kendaraan AS a
    //     JOIN murid_to_kendaraan AS b
    //     ON a.id = b.id_kendaraan
    //     JOIN murid AS c
    //     ON b.id_murid = c.student_id
    //     JOIN live_view AS d
    //     ON a.rfid_tag = d.UID
    //     WHERE 
    //     DATE(d.entry_date) = CURRENT_DATE
    //     ORDER BY
    //     d.entry_date DESC
    //     LIMIT $offset, $limit
    // ;");

    $result->execute();
    $hasil = $result->fetchAll(PDO::FETCH_ASSOC);
    $result = array("data" => $hasil, "total_pages" => $total_pages);
    echo json_encode($result);
}
?>
