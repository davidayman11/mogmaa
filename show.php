<?php
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

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $conn->real_escape_string($_GET['delete']);
    $deleteSql = "DELETE FROM employees WHERE id = $id";
    if ($conn->query($deleteSql) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location.href='index.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Retrieve data from the database with search filter
$sql = "SELECT * FROM employees";
if ($search) {
    $sql .= " WHERE name LIKE '%$search%' OR phone LIKE '%$search%' OR team LIKE '%$search%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <style>
        /* Your existing CSS styles */
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
      <h1>Employee Details</h1>
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
            <th>Action</th> <!-- New column for delete action -->
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
              // Output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["id"] . "</td>";
                  echo "<td>" . $row["name"] . "</td>";
                  echo "<td>" . $row["phone"] . "</td>";
                  echo "<td>" . $row["team"] . "</td>";
                  echo "<td>" . $row["grade"] . "</td>";
                  echo "<td>" . $row["payment"] . "</td>";
                  echo "<td><a href='index.php?delete=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a></td>"; // Delete link
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
