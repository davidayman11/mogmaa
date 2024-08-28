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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        /* Add additional styling for buttons */
        .action-buttons a {
            padding: 5px 10px;
            text-decoration: none;
            font-size: 14px;
            color: white;
            border-radius: 5px;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .delete-btn {
            background-color: #f44336;
        }
    </style>
</head>
<body>
<div class="demo-page">
    <div class="demo-page-navigation">
        <!-- Your existing navigation menu -->
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
                        <th>Edit</th> <!-- Add Edit column -->
                        <th>Delete</th> <!-- Add Delete column -->
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
                            echo "<td class='action-buttons'><a class='edit-btn' href='edit.php?id=" . $row["id"] . "'>Edit</a></td>";
                            echo "<td class='action-buttons'><a class='delete-btn' href='delete.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='no-records'>No records found</td></tr>";
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
