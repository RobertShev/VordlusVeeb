
<?php
//$mysqli defineerimata


$servername = "localhost";
$username = "if17";
$password = "if17";
$dbname = "if17_ttaevik_2";
// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);


	if(isset($_POST["submit"])){
		
		if(isset($_POST["nimetus"]) and isset($_POST["kirjeldus"])){
			echo $_POST["nimetus"];
			
			$stmt = $mysqli->prepare("INSERT INTO computers (pcname, pccpu, pcgpu, storage) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("sssi", $_POST["pcname"], $_POST["pccpu"],$_POST["pcgpu"],$_POST["storage"]);
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
	<p> Palun sisesta andmed: </p>
		<label>Nimetus</label> 
		<input type="text" name= "pcname">
		<br><br>
		<label>Protsessor</label> 
		<input type="text" name= "pccpu">
		<br><br>
		<label>Graafikakaart</label> 
		<input type="text" name= "pcgpu">
		<br><br>
		<label>Kõvaketas</label> 
		<input type="text" name= "storage">
		<br><br>
		<input name="submit" type="submit" value="Sisesta">
		
	</form>