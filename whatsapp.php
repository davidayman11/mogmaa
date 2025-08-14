<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require_login();
$title = 'WhatsApp Sender';
require __DIR__ . '/includes/header.php';

$prefillPhone = preg_replace('/[^0-9]/', '', $_GET['to'] ?? '');
$prefillMsg = trim($_GET['msg'] ?? '');
?>
<h1>Send WhatsApp Message</h1>
<form method="post" action="send_whatsapp.php" onsubmit="return validateForm();">
  <?php echo csrf_field(); ?>
  <div class="field">
    <label>Phone (with country code)</label>
    <input type="tel" name="phone" value="<?php echo e($prefillPhone); ?>" placeholder="201234567890" required pattern="[0-9]{10,15}">
  </div>
  <div class="field">
    <label>Message</label>
    <textarea name="message" rows="5" required><?php echo e($prefillMsg ?: 'Hello, this is a test from Mogmaa.'); ?></textarea>
  </div>
  <div>
    <button class="btn btn-primary" type="submit">Send</button>
  </div>
</form>

<script>
function validateForm(){
  const p = document.querySelector('input[name=phone]').value.trim();
  if(!/^\d{10,15}$/.test(p)){ alert('Please enter a valid phone number (digits only, 10–15).'); return false; }
  return true;
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
