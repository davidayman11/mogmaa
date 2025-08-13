<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24 - Ahaly</title>
    <link rel="stylesheet" href="styles.css"> <!-- Shared styles -->
</head>
<body>
<div class="demo-page">
    
    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="demo-page-content">

        <!-- Logout message -->
        <?php if (!empty($_SESSION['logout_msg'])): ?>
            <div class="logout-message">
                <?php 
                echo htmlspecialchars($_SESSION['logout_msg'], ENT_QUOTES, 'UTF-8'); 
                unset($_SESSION['logout_msg']); 
                ?>
            </div>
        <?php endif; ?>

        <!-- Form Section -->
        <section>
            <h1>Enter Details</h1>
            <form action="submit.php" method="post">
                
                <div class="nice-form-group">
                    <label for="name">Name:</label>
                    <input id="name" type="text" name="name" placeholder="Your name" required>
                </div>

                <div class="nice-form-group">
                    <label for="phone">Phone:</label>
                    <input id="phone" type="tel" name="phone" placeholder="Your Phone" value="+2" required>
                </div>

                <div class="nice-form-group">
                    <label for="team">Team:</label>
                    <input id="team" type="text" name="team" placeholder="ahaly" value="ahaly" required>
                </div>

                <div class="nice-form-group">
                    <label for="payment">Payment:</label>
                    <input id="payment" type="text" name="payment" placeholder="Payment" required>
                </div>

                <input type="submit" value="Submit" class="btn-submit">
            </form>
        </section>
    </main>
</div>
</body>
</html>