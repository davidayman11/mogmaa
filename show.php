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

// Handle search and payment filter query
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$payment_filter = isset($_GET['payment_filter']) ? $conn->real_escape_string($_GET['payment_filter']) : '';
$payment_value = isset($_GET['payment_value']) ? (float)$_GET['payment_value'] : '';

// Build the SQL query
$sql = "SELECT * FROM employees WHERE 1=1";
if ($search) {
    $sql .= " AND (name LIKE '%$search%' OR phone LIKE '%$search%' OR team LIKE '%$search%')";
}
if ($payment_filter && $payment_value) {
    $sql .= " AND payment $payment_filter $payment_value";
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
        /* Your existing CSS styles */
        /* ... */
    </style>
</head>
<body>
<div class="demo-page">
    <div class="demo-page-navigation">
        <!-- Navigation content -->
    </div>
    <main class="demo-page-content">
        <section>
            <h1>Details</h1>
            <div class="search-container">
                <form class="search-form" method="GET" action="">
                    <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
                    <select name="payment_filter">
                        <option value="">Filter by Payment</option>
                        <option value="=" <?php echo $payment_filter == '=' ? 'selected' : ''; ?>>Equal to</option>
                        <option value=">" <?php echo $payment_filter == '>' ? 'selected' : ''; ?>>Greater than</option>
                        <option value="<" <?php echo $payment_filter == '<' ? 'selected' : ''; ?>>Less than</option>
                    </select>
                    <input type="number" step="0.01" name="payment_value" placeholder="Payment value" value="<?php echo htmlspecialchars($payment_value); ?>">
                    <input type="submit" value="Filter">
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
                        <th>#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Team</th>
                        <th>Grade</th>
                        <th>Payment</th>
                        <th>Timestamp</th>
                        <?php if ($is_logged_in): ?>
                        <th>Actions</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                $row_number = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row_number . "</td>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["phone"] . "</td>";
                        echo "<td>" . $row["team"] . "</td>";
                        echo "<td>" . $row["grade"] . "</td>";
                        $payment = floatval($row["payment"]);
                        echo "<td>" . number_format($payment, 2) . "</td>";
                        echo "<td>" . $row["Timestamp"] . "</td>";
                        if ($is_logged_in) {
                            echo "<td>";
                            echo "<a href='edit.php?id=" . $row["id"] . "' style='padding: 5px; text-decoration: none; color: #4CAF50;'>Edit</a> | ";
                            echo "<a href='delete.php?id=" . $row["id"] . "' style='padding: 5px; text-decoration: none; color: #f44336;' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
                            echo "</td>";
                        }
                        echo "</tr>";
                        $row_number++;
                    }
                } else {
                    echo "<tr><td colspan='9' class='no-records'>No records found</td></tr>";
                }
                ?>
                </tbody>
                <?php if ($is_logged_in): ?>
                <tfoot>
                  <tr>
                    <td colspan="6">Total Payment:</td>
                    <td><?php echo number_format($total_payment, 2); ?></td>
                    <td></td> <!-- Empty cell for the Timestamp column -->
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
