<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

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

// Check if the ID parameter is set
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    // SQL query to delete the record
    $sql = "DELETE FROM employees WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the details page with a success message
        header("Location: index.php?message=Record deleted successfully");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Redirect back to the details page if no ID is provided
    header("Location: index.php?message=No ID provided");
    exit;
}

$conn->close();
?>
