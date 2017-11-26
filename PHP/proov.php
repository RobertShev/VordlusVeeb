
<?php
//$mysqli defineerimata


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "andmebaas";
// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);


	if(isset($_POST["submit"])){
		
		if(isset($_POST["nimetus"]) and isset($_POST["kirjeldus"])){
			echo $_POST["nimetus"];
			
			$stmt = $mysqli->prepare("INSERT INTO komponent (nimetus, kirjeldus) VALUES (?, ?)");
			$stmt->bind_param("ss", $_POST["nimetus"], $_POST["kirjeldus"]);
			$stmt->execute();			
		}
		
	}



?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>sisesta andmed</title>
</head>
<body>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<p> sisesta andmed: </p>
		<label>Nimetus</label> 
		<input type="text" name= "nimetus">
		<br><br>
		<label>kirjeldus</label> 
		<input type="text" name= "kirjeldus">
		<br><br>
		<input name="submit" type="submit" value="Sisesta">
		
	</form>