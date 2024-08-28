<?php
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

// Get the employee ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the employee if ID is provided
if ($id) {
    $sql = "DELETE FROM employees WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
        header("Location: show.php"); // Redirect to show.php after deletion
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid ID";
}

$conn->close();
?>
