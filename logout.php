<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
logout_user();
flash('success', 'Signed out.');
header('Location: login.php');
exit;
