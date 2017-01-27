<?php
header('X-Frame-Options: DENY');
if(empty($_POST["name"]) || empty($_POST["address"]) || empty($_POST["creditcard"])) {
    header('Location: form.php');
}
// Here we only pretend that we are also performing a check to see whether the credit card is valid!


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Thank you!</title>
    </head>
    <body>

<?php
echo '<p><a href="index.php">home</a></p>';
        
include('admin/connect.php');

$fname = $_POST["name"];
$faddress = $_POST["address"];
$creditcard = $_POST["creditcard"];

$fstring = $fname . $faddress . $creditcard;
$ticket = md5(uniqid($fstring, true));

$_fname = mysqli_real_escape_string($conn, $fname);
$_faddress = mysqli_real_escape_string($conn, $faddress);
$_creditcard = mysqli_real_escape_string($conn, $creditcard);

$sql = "INSERT INTO Attenders (name, address, creditcard, ticket) VALUES ('$_fname','$_faddress','$_creditcard','$ticket')";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Thank you!</h1>";
    echo htmlspecialchars($fname) . "<br>";
    echo htmlspecialchars($faddress) . "<br>";
    echo "<h1>You have been signed up to the event!</h1>";
    echo "Here is your Ticket-number: <br><br>" . htmlspecialchars($ticket) . "<br>";


} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

    </body>
</html>

