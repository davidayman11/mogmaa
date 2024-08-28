<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require 'db_connection.php'; // Include the database connection

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid ID.";
    exit();
}

$id = intval($_GET['id']);

$query = "DELETE FROM attendees WHERE id = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Record deleted successfully.";
} else {
    echo "Failed to delete record or record not found.";
}
$stmt->close();
$conn->close();
?>
