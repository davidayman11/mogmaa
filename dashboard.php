<?php
session_start();
require_once 'db.php';

// --- Set current page for sidebar highlighting ---
$current_page = basename($_SERVER['PHP_SELF']); // For side_nav.php active link

// --- Get all teams ---
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
while ($row = $teams_result->fetch_assoc()) {
    $teams[] = $row['team'];
}

// --- Summary by team ---
$team_data = [];
$total_scouts_all = 0;
$total_payment_all = 0;

foreach ($teams as $team) {
    $total_scouts_team = $conn->query("SELECT COUNT(*) as cnt FROM employees WHERE team='$team'")->fetch_assoc()['cnt'];
    $total_payment_team = $conn->query("SELECT SUM(payment) as sum_pay FROM employees WHERE team='$team'")->fetch_assoc()['sum_pay'];

    $team_data[$team] = [
        'total_scouts' => $total_scouts_team
    ];

    $total_scouts_all += $total_scouts_team;
    $total_payment_all += $total_payment_team;
}

// --- Payment distribution (normalized and grouped) ---
$payment_dist = [];
$payment_query = $conn->query("SELECT ROUND(payment,2) as pay, COUNT(*) as count FROM employees GROUP BY pay ORDER BY pay ASC");
while($row = $payment_query->fetch_assoc()){
    $payment_dist[$row['pay']] = $row['count'];
}

// --- Handle CSV Export ---
if(isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="team_report.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Team','Total Scouts']);
    foreach($team_data as $team => $stats){
        fputcsv($output, [$team,$stats['total_scouts']]);
    }
    fclose($output);
    exit();
}

// --- Include the sidebar at the top ---
include 'side_nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scout Dashboard</title>
<style>
body { font-family:"Segoe UI", Arial, sans-serif; margin:0; background:#f4f4f4; color:#333; }

/* Sidebar container */
.side-nav {
    width: 220px;
    background-color: #2c3e50;
    height: 100vh;
    padding-top: 20px;
    position: fixed;
    transition: width 0.3s;
    z-index: 1000;
}
.side-nav ul { list-style-type: none; padding: 0; margin: 0; }
.side-nav ul li { margin-bottom: 5px; }
.side-nav ul li a {
    color: #ecf0f1;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 12px 20px;
    font-weight: 500;
    border-radius: 6px;
    transition: background 0.3s, padding-left 0.3s;
}
.side-nav ul li a:hover { background-color: #34495e; padding-left: 25px; }
.side-nav ul li a.active { background-color: #1abc9c; color:#fff; }
.side-nav ul li a .icon { margin-right: 10px; font-size: 18px; }
@media (max-width: 768px) {
    .side-nav { width: 60px; padding-top: 10px; }
    .side-nav ul li a { padding: 10px 12px; justify-content: center; }
    .side-nav ul li a .label { display: none; }
    .side-nav ul li a .icon { margin: 0; font-size: 20px; }
}

/* Main content */
.main-content {
    margin-left: 220px; /* Matches sidebar width */
    padding: 30px;
}
@media(max-width:768px){ 
    .main-content { margin-left: 60px; } 
    .cards { flex-direction: column; } 
}

/* Cards */
.cards { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:40px; }
.card { background:#fff; padding:20px 25px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.06); flex:1; min-width:220px; text-align:center; transition:transform 0.2s, box-shadow 0.2s; }
.card:hover { transform:translateY(-2px); box-shadow:0 12px 25px rgba(0,0,0,0.1); }
.card h3 { margin-bottom:15px; font-size:20px; color:#0f766e; }
.card p { font-size:18px; font-weight:bold; margin:8px 0; }
.total-card { background:#1abc9c; color:#fff; border-top:5px solid #16a085; }
.total-card h3, .total-card p { color:#fff; }

/* Export button */
.export-btn { background:#0f766e; color:#fff; padding:10px 20px; border:none; border-radius:6px; text-decoration:none; margin-bottom:20px; display:inline-block; transition:0.3s; }
.export-btn:hover { background:#0d665b; }

/* Payment table */
.payment-table { width:100%; max-width:500px; margin:0 auto 40px auto; border-collapse:collapse; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.05); }
.payment-table th, .payment-table td { padding:10px; text-align:center; border-bottom:1px solid #eee; }
.payment-table th { background:#0f766e; color:#fff; }
.payment-table tr:last-child td { border-bottom:none; }
</style>
</head>
<body>
    <div class="main-content">
        <h1>Scout Dashboard</h1>
        <a href="?export=csv" class="export-btn">Export Team Report</a>

        <div class="cards">
            <!-- Total Summary Cards -->
            <div class="card total-card">
                <h3>Total Scouts</h3>
                <p><?php echo $total_scouts_all; ?></p>
            </div>
            <div class="card total-card">
                <h3>Total Payment</h3>
                <p>$<?php echo number_format($total_payment_all,2); ?></p>
            </div>
        </div>

        <div class="cards">
            <!-- Team Cards -->
            <?php foreach($team_data as $team => $stats): ?>
            <div class="card" style="border-top:5px solid #<?php echo substr(md5($team),0,6); ?>">
                <h3><?php echo htmlspecialchars($team); ?></h3>
                <p>Total: <?php echo $stats['total_scouts']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Payment Distribution Table -->
        <div class="cards">
            <div class="card" style="flex:1 1 100%;">
                <h3 style="text-align:center; margin-bottom:15px;">Payment Distribution</h3>
                <table class="payment-table">
                    <thead>
                        <tr>
                            <th>Payment</th>
                            <th>Number of Members</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($payment_dist as $amount => $count): ?>
                        <tr>
                            <td>$<?php echo number_format($amount,2); ?></td>
                            <td><?php echo $count; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>