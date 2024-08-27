<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM attendees WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if(isset($_POST['update'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $team = $_POST['team'];
    $grade = $_POST['grade'];
    $payment = $_POST['payment'];

    $query = "UPDATE attendees SET name='$name', phone='$phone', team='$team', grade='$grade', payment='$payment' WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: show.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Details</title>
</head>
<body>
    <h1>Edit Details</h1>
    <form method="post" action="">
        Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
        Phone: <input type="text" name="phone" value="<?php echo $row['phone']; ?>"><br>
        Team: <input type="text" name="team" value="<?php echo $row['team']; ?>"><br>
        Grade: <input type="text" name="grade" value="<?php echo $row['grade']; ?>"><br>
        Payment: <input type="text" name="payment" value="<?php echo $row['payment']; ?>"><br>
        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>
