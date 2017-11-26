
<!DOCTYPE html>
<html>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "andmebaas";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($mysqli->connect_error)
    {
    echo "connection failed";
    }
else
    {
        echo "Connection successful!";
    }

$stmt = $mysqli->prepare("SELECT * FROM komponent");
$stmt->execute();
$stmt -> bind_result($reebok, $nike, $adidas, $kappa);
$stmt->fetch();
echo $reebok ." ". $nike . $adidas . $kappa;
$stmt->close();
$mysqli->close();

if (isset($_POST['nimetus']))
{
    $tsau = $_POST['nimetus'];
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $stmt = $mysqli->prepare("INSERT INTO komponent (nimetus, kirjeldus) VALUES (?, ?)");
    echo $mysqli->error;
    $stmt->bind_param("ss", $_POST['nimetus'], $_POST['nimetus']);
    $stmt->execute();
    echo $mysqli->error;
    $stmt->close();
    $mysqli->close();
}

?>


<form action= "" method="post">

    <input type="text" name="nimetus"><br/>

</form>
</body>
</html>
