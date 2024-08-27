<?php
// Hardcoded credentials for admin
$admin_username = "admin";
$admin_password = "password";

// Simulate login (for demonstration purposes)
session_start();
if (!isset($_SESSION['logged_in'])) {
    $_SESSION['logged_in'] = false;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
        $_SESSION['logged_in'] = true;
    }
}

// Logout action
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    $_SESSION['logged_in'] = false;
    header("Location: show.php");
    exit;
}

// Fetch data from the database
$conn = new mysqli('localhost', 'username', 'password', 'mogmaa');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM attendees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Data</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>

<?php if ($_SESSION['logged_in']): ?>
    <h1>Attendee Details</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Team</th>
            <th>Grade</th>
            <th>Payment</th>
            <th>Serial Number</th>
            <?php if ($_SESSION['logged_in']): ?>
            <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['team']; ?></td>
            <td><?php echo $row['grade']; ?></td>
            <td><?php echo $row['payment']; ?></td>
            <td><?php echo $row['serial_number']; ?></td>
            <?php if ($_SESSION['logged_in']): ?>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
            <?php endif; ?>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="show.php?action=logout">Logout</a>
<?php else: ?>
    <h2>Login as Admin</h2>
    <form method="POST" action="show.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
<?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
