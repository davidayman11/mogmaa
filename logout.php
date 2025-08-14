<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'utils.php';

$auth = new Auth();

// Perform logout
$auth->logout();

// Redirect to login page with success message
Utils::redirect('login.php', 'You have been successfully logged out.', 'success');
?>

