<?php
    // connection_db.php
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "pos_mart";
    //$port = 3306; // Use the correct port (3306 or 3307)

    // Establish database connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);


    if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed. Please contact the administrator.");
}

// Set charset to utf8mb4 for proper encoding
$conn->set_charset("utf8mb4");

    
?>