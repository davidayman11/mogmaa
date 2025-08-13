<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}

include_once("includes/header.php");
?>

        <section>
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
        </section>

<?php
include_once("includes/footer.php");
?>

