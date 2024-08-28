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
    die("Connection failed: " . $conn->connect_error);
}

// Get employee ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $team = $conn->real_escape_string($_POST['team']);
    $grade = $conn->real_escape_string($_POST['grade']);
    $payment = $conn->real_escape_string($_POST['payment']);

    $sql = "UPDATE employees SET name='$name', phone='$phone', team='$team', grade='$grade', payment='$payment' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: show.php"); // Redirect to the table view after updating
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Retrieve existing employee data
    $sql = "SELECT * FROM employees WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "Employee not found";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
</head>
<body>
    <h1>Edit Employee</h1>
    <form method="POST" action="">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>"><br>

        <label for="phone">Phone:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>"><br>

        <label for="team">Team:</label><br>
        <input type="text" id="team" name="team" value="<?php echo htmlspecialchars($employee['team']); ?>"><br>

        <label for="grade">Grade:</label><br>
        <input type="text" id="grade" name="grade" value="<?php echo htmlspecialchars($employee['grade']); ?>"><br>

        <label for="payment">Payment:</label><br>
        <input type="text" id="payment" name="payment" value="<?php echo htmlspecialchars($employee['payment']); ?>"><br><br>

        <input type="submit" value="Update">
    </form>
    <a href="show.php">Cancel</a>
</body>
</html>

<?php
$conn->close();
?>
