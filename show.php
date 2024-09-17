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
if ($dates_result->num_rows > 0) {
    while ($date_row = $dates_result->fetch_assoc()) {
        $dates[] = $date_row['date'];
    }
}

// Retrieve unique team names for filter options
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
if ($teams_result->num_rows > 0) {
    while ($team_row = $teams_result->fetch_assoc()) {
        $teams[] = $team_row['team'];
    }
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
        $payment = floatval($row["payment"]);
        $total_payment += $payment;
    }
}

// Reset result pointer
$result->data_seek(0);

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
            height: 100vh;
        }

        .demo-page-navigation {
            width: 250px;
            background-color: #333;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
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
            display: flex;
            align-items: center;
        }

        .demo-page-navigation nav ul li a svg {
            margin-right: 10px;
        }

        .demo-page-content {
            flex-grow: 1;
            padding: 40px;
        }

        .demo-page-content h1 {
            margin-top: 0;
            color: #4CAF50;
        }

        .filter-container {
            margin-bottom: 20px;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .form-group {
            flex: 1;
            min-width: 200px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .filter-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .filter-form button:hover {
            background-color: #45a049;
        }

        .total-payment {
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .no-records {
            text-align: center;
            padding: 20px;
            color: #999;
        }

        tfoot tr {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .action-links a {
            padding: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        .action-links a.edit {
            color: #4CAF50;
        }

        .action-links a.delete {
            color: red;
        }

        .action-links a.resend {
            color: blue;
        }
    </style>
</head>
<body>
<div class="demo-page">
    <div class="demo-page-navigation">
        <nav>
            <ul>
                <li>
                    <a href="./index.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                        </svg>
                        MOGAM3'24
                    </a>
                </li>
                <li>
                    <a href="./index.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                            <polygon points="12 2 2 7 12 12 22 7 12 2" />
                            <polyline points="2 17 12 22 22 17" />
                            <polyline points="2 12 12 17 22 12" />
                        </svg>
                        Details
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <main class="demo-page-content">
        <section>
            <h1>Details</h1>
            <div class="filter-container">
                <form class="filter-form" method="GET" action="">
                    <div class="form-group">
                        <label for="name">Filter by Name:</label>
                        <input id="name" type="text" name="name" placeholder="Enter name" value="<?php echo htmlspecialchars($name_filter, ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Filter by Date:</label>
                        <select id="date" name="date">
                            <option value="">Select Date</option>
                            <?php foreach ($dates as $date): ?>
                            <option value="<?php echo htmlspecialchars($date, ENT_QUOTES); ?>" <?php echo ($date_filter == $date) ? 'selected' : ''; ?>>
                                <?php echo date('F j, Y', strtotime($date)); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="team">Filter by Team:</label>
                        <select id="team" name="team">
                            <option value="">Select Team</option>
                            <?php foreach ($teams as $team): ?>
                            <option value="<?php echo htmlspecialchars($team, ENT_QUOTES); ?>" <?php echo ($team_filter == $team) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($team, ENT_QUOTES); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit">Filter</button>
                </form>
                <?php if ($is_logged_in): ?>
                <div class="total-payment">Total Payment: <?php echo number_format($total_payment, 2); ?></div>
                <?php endif; ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Team</th>
                        <th>Grade</th>
                        <th>Payment</th>
                        <th>Timestamp</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["id"], ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($row["name"], ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($row["phone"], ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($row["team"], ENT_QUOTES); ?></td>
                        <td><?php echo htmlspecialchars($row["grade"], ENT_QUOTES); ?></td>
                        <td><?php echo number_format(floatval($row["payment"]), 2); ?></td>
                        <td><?php echo date('F j, Y, g:i a', strtotime($row["timestamp"])); ?></td>
                        <td class="action-links">
                            <a href="edit.php?id=<?php echo urlencode($row['id']); ?>" class="edit">Edit</a> |
                            <a href="delete.php?id=<?php echo urlencode($row['id']); ?>" class="delete">Delete</a> |
                            <a href="resend.php?id=<?php echo urlencode($row['id']); ?>" class="resend">Resend</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="no-records">No records found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <?php if ($result->num_rows > 0): ?>
                <tfoot>
                    <tr>
                        <td colspan="8" class="total-payment">Total Payment: <?php echo number_format($total_payment, 2); ?></td>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </section>
    </main>
</div>
</body>
</html>

<?php
$conn->close();
?>
