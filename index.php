<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOGAM3'24</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f9; color: #333;">

<div style="padding: 20px; max-width: 800px; margin: auto; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
  <nav style="margin-bottom: 20px;">
    <ul style="list-style: none; padding: 0; display: flex; gap: 15px;">
      <li>
        <a href="./index.php" style="text-decoration: none; color: #333; display: flex; align-items: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
            <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
          </svg>
          Enter Employee Details
        </a>
      </li>
      <li>
        <a href="./show.php" style="text-decoration: none; color: #333; display: flex; align-items: center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
            <polygon points="12 2 2 7 12 12 22 7 12 2" />
            <polyline points="2 17 12 22 22 17" />
            <polyline points="2 12 12 17 22 12" />
          </svg>
          Employee Details
        </a>
      </li>
    </ul>
  </nav>

  <main>
    <section>
      <h1 style="font-size: 24px; margin-bottom: 20px;">Enter Employee Details</h1>
      <form action="submit.php" method="post">
        <div style="margin-bottom: 15px;">
          <label for="name" style="display: block; margin-bottom: 5px;">Name:</label>
          <input type="text" id="name" name="name" placeholder="Your name" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
          <label for="phone" style="display: block; margin-bottom: 5px;">Phone:</label>
          <input type="tel" id="phone" name="phone" placeholder="Your Phone" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
          <label for="team" style="display: block; margin-bottom: 5px;">Team:</label>
          <input type="text" id="team" name="team" placeholder="Team" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
          <label for="grade" style="display: block; margin-bottom: 5px;">Grade:</label>
          <input type="text" id="grade" name="grade" placeholder="Grade" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
          <label for="payment" style="display: block; margin-bottom: 5px;">Payment:</label>
          <input type="text" id="payment" name="payment" placeholder="Payment" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        <input type="submit" value="Submit" style="background-color: #007bff; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer;">
      </form>
    </section>
  </main>
</div>

</body>
</html>
