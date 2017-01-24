<?php
session_start();
if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
    header('Location: https://' . $_SERVER["HTTP_HOST"] . '/firstproject/admin/login.php');
}
?>

