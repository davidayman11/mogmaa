<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require 'db_connection.php'; // Include the database connection

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid ID.";
    exit();
}

$id = intval($_GET['id']);

$query = "SELECT * FROM attendees WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

if (!$record) {
    echo "Record not found.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $team = $_POST['team'];
    $grade = $_POST['grade'];
    $payment = $_POST['payment'];

    $updateQuery = "UPDATE attendees SET name = ?, phone = ?, team = ?, grade = ?, payment = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssssi", $name, $phone, $team, $grade, $payment, $id);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update record.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h1>Edit Record</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="post">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($record['name']); ?>" required /><br>

        <label>Phone:</label>
        <input type="tel" name="phone" value="<?php echo htmlspecialchars($record['phone']); ?>" required /><br>

        <label>Team:</label>
        <select name="team" required>
            <option value="" disabled>Select your team</option>
            <option value="team1" <?php if ($record['team'] == 'team1') echo 'selected'; ?>>bra3em</option>
            <option value="team2" <?php if ($record['team'] == 'team2') echo 'selected'; ?>>ashbal</option>
            <option value="team3" <?php if ($record['team'] == 'team3') echo 'selected'; ?>>zahrat</option>
            <option value="team3" <?php if ($record['team'] == 'team3') echo 'selected'; ?>>kshafa</option>
            <option value="team3" <?php if ($record['team'] == 'team3') echo 'selected'; ?>>morshdat</option>
            <option value="team3" <?php if ($record['team'] == 'team3') echo 'selected'; ?>>motkadem</option>
            <option value="team3" <?php if ($record['team'] == 'team3') echo 'selected'; ?>>ra2edat</option>
            <option value="team3" <?php if ($record['team'] == 'team3') echo 'selected'; ?>>gwala</option>
            <option value="team3" <?php if ($record['team'] == 'team3') echo 'selected'; ?>>kada</option>
        </select><br>

        <label>Grade:</label>
        <input type="text" name="grade" value="<?php echo htmlspecialchars($record['grade']); ?>" required /><br>

        <label>Payment:</label>
        <input type="text" name="payment" value="<?php echo htmlspecialchars($record['payment']); ?>" required /><br>

        <input type="submit" value="Update Record" />
    </form>
</body>
</html>
