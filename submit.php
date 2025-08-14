<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST['name']);
    $phone   = trim($_POST['phone']);
    $team    = trim($_POST['team']);
    $grade   = trim($_POST['grade']);
    $payment = trim($_POST['payment']);

    // Generate a random 4-char ID
    $id = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 4);

    $stmt = $conn->prepare("INSERT INTO employees (id, name, phone, team, grade, payment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $id, $name, $phone, $team, $grade, $payment);

    if ($stmt->execute()) {
        echo "<h2>Registration Successful!</h2>";
        echo "<p>Your ID: <strong>$id</strong></p>";
        echo "<a href='index.php'>Go Back</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>