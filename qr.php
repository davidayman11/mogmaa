<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require_login();
$title = 'QR Generator';
require __DIR__ . '/includes/header.php';

// If generate_qr.php returns an image by query string (e.g., ?data=...), we can show it here.
$qrData = trim($_GET['data'] ?? '');
$qrUrl = $qrData ? 'generate_qr.php?data=' . urlencode($qrData) : '';
?>
<h1>Generate QR</h1>
<form method="get" action="qr.php">
  <div class="field">
    <label>QR Data (text / URL)</label>
    <input type="text" name="data" value="<?php echo e($qrData); ?>" required>
  </div>
  <div>
    <button class="btn btn-primary" type="submit">Generate</button>
  </div>
</form>

<?php if ($qrUrl): ?>
  <hr>
  <h2>Preview</h2>
  <div style="display:flex; gap:16px; align-items:flex-start;">
    <img src="<?php echo e($qrUrl); ?>" alt="QR Code" style="border:1px solid #eee; border-radius:10px; padding:10px; max-width:256px;">
    <div>
      <a class="btn btn-outline" href="<?php echo e($qrUrl); ?>" download="qr.png">Download PNG</a>
      <p style="margin-top:8px;">Scan this QR code or download it for printing.</p>
    </div>
  </div>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
