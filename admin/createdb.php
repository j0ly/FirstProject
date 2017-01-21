<?php
$ini = parse_ini_file("config.ini");

// Create connection
$conn = new mysqli($ini['servername'], $ini['username'], $ini['password']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE " . $ini['dbname'];
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully. ";
} else {
    echo "Error creating database: " . $conn->error . ". ";
}

$conn->close();


// Create connection
$conn = new mysqli($ini['servername'], $ini['username'], $ini['password'], $ini['dbname']);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE Attenders (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(60) NOT NULL,
address VARCHAR(100),
creditcard VARCHAR(50),
ticket  VARCHAR(40)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully.";
} else {
    echo "Error creating table: " . $conn->error . ".";
}

$conn->close();

?>
