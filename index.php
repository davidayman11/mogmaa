<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Form</title>
    <link rel="stylesheet" href="styles.css">
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
            Enter Employee Details</a>
        </li>
        <li>
        <a href="./show.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
              <polygon points="12 2 2 7 12 12 22 7 12 2" />
              <polyline points="2 17 12 22 22 17" />
              <polyline points="2 12 12 17 22 12" />
            </svg>
            Employee Details</a>
        </li>
      </ul>
    </nav>
  </div>
  <main class="demo-page-content">
    <section>
      <h1>Enter frd Details</h1>
      <form action="submit.php" method="post">
        <div class="nice-form-group">
          <label>Name:</label>
          <input type="text" name="name" placeholder="Your name" required />
        </div>
        <div class="nice-form-group">
          <label>Phone</label>
          <input type="tel" name="phone" placeholder="Your Phone" required />
        </div>
        <div class="nice-form-group">
          <label>Team:</label>
          <input type="text" name="team" placeholder="Team" required />
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
</body>
</html>
