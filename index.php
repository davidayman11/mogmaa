<?php
// Start the session
session_start();

// Hardcoded username and password
$hardcodedUsername = 'admin';
$hardcodedPassword = 'password';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $hardcodedUsername && $password === $hardcodedPassword) {
        // Store session variable
        $_SESSION['loggedin'] = true;
        header('Location: index.php');
        exit();
    } else {
        $loginError = "Invalid username or password.";
    }
}

// If not logged in, display the login form
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo '<div class="demo-page">';
    echo '<div class="demo-page-navigation">';
    echo '<nav>';
    echo '<ul>';
    echo '<li><a href="./index.php">MOGAM3\'24</a></li>';
    echo '</ul>';
    echo '</nav>';
    echo '</div>';
    echo '<main class="demo-page-content">';
    echo '<section>';
    echo '<h1>Login</h1>';
    echo '<form action="index.php" method="post">';
    echo '<div class="nice-form-group">';
    echo '<label>Username:</label>';
    echo '<input type="text" name="username" required />';
    echo '</div>';
    echo '<div class="nice-form-group">';
    echo '<label>Password:</label>';
    echo '<input type="password" name="password" required />';
    echo '</div>';
    if (isset($loginError)) {
        echo '<p style="color:red;">' . $loginError . '</p>';
    }
    echo '<input type="submit" value="Login">';
    echo '</form>';
    echo '</section>';
    echo '</main>';
    echo '</div>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24</title>
    <style>
        /* Your existing styles */
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
              MOGAM3'24
          </a>
        </li>
        <li>
          <a href="./show.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
                <polygon points="12 2 2 7 12 12 22 7 12 2" />
                <polyline points="2 17 12 22 22 17" />
                <polyline points="2 12 12 17 22 12" />
              </svg>
              Details
          </a>
        </li>
      </ul>
    </nav>
  </div>
  <main class="demo-page-content">
    <section>
      <h1>Enter Details</h1>
      <form action="submit.php" method="post">
        <!-- Your existing form fields -->
        <input type="submit" value="Submit">
      </form>
    </section>
  </main>
</div>
</body>
</html>
