<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<div style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px; font-family: Arial, sans-serif;'>Connection failed: " . $conn->connect_error . "</div>");
}

// Capture form data
$name = $_POST['name'];
$phone = $_POST['phone'];
$team = $_POST['team'];
$grade = $_POST['grade'];
$payment = $_POST['payment'];

// Initialize validation flag and error messages
$valid = true;
$error_messages = [];

// Validate phone number: must start with +20 and be 13 characters long
if (!preg_match('/^\+20\d{9}$/', $phone)) {
    $valid = false;
    $error_messages[] = "The phone number must start with +20 and be exactly 13 characters long.";
}

// Validate payment: must contain only numeric characters (English numbers)
if (!preg_match('/^\d+$/', $payment)) {
    $valid = false;
    $error_messages[] = "The payment must contain only numeric characters.";
}

// If validation fails, display error messages
if (!$valid) {
    echo "<div style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px; font-family: Arial, sans-serif;'>";
    echo "<ul>";
    foreach ($error_messages as $message) {
        echo "<li>" . htmlspecialchars($message) . "</li>";
    }
    echo "</ul>";
    echo "</div>";
} else {
    // If validation passes, proceed with database insertion

    // Generate a 4-character unique ID
    $id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);

    // Insert data into MySQL database
    $sql = "INSERT INTO employees (id, name, phone, team, grade, payment)
    VALUES ('$id', '$name', '$phone', '$team', '$grade', '$payment')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the QR code generation page
        header("Location: generate_qr.php?id=$id&name=" . urlencode($name) . "&phone=" . urlencode($phone) . "&team=" . urlencode($team) . "&grade=" . urlencode($grade) . "&payment=" . urlencode($payment));
        exit;
    } else {
        echo "<div style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px; font-family: Arial, sans-serif;'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$conn->close();
?>
