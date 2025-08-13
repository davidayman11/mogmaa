<?php
session_start(); // Start the session

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle filter parameters
$name_filter = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
$date_filter = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';
$team_filter = isset($_GET['team']) ? $conn->real_escape_string($_GET['team']) : '';

// Retrieve unique dates for filter options
$dates_result = $conn->query("SELECT DISTINCT DATE(Timestamp) as date FROM employees ORDER BY date DESC");
$dates = [];
while ($date_row = $dates_result->fetch_assoc()) {
    $dates[] = $date_row['date'];
}

// Retrieve unique team names for filter options
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
while ($team_row = $teams_result->fetch_assoc()) {
    $teams[] = $team_row['team'];
}

// Retrieve data from the database with filters
$sql = "SELECT * FROM employees WHERE 1=1";
if ($name_filter) {
    $sql .= " AND name LIKE '%$name_filter%'";
}
if ($date_filter) {
    $sql .= " AND DATE(Timestamp) = '$date_filter'";
}
if ($team_filter) {
    $sql .= " AND team LIKE '%$team_filter%'";
}
$sql .= " ORDER BY Timestamp ASC";
$result = $conn->query($sql);

// Calculate total payment
$total_payment = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_payment += floatval($row["payment"]);
    }
    $result->data_seek(0); // Reset result pointer
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .demo-page {
            display: flex;
            min-height: 100vh;
        }
        .demo-page-navigation {
            width: 250px;
            background-color: #333;
            padding: 20px;
        }
        .demo-page-navigation nav ul {
            list-style: none;
            padding: 0;
        }
        .demo-page-navigation nav ul li {
            margin-bottom: 20px;
        }
        .demo-page-navigation nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }
        .demo-page-content {
            flex-grow: 1;
            padding: 40px;
        }
        h1 {
            color: #4CAF50;
        }
        .filter-form input, .filter-form select {
            padding: 8px;
            margin-right: 8px;
        }
        .filter-form input[type="submit"] {
            background: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        tbody tr:hover {
            background: #f1f1f1;
        }
        .action-btn {
            padding: 5px 8px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-edit { background: #4CAF50; color: white; }
        .btn-delete { background: #f44336; color: white; }
        .btn-resend { background: #2196F3; color: white; }
    </style>
</head>
<body>
<div class="demo-page">
    <div class="demo-page-navigation">
        <nav>
            <ul>
                <li><a href="./index.php">MOGAM3'24</a></li>
                <li><a href="./index.php">Details</a></li>
            </ul>
        </nav>
    </div>
    <main class="demo-page-content">
        <section>
            <h1>Details</h1>
            <form class="filter-form" method="GET" action="">
                <input type="text" name="name" placeholder="Filter by Name" value="<?php echo htmlspecialchars($name_filter); ?>">
                <select name="date">
                    <option value="">Filter by Date</option>
                    <?php foreach ($dates as $date): ?>
                        <option value="<?php echo $date; ?>" <?php echo ($date_filter == $date) ? 'selected' : ''; ?>>
                            <?php echo date("Y-m-d", strtotime($date)); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="team">
                    <option value="">Filter by Team</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo htmlspecialchars($team); ?>" <?php echo ($team_filter == $team) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($team); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Filter">
            </form>

            <?php if ($result->num_rows > 0): ?>
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
                        <?php
                        $row_number = 1;
                        while ($row = $result->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $row_number++; ?></td>
                            <td><?php echo htmlspecialchars($row["id"]); ?></td>
                            <td><?php echo htmlspecialchars($row["name"]); ?></td>
                            <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                            <td><?php echo htmlspecialchars($row["team"]); ?></td>
                            <td><?php echo htmlspecialchars($row["grade"]); ?></td>
                            <td><?php echo number_format((float)$row["payment"], 2); ?></td>
                            <td><?php echo date("Y-m-d", strtotime($row["Timestamp"])); ?></td>
                            <?php if ($is_logged_in): ?>
                            <td>
                                <a href="edit.php?id=<?php echo $row["id"]; ?>" class="action-btn btn-edit">Edit</a>
                                <a href="delete.php?id=<?php echo $row["id"]; ?>" onclick="return confirm('Are you sure?');" class="action-btn btn-delete">Delete</a>
                                <a href="resend.php?id=<?php echo $row["id"]; ?>" class="action-btn btn-resend">Resend</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="<?php echo $is_logged_in ? '9' : '8'; ?>">
                                Total Payment: <?php echo number_format($total_payment, 2); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <div class="no-records">No records found</div>
            <?php endif; ?>
        </section>
    </main>
</div>
</body>
</html>

<?php
$conn->close();
?>