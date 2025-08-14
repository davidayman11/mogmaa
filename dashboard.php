<?php
session_start();
require_once 'db.php';

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
        'total_scouts' => $total_scouts_team,
        'total_payment' => $total_payment_team
    ];

    $total_scouts_all += $total_scouts_team;
    $total_payment_all += $total_payment_team;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Scout Dashboard</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { font-family:"Segoe UI", Arial, sans-serif; margin:0; background:#f4f4f4; color:#333; }
.layout { display:grid; grid-template-columns:220px 1fr; min-height:100vh; }
.main-content { padding:30px; }
h1 { color:#0f766e; margin-bottom:25px; }
.cards { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:40px; }
.card { background:#fff; padding:20px 25px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.06); flex:1; min-width:220px; text-align:center; transition:transform 0.2s, box-shadow 0.2s; }
.card:hover { transform:translateY(-2px); box-shadow:0 12px 25px rgba(0,0,0,0.1); }
.card h3 { margin-bottom:15px; font-size:20px; color:#0f766e; }
.card p { font-size:18px; font-weight:bold; margin:8px 0; }
.total-card { background:#1abc9c; color:#fff; border-top:5px solid #16a085; }
.total-card h3, .total-card p { color:#fff; }
.chart-container { background:#fff; padding:25px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.06); margin-bottom:40px; max-width:600px; margin-left:auto; margin-right:auto; }
@media(max-width:768px){ .layout{grid-template-columns:1fr;} .cards{flex-direction:column;} }
</style>
</head>
<body>
<div class="layout">
    <div class="side-nav">
        <?php include 'side_nav.php'; ?>
    </div>
    <div class="main-content">
        <h1>Scout Dashboard</h1>

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
                <p>Total Scouts: <?php echo $stats['total_scouts']; ?></p>
                <p>Total Payment: $<?php echo number_format($stats['total_payment'],2); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Pie Chart -->
        <div class="chart-container">
            <canvas id="teamPieChart"></canvas>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('teamPieChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode(array_keys($team_data)); ?>,
        datasets: [{
            data: <?php echo json_encode(array_map(function($t){ return $t['total_scouts']; }, $team_data)); ?>,
            backgroundColor: <?php echo json_encode(array_map(function($t){ return '#' . substr(md5($t['total_scouts']),0,6); }, $team_data)); ?>,
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive:true,
        plugins: {
            legend: { position: 'bottom' },
            tooltip: { callbacks: {
                label: function(context) {
                    let total = context.dataset.data.reduce((a,b)=>a+b,0);
                    let val = context.raw;
                    let percent = ((val/total)*100).toFixed(1);
                    return context.label + ': ' + val + ' (' + percent + '%)';
                }
            }}
        }
    }
});
</script>
</body>
</html>