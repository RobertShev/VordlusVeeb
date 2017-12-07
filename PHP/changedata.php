<?php


	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy(); //lõpetab sessiooni
		header("Location: main.php");
	}
	

	
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Muuda kuulutust</title>
</head>
<body>


	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="insert.php">Kuulutuse sisestamine</a></p>
	
<center>
		<p><strong>Muuda andmeid: </strong></p>

	</center>	
		
		
	</body>