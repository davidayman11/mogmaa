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

// Handle bulk update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['employees'] as $id => $employee) {
        $name = $conn->real_escape_string($employee['name']);
        $phone = $conn->real_escape_string($employee['phone']);
        $team = $conn->real_escape_string($employee['team']);
        $grade = $conn->real_escape_string($employee['grade']);
        $payment = $conn->real_escape_string($employee['payment']);

        $updateSql = "UPDATE employees SET name='$name', phone='$phone', team='$team', grade='$grade', payment='$payment' WHERE id='$id'";
        $conn->query($updateSql);
    }

    // Redirect to avoid resubmission
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Retrieve data from the database with search filter
$sql = "SELECT * FROM employees";
if ($search) {
    $sql .= " WHERE name LIKE '%$search%' OR phone LIKE '%$search%' OR team LIKE '%$search%'";
}
$result = $conn->query($sql);

// Check if the user is logged in
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <style>
        /* Your existing styles here */
    </style>
</head>
<body>
<div class="demo-page">
  <div class="demo-page-navigation">
    <nav>
      <!-- Your existing navigation code -->
    </nav>
  </div>
  <main class="demo-page-content">
    <section>
      <h1>Employee Details</h1>
      <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
      </form>
      <?php if ($is_logged_in): ?>
      <form method="POST" action="">
      <?php endif; ?>
      <table>
        <thead>
          <tr>
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
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                if ($is_logged_in) {
                    echo "<td><input type='text' name='employees[" . $row["id"] . "][name]' value='" . $row["name"] . "'></td>";
                    echo "<td><input type='text' name='employees[" . $row["id"] . "][phone]' value='" . $row["phone"] . "'></td>";
                    echo "<td><input type='text' name='employees[" . $row["id"] . "][team]' value='" . $row["team"] . "'></td>";
                    echo "<td><input type='text' name='employees[" . $row["id"] . "][grade]' value='" . $row["grade"] . "'></td>";
                    echo "<td><input type='text' name='employees[" . $row["id"] . "][payment]' value='" . $row["payment"] . "'></td>";
                    echo "<td>";
                    echo "<a href='edit.php?id=" . $row["id"] . "' style='padding: 5px 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Edit</a> ";
                    echo "<a href='delete.php?id=" . $row["id"] . "' style='padding: 5px 10px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;'>Delete</a>";
                    echo "</td>";
                } else {
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["phone"] . "</td>";
                    echo "<td>" . $row["team"] . "</td>";
                    echo "<td>" . $row["grade"] . "</td>";
                    echo "<td>" . $row["payment"] . "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='no-records'>No records found</td></tr>";
        }
        ?>
        </tbody>
      </table>
      <?php if ($is_logged_in): ?>
      <input type="submit" name="update" value="Save All" style="margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
      </form>
      <?php endif; ?>
    </section>
  </main>
</div>

</body>
</html>

<?php
$conn->close();
?>
