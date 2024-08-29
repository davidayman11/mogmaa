<?php
session_start(); // Start the session

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    
    // Delete the record from the database
    $deleteSql = "DELETE FROM employees WHERE id = '$id'";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: show.php"); // Redirect to the show page after deletion
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    die("Invalid ID.");
}

$conn->close();
?>
