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

// Handle search query
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Handle sorting
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'Timestamp'; // Default sorting by Timestamp
$sort_order = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'asc' : 'desc'; // Default sorting order is descending

// Retrieve data from the database with search filter and sorting
$sql = "SELECT * FROM employees";
if ($search) {
    $sql .= " WHERE name LIKE '%$search%' OR phone LIKE '%$search%' OR team LIKE '%$search%' OR Timestamp LIKE '%$search%'";
}
$sql .= " ORDER BY $sort_column $sort_order";
$result = $conn->query($sql);

// Toggle sort order
$next_order = ($sort_order == 'asc') ? 'desc' : 'asc';

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
        /* Existing CSS styles */
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

        .action-btn {
            padding: 5px;
            text-decoration: none;
            border-radius: 5px;
        }

        .edit-btn {
            color: #fff;
            background-color: #4CAF50;
        }

        .delete-btn {
            color: #fff;
            background-color: red;
        }

        .resend-btn {
            color: #fff;
            background-color: blue;
        }

        .filter-input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 10px;
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
            MOGAM3'24</a>
        </li>
        <li>
        <a href="./index.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
              <polygon points="12 2 2 7 12 12 22 7 12 2" />
              <polyline points="2 17 12 22 22 17" />
              <polyline points="2 12 12 17 22 12" />
            </svg>
             Details</a>
        </li>
      </ul>
    </nav>
  </div>
  <main class="demo-page-content">
    <section>
      <h1>Details</h1>
      <div class="search-container">
        <form class="search-form" method="GET" action="">
          <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
          <input type="submit" value="Search">
        </form>
        <?php if ($is_logged_in): ?>
        <div class="total-payment">
          Total Payment: <?php echo number_format($total_payment, 2); ?>
        </div>
        <?php endif; ?>
      </div>
      <table>
        <thead>
          <tr>
            <th>#</th> <!-- Row number header -->
            <th><a href="?sort=id&order=<?php echo $next_order; ?>">ID</a></th>
            <th><a href="?sort=name&order=<?php echo $next_order; ?>">Name</a></th>
            <th><a href="?sort=phone&order=<?php echo $next_order; ?>">Phone</a></th>
            <th><a href="?sort=team&order=<?php echo $next_order; ?>">Team</a></th>
            <th><a href="?sort=grade&order=<?php echo $next_order; ?>">Grade</a></th>
            <th><a href="?sort=payment&order=<?php echo $next_order; ?>">Payment</a></th>
            <th><a href="?sort=Timestamp&order=<?php echo $next_order; ?>">Timestamp</a></th>
            <?php if ($is_logged_in): ?>
            <th>Actions</th>
            <?php endif; ?>
          </tr>
          <tr>
            <!-- Filter inputs for each column -->
            <td></td> <!-- Empty cell for row number -->
            <td><input type="text" class="filter-input" placeholder="Filter ID"></td>
            <td><input type="text" class="filter-input" placeholder="Filter Name"></td>
            <td><input type="text" class="filter-input" placeholder="Filter Phone"></td>
            <td><input type="text" class="filter-input" placeholder="Filter Team"></td>
            <td><input type="text" class="filter-input" placeholder="Filter Grade"></td>
            <td><input type="text" class="filter-input" placeholder="Filter Payment"></td>
            <td><input type="text" class="filter-input" placeholder="Filter Timestamp"></td>
            <td></td> <!-- Empty cell for actions -->
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
          <?php $row_number = 1; ?>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row_number++; ?></td>
            <td><?php echo $row["id"]; ?></td>
            <td><?php echo htmlspecialchars($row["name"]); ?></td>
            <td><?php echo htmlspecialchars($row["phone"]); ?></td>
            <td><?php echo htmlspecialchars($row["team"]); ?></td>
            <td><?php echo htmlspecialchars($row["grade"]); ?></td>
            <td><?php echo number_format($row["payment"], 2); ?></td>
            <td><?php echo htmlspecialchars($row["Timestamp"]); ?></td>
            <?php if ($is_logged_in): ?>
            <td>
              <a href="edit.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
              <a href="delete.php?id=<?php echo $row['id']; ?>" class="action-btn delete-btn">Delete</a>
              <a href="resend.php?id=<?php echo $row['id']; ?>" class="action-btn resend-btn">Resend</a>
            </td>
            <?php endif; ?>
          </tr>
          <?php endwhile; ?>
          <?php else: ?>
          <tr>
            <td colspan="9" class="no-records">No records found</td>
          </tr>
          <?php endif; ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="6">Total Payment</td>
            <td colspan="3"><?php echo number_format($total_payment, 2); ?></td>
          </tr>
        </tfoot>
      </table>
    </section>
  </main>
</div>
</body>
</html>
