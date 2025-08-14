<?php
session_start();
require_once 'db.php';

$current_page = basename($_SERVER['PHP_SELF']);

// --- Get teams ---
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
while ($row = $teams_result->fetch_assoc()) {
    $teams[] = $row['team'];
}

// --- CSV Download ---
if (isset($_GET['download_csv'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=teams.csv');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Team', 'Member Count']);

    foreach ($teams as $team) {
        $count = $conn->query("SELECT COUNT(*) as c FROM employees WHERE team='$team'")->fetch_assoc()['c'];
        fputcsv($output, [$team, $count]);
    }
    fclose($output);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Teams Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 0; }
        .container { width: 90%; margin: auto; padding-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden; }
        table th, table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        table th { background: #007bff; color: white; }
        tr:hover { background: #f1f1f1; }
        .btn { text-decoration: none; padding: 6px 12px; color: white; border-radius: 4px; }
        .btn-view { background: #28a745; }
        .btn-download { background: #17a2b8; float: right; margin-bottom: 10px; }
        h2 { margin: 0; padding: 10px 0; }
    </style>
</head>
<body>
<div class="container">
    <h2>Teams Dashboard</h2>
    <a href="?download_csv=1" class="btn btn-download">Download CSV</a>

    <table>
        <thead>
            <tr>
                <th>Team</th>
                <th>Members</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($teams as $team): ?>
                <?php
                $count = $conn->query("SELECT COUNT(*) as c FROM employees WHERE team='$team'")->fetch_assoc()['c'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($team) ?></td>
                    <td><?= $count ?></td>
                    <td><a class="btn btn-view" href="team_members.php?team=<?= urlencode($team) ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>