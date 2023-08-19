<?php
// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PW);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    exit;
}

// Check if database exists
$sql = "SHOW DATABASES LIKE '" . DB_NAME . "'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Select the existing database
    if (!mysqli_select_db($conn, DB_NAME)) {
        error_log("Error selecting existing database: " . $conn->error);
        exit;
    }
    error_log("Database already exists, connected successfully");
} else {
    // Create and select new database
    $sql = "CREATE DATABASE " . DB_NAME;
    if ($conn->query($sql) === TRUE) {
        if (!mysqli_select_db($conn, DB_NAME)) {
            error_log("Error selecting newly created database: " . $conn->error);
            exit;
        }
        error_log("Database created successfully");
    } else {
        error_log("Error creating database: " . $conn->error);
        exit;
    }
}
?>
