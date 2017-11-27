
<?php


require("functions.php");
$database = "if17_ttaevik_2";

// Create connection
$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);


	if(isset($_POST["submit"])){
		
		if(isset($_POST["pcname"]) and isset($_POST["pccpu"]) and isset($_POST["pcgpu"]) and isset($_POST["storage"])){
			//echo $_POST["pcname"];
			
			$stmt = $mysqli->prepare("INSERT INTO computers (pcname, pccpu, pcgpu, storage) VALUES (?, ?, ?, ?)");
			echo $mysqli->error;
			$stmt->bind_param("sssi", $_POST["pcname"], $_POST["pccpu"],$_POST["pcgpu"],$_POST["storage"]);
			$stmt->execute();
			echo $stmt->error;
			echo $_POST["pcname"];		
		}
	
	$stmt->close();
	$mysqli->close();	
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
	<center>
	<p><strong>Palun sisesta andmed: </strong></p>
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
	</center>
	</form>