<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
require 'db_connect.php';

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM employees WHERE id=$id");
$employee = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $team = $conn->real_escape_string($_POST['team']);
    $grade = $conn->real_escape_string($_POST['grade']);
    $payment = floatval($_POST['payment']);

    $conn->query("UPDATE employees SET name='$name', phone='$phone', team='$team', grade='$grade', payment=$payment WHERE id=$id");
    header("Location: details.php");
    exit();
}
?>
<h1>Edit Record</h1>
<form method="POST">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>"><br>
    Phone: <input type="text" name="phone" value="<?= htmlspecialchars($employee['phone']) ?>"><br>
    Team: <input type="text" name="team" value="<?= htmlspecialchars($employee['team']) ?>"><br>
    Grade: <input type="text" name="grade" value="<?= htmlspecialchars($employee['grade']) ?>"><br>
    Payment: <input type="text" name="payment" value="<?= htmlspecialchars($employee['payment']) ?>"><br>
    <button type="submit">Update</button>
</form>