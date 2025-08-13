<?php
// Start the session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="demo-page">
    <div class="demo-page-navigation">
        <?php include 'sidebar.php'; ?>
    </div>
    <main class="demo-page-content">
        <?php if (isset($_SESSION['logout_msg'])): ?>
            <div class="logout-message">
                <?php 
                echo $_SESSION['logout_msg']; 
                unset($_SESSION['logout_msg']); // Remove the message after displaying it
                ?>
            </div>
        <?php endif; ?>

