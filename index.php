<?php
// Start the session
session_start();

// Check for the message
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    // Clear the message after displaying
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin: 20px;
            border: 1px solid #d6e9c6;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="demo-page">
        <div class="demo-page-navigation">
            <nav>
                <ul>
                    <li>
                        <a href="./index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tool">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                            </svg>
                            MOGAM3'24</a>
                    </li>
                    <li>
                        <a href="./show.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                                <polyline points="2 17 12 22 22 17" />
                                <polyline points="2 12 12 17 22 12" />
                            </svg>
                            Details</a>
                    </li>
                    <!-- New Admin link -->
                    <li>
                        <a href="./login.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Admin</a>
                    </li>
                    <!-- New Logout link -->
                    <li>
                        <a href="./logout.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                <path d="M10 9l-3-3 3-3" />
                                <path d="M21 15v4H3v-4" />
                                <path d="M21 9l-3 3-3-3" />
                            </svg>
                            Logout</a>
                    </li>
                </ul>
            </nav>
        </div>
        <main class="demo-page-content">
            <section>
                <h1>Enter Details</h1>
                <form action="submit.php" method="post">
                    <div class="nice-form-group">
                        <label>Name:</label>
                        <input type="text" name="name" placeholder="Your name" required />
                    </div>
                    <div class="nice-form-group">
                        <label>Phone:</label>
                        <input type="tel" name="phone" placeholder="Your Phone" value="+2" required />
                    </div>
                    <div class="nice-form-group">
                        <label>Team:</label>
                        <select name="team" required>
                            <option value="" disabled selected>Select your team</option>
                            <option value="team1">bra3em</option>
                            <option value="team2">ashbal</option>
                            <option value="team3">zahrat</option>
                            <option value="team3">kshafa</option>
                            <option value="team3">morshdat</option>
                            <option value="team3">motkadem</option>
                            <option value="team3">ra2edat</option>
                            <option value="team3">gwala</option>
                            <option value="team3">kada</option>
                        </select>
                    </div>
                    <div class="nice-form-group">
                        <label>Grade:</label>
                        <input type="text" name="grade" placeholder="Grade" required />
                    </div>
                    <div class="nice-form-group">
                        <label>Payment:</label>
                        <input type="text" name="payment" placeholder="Payment" required />
                    </div>
                    <input type="submit" value="Submit">
                </form>
            </section>
        </main>
    </div>
    <!-- Display logout message -->
    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
</body>
</html>
