<?php

	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy(); //lõpetab sessiooni
		header("Location: main.php");
	}
	
	require("functions.php");
	require("config.php");
	$database = "if17_ttaevik_2";

	// Create connection
	$conn =  new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT id, pcname, pccpu, pcgpu, storage FROM computers";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	    echo "<table><tr><th>ID</th><th>Nimi</th><th>Protsessor</th><th>Graafikakaart</th><th>Kõvaketas</th></tr>";
	    // output data of each row
	    	echo "<select>";

		while($row = $result->fetch_assoc()) {
			echo '<option name="pcs" value="' . $row["id"] . '">' . $row["pcname"] .'</option>';
			
		  //  echo "<tr><td>".$row["id"]."</td><td>".$row["pcname"]." ".$row["pccpu"]."</td><td>".$row["pcgpu"]."</td><td>".$row["storage"]."</td></tr>";
	    }
			    	echo "</select>";

	    echo "</table>";
	} else {
	    echo "0 results";
	}
	$conn->close();
	?>ˇ
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>

	</title>
</head>

<body>


	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="changedata.php">Muuda kuulutust</a></p>
	<p><a href="insert.php">Sisesta kuulutus</a></p>
	<center>	
	<p>Kuulutuste vaatamine2</p>
	</center>
	

</body>
</html>
