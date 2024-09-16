<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "193.203.168.53";
$username = "u968010081_mogamaa";
$password = "Mogamaa_2000";
$dbname = "u968010081_mogamaa";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<div style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px; font-family: Arial, sans-serif;'>Connection failed: " . $conn->connect_error . "</div>");
}

// Initialize variables to avoid undefined index errors
$name = $phone = $team = $grade = $payment = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a 4-character unique ID
    $id = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);

    // Capture form data
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $team = $_POST['team'];
    $grade = $_POST['grade'];
    $payment = $_POST['payment'];

    // Insert data into MySQL database
    $sql = "INSERT INTO employees (id, name, phone, team, grade, payment)
    VALUES ('$id', '$name', '$phone', '$team', '$grade', '$payment')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the QR code generation page
        header("Location: generate_qr.php?id=$id&name=" . urlencode($name) . "&phone=" . urlencode($phone) . "&team=" . urlencode($team) . "&grade=" . urlencode($grade) . "&payment=" . urlencode($payment));
        exit;
    } else {
        echo "<div style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px; font-family: Arial, sans-serif;'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahaly - Enter Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #4CAF50;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input[type="text"],
        .form-group input[type="tel"],
        .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Enter Ahaly Details</h1>
        <form action="ahaly.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" name="phone" id="phone" placeholder="Enter your phone number" required>
            </div>

            <div class="form-group">
                <label for="team">Team:</label>
                <select name="team" id="team" required>
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

            <div class="form-group">
                <label for="grade">Grade:</label>
                <input type="text" name="grade" id="grade" placeholder="Enter your grade" required>
            </div>

            <div class="form-group">
                <label for="payment">Payment:</label>
                <input type="text" name="payment" id="payment" placeholder="Enter payment status" required>
            </div>

            <input type="submit" value="Submit">
        </form>
    </div>

</body>
</html>
