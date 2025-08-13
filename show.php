<?php
session_start(); // Start the session

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Database connection
include_once("config.php");

// Handle filter parameters
$name_filter = isset($_GET["name"]) ? $conn->real_escape_string($_GET["name"]) : "";
$date_filter = isset($_GET["date"]) ? $conn->real_escape_string($_GET["date"]) : "";
$team_filter = isset($_GET["team"]) ? $conn->real_escape_string($_GET["team"]) : "";


// Retrieve unique dates for filter options
$dates_result = $conn->query("SELECT DISTINCT DATE(Timestamp) as date FROM employees ORDER BY date DESC");
$dates = [];
if ($dates_result->num_rows > 0) {
    while ($date_row = $dates_result->fetch_assoc()) {
        $dates[] = $date_row["date"];
    }
}

// Retrieve unique team names for filter options
$teams_result = $conn->query("SELECT DISTINCT team FROM employees");
$teams = [];
if ($teams_result->num_rows > 0) {
    while ($team_row = $teams_result->fetch_assoc()) {
        $teams[] = $team_row["team"];
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
$is_logged_in = isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;

include_once("includes/header.php");
?>

        <section>
            <h1>Details</h1>
            <div class="filter-container">
                <form class="filter-form" method="GET" action="">
                    <input type="text" name="name" placeholder="Filter by Name" value="<?php echo htmlspecialchars($name_filter); ?>">
                    <select name="date">
                        <option value="">Filter by Date</option>
                        <?php foreach ($dates as $date): ?>
                        <option value="<?php echo htmlspecialchars($date); ?>" <?php echo ($date_filter == $date) ? 'selected' : ''; ?>>
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
            </div>
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
                    <?php if ($is_logged_in): ?>
                    <th>Actions</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php
                $row_number = 1; // Initialize row number
                while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row_number++; ?></td> <!-- Display row number -->
                    <td><?php echo htmlspecialchars($row["id"]); ?></td>
                    <td><?php echo htmlspecialchars($row["name"]); ?></td>
                    <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                    <td><?php echo htmlspecialchars($row["team"]); ?></td>
                    <td><?php echo htmlspecialchars($row["grade"]); ?></td>
                    <td><?php echo number_format((float)$row["payment"], 2); ?></td> <!-- Convert to float before formatting -->
                    <td><?php echo date("Y-m-d", strtotime($row["Timestamp"])); ?></td> <!-- Display Timestamp -->
                    <?php if ($is_logged_in): ?>
                    <td>
                        <a href="edit.php?id=<?php echo htmlspecialchars($row["id"]); ?>" class="action-link edit-link">Edit</a> | 
                        <a href="delete.php?id=<?php echo htmlspecialchars($row["id"]); ?>" class="action-link delete-link">Delete</a> | 
                        <a href="resend.php?id=<?php echo htmlspecialchars($row["id"]); ?>" class="action-link resend-link">Resend Code</a> <!-- Resend Code button -->
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="<?php echo $is_logged_in ? '9' : '8'; ?>">Total Payment: <?php echo number_format($total_payment, 2); ?></td>
                </tr>
                </tfoot>
            </table>
            <?php else: ?>
            <div class="no-records">No records found</div>
            <?php endif; ?>
        </section>

<?php
include_once("includes/footer.php");
$conn->close();
?>

