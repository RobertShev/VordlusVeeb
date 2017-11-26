
<!DOCTYPE html>
<html>
<body>

<?php
class Komponent {
    public $nimetus = 'parent';
    public $kirjeldus = 'kfassfa';

    function setSomething($s)
    {
        $this->nimetus = $s;
        return true;
    }

}

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
$heihoo = array();
while($stmt->fetch())
{

    //echo $reebok ." ". $nike . $adidas . $kappa;
    $testime = new Komponent();
    $testime->kirjeldus = $reebok;
    $testime->nimetus = $nike;

    echo $testime->kirjeldus;
}



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
