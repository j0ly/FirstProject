<?php header('X-Frame-Options: DENY'); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Thank you!</title>
    </head>
    <body>

<?php
require_once('auth.php');
include('connect.php');

$sql = "SELECT name, address, creditcard, ticket FROM Attenders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo "Name: " . $row["name"] . "<br>";
        echo "Address: " . $row["address"] . "<br>";
        echo "Credit Card: " . $row["creditcard"] . "<br>";
        echo "Ticket number: " . $row["ticket"] . "<br><br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

    </body>
</html>

