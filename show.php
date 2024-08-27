<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in and display the Logout button
if(isset($_SESSION['username'])) {
    echo "<a href='logout.php'>Logout</a><br><br>";
}

$query = "SELECT * FROM attendees";
$result = mysqli_query($conn, $query);

echo "<table border='1'>
<tr>
<th>Name</th>
<th>Phone</th>
<th>Team</th>
<th>Grade</th>
<th>Payment</th>";

if(isset($_SESSION['username'])) {
    echo "<th>Actions</th>";
}

echo "</tr>";

while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $row['phone'] . "</td>";
    echo "<td>" . $row['team'] . "</td>";
    echo "<td>" . $row['grade'] . "</td>";
    echo "<td>" . $row['payment'] . "</td>";

    if(isset($_SESSION['username'])) {
        echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
    }

    echo "</tr>";
}
echo "</table>";
?>
