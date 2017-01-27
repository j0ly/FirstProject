<?php header('X-Frame-Options: DENY'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign up form</title>
    </head>
    <body>
        Enter a value into every field!
        
        <h1>Sign up to the event using this form</h1>

        <form action="done.php" method="POST">
            <label for="name">Name</label>: <input type="text" name="name" id="name"/><br>
            <label for="address">Address</label>: <input type="text" name="address" id="address"/><br><br>
            <label for="creditcard">Credit Card number</label>: <input type="text" name="creditcard" id="creditcard"/> (don't enter real credit card numbers)<br>   
            <p><input type="submit" value="Submit" /></p>
        </form>

        <p></p>
    </body>
</html>

