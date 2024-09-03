<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    die("Unauthorized access.");
}

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the user's information from the database
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM employees WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Here, you can include the code to resend the serial number or code via WhatsApp
    // Example: Send the serial number via WhatsApp using the stored phone number
    $phone = $row['phone'];
    $serial_number = $row['serial_number']; // Assuming you have a serial number field

    // Code to send the serial number via WhatsApp
    // Example:
    $url = "https://api.whatsapp.com/send?phone=" . urlencode($phone) . "&text=" . urlencode("Your serial number is: " . $serial_number);

    // Redirect the user to WhatsApp
    header("Location: $url");
    exit;
} else {
    echo "Record not found.";
}

$conn->close();
?>
