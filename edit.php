<?php
require_once 'includes/auth.php';
require_admin();            // block non-admins
require_once 'db.php';

$id = $_GET['id'] ?? '';
if (!$id) {
    header('Location: detail.php');
    exit;
}

// On POST -> update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $team    = trim($_POST['team'] ?? '');
    $grade   = trim($_POST['grade'] ?? '');
    $payment = trim($_POST['payment'] ?? '');

    $stmt = $conn->prepare("UPDATE employees SET name=?, phone=?, team=?, grade=?, payment=? WHERE id=?");
    $stmt->bind_param("ssssss", $name, $phone, $team, $grade, $payment, $id);
    if ($stmt->execute()) {
        $stmt->close();
        header('Location: detail.php');
        exit;
    } else {
        $error = $stmt->error;
        $stmt->close();
    }
}

// fetch existing row
$stmt = $conn->prepare("SELECT id, name, phone, team, grade, payment FROM employees WHERE id=? LIMIT 1");
$stmt->bind_param("s", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    $stmt->close();
    header('Location: detail.php');
    exit;
}
$row = $res->fetch_assoc();
$stmt->close();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit - <?php echo htmlspecialchars($row['id']); ?></title>
<style>
body{font-family:Arial;background:#f4f4f4;padding:20px}
.form-box{max-width:600px;background:#fff;padding:20px;border-radius:6px;box-shadow:0 4px 12px rgba(0,0,0,.06)}
label{display:block;margin-top:10px}
input, select{width:100%;padding:8px;margin-top:6px;border:1px solid #ccc;border-radius:4px}
button{margin-top:12px;padding:10px 16px;background:#4CAF50;color:#fff;border:0;border-radius:4px}
.error{color:#c00}
</style>
</head>
<body>
<div class="form-box">
  <h3>Edit ID: <?php echo htmlspecialchars($row['id']); ?></h3>
  <?php if (!empty($error)): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
  <form method="post">
    <label>Name</label>
    <input name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
    <label>Phone</label>
    <input name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
    <label>Team</label>
    <input name="team" value="<?php echo htmlspecialchars($row['team']); ?>" required>
    <label>Grade</label>
    <input name="grade" value="<?php echo htmlspecialchars($row['grade']); ?>" required>
    <label>Payment</label>
    <input name="payment" value="<?php echo htmlspecialchars($row['payment']); ?>" required>
    <button type="submit">Save</button>
    <a href="detail.php" style="margin-left:10px">Cancel</a>
  </form>
</div>
</body>
</html>