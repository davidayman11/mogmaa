<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';
require_login();
check_csrf();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { flash('error', 'Invalid ID'); redirect('index.php'); }

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if (!$name) {
        flash('error', 'Name is required.');
        redirect('edit.php?id=' . $id);
    }
    try {
        $stmt = $pdo->prepare("UPDATE employees SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
        flash('success', 'Record updated.');
        redirect('show.php?id=' . $id);
    } catch (Throwable $e) {
        error_log('[EDIT] ' . $e->getMessage());
        flash('error', 'Update failed.');
        redirect('edit.php?id=' . $id);
    }
}

$title = 'Edit #' . $id;
require __DIR__ . '/includes/header.php';

try {
    $stmt = $pdo->prepare("SELECT id, name FROM employees WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
} catch (Throwable $e) {
    $row = null;
}
?>
<h1>Edit Record #<?php echo e((string)$id); ?></h1>
<?php if ($row): ?>
<form method="post" action="edit.php?id=<?php echo e((string)$id); ?>">
  <?php echo csrf_field(); ?>
  <div class="field">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo e($row['name'] ?? ''); ?>" required>
  </div>
  <div class="right">
    <button class="btn btn-primary" type="submit">Save</button>
  </div>
</form>
<?php else: ?>
  <p>Record not found.</p>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
