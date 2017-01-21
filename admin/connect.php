<?php
$ini = parse_ini_file("config.ini");
$conn = new mysqli($ini['servername'], $ini['username'], $ini['password'], $ini['dbname']);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
