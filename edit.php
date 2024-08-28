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

// Get the employee ID from the URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Retrieve employee details if ID is provided
if ($id) {
    $sql = "SELECT * FROM employees WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit;
    }
} else {
    echo "Invalid ID";
    exit;
}

// Update the employee details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $team = $conn->real_escape_string($_POST['team']);
    $grade = $conn->real_escape_string($_POST['grade']);
    $payment = $conn->real_escape_string($_POST['payment']);

    $sql = "UPDATE employees SET name = '$name', phone = '$phone', team = '$team', grade = '$grade', payment = '$payment' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header("Location: show.php"); // Redirect to show.php after update
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h1>Edit Employee</h1>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required><br>

        <label for="team">Team:</label>
        <input type="text" id="team" name="team" value="<?php echo htmlspecialchars($employee['team']); ?>" required><br>

        <label for="grade">Grade:</label>
        <input type="text" id="grade" name="grade" value="<?php echo htmlspecialchars($employee['grade']); ?>" required><br>

        <label for="payment">Payment:</label>
        <input type="text" id="payment" name="payment" value="<?php echo htmlspecialchars($employee['payment']); ?>" required><br>

        <input type="submit" value="Update">
    </form>
    <a href="show.php">Back to Details</a>
</body>
</html>

<?php
$conn->close();
?>
