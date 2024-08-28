<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Your page content starts here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <style>
        /* Your existing styles */
    </style>
</head>
<body>
<!-- Page content -->
</body>
</html>
