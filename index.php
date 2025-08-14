<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background-color: #f4f6f8; }
        .main { margin-left: 200px; padding: 20px; }
        form { background: white; padding: 20px; max-width: 400px; border-radius: 8px; box-shadow: 0px 2px 5px rgba(0,0,0,0.1); }
        .nice-form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; }
        input[type="submit"] { background-color: #27ae60; color: white; border: none; cursor: pointer; }
        input[type="submit"]:hover { background-color: #219150; }
    </style>
</head>
<body>

<?php include 'sidenav.php'; ?>

<div class="main">
    <h1>Enter Details</h1>
    <form action="submit.php" method="post">
        <div class="nice-form-group">
            <label>Name:</label>
            <input type="text" name="name" placeholder="Your name" required/>
        </div>
        <div class="nice-form-group">
            <label>Phone:</label>
            <input type="tel" name="phone" placeholder="Your Phone" value="+2" required/>
        </div>
        <div class="nice-form-group">
            <label>Team:</label>
            <select name="team" required>
                <option value="" disabled selected>Select your team</option>
                <option value="bra3em">bra3em</option>
                <option value="ashbal">ashbal</option>
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
            <label>Grade:</label>
            <input type="text" name="grade" placeholder="Grade" required/>
        </div>
        <div class="nice-form-group">
            <label>Payment:</label>
            <input type="text" name="payment" placeholder="Payment" required/>
        </div>
        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>