<?php

	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy(); //lõpetab sessiooni
		header("Location: main.php");
	}
	
	require("functions.php");
	require("config.php");
	$database = "if17_ttaevik_2";
	
	$alldata = createDataTable();

	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Sisestatud kuulutused</title>
</head>

<body>


	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="changedata.php">Muuda kuulutust</a></p>
	<p><a href="insert.php">Sisesta kuulutus</a></p>
	<hr>
	<center>	
	<p>Kuulutuste vaatamine</p>
	


	
	<div style="width 40%">
		<?php echo $alldata; ?>
	</div>
	
	</center>
</body>
</html>
