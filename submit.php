<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "193.203.168.53";
$username   = "u968010081_mogamaa";
$password   = "Mogamaa_2000";
$dbname     = "u968010081_mogamaa";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<div class='notification error'>Connection failed: " . $conn->connect_error . "</div>");
}

// Capture form data safely
$name    = $_POST['name']    ?? '';
$phone   = $_POST['phone']   ?? '';
$team    = $_POST['team']    ?? '';
$grade   = $_POST['grade']   ?? '';
$payment = $_POST['payment'] ?? '';

// Validation
$valid = true;
$error_messages = [];

// Phone must start with +20 and be 13 characters total
if (!preg_match('/^\+20\d{10}$/', $phone)) {
    $valid = false;
    $error_messages[] = "The phone number must start with +20 and be exactly 13 characters long.";
}

// Payment must be numeric
if (!preg_match('/^\d+$/', $payment)) {
    $valid = false;
    $error_messages[] = "The payment must contain only numeric characters.";
}

if (!$valid) {
    echo "<div class='notification error'><ul>";
    foreach ($error_messages as $message) {
        echo "<li>" . htmlspecialchars($message) . "</li>";
    }
    echo "</ul></div>";
} else {
    // Generate unique 4-char ID
    $id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);

    // Insert into employees table
    $stmt = $conn->prepare("INSERT INTO employees (id, name, phone, team, grade, payment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id, $name, $phone, $team, $grade, $payment);

    if ($stmt->execute()) {
        echo "<div class='notification success'>Form submitted successfully! Redirecting...</div>";
        header("Refresh: 2; URL=detail.php");
        exit;
    } else {
        echo "<div class='notification error'>Error: " . htmlspecialchars($stmt->error) . "</div>";
    }
    $stmt->close();
}

$conn->close();
?>

<!-- Minimal styling -->
<style>
    body { font-family: Arial, sans-serif; background: #f4f7f6; margin: 0; padding: 20px; }
    .notification { padding: 15px; margin: 20px 0; border-radius: 5px; }
    .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    ul { padding-left: 20px; }
</style>