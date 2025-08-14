<?php
// includes/header.php
declare(strict_types=1);
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo e($title ?? 'Dashboard'); ?></title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Minimal structural styles to keep your existing UI while improving consistency */
    body { margin:0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, 'Noto Sans', 'Helvetica Neue', sans-serif; background:#f8f9fb; }
    header, footer { background:#111827; color:#fff; }
    header .wrap, footer .wrap { max-width: 1100px; margin: 0 auto; padding: 12px 16px; display:flex; align-items:center; justify-content:space-between; }
    nav a { color:#d1d5db; text-decoration:none; margin-right:12px; }
    nav a.active, nav a:hover { color:#fff; text-decoration:underline; }
    .container { max-width:1100px; margin: 20px auto; background:#fff; padding:16px; border-radius:10px; box-shadow: 0 2px 8px rgba(0,0,0,.06); }
    .flash { padding: 10px 12px; margin-bottom:12px; border-radius:8px; background:#ecfdf5; color:#065f46; border:1px solid #d1fae5; }
    .error { background:#fef2f2; color:#991b1b; border-color:#fee2e2; }
    .btn { display:inline-block; padding:8px 12px; border-radius:8px; border:1px solid #e5e7eb; text-decoration:none; }
    .btn-primary { background:#111827; color:#fff; border-color:#111827; }
    .btn-outline { background:#fff; color:#111827; }
    .right { text-align:right; }
    .grid { display:grid; gap:12px; }
    .grid-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .grid-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    @media (max-width: 800px) { .grid-2, .grid-3 { grid-template-columns: 1fr; } }
    form .field { margin-bottom:12px; }
    form label { display:block; margin-bottom:6px; font-weight:600; }
    form input, form select, form textarea { width:100%; padding:8px; border-radius:8px; border:1px solid #e5e7eb; }
  </style>
</head>
<body>
<header>
  <div class="wrap">
    <div><strong>Mogmaa</strong> <?php if (!empty($_SESSION['user_name'])) echo '— Hello, ' . e($_SESSION['user_name']); ?></div>
    <nav>
      <a href="index.php" class="<?php echo ($_SERVER['SCRIPT_NAME'] ?? '') === '/index.php' ? 'active' : ''; ?>">Home</a>
      <a href="qr.php" class="<?php echo basename($_SERVER['SCRIPT_NAME']) === 'qr.php' ? 'active' : ''; ?>">QR</a>
      <a href="whatsapp.php" class="<?php echo basename($_SERVER['SCRIPT_NAME']) === 'whatsapp.php' ? 'active' : ''; ?>">WhatsApp</a>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container">
<?php if ($msg = flash('success')): ?><div class="flash"><?php echo e($msg); ?></div><?php endif; ?>
<?php if ($msg = flash('error')): ?><div class="flash error"><?php echo e($msg); ?></div><?php endif; ?>
