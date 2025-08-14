<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Side Navigation</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .sidenav {
            height: 100%;
            width: 200px;
            background-color: #2c3e50;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }
        .sidenav a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            color: #ecf0f1;
            display: block;
        }
        .sidenav a:hover {
            background-color: #34495e;
        }
        .content {
            margin-left: 200px;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidenav">
    <a href="index.php">🏠 Home</a>
    <a href="page1.php">📄 Page 1</a>
    <a href="page2.php">📊 Page 2</a>
    <a href="settings.php">⚙ Settings</a>
</div>

<div class="content">
    <h2>Welcome</h2>
    <p>This is the content area.</p>
</div>

</body>
</html>