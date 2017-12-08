<?php

	require("functions.php");
	

	

	if(!isset($_SESSION["userId"])){
		header("Location: main.php");
		exit();
	}
	

	if(isset($_GET["logout"])){
		session_destroy(); //lõpetab sessiooni
		header("Location: main.php");
		
	}
	

	$userdata= readAllData();

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
	<p><a href="timeline2.php">Vaata kuulutusi</a></p>
	<hr>
	
	<center>
		<h2> Muuda oma kuulutuste andmeid: </h2>
		<p><strong> Teie poolt sisestatud kuulutused:</strong></p>
			
<p></p>

		<?php echo $userdata; ?>
	
	</center>	
		
		
	</body>