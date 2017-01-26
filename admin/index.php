<?php
header('X-Frame-Options: DENY'); 
require_once('auth.php');
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Event X Admins</title>
    </head>
    <body>

        <h2>Welcome admin!</h2>
        Look who have signed up to the event <a href="list.php">here</a><br>

        <p></p>
    </body>
</html>

