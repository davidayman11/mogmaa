<?php
// Show errors while debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = '193.203.168.53';
$username   = 'u968010081_mogamaa';
$password   = 'Mogamaa_2000';
$dbname     = 'u968010081_mogamaa';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mogamaa Fun Day Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm p-4">
                <h1 class="h4 mb-4 text-center">Register for Mogamaa Fun Day</h1>
                <form method="post" action="submit.php" novalidate>
                    <div class="mb-3">
                        <label class="form-label">ID (4 chars)</label>
                        <input type="text" name="id" maxlength="4" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control" placeholder="+20XXXXXXXXXX" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Team</label>
                        <select name="team" class="form-select" required>
                            <option value="" selected disabled>Select team</option>
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
                    <div class="mb-3">
                        <label class="form-label">Grade</label>
                        <input type="text" name="grade" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment</label>
                        <input type="text" name="payment" class="form-control" required>
                    </div>
                    <button class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>