<?php
// Start the session
session_start();

// Check if the admin is logged in (implement a login system for better security)
// if (!isset($_SESSION['admin_logged_in'])) {
//     header('Location: login.php');
//     exit();
// }

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the database
$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .admin-page {
            display: flex;
            height: 100vh;
        }

        .admin-page-content {
            flex-grow: 1;
            padding: 40px;
        }

        .admin-page-content h1 {
            margin-top: 0;
            color: #4CAF50;
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

        .actions {
            display: flex;
            gap: 10px;
        }

        .actions a {
            text-decoration: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .actions a.edit {
            background-color: #4CAF50;
        }

        .actions a.delete {
            background-color: #f44336;
        }

        .actions a.edit:hover {
            background-color: #45a049;
        }

        .actions a.delete:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
<div class="admin-page">
  <main class="admin-page-content">
    <section>
      <h1>Admin Panel - Employee Management</h1>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Team</th>
            <th>Grade</th>
            <th>Payment</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["id"] . "</td>";
                  echo "<td>" . $row["name"] . "</td>";
                  echo "<td>" . $row["phone"] . "</td>";
                  echo "<td>" . $row["team"] . "</td>";
                  echo "<td>" . $row["grade"] . "</td>";
                  echo "<td>" . $row["payment"] . "</td>";
                  echo "<td class='actions'>";
                  echo "<a href='edit_employee.php?id=" . $row["id"] . "' class='edit'>Edit</a>";
                  echo "<a href='delete_employee.php?id=" . $row["id"] . "' class='delete' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
                  echo "</td>";
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
