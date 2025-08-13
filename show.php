<?php
session_start();

// Debug mode (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
require_once 'db_connect.php'; // External DB connection file

// Sanitize and get filters
$name_filter = isset($_GET['name']) ? trim($_GET['name']) : '';
$date_filter = isset($_GET['date']) ? trim($_GET['date']) : '';
$team_filter = isset($_GET['team']) ? trim($_GET['team']) : '';

// Get unique dates
$dates = [];
$date_stmt = $conn->query("SELECT DISTINCT DATE(Timestamp) AS date FROM employees ORDER BY date DESC");
while ($row = $date_stmt->fetch_assoc()) {
    $dates[] = $row['date'];
}

// Get unique teams
$teams = [];
$team_stmt = $conn->query("SELECT DISTINCT team FROM employees ORDER BY team ASC");
while ($row = $team_stmt->fetch_assoc()) {
    $teams[] = $row['team'];
}

// Build query dynamically with prepared statement
$sql = "SELECT * FROM employees WHERE 1=1";
$params = [];
$types = "";

if (!empty($name_filter)) {
    $sql .= " AND name LIKE ?";
    $params[] = "%" . $name_filter . "%";
    $types .= "s";
}

if (!empty($date_filter)) {
    $sql .= " AND DATE(Timestamp) = ?";
    $params[] = $date_filter;
    $types .= "s";
}

if (!empty($team_filter)) {
    $sql .= " AND team LIKE ?";
    $params[] = "%" . $team_filter . "%";
    $types .= "s";
}

$sql .= " ORDER BY Timestamp ASC";

// Prepare statement
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Calculate total payment
$total_payment = 0;
$rows = [];
while ($row = $result->fetch_assoc()) {
    $total_payment += floatval($row['payment']);
    $rows[] = $row;
}

$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- We'll move CSS here later -->
</head>
<body>
<div class="demo-page">
    <?php include 'sidebar.php'; ?>

    <main class="demo-page-content">
        <section>
            <h1>Details</h1>

            <!-- Filters -->
            <form class="filter-form" method="GET">
                <input type="text" name="name" placeholder="Filter by Name" value="<?= htmlspecialchars($name_filter) ?>">
                
                <select name="date">
                    <option value="">Filter by Date</option>
                    <?php foreach ($dates as $date): ?>
                        <option value="<?= htmlspecialchars($date) ?>" <?= $date_filter === $date ? 'selected' : '' ?>>
                            <?= htmlspecialchars($date) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="team">
                    <option value="">Filter by Team</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?= htmlspecialchars($team) ?>" <?= $team_filter === $team ? 'selected' : '' ?>>
                            <?= htmlspecialchars($team) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="submit" value="Filter">
            </form>

            <!-- Results Table -->
            <?php if (count($rows) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Team</th>
                            <th>Grade</th>
                            <th>Payment</th>
                            <th>Date</th>
                            <?php if ($is_logged_in): ?><th>Actions</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['team']) ?></td>
                                <td><?= htmlspecialchars($row['grade']) ?></td>
                                <td><?= number_format((float)$row['payment'], 2) ?></td>
                                <td><?= date("Y-m-d", strtotime($row['Timestamp'])) ?></td>
                                <?php if ($is_logged_in): ?>
                                    <td>
                                        <a class="btn-edit" href="edit.php?id=<?= urlencode($row['id']) ?>">Edit</a> | 
                                        <a class="btn-delete" href="delete.php?id=<?= urlencode($row['id']) ?>" onclick="return confirm('Delete this record?')">Delete</a> | 
                                        <a class="btn-resend" href="resend.php?id=<?= urlencode($row['id']) ?>">Resend Code</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="<?= $is_logged_in ? 9 : 8 ?>">
                                Total Payment: <?= number_format($total_payment, 2) ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <div class="no-records">No records found</div>
            <?php endif; ?>
        </section>
    </main>
</div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>