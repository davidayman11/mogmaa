<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Database connection
require_once 'db.php';

// Fetch payment distribution for the pie chart
$paymentData = [];
$sql = "SELECT payment_amount, COUNT(*) AS count FROM payments GROUP BY payment_amount";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $paymentData[] = [
        'amount' => $row['payment_amount'],
        'count' => (int)$row['count']
    ];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .chart-container {
            width: 100%;
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body>
    <?php include 'sidenav.php'; ?>

    <div class="content">
        <h2>Dashboard</h2>

        <!-- Pie Chart -->
        <div class="chart-container">
            <canvas id="paymentPie"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('paymentPie').getContext('2d');
        const paymentData = <?php echo json_encode($paymentData); ?>;

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: paymentData.map(item => item.amount + ' EGP'),
                datasets: [{
                    label: 'Payment Distribution',
                    data: paymentData.map(item => item.count),
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
</body>
</html>