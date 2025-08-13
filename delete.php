<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
require 'db_connect.php';

$id = intval($_GET['id']);
$conn->query("DELETE FROM employees WHERE id=$id");
header("Location: details.php");
exit();