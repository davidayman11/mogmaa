<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Add your admin panel logic here

// Example: Display all employees with edit/delete options
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="demo-page">
    <h2>Admin Panel</h2>
    <a href="logout.php">Logout</a>
    <table>
        <!-- Add table with employees data and edit/delete options -->
    </table>
</div>
</body>
</html>
