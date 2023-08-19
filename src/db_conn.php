<?php
require('../src/db_init.php');

$conn->select_db(DB_NAME);

$tables = array(
    'usd_rates' => "CREATE TABLE usd_rates (id INT(11) AUTO_INCREMENT PRIMARY KEY, time_period DATE NOT NULL, obs_value DECIMAL(10, 4) NOT NULL, status VARCHAR(50) NOT NULL)",
    'eur_rates' => "CREATE TABLE eur_rates (id INT(11) AUTO_INCREMENT PRIMARY KEY, time_period DATE NOT NULL, obs_value DECIMAL(10, 4) NOT NULL, status VARCHAR(50) NOT NULL)",
    'gbp_rates' => "CREATE TABLE gbp_rates (id INT(11) AUTO_INCREMENT PRIMARY KEY, time_period DATE NOT NULL, obs_value DECIMAL(10, 4) NOT NULL, status VARCHAR(50) NOT NULL)"
);

foreach ($tables as $tableName => $createTableQuery) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");

    if ($result->num_rows == 0) {
        try {
            if ($conn->query($createTableQuery) !== TRUE) {
                throw new Exception("Error creating table $tableName: " . $conn->error);
            }
        } catch (Exception $e) {
            echo "<script>console.log(" . $e . ")</script>";
        }
    } else {
        $result = $conn->query("SELECT COUNT(*) FROM $tableName");
        $row = $result->fetch_row();
        
        if ($row[0] <= 0) {
            try {
                require_once("../src/fetch.php");
            } catch (Exception $e) {
                echo "<script>console.log(" . $e . ")</script>";
            }
            break;
        } else {
            echo "<script>console.log('Table " . $tableName . " is populated with " . $row[0] . " rows.')</script>";
        }
    }
}
?>
