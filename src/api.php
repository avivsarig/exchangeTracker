<?php
require_once('../config.php');
require('../src/db_conn.php');

// Check if currency and dates are provided
if (isset($_GET['currency']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $currency = $_GET['currency'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    // Choose the table based on currency
    $table_name = $currency . "_rates";

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT time_period, obs_value FROM $table_name WHERE time_period BETWEEN ? AND ? ORDER BY time_period ASC");
    $stmt->bind_param("ss", $start_date, $end_date);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results and encode in JSON
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Return the JSON response
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Invalid parameters']);
}
?>
