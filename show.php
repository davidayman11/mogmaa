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

// Construct the SQL query with search and order by the last added entries
$sql = "SELECT * FROM employees WHERE 
        (name LIKE '%$search%' OR phone LIKE '%$search%' OR team LIKE '%$search%')
        ORDER BY id DESC";

$result = $conn->query($sql);

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
        /* Your CSS styles here */
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
      <form class="search-form" method="GET" action="">
        <input type="text" name="search" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
      </form>
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
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["team"] . "</td>";
                echo "<td>" . $row["grade"] . "</td>";
                echo "<td>" . $row["payment"] . "</td>";
                if ($is_logged_in) {
                    echo "<td>";
                    echo "<a href='edit.php?id=" . $row["id"] . "' style='padding: 5px 10px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Edit</a> ";
                    echo "<a href='delete.php?id=" . $row["id"] . "' style='padding: 5px 10px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px;'>Delete</a>";
                    echo "</td>";
                }
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' class='no-records'>No records found</td></tr>";
        }
        ?>
        </tbody>
      </table>
    </section>
  </main>
</div>

</body>
</html>

<?php
$conn->close();
?>
