<?php
require_once __DIR__ . '/../config/app.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MOGAMAA Fun Day</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#f7f7fb}
    .navbar{box-shadow:0 2px 12px rgba(0,0,0,.05)}
    .card{border:0;border-radius:1rem;box-shadow:0 8px 24px rgba(0,0,0,.06)}
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= e(url('public/index.php')) ?>">MOGAMAA'24</a>
    <div class="ms-auto">
      <a href="<?= e(url('admin/login.php')) ?>" class="btn btn-outline-primary btn-sm">Admin</a>
    </div>
  </div>
</nav>
<main class="container py-4">
