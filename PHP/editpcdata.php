<?php

	require("functions.php");
	require("changedatafunctions.php");
	$notice= "";

	
	//kui pole sisse logitud, liigume login lehele
	if(!isset($_SESSION["userId"])){
		header("Location: main.php");
		exit();
	}
	
	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy(); //lõpetab sessiooni
		header("Location: main.php");
		
	}
	
	//kui klõpsati uuendamise nuppu
	if(isset($_POST["ideaBtn"])){
		updateIdea($_POST["id"],test_input($_POST["name"]),($_POST["cpu"]),($_POST["gpu"]),($_POST["storage"]));
		header("Location: changedata.php");
		exit();
	}
	
	//kontrollib kas mõte kustutatakse
	if(isset($_GET["delete"])){
		deleteIdea($_GET["id"]);
		header("Location: changedata.php");
		exit();
	}
	
	$userdata = getUserData($_GET["id"]);

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

		<h2> Muuda andmeid: </h2>
	
	
	<h2>Kuulutuse muutmine:</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
	
	<label>kuulutus: </label>
	<textarea name ="dsf" ><?php echo $userdata->name; ?></textarea>
	<textarea name ="cpu" ><?php echo $userdata->cpu; ?></textarea>
	<textarea name ="gpu" ><?php echo $userdata->gpu; ?></textarea>
	<textarea name ="storage" ><?php echo $userdata->storage; ?></textarea>
	<br>
	
	
	<br>
	<input name="ideaBtn" type="submit" value="Salvesta kuulutus"><span><?php echo $notice; ?></span>
	
	</form>
	
	<p><a href= "?id=<?=$_GET["id"];?>&delete=true">Kustuta see kuulutus</a>!</p>
	<hr>
	</body>