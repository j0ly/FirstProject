<?php
header('X-Frame-Options: DENY'); 
$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        if($username == 'admin' && $password == 'password') {
            session_start();
            $_SESSION["authenticated"] = 'true';
            header('Location: index.php');
        }
        else {
            header('Location: login.php');
        }
        
    } else {
        header('Location: login.php');
    }
} else {
?>
<!DOCTYPE html>
<html>
<body>
<h1>Login</h1>
<form id="login" method="post">
     <label for="username">Username:</label>
     <input id="username" name="username" type="text" required autocomplete="off">
     <br>
     <label for="password">Password:</label>
     <input id="password" name="password" type="password" required autocomplete="off">
     <br><br>
     <input type="submit" value="Login">
</form>
</body>
</html>
<?php } ?>

