<?php
// Start session
session_start();

// Check if the admin is logged in (implement a login system for better security)

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the employee ID from the URL
$id = $_GET['id'];

// Delete the employee record
$sql = "DELETE FROM employees WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
    header("Location: admin_panel.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>

