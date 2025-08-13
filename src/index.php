<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24 - Registration System</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/styles.css">
    <meta name="description" content="MOGAM3'24 Registration System - Enter your details for event registration">
    <meta name="keywords" content="MOGAM3, registration, event, team">
</head>
<body>
    <div class="demo-page">
        <?php include '../components/sidenav.php'; ?>
        
        <main class="demo-page-content fade-in">
            <!-- Display logout message if it exists -->
            <?php if (isset($_SESSION['logout_msg'])): ?>
                <div class="logout-message">
                    <?php 
                    echo htmlspecialchars($_SESSION['logout_msg']); 
                    unset($_SESSION['logout_msg']); // Remove the message after displaying it
                    ?>
                </div>
            <?php endif; ?>

            <section>
                <h1>Enter Details</h1>
                <form action="submit.php" method="post" class="registration-form">
                    <div class="nice-form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter your full name" required/>
                    </div>
                    
                    <div class="nice-form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" value="+2" required/>
                    </div>
                    
                    <div class="nice-form-group">
                        <label for="team">Team:</label>
                        <select id="team" name="team" required>
                            <option value="" disabled selected>Select your team</option>
                            <option value="bra3em">Bra3em</option>
                            <option value="ashbal">Ashbal</option>
                            <option value="zahrat">Zahrat</option>
                            <option value="kshafa">Kshafa</option>
                            <option value="morshdat">Morshdat</option>
                            <option value="motkadem">Motkadem</option>
                            <option value="ra2edat">Ra2edat</option>
                            <option value="gwala">Gwala</option>
                            <option value="kada">Kada</option>
                        </select>
                    </div>
                    
                    <div class="nice-form-group">
                        <label for="grade">Grade:</label>
                        <input type="text" id="grade" name="grade" placeholder="Enter your grade" required/>
                    </div>
                    
                    <div class="nice-form-group">
                        <label for="payment">Payment:</label>
                        <input type="text" id="payment" name="payment" placeholder="Enter payment amount" required/>
                    </div>
                    
                    <input type="submit" value="Submit Registration" class="btn-submit">
                </form>
            </section>
        </main>
    </div>

    <script>
        // Add form validation and enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.registration-form');
            const inputs = form.querySelectorAll('input, select');
            
            // Add focus effects
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
            
            // Phone number formatting
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (!value.startsWith('2')) {
                    value = '2' + value.replace(/^2+/, '');
                }
                this.value = '+' + value;
            });
            
            // Form submission enhancement
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('input[type="submit"]');
                submitBtn.value = 'Submitting...';
                submitBtn.disabled = true;
            });
        });
    </script>
</body>
</html>
