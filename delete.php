<?php header('X-Frame-Options: DENY'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cancel</title>
    </head>
    <body>

<?php
echo '<p><a href="http://' . $_SERVER["HTTP_HOST"] .'/firstproject/index.php">home</a></p>';        
        
include('admin/connect.php');

$ticket = $_POST["ticket"];

$sql = "DELETE FROM Attenders WHERE ticket = '" . $ticket ."'";

if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
       echo "Your SignUp has been successfully canceled!";
    } else {
       echo "Matching ID not found!";
    }
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>

    </body>
</html>

