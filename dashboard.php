<?php
session_start();
require_once 'db.php';

// --- Get teams ---
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
while ($row = $teams_result->fetch_assoc()) {
    $teams[] = $row['team'];
}

// --- Summary ---
$total_scouts_all = $conn->query("SELECT COUNT(*) as c FROM employees")->fetch_assoc()['c'];

// --- Payment distribution ---
$payment_dist = [];
$payment_query = $conn->query("SELECT ROUND(payment,2) as pay, COUNT(*) as count FROM employees GROUP BY pay ORDER BY pay ASC");
while ($row = $payment_query->fetch_assoc()) {
    $payment_dist[$row['pay']] = $row['count'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Scout Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f6f9; margin:0; padding:0; }
        .container { width: 95%; margin:auto; padding:20px; }
        .cards { display:flex; gap:20px; flex-wrap:wrap; margin-bottom:40px; }
        .card { background:white; padding:20px; border-radius:10px; box-shadow:0 4px 15px rgba(0,0,0,0.1); flex:1; min-width:220px; text-align:center; }
        .card h3 { color:#007bff; margin-bottom:10px; }
        .card p { font-size:18px; font-weight:bold; margin:0; }
        .btn { display:inline-block; padding:6px 12px; margin-top:10px; background:#28a745; color:white; text-decoration:none; border-radius:4px; }
        .btn:hover { background:#218838; }
        table { width:100%; border-collapse:collapse; background:white; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
        table th, table td { padding:12px; text-align:center; border-bottom:1px solid #ddd; }
        table th { background:#007bff; color:white; }
        tr:hover { background:#f1f1f1; }
    </style>
</head>
<body>
<div class="container">
    <h1>Scout Dashboard</h1>

    <div class="cards">
        <div class="card">
            <h3>Total Scouts</h3>
            <p><?= $total_scouts_all ?></p>
        </div>
    </div>

    <h2>Team Distribution</h2>
    <div class="cards">
        <?php foreach ($teams as $team): ?>
            <?php
            $count = $conn->query("SELECT COUNT(*) as c FROM employees WHERE team='$team'")->fetch_assoc()['c'];
            ?>
            <div class="card">
                <h3><?= htmlspecialchars($team) ?></h3>
                <p>Total Scouts: <?= $count ?></p>
                <a class="btn" href="team_members.php?team=<?= urlencode($team) ?>">View Members</a>
                <a class="btn" href="dashboard.php?team_export=<?= urlencode($team) ?>">Download CSV</a>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>Payment Distribution</h2>
    <table>
        <thead>
            <tr><th>Payment</th><th>Number of Members</th></tr>
        </thead>
        <tbody>
            <?php foreach ($payment_dist as $amount => $count): ?>
            <tr>
                <td>$<?= number_format($amount,2) ?></td>
                <td><?= $count ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
// CSV export per team
if (isset($_GET['team_export'])) {
    $team_name = $conn->real_escape_string($_GET['team_export']);
    header('Content-Type:text/csv');
    header('Content-Disposition:attachment;filename="'.$team_name.'_members.csv"');
    $output = fopen('php://output', 'w');

    // Get all columns
    $res = $conn->query("SHOW COLUMNS FROM employees");
    $cols = [];
    while($c = $res->fetch_assoc()) $cols[] = $c['Field'];
    fputcsv($output, $cols);

    $members = $conn->query("SELECT * FROM employees WHERE team='$team_name'");
    while($row = $members->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}
?>
</body>
</html>