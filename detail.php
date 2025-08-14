<?php
session_start();

// DB connection
require_once 'db.php'; // Your db.php with $conn = new mysqli(...);

// Handle filters
$name_filter = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
$date_filter = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';
$team_filter = isset($_GET['team']) ? $conn->real_escape_string($_GET['team']) : '';

// Get distinct dates
$dates_result = $conn->query("SELECT DISTINCT DATE(Timestamp) as date FROM employees ORDER BY date ASC");
$dates = [];
while ($row = $dates_result->fetch_assoc()) {
    $dates[] = $row['date'];
}

// Get distinct teams
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
while ($row = $teams_result->fetch_assoc()) {
    $teams[] = $row['team'];
}

// Build query with filters
$sql = "SELECT * FROM employees WHERE 1=1";
if ($name_filter) $sql .= " AND name LIKE '%$name_filter%'";
if ($date_filter) $sql .= " AND DATE(Timestamp) = '$date_filter'";
if ($team_filter) $sql .= " AND team = '$team_filter'";
$sql .= " ORDER BY Timestamp DESC";

$result = $conn->query($sql);

// Calculate total
$total_payment = 0;
$data = [];
while ($row = $result->fetch_assoc()) {
    $total_payment += floatval($row["payment"]);
    $data[] = $row;
}

// Check login
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Details</title>
<style>
    body { font-family: Arial, sans-serif; margin: 0; background: #f4f4f4; }
    .container { display: flex; min-height: 100vh; }
    .sidenav { 
        width: 220px; 
        background: #333; 
        padding: 20px; 
        color: white; 
        box-sizing: border-box; 
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    .sidenav a { display: block; color: white; text-decoration: none; margin: 10px 0; }
    .sidenav a:hover { background: #444; padding-left: 5px; }
    .content { 
        flex: 1; 
        padding: 20px; 
        min-width: 0;
        overflow-x: auto;
    }
    h1 { color: #4CAF50; margin-top: 0; }
    form { display: flex; gap: 10px; flex-wrap: wrap; }
    form input, form select { padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
    form input[type=submit] { background: #4CAF50; color: white; cursor: pointer; }
    form input[type=submit]:hover { background: #45a049; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    th, td { padding: 10px; border: 1px solid #ddd; }
    th { background: #f2f2f2; }
    tr:nth-child(even) { background: #fafafa; }
    tr:hover { background: #f1f1f1; }
    tfoot { font-weight: bold; background: #f2f2f2; }
    .no-records { padding: 20px; text-align: center; background: white; margin-top: 20px; }
</style>
</head>
<body>
<div class="container">
    <?php include 'sidenav.php'; ?>
    <div class="content">
        <h1>Details</h1>
        <form method="GET">
            <input type="text" name="name" placeholder="Filter by Name" value="<?php echo htmlspecialchars($name_filter); ?>">
            <select name="date">
                <option value="">Filter by Date</option>
                <?php foreach ($dates as $date): ?>
                    <option value="<?php echo $date; ?>" <?php if ($date_filter==$date) echo 'selected'; ?>><?php echo $date; ?></option>
                <?php endforeach; ?>
            </select>
            <select name="team">
                <option value="">Filter by Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team; ?>" <?php if ($team_filter==$team) echo 'selected'; ?>><?php echo $team; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Filter">
        </form>
        
        <?php if (count($data) > 0): ?>
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
                <?php foreach ($data as $i => $row): ?>
                <tr>
                    <td><?php echo $i+1; ?></td>
                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                    <td><?php echo htmlspecialchars($row["team"]); ?></td>
                    <td><?php echo htmlspecialchars($row["grade"]); ?></td>
                    <td><?php echo number_format($row["payment"], 2); ?></td>
                    <td><?php echo date("Y-m-d", strtotime($row["Timestamp"])); ?></td>
                    <?php if ($is_logged_in): ?>
                    <td>
                        <a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a> | 
                        <a href="delete.php?id=<?php echo $row["id"]; ?>" style="color:red;">Delete</a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="<?php echo $is_logged_in ? 9 : 8; ?>">Total Payment: <?php echo number_format($total_payment, 2); ?></td>
                </tr>
            </tfoot>
        </table>
        <?php else: ?>
        <div class="no-records">No records found.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>