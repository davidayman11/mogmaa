<?php
session_start();

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login credentials from form
$user = $_POST['username'];
$pass = $_POST['password'];

// Simple authentication logic (replace with your own)
if ($user === 'admin' && $pass === 'password') { // Replace with real authentication
    $_SESSION['logged_in'] = true;
    header("Location: index.php"); // Redirect to the main page or dashboard
    exit();
} else {
    echo "Invalid username or password.";
}

$conn->close();
?>
