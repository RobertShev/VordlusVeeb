<?php

	require("functions.php");
	
	$notice= "";
	$ideas="";
	
	//kui pole sisse logitud, liigume login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: login.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy(); //lõpetab sessiooni
		header("Location: login.php");
		
	}
	
	//kas vajutati mõtte salvestamise nuppu
	if(isset($_POST["ideaBtn"])){
		
		if(isset($_POST["userIdeas"]) and isset($_POST["ideaColor"]) and !empty($_POST["userIdeas"]) and !empty($_POST["ideaColor"])){
			//echo $_POST["ideaColor"];
			
			$notice = saveIdea(test_input($_POST["userIdeas"]),$_POST["ideaColor"]);
		}
	
	
	}
	$userdata= readAllData();
?>
	
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
	
	<center>
		<h2> Muuda andmeid: </h2>
		<p><strong> Teie poolt sisestatud kuulutused:</strong></p>
			
<p></p>
	<div style="width 40%">
		<?php echo $userdata; ?>
	</div>
	</center>	
		
		
	</body>