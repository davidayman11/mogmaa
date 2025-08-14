<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
require __DIR__ . '/includes/db.php';

check_csrf();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $next = $_POST['next'] ?? 'index.php';

    if (!$email || !$password) {
        flash('error', 'Email and password are required.');
        redirect('login.php?next=' . urlencode($next));
    }

    try {
        // 1️⃣ First check if the hardcoded admin login matches
        if ($email === 'admin' && $password === 'password') {
            // Hardcoded admin login successful
            login_user(0, 'Admin'); // ID=0 for hardcoded admin
            flash('success', 'Welcome back, Admin!');
            redirect($next ?: 'index.php');
        }

        // 2️⃣ Otherwise check the database as usual
        $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $hash = $user['password'] ?? '';
            $ok = false;

            if ($hash && password_get_info((string)$hash)['algo'] !== 0) {
                $ok = password_verify($password, (string)$hash);
            } else {
                // Legacy plaintext password
                $ok = hash_equals((string)$hash, $password);
            }

            if ($ok) {
                login_user((int)$user['id'], (string)($user['name'] ?? 'User'));

                // Upgrade hash if legacy plaintext
                if ($hash && password_get_info((string)$hash)['algo'] === 0) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    $up = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $up->execute([$newHash, (int)$user['id']]);
                }

                flash('success', 'Welcome back!');
                redirect($next ?: 'index.php');
            }
        }

        flash('error', 'Invalid credentials.');
    } catch (Throwable $e) {
        error_log('[LOGIN] ' . $e->getMessage());
        flash('error', 'Something went wrong.');
    }

    redirect('login.php?next=' . urlencode($next));
}

$title = 'Login';
$next = $_GET['next'] ?? 'index.php';
require __DIR__ . '/includes/header.php';
?>
<h1>Login</h1>
<form method="post" action="login.php" autocomplete="off" novalidate>
  <?php echo csrf_field(); ?>
  <input type="hidden" name="next" value="<?php echo e($next); ?>">
  <div class="field">
    <label>Email</label>
    <input type="text" name="email" required>
  </div>
  <div class="field">
    <label>Password</label>
    <input type="password" name="password" required>
  </div>
  <div class="right">
    <button class="btn btn-primary" type="submit">Sign in</button>
  </div>
</form>
<?php require __DIR__ . '/includes/footer.php'; ?>