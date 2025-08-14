<?php
session_start();
require_once 'includes/auth.php'; // for is_admin()
require_once 'db.php'; // your existing DB file ($conn)

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

// Check login (compat with older code using 'logged_in')
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Details</title>
<style>
/* copy your CSS or keep concise */
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:Arial;background:#f4f4f4}
.layout{display:grid;grid-template-columns:240px 1fr;min-height:100vh}
.main-content{padding:20px}
h1{color:#4CAF50;margin-bottom:20px}
.filter-form{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:20px;padding:12px;background:#fff;border-radius:6px}
.filter-form input, .filter-form select{padding:8px;border:1px solid #ccc;border-radius:4px}
.filter-form input[type=submit]{background:#4CAF50;color:#fff;border:0;padding:8px 16px;cursor:pointer}
.table-container{background:#fff;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,.06);overflow:auto}
table{width:100%;border-collapse:collapse}
th,td{padding:12px;border-bottom:1px solid #eee;text-align:left}
th{background:#f8f8f8}
tr:nth-child(even){background:#fbfbfb}
tr:hover{background:#eef7ee}
tfoot td{font-weight:bold;background:#4CAF50;color:#fff;padding:12px}
.action-links a{margin-right:8px;color:#007bff;text-decoration:none}
.action-links a.delete{color:#dc3545}
.no-records{background:#fff;padding:30px;border-radius:6px;text-align:center}
.sidebar { background:#333; color:#fff; padding:20px; }
.sidebar a{color:#fff;display:block;padding:8px 0;text-decoration:none}
.sidebar a:hover{opacity:.9}
</style>
</head>
<body>
<div class="layout">
    <div class="sidebar">
        <?php include 'sidenav.php'; ?>
    </div>

    <div class="main-content">
        <h1>Employee Details</h1>

        <form method="GET" class="filter-form">
            <input type="text" name="name" placeholder="Filter by Name" value="<?php echo htmlspecialchars($name_filter); ?>">
            <select name="date">
                <option value="">Filter by Date</option>
                <?php foreach ($dates as $date): ?>
                    <option value="<?php echo htmlspecialchars($date); ?>" <?php if ($date_filter == $date) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($date); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="team">
                <option value="">Filter by Team</option>
                <?php foreach ($teams as $team): ?>
                    <option value="<?php echo htmlspecialchars($team); ?>" <?php if ($team_filter == $team) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($team); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Apply Filters">
        </form>

        <?php if (count($data) > 0): ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>#</th><th>ID</th><th>Name</th><th>Phone</th><th>Team</th><th>Grade</th><th>Payment</th><th>Date</th>
                            <?php if (is_admin()): ?><th>Actions</th><?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $i => $row): ?>
                            <tr>
                                <td><?php echo $i + 1; ?></td>
                                <td><?php echo htmlspecialchars($row["id"]); ?></td>
                                <td><?php echo htmlspecialchars($row["name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                <td><?php echo htmlspecialchars($row["team"]); ?></td>
                                <td><?php echo htmlspecialchars($row["grade"]); ?></td>
                                <td><?php echo number_format($row["payment"], 2); ?></td>
                                <td><?php echo date("Y-m-d", strtotime($row["Timestamp"])); ?></td>

                                <?php if (is_admin()): ?>
                                <td class="action-links">
                                    <a href="edit.php?id=<?php echo urlencode($row['id']); ?>">Edit</a>
                                    <a href="delete.php?id=<?php echo urlencode($row['id']); ?>" class="delete" onclick="return confirm('Delete this record?')">Delete</a>
                                    <a href="resend.php?id=<?php echo urlencode($row['id']); ?>">Resend</a>
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo is_admin() ? 9 : 8; ?>">Total Payment: <?php echo number_format($total_payment, 2); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <div class="no-records"><h3>No Records Found</h3><p>Try adjusting your filters.</p></div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>