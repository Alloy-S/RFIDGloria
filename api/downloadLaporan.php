<?php
include("../conn.php");

// Fetch start and end dates from the GET parameters
$start = isset($_GET["start-date"]) ? $_GET["start-date"] : date('Y-m-d');
$end = isset($_GET["end-date"]) ? $_GET["end-date"] : date('Y-m-d');

// Use parameterized query to prevent SQL injection
$query = "SELECT * FROM history WHERE DATE(tapin_date) >= '" . $start . "' AND DATE(tapout_date) <= '" . $end . "'";

// Prepare the query
$result = $conn->prepare($query);

// Execute the query
if ($result->execute()) {
    // Fetch data from the result set
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are rows
    if ($rows) {
        // Set headers for Excel file download
        header('Content-Type: application/vnd.ms-excel; charset=utf-8');
        header('Content-Disposition: attachment; filename="Riwayat_Penjemputan.csv"');

        // Open a file handle for writing to output
        $output = fopen('php://output', 'w');

        // Output Excel column headers
        fputcsv($output, array_keys($rows[0]));

        // Output data rows
        foreach ($rows as $row) {
            fputcsv($output, $row);
        }

        // Close the file handle
        fclose($output);
    } else {
        // Handle the case where no rows are returned
        echo "No data found for the specified date range.";
    }
} else {
    // Handle the case where the query execution failed
    echo "Error executing the query: " . print_r($result->errorInfo(), true);
}

// Close the database connection
$conn = null;
?>
