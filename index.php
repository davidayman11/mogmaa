<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }
        .main {
            margin-left: 200px; /* same width as sidenav */
            padding: 20px;
        }
        form {
            background: white;
            padding: 20px;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
        }
        form button {
            background-color: #27ae60;
            color: white;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #219150;
        }
    </style>
</head>
<body>

<?php include 'sidenav.php'; ?>

<div class="main">
    <h1>Welcome to Home Page</h1>
    <form method="post" action="">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>