<?php header('X-Frame-Options: DENY'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cancel form</title>
    </head>
    <body>

        <h2>Enter your Ticket-number to cancel your SignUp</h2>

        <form action="delete.php" method="POST">
            <p><label for="guestid">Ticket-number</label>: <input type="text" name="ticket" id="ticket"/></p>
            <p><input type="submit" value="Submit" /></p>
        </form>

        <p></p>
    </body>
</html>

