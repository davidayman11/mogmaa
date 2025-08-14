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
    background-color: #f4f6f8; /* keep existing background */
    color: #333;
}
.main {
    margin-left: 220px;
    padding: 40px 30px;
    min-height: 100vh;
}

/* Heading */
h1 {
    color: #0f766e;
    margin-bottom: 25px;
    font-size: 28px;
}

/* Form card */
form {
    background: #ffffff;
    padding: 30px 35px;
    max-width: 500px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    transition: transform 0.2s, box-shadow 0.2s;
}
form:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
}

/* Form groups */
.nice-form-group {
    margin-bottom: 20px;
}
label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: #0f766e;
    font-size: 15px;
}

/* Inputs and selects */
input, select {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    transition: border 0.2s, box-shadow 0.2s;
}
input:focus, select:focus {
    border-color: #0f766e;
    box-shadow: 0 0 6px rgba(15,118,110,0.25);
    outline: none;
}

/* Submit button */
input[type="submit"] {
    background-color: #0f766e;
    color: #fff;
    border: none;
    padding: 14px 20px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}
input[type="submit"]:hover {
    background-color: #115e59;
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .main {
        margin-left: 0;
        padding: 20px;
    }
    form {
        max-width: 100%;
        padding: 25px;
    }
}
</style>
</head>
<body>

<?php include 'sidenav.php'; ?>

<div class="main">
    <h1>Register Employee</h1>
    <form action="submit.php" method="post">
        <div class="nice-form-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Enter full name" required/>
        </div>
        <div class="nice-form-group">
            <label>Phone</label>
            <input type="tel" name="phone" placeholder="+20XXXXXXXXXX" value="+2" required/>
        </div>
        <div class="nice-form-group">
            <label>Team</label>
            <select name="team" required>
                <option value="" disabled selected>Select team</option>
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
            <label>Grade</label>
            <input type="text" name="grade" placeholder="Enter grade" required/>
        </div>
        <div class="nice-form-group">
            <label>Payment</label>
            <input type="text" name="payment" placeholder="Enter payment amount" required/>
        </div>
        <input type="submit" value="Submit">
    </form>
</div>

</body>
</html>