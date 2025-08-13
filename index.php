<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS -->
</head>
<body>
<div class="demo-page">

    <!-- Sidebar Navigation -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="demo-page-content">

        <!-- Display logout message -->
        <?php if (!empty($_SESSION['logout_msg'])): ?>
            <div class="logout-message">
                <?= htmlspecialchars($_SESSION['logout_msg']); ?>
            </div>
            <?php unset($_SESSION['logout_msg']); ?>
        <?php endif; ?>

        <!-- Form Section -->
        <section>
            <h1>Enter Details</h1>
            <form action="submit.php" method="post">
                
                <div class="nice-form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" placeholder="Your name" required>
                </div>

                <div class="nice-form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" placeholder="Your Phone" value="+2" required>
                </div>

                <div class="nice-form-group">
                    <label for="team">Team:</label>
                    <select id="team" name="team" required>
                        <option value="" disabled selected>Select your team</option>
                        <option value="bra3em">bra3em</option>
                        <option value="ashbal">asjjjjjjjjjjhbal</option>
                        <option value="zahrat">zahrat</option>
                        <option value="kshafa">kshafa</option>
                        <option value="morshdat">morshdat</option>
                        <option value="motkadem">motkadem</option>
                        <option value="ra2edat">ra2edat</option>
                        <option value="gwala">gwala</option>
                        <option value="kada">kada</option>
                    </select>
                </div>

                <div class="nice-form-group">
                    <label for="grade">Grade:</label>
                    <input type="text" id="grade" name="grade" placeholder="Grade" required>
                </div>

                <div class="nice-form-group">
                    <label for="payment">Payment:</label>
                    <input type="text" id="payment" name="payment" placeholder="Payment" required>
                </div>

                <input type="submit" value="Submit">
            </form>
        </section>

    </main>
</div>
</body>
</html>