<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24</title>
    <style>
        /* Your existing CSS styles */
    </style>
</head>
<body>
<div class="demo-page">
    <div class="demo-page-navigation">
        <nav>
            <ul>
                <li>
                    <a href="./index.php">
                        <!-- Your icon and label for MOGAM3'24 -->
                    </a>
                </li>
                <li>
                    <a href="./show.php">
                        <!-- Your icon and label for Details -->
                    </a>
                </li>
                <li>
                    <a href="./ahaly.php">
                        <!-- Your icon and label for Ahaly -->
                    </a>
                </li>
                <li>
                    <a href="./login.php">
                        <!-- Your icon and label for Admin -->
                    </a>
                </li>
                <li>
                    <a href="./logout.php">
                        <!-- Your icon and label for Logout -->
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <main class="demo-page-content">
        <!-- Page content -->
    </main>
</div>
</body>
</html>
