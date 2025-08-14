<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Register</title>
<style>
body {
    margin: 0;
    font-family: "Segoe UI", Arial, sans-serif;
    background-color: #f4f6f8;
    color: #333;
}
.main {
    margin-left: 220px;
    padding: 30px;
}
h1 {
    color: #0f766e;
    margin-bottom: 20px;
}
form {
    background: #fff;
    padding: 25px 30px;
    max-width: 450px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}
.nice-form-group {
    margin-bottom: 18px;
}
label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #0f766e;
}
input, select {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 14px;
    transition: border 0.2s, box-shadow 0.2s;
}
input:focus, select:focus {
    border-color: #0f766e;
    box-shadow: 0 0 5px rgba(15,118,110,0.3);
    outline: none;
}
input[type="submit"] {
    background-color: #0f766e;
    color: white;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
}
input[type="submit"]:hover {
    background-color: #115e59;
}
/* Responsive adjustments */
@media (max-width: 768px) {
    .main {
        margin-left: 0;
        padding: 20px;
    }
    form {
        max-width: 100%;
    }
}
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