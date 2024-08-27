<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM attendees WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: show.php");
}

?>
