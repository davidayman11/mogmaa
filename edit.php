<?php
session_start();

// Check login
if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Include DB connection
require_once "db_connect.php";

// Initialize variables
$id = $name = $phone = $team = $grade = $payment = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id      = intval($_POST['id']);
    $name    = trim($_POST['name']);
    $phone   = trim($_POST['phone']);
    $team    = trim($_POST['team']);
    $grade   = trim($_POST['grade']);
    $payment = trim($_POST['payment']);

    $stmt = $conn->prepare("
        UPDATE employees
        SET name = ?, phone = ?, team = ?, grade = ?, payment = ?
        WHERE id = ?
    ");
    $stmt->bind_param("sssssi", $name, $phone, $team, $grade, $payment, $id);

    if ($stmt->execute()) {
        header("Location: index.php?message=" . urlencode("Record updated successfully"));
        exit;
    } else {
        die("Error updating record: " . $stmt->error);
    }
}

// Handle fetching data for edit form
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT name, phone, team, grade, payment FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($name, $phone, $team, $grade, $payment);
        $stmt->fetch();
    } else {
        die("No record found with ID: " . htmlspecialchars($id));
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    header("Location: index.php?message=" . urlencode("No ID provided"));
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="edit-container">
    <h1>Edit Record</h1>
    <form class="edit-form" method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required>

        <label for="team">Team:</label>
        <input type="text" id="team" name="team" value="<?php echo htmlspecialchars($team); ?>" required>

        <label for="grade">Grade:</label>
        <input type="text" id="grade" name="grade" value="<?php echo htmlspecialchars($grade); ?>" required>

        <label for="payment">Payment:</label>
        <input type="number" id="payment" name="payment" value="<?php echo htmlspecialchars($payment); ?>" required>

        <input type="submit" value="Update">
    </form>
</div>
</body>
</html>