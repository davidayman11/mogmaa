<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db_connect.php';

// Check login status
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Filters
$name_filter = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
$date_filter = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';
$team_filter = isset($_GET['team']) ? $conn->real_escape_string($_GET['team']) : '';

// Dates
$dates_result = $conn->query("SELECT DISTINCT DATE(Timestamp) as date FROM employees ORDER BY date DESC");
$dates = [];
while ($date_row = $dates_result->fetch_assoc()) {
    $dates[] = $date_row['date'];
}

// Teams
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
while ($team_row = $teams_result->fetch_assoc()) {
    $teams[] = $team_row['team'];
}

// Query
$sql = "SELECT * FROM employees WHERE 1=1";
if ($name_filter) $sql .= " AND name LIKE '%$name_filter%'";
if ($date_filter) $sql .= " AND DATE(Timestamp) = '$date_filter'";
if ($team_filter) $sql .= " AND team LIKE '%$team_filter%'";
$sql .= " ORDER BY Timestamp ASC";
$result = $conn->query($sql);

// Total Payment
$total_payment = 0;
while ($row = $result->fetch_assoc()) {
    $total_payment += floatval($row["payment"]);
}
$result->data_seek(0); // Reset pointer
?>
<!DOCTYPE html>
<html>
<head>
    <title>Details</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; }
        table { border-collapse: collapse; width: 100%; background: #fff; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f2f2f2; }
        a.action-btn { padding: 5px 8px; border-radius: 4px; color: white; text-decoration: none; }
        a.edit { background: #4CAF50; }
        a.delete { background: red; }
        a.resend { background: blue; }
    </style>
</head>
<body>
<h1>Details</h1>
<form method="GET">
    <input type="text" name="name" placeholder="Filter by Name" value="<?= htmlspecialchars($name_filter) ?>">
    <select name="date">
        <option value="">Filter by Date</option>
        <?php foreach ($dates as $date): ?>
        <option value="<?= htmlspecialchars($date) ?>" <?= ($date_filter == $date) ? 'selected' : '' ?>>
            <?= htmlspecialchars($date) ?>
        </option>
        <?php endforeach; ?>
    </select>
    <select name="team">
        <option value="">Filter by Team</option>
        <?php foreach ($teams as $team): ?>
        <option value="<?= htmlspecialchars($team) ?>" <?= ($team_filter == $team) ? 'selected' : '' ?>>
            <?= htmlspecialchars($team) ?>
        </option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="Filter">
</form>

<?php if ($result->num_rows > 0): ?>
<table>
    <thead>
        <tr>
            <th>#</th><th>ID</th><th>Name</th><th>Phone</th><th>Team</th><th>Grade</th><th>Payment</th><th>Date</th>
            <?php if ($is_logged_in): ?><th>Actions</th><?php endif; ?>
        </tr>
    </thead>
    <tbody>
    <?php $i=1; while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row["id"]) ?></td>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["phone"]) ?></td>
            <td><?= htmlspecialchars($row["team"]) ?></td>
            <td><?= htmlspecialchars($row["grade"]) ?></td>
            <td><?= number_format((float)$row["payment"], 2) ?></td>
            <td><?= date("Y-m-d", strtotime($row["Timestamp"])) ?></td>
            <?php if ($is_logged_in): ?>
            <td>
                <a class="action-btn edit" href="edit.php?id=<?= $row["id"] ?>">Edit</a>
                <a class="action-btn delete" href="delete.php?id=<?= $row["id"] ?>" onclick="return confirm('Delete this record?')">Delete</a>
                <a class="action-btn resend" href="resend.php?id=<?= $row["id"] ?>">Resend</a>
            </td>
            <?php endif; ?>
        </tr>
    <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr><td colspan="<?= $is_logged_in ? 9 : 8 ?>">Total Payment: <?= number_format($total_payment, 2) ?></td></tr>
    </tfoot>
</table>
<?php else: ?>
<p>No records found.</p>
<?php endif; ?>
</body>
</html>
<?php $conn->close(); ?>