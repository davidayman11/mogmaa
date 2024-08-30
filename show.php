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

// Handle search query
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Retrieve data from the database with search filter
$sql = "SELECT * FROM employees ORDER BY Timestamp ASC";
if ($search) {
    $sql .= " WHERE name LIKE '%$search%' OR phone LIKE '%$search%' OR team LIKE '%$search%'";
}
$result = $conn->query($sql);

// Calculate total payment
$total_payment = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Convert payment to a numeric value
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

        .search-form {
            margin-bottom: 20px;
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
      <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
      </form>
      <table>
        <thead>
          <tr>
            <th>#</th> <!-- Row number header -->
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Team</th>
            <th>Grade</th>
            <th>Payment</th>
            <?php if ($is_logged_in): ?>
            <th>Actions</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
        <?php
        $row_number = 1; // Initialize row number
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_number . "</td>"; // Display row number
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["team"] . "</td>";
                echo "<td>" . $row["grade"] . "</td>";
                // Convert payment to a numeric value
                $payment = floatval($row["payment"]);
                echo "<td>" . number_format($payment, 2) . "</td>";
                if ($is_logged_in) {
                    echo "<td>";
                    echo "<a href='edit.php?id=" . $row["id"] . "' style='padding: 5px; text-decoration: none; color: #4CAF50;'>Edit</a>";
                    echo "<a href='delete.php?id=" . $row["id"] . "' style='padding: 5px; text-decoration: none; color: #f44336;'>Delete</a>";
                    echo "</td>";
                }
                echo "</tr>";
                $row_number++; // Increment row number
            }
        } else {
            echo "<tr><td colspan='" . ($is_logged_in ? '8' : '7') . "' class='no-records'>No records found</td></tr>"; // Adjust colspan to include new column
        }
        ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="<?php echo $is_logged_in ? '8' : '7'; ?>">Total Payment: <?php echo number_format($total_payment, 2); ?></td>
          </tr>
        </tfoot>
      </table>
    </section>
  </main>
</div>

</body>
</html>

<?php
$conn->close();
?>
