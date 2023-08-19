<?php
require_once('../config.php');
require('./db_conn.php');

$error_message = "";

if (isset($_GET['currency']) && isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $currency = $_GET['currency'];
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];

    // Validate dates
    if ($end_date == '' || $start_date == ''){
        $error_message = 'Please enter both start and end dates';
    } else {
        if ($end_date <= $start_date) {
            $error_message = 'End date must be after start date';
        } else {
            $current_date = date('Y-m-d');
            if ($end_date > $current_date) {
                $error_message = 'End date cannot be in the future';
            }
        }
    }

    if (empty($error_message)) {
        $table_name = $currency . "_rates";

        $stmt = $conn->prepare("SELECT time_period, obs_value FROM $table_name WHERE time_period BETWEEN ? AND ? ORDER BY time_period ASC");
        $stmt->bind_param("ss", $start_date, $end_date);

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        
        $output['data'] = $data;
        $json_content = json_encode($output);

        $file_name = "$currency-$start_date-$end_date.json";
        $file_path = "../output/$file_name";
        
        file_put_contents($file_path, $json_content);

        echo "<p>JSON data saved to $file_name<p>";
    }
}

if (!empty($error_message)) {
    echo "<p>Error: $error_message</p>";
}
?>
