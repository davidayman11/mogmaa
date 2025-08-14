<?php
session_start();
require_once 'db.php'; // Database connection

// --- Set current page for sidebar ---
$current_page = basename($_SERVER['PHP_SELF']);

// --- Get teams ---
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
while ($row = $teams_result->fetch_assoc()) {
    $teams[] = $row['team'];
}

// --- Summary ---
$team_data = [];
$total_scouts_all = 0;
$total_payment_all = 0;
foreach ($teams as $team) {
    $total_scouts = $conn->query("SELECT COUNT(*) as cnt FROM employees WHERE team='$team'")->fetch_assoc()['cnt'];
    $total_payment = $conn->query("SELECT SUM(payment) as sum_pay FROM employees WHERE team='$team'")->fetch_assoc()['sum_pay'];

    $team_data[$team] = ['total_scouts' => $total_scouts, 'total_payment' => $total_payment];
    $total_scouts_all += $total_scouts;
    $total_payment_all += $total_payment;
}

// --- Payment distribution ---
$payment_dist = [];
$payment_query = $conn->query("SELECT ROUND(payment,2) as pay, COUNT(*) as count FROM employees GROUP BY pay ORDER BY pay ASC");
while ($row = $payment_query->fetch_assoc()) {
    $payment_dist[$row['pay']] = $row['count'];
}

// --- CSV export for all teams ---
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type:text/csv');
    header('Content-Disposition:attachment;filename="team_report.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Team', 'Total Scouts', 'Total Payment']);
    foreach ($team_data as $team => $stats) {
        fputcsv($output, [$team, $stats['total_scouts'], $stats['total_payment']]);
    }
    fclose($output);
    exit();
}

// --- CSV export per team ---
if (isset($_GET['team_export']) && !empty($_GET['team_export'])) {
    $team_name = $conn->real_escape_string($_GET['team_export']);
    header('Content-Type:text/csv');
    header('Content-Disposition:attachment;filename="'.$team_name.'_members.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Name', 'Payment', 'Other Columns...']);
    $members = $conn->query("SELECT name, payment FROM employees WHERE team='$team_name'");
    while ($m = $members->fetch_assoc()) {
        fputcsv($output, [$m['name'], $m['payment']]);
    }
    fclose($output);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scout Dashboard</title>
<style>
body { font-family:"Segoe UI", Arial, sans-serif; margin:0; background:#f4f4f4; color:#333; display:flex; }
.main-content { margin-left:220px; padding:30px; width:100%; }
@media(max-width:768px){ .main-content{ margin-left:60px; } .cards{ flex-direction: column; } }
.cards { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:40px; }
.card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.06); flex:1; min-width:220px; text-align:center; }
.card h3 { margin-bottom:15px; color:#0f766e; }
.card p { font-size:18px; font-weight:bold; margin:8px 0; }
.total-card { background:#1abc9c; color:#fff; border-top:5px solid #16a085; }
.total-card h3, .total-card p { color:#fff; }
.export-btn { background:#0f766e; color:#fff; padding:10px 20px; border:none; border-radius:6px; text-decoration:none; margin-bottom:20px; display:inline-block; }
.export-btn:hover { background:#0d665b; }
.payment-table { width:100%; max-width:500px; margin:0 auto 40px auto; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.05); }
.payment-table th, .payment-table td { padding:10px; text-align:center; border-bottom:1px solid #eee; }
.payment-table th { background:#0f766e; color:#fff; }
.payment-table tr:last-child td { border-bottom:none; }
.card-buttons { margin-top:10px; display:flex; justify-content:center; gap:10px; flex-wrap:wrap; }
.card-buttons a { padding:6px 12px; background:#0f766e; color:#fff; border-radius:6px; text-decoration:none; font-size:14px; }
.card-buttons a:hover { background:#0d665b; }
</style>
</head>
<body>

<?php include 'sidenav.php'; ?>

<div class="main-content">
    <h1>Scout Dashboard</h1>
    <a href="?export=csv" class="export-btn">Export All Teams Report (CSV)</a>

    <div class="cards">
        <div class="card total-card">
            <h3>Total Scouts</h3>
            <p><?php echo $total_scouts_all; ?></p>
        </div>
        <div class="card total-card">
            <h3>Total Payment</h3>
            <p>$<?php echo number_format($total_payment_all, 2); ?></p>
        </div>
    </div>

    <h2>Team Distribution</h2>
    <div class="cards">
        <?php foreach ($team_data as $team => $stats): ?>
        <div class="card" style="border-top:5px solid #<?php echo substr(md5($team),0,6); ?>">
            <h3><?php echo htmlspecialchars($team); ?></h3>
            <p>Total Scouts: <?php echo $stats['total_scouts']; ?></p>
            <p>Total Payment: $<?php echo number_format($stats['total_payment'], 2); ?></p>
            <div class="card-buttons">
                <a href="?team_export=<?php echo urlencode($team); ?>">Download CSV</a>
                <a href="team.php?team=<?php echo urlencode($team); ?>">View Members</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <h2>Payment Distribution</h2>
    <table class="payment-table">
        <thead>
            <tr><th>Payment</th><th>Number of Members</th></tr>
        </thead>
        <tbody>
            <?php foreach ($payment_dist as $amount => $count): ?>
            <tr>
                <td>$<?php echo number_format($amount, 2); ?></td>
                <td><?php echo $count; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>