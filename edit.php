<?php
session_start(); // Start the session

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
    die("Connection failed: " . $conn->connect_error);
}

// Check if an ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    
    // Fetch the record from the database
    $sql = "SELECT * FROM employees WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        die("Record not found.");
    }
} else {
    die("Invalid ID.");
}

// Handle the form submission for updating the record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $team = $conn->real_escape_string($_POST['team']);
    $grade = $conn->real_escape_string($_POST['grade']);
    $payment = $conn->real_escape_string($_POST['payment']);

    $updateSql = "UPDATE employees SET name='$name', phone='$phone', team='$team', grade='$grade', payment='$payment' WHERE id='$id'";
    if ($conn->query($updateSql) === TRUE) {
        header("Location: show.php"); // Redirect to the show page after update
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
        /* Your existing styles */
    </style>
</head>
<body>
<h1>Edit Employee</h1>
<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
    <br>
    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
    <br>
    <label for="team">Team:</label>
    <input type="text" id="team" name="team" value="<?php echo htmlspecialchars($employee['team']); ?>" required>
    <br>
    <label for="grade">Grade:</label>
    <input type="text" id="grade" name="grade" value="<?php echo htmlspecialchars($employee['grade']); ?>" required>
    <br>
    <label for="payment">Payment:</label>
    <input type="text" id="payment" name="payment" value="<?php echo htmlspecialchars($employee['payment']); ?>" required>
    <br>
    <input type="submit" value="Save Changes">
</form>
<a href="show.php">Back to List</a>
</body>
</html>
