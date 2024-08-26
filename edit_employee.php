<?php
// Start session
session_start();

// Check if the admin is logged in (implement a login system for better security)

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the employee ID from the URL
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update employee record
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $team = $_POST['team'];
    $grade = $_POST['grade'];
    $payment = $_POST['payment'];

    $sql = "UPDATE employees SET name='$name', phone='$phone', team='$team', grade='$grade', payment='$payment' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Fetch the existing record
    $sql = "SELECT * FROM employees WHERE id=$id";
    $result = $conn->query($sql);
    $employee = $result->fetch_assoc();
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
        /* Add similar styling as above */
    </style>
</head>
<body>
<div class="demo-page">
  <h2>Edit Employee</h2>
  <form method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?php echo $employee['name']; ?>" required><br>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" value="<?php echo $employee['phone']; ?>" required><br>

    <label for="team">Team:</label>
    <input type="text" id="team" name="team" value="<?php echo $employee['team']; ?>" required><br>

    <label for="grade">Grade:</label>
    <input type="text" id="grade" name="grade" value="<?php echo $employee['grade']; ?>" required><br>

    <label for="payment">Payment:</label>
    <input type="text" id="payment" name="payment" value="<?php echo $employee['payment']; ?>" required><br>

    <button type="submit">Update</button>
  </form>
</div>
</body>
</html>
