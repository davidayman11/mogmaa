<?php
session_start();
require_once 'db.php'; // Database connection

// --- Get all teams ---
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
while ($row = $teams_result->fetch_assoc()) {
    $teams[] = $row['team'];
}

// --- Summary by team (employees table only) ---
$team_data = [];
foreach ($teams as $team) {
    $total_scouts_team = $conn->query("SELECT COUNT(*) as cnt FROM employees WHERE team='$team'")->fetch_assoc()['cnt'];
    $registered_today_team = $conn->query("SELECT COUNT(*) as cnt FROM employees WHERE team='$team' AND DATE(Timestamp)=CURDATE()")->fetch_assoc()['cnt'];
    $total_payment_team = $conn->query("SELECT SUM(payment) as sum_pay FROM employees WHERE team='$team'")->fetch_assoc()['sum_pay'];

    $team_data[$team] = [
        'total_scouts' => $total_scouts_team,
        'registered_today' => $registered_today_team,
        'total_payment' => $total_payment_team
    ];
}

// --- Registrations trend (last 7 days per team) ---
$dates_array = [];
$registration_chart = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $dates_array[] = $date;
    foreach ($teams as $team) {
        $count = $conn->query("SELECT COUNT(*) as cnt FROM employees WHERE team='$team' AND DATE(Timestamp)='$date'")->fetch_assoc()['cnt'];
        $registration_chart[$team][] = intval($count);
    }
}

// --- Handle Export CSV ---
if(isset($_GET['export']) && $_GET['export'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="team_report.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Team', 'Total Scouts', 'Registered Today', 'Total Payment']);
    foreach($team_data as $team => $stats) {
        fputcsv($output, [$team, $stats['total_scouts'], $stats['registered_today'], $stats['total_payment']]);
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { font-family: "Segoe UI", Arial, sans-serif; margin:0; background:#f4f4f4; color:#333; }
.layout { display: grid; grid-template-columns:220px 1fr; min-height:100vh; }
.main-content { padding: 30px; }
h1 { color:#0f766e; margin-bottom:25px; }
.export-btn { background:#0f766e; color:#fff; padding:10px 20px; border:none; border-radius:6px; text-decoration:none; margin-bottom:20px; display:inline-block; transition:0.3s; }
.export-btn:hover { background:#0d665b; }
.cards { display:flex; flex-wrap:wrap; gap:20px; margin-bottom:40px; }
.card { background:#fff; padding:20px 25px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.06); flex:1; min-width:200px; text-align:center; transition:transform 0.2s, box-shadow 0.2s; }
.card:hover { transform:translateY(-2px); box-shadow:0 12px 25px rgba(0,0,0,0.1); }
.card h3 { margin-bottom:10px; font-size:18px; color:#0f766e; }
.card p { font-size:18px; font-weight:bold; margin:5px 0; }
.chart-container { background:#fff; padding:25px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.06); margin-bottom:40px; }
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
        <a href="?export=csv" class="export-btn">Export Team Report</a>

        <div class="cards">
            <?php foreach($team_data as $team => $stats): ?>
            <div class="card" style="border-top: 5px solid #<?php echo substr(md5($team),0,6); ?>">
                <h3><?php echo htmlspecialchars($team); ?></h3>
                <p>Total Scouts: <?php echo $stats['total_scouts']; ?></p>
                <p>Registered Today: <?php echo $stats['registered_today']; ?></p>
                <p>Total Payment: $<?php echo number_format($stats['total_payment'],2); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="chart-container">
            <canvas id="teamRegistrationChart"></canvas>
        </div>
    </div>
</div>

<script>
const ctx = document.getElementById('teamRegistrationChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates_array); ?>,
        datasets: [
            <?php foreach($registration_chart as $team => $counts): ?>
            {
                label: '<?php echo $team; ?>',
                data: <?php echo json_encode($counts); ?>,
                borderColor: '<?php echo '#' . substr(md5($team),0,6); ?>',
                backgroundColor: 'rgba(0,0,0,0)',
                tension: 0.3,
                pointRadius:5,
                pointHoverRadius:7
            },
            <?php endforeach; ?>
        ]
    },
    options: {
        responsive:true,
        plugins:{ legend:{ position:'top' }, tooltip:{ mode:'index', intersect:false } },
        scales:{ y:{ beginAtZero:true } }
    }
});
</script>
</body>
</html>