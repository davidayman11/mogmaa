<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

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

// Initialize variables
$id = "";
$name = "";
$phone = "";
$team = "";
$grade = "";
$payment = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conn->real_escape_string($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $team = $conn->real_escape_string($_POST['team']);
    $grade = $conn->real_escape_string($_POST['grade']);
    $payment = $conn->real_escape_string($_POST['payment']);

    // Update the record in the database
    $sql = "UPDATE employees SET name='$name', phone='$phone', team='$team', grade='$grade', payment='$payment' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the details page with a success message
        header("Location: index.php?message=Record updated successfully");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    // Check if the ID parameter is set
    if (isset($_GET['id'])) {
        $id = $conn->real_escape_string($_GET['id']);

        // Retrieve the current data of the record
        $sql = "SELECT * FROM employees WHERE id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
            $phone = $row['phone'];
            $team = $row['team'];
            $grade = $row['grade'];
            $payment = $row['payment'];
        } else {
            echo "No record found with ID: " . htmlspecialchars($id);
            exit;
        }
    } else {
        // Redirect back to the details page if no ID is provided
        header("Location: index.php?message=No ID provided");
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .edit-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .edit-container h1 {
            margin-top: 0;
            color: #4CAF50;
        }

        .edit-form {
            display: flex;
            flex-direction: column;
        }

        .edit-form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .edit-form input[type="text"], .edit-form input[type="number"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .edit-form input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        .edit-form input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
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
