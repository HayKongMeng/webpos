<?php
    // connection_db.php
    $host = "db"; // Use the service name from docker-compose.yml
    $dbUsername = "pos_user";
    $dbPassword = "1234";
    $dbName = "pos_mart";

    // Establish database connection
   $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);


    if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed. Please contact the administrator.");
}

// Set charset to utf8mb4 for proper encoding
$conn->set_charset("utf8mb4");

    
?>