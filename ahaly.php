<?php
session_start(); // Start the session

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
                    <label>team:</label>
                    <input type="text" name="team" placeholder="ahaly" value="ahaly" required/>
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

