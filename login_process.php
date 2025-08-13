<?php
session_start();

// Database connection (not used here, but kept if needed later)
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login credentials from form
$user = trim($_POST['username'] ?? '');
$pass = trim($_POST['password'] ?? '');

// Fixed authentication
if ($user === 'admin' && $pass === 'password') {
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $user;
    header("Location: index.php"); // Redirect to dashboard
    exit();
} else {
    echo "Invalid username or password.";
}

$conn->close();
?>