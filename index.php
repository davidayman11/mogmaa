<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

$title = 'Home';
require __DIR__ . '/includes/header.php';

// Example secure read (adjust table/columns to your schema)
try {
    // Replace 'employees' with your table if different
    $stmt = $pdo->query("SELECT id, name FROM employees ORDER BY id DESC LIMIT 10");
    $rows = $stmt->fetchAll();
} catch (Throwable $e) {
    $rows = [];
    error_log('[INDEX] ' . $e->getMessage());
}
?>
<h1>Dashboard</h1>
<p>Welcome to your improved backend. The layout is consistent and the code is cleaner & more secure.</p>

<section>
  <h2>Recent Records</h2>
  <div class="grid grid-2">
    <?php if ($rows): foreach ($rows as $r): ?>
      <div class="card" style="padding:12px; border:1px solid #eee; border-radius:10px;">
        <div><strong>#<?php echo e((string)$r['id']); ?></strong></div>
        <div><?php echo e($r['name'] ?? ''); ?></div>
        <div class="right">
          <a class="btn" href="show.php?id=<?php echo urlencode((string)$r['id']); ?>">View</a>
          <a class="btn btn-primary" href="edit.php?id=<?php echo urlencode((string)$r['id']); ?>">Edit</a>
        </div>
      </div>
    <?php endforeach; else: ?>
      <p>No records yet.</p>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
