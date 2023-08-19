<?php
// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PW);

// Check connection
if ($conn->connect_error) {
    echo "<script>console.log('Connection failed: " . $conn->connect_error . "')</script>";
    exit;
}

// Check if database exists
$sql = "SHOW DATABASES LIKE '" . DB_NAME . "'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Select the existing database
    if (!mysqli_select_db($conn, DB_NAME)) {
        echo "<script>console.log('Error selecting existing database: " . $conn->error . "')</script>";
        exit;
    }
    echo "<script>console.log('Database already exists, connected successfully')</script>";
} else {
    // Create and select new database
    $sql = "CREATE DATABASE " . DB_NAME;
    if ($conn->query($sql) === TRUE) {
        if (!mysqli_select_db($conn, DB_NAME)) {
            echo "<script>console.log('Error selecting newly created database: " . $conn->error . "')</script>";
            exit;
        }
        echo "<script>console.log('Database created successfully')</script>";
    } else {
        echo "<script>console.log('Error creating database: " . $conn->error . "')</script>";
        exit;
    }
}
?>
