<?php
session_start();
require_once 'db.php';

$team = isset($_GET['team']) ? $conn->real_escape_string($_GET['team']) : '';
if(!$team) die("No team specified.");

// Get all members of the team
$members = $conn->query("SELECT * FROM employees WHERE team='$team'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Team Members - <?= htmlspecialchars($team) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; padding:0; }
        .container { width:95%; margin:auto; padding:20px; }
        table { width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05); margin-top:20px; }
        table th, table td { padding:12px; text-align:center; border-bottom:1px solid #ddd; }
        table th { background:#007bff; color:white; }
        tr:hover { background:#f1f1f1; }
        .btn { display:inline-block; padding:6px 12px; margin-top:10px; background:#17a2b8; color:white; text-decoration:none; border-radius:4px; }
        .btn:hover { background:#138496; }
    </style>
</head>
<body>
<div class="container">
    <h2>Members of <?= htmlspecialchars($team) ?></h2>
    <a class="btn" href="dashboard.php">⬅ Back to Dashboard</a>
    <a class="btn" href="team_members.php?team=<?= urlencode($team) ?>&download_csv=1">Download CSV</a>

    <table>
        <thead>
            <tr>
                <?php
                // show table headers dynamically
                $res = $conn->query("SHOW COLUMNS FROM employees");
                $cols = [];
                while($c = $res->fetch_assoc()) {
                    $cols[] = $c['Field'];
                    echo "<th>".htmlspecialchars($c['Field'])."</th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $members->fetch_assoc()): ?>
            <tr>
                <?php foreach($cols as $col): ?>
                <td><?= htmlspecialchars($row[$col]) ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php
// CSV export for this team
if (isset($_GET['download_csv'])) {
    header('Content-Type:text/csv');
    header('Content-Disposition:attachment;filename="'.$team.'_members.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, $cols);

    $members = $conn->query("SELECT * FROM employees WHERE team='$team'");
    while($row = $members->fetch_assoc()) fputcsv($output, $row);

    fclose($output);
    exit();
}
?>
</body>
</html>