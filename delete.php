<?php
session_start();

// Check if the user is logged in
if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Include database connection
require_once "db_connect.php";

// Validate `id` parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure it's an integer

    // Prepared statement for secure deletion
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?message=" . urlencode("Record deleted successfully"));
        exit;
    } else {
        header("Location: index.php?message=" . urlencode("Error deleting record"));
        exit;
    }

    $stmt->close();
} else {
    header("Location: index.php?message=" . urlencode("Invalid ID provided"));
    exit;
}

$conn->close();
?>