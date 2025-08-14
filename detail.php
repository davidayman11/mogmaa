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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }
        
        .layout {
            display: grid;
            grid-template-columns: 240px 1fr;
            min-height: 100vh;
        }
        
        .main-content {
            padding: 20px;
            overflow: hidden;
        }
        
        h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        .filter-form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 15px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .filter-form input,
        .filter-form select {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .filter-form input[type="submit"] {
            background: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
            padding: 8px 20px;
        }
        
        .filter-form input[type="submit"]:hover {
            background: #45a049;
        }
        
        .table-container {
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        tr:hover {
            background: #e8f5e8;
        }
        
        tfoot tr {
            background: #4CAF50 !important;
            color: white;
            font-weight: bold;
        }
        
        tfoot td {
            border-top: 2px solid #45a049;
        }
        
        .no-records {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #666;
        }
        
        .action-links a {
            color: #007bff;
            text-decoration: none;
            margin-right: 10px;
        }
        
        .action-links a:hover {
            text-decoration: underline;
        }
        
        .action-links a.delete {
            color: #dc3545;
        }
        
        @media (max-width: 768px) {
            .layout {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
            }
            
            .filter-form {
                flex-direction: column;
            }
            
            .filter-form input,
            .filter-form select {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <!-- Include Sidebar -->
        <div class="sidebar">
            <?php include 'sidenav.php'; ?>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <h1>Employee Details</h1>
            
            <!-- Filter Form -->
            <form method="GET" class="filter-form">
                <input type="text" name="name" placeholder="Filter by Name" value="<?php echo htmlspecialchars($name_filter); ?>">
                
                <select name="date">
                    <option value="">Filter by Date</option>
                    <?php foreach ($dates as $date): ?>
                        <option value="<?php echo $date; ?>" <?php if ($date_filter == $date) echo 'selected'; ?>>
                            <?php echo $date; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select name="team">
                    <option value="">Filter by Team</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo $team; ?>" <?php if ($team_filter == $team) echo 'selected'; ?>>
                            <?php echo $team; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <input type="submit" value="Apply Filters">
            </form>
            
            <!-- Data Table or No Records Message -->
            <?php if (count($data) > 0): ?>
                <div class="table-container">
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
                                    <td><?php echo $i + 1; ?></td>
                                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["team"]); ?></td>
                                    <td><?php echo htmlspecialchars($row["grade"]); ?></td>
                                    <td><?php echo number_format($row["payment"], 2); ?></td>
                                    <td><?php echo date("Y-m-d", strtotime($row["Timestamp"])); ?></td>
                                    <?php if ($is_logged_in): ?>
                                        <td class="action-links">
                                            <a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a>
                                            <a href="delete.php?id=<?php echo $row["id"]; ?>" class="delete">Delete</a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="<?php echo $is_logged_in ? 9 : 8; ?>">
                                    Total Payment: <?php echo number_format($total_payment, 2); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-records">
                    <h3>No Records Found</h3>
                    <p>Try adjusting your filters or check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>