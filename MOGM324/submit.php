<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Generate a 4-character unique ID
$id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);

// Capture form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$team = $_POST['team'];
$grade = $_POST['grade'];
$payment = $_POST['payment'];

// Insert data into MySQL database
$sql = "INSERT INTO employees (id, name, phone, team, grade, payment)
VALUES ('$id', '$name', '$phone', '$team', '$grade', '$payment')";

if ($conn->query($sql) === TRUE) {
    // Redirect to the QR code generation page
    header("Location: generate_qr.php?id=$id&name=" . urlencode($name) . "&phone=" . urlencode($phone) . "&team=" . urlencode($team) . "&grade=" . urlencode($grade) . "&payment=" . urlencode($payment));
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
