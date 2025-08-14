<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$title = 'Record #' . $id;
require __DIR__ . '/includes/header.php';

if ($id <= 0) { echo '<p>Invalid ID.</p>'; require __DIR__ . '/includes/footer.php'; exit; }

try {
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
} catch (Throwable $e) {
    $row = null;
    error_log('[SHOW] ' . $e->getMessage());
}
?>
<h1>Record #<?php echo e((string)$id); ?></h1>
<?php if ($row): ?>
  <pre style="background:#f9fafb; padding:12px; border-radius:10px; overflow:auto;"><?php echo e(json_encode($row, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)); ?></pre>
  <div class="right">
    <a class="btn btn-primary" href="edit.php?id=<?php echo urlencode((string)$id); ?>">Edit</a>
  </div>
<?php else: ?>
  <p>Record not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
