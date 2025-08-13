<?php
// Secure Database Connection File

$servername = "193.203.168.53";
$username   = "u968010081_mogamaa";
$password   = "Mogamaa_2000";
$dbname     = "u968010081_mogamaa";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection with detailed error logging
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error, 0);
    die("Database connection error. Please try again later.");
}

// Optional: set character set to UTF-8
$conn->set_charset("utf8mb4");
?>