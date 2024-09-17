<?php
session_start();

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
$name_filter = isset($_GET['name']) ? '%' . $conn->real_escape_string($_GET['name']) . '%' : '%';
$date_filter = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';
$team_filter = isset($_GET['team']) ? '%' . $conn->real_escape_string($_GET['team']) . '%' : '%';

// Retrieve unique dates and team names for filter options
$dates_result = $conn->query("SELECT DISTINCT DATE(Timestamp) as date FROM employees ORDER BY date DESC");
$dates = $dates_result->fetch_all(MYSQLI_ASSOC);

$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = $teams_result->fetch_all(MYSQLI_ASSOC);

// Prepare SQL query with filters
$sql = "SELECT * FROM employees WHERE name LIKE ? AND DATE(Timestamp) = ? AND team LIKE ? ORDER BY Timestamp ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $name_filter, $date_filter, $team_filter);
$stmt->execute();
$result = $stmt->get_result();

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
        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-form {
            display: flex;
            align-items: center;
        }
        .search-form input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 200px;
        }
        .search-form input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            margin-left: 10px;
        }
        .search-form input[type="submit"]:hover {
            background-color: #45a049;
        }
        .total-payment {
            margin-left: 20px;
            font-size: 16px;
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                            <path d="M2 12l3 3 7-7-3-3-7 7z" />
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <a href="./add.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Add New
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="demo-page-content">
        <h1>Details</h1>
        <form class="search-form" method="get" action="">
            <input type="text" name="name" placeholder="Search by Name" value="<?php echo htmlspecialchars($_GET['name'] ?? '', ENT_QUOTES); ?>">
            <input type="submit" value="Search">
        </form>
        <div class="search-container">
            <form method="get" action="">
                <label for="date">Date:</label>
                <select id="date" name="date">
                    <option value="">All Dates</option>
                    <?php foreach ($dates as $date) : ?>
                        <option value="<?php echo htmlspecialchars($date['date'], ENT_QUOTES); ?>" <?php if ($date_filter == $date['date']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($date['date'], ENT_QUOTES); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="team">Team:</label>
                <select id="team" name="team">
                    <option value="">All Teams</option>
                    <?php foreach ($teams as $team) : ?>
                        <option value="<?php echo htmlspecialchars($team['team'], ENT_QUOTES); ?>" <?php if ($team_filter == '%' . $team['team'] . '%') echo 'selected'; ?>>
                            <?php echo htmlspecialchars($team['team'], ENT_QUOTES); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Filter">
            </form>
            <div class="total-payment">
                Total Payment: <?php echo number_format($total_payment, 2); ?>
            </div>
        </div>
        <?php if ($result->num_rows > 0) : ?>
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
                        <?php if ($is_logged_in) : ?>
                            <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['phone'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['team'], ENT_QUOTES); ?></td>
                            <td><?php echo htmlspecialchars($row['grade'], ENT_QUOTES); ?></td>
                            <td><?php echo number_format($row['payment'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['Timestamp'], ENT_QUOTES); ?></td>
                            <?php if ($is_logged_in) : ?>
                                <td>
                                    <a href="edit.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?>">Edit</a>
                                    <a href="delete.php?id=<?php echo htmlspecialchars($row['id'], ENT_QUOTES); ?>">Delete</a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="<?php echo $is_logged_in ? 8 : 7; ?>">Total Payment: <?php echo number_format($total_payment, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        <?php else : ?>
            <div class="no-records">No records found.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
