<?php
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
	    echo "<table><tr><th>ID</th><th>Name</th><th>Birthday</th><th>email</th></tr>";
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo "<tr><td>".$row["id"]."</td><td>".$row["pcname"]." ".$row["pccpu"]."</td><td>".$row["pcgpu"]."</td><td>".$row["storage"]."</td></tr>";
	    }
	    echo "</table>";
	} else {
	    echo "0 results";
	}
	$conn->close();
	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>

	</title>
</head>
<body>

	<p>See veebileht on loodud ÃµppetÃ¶Ã¶ raames ning ei sisalda tÃµsiseltvÃµetavat sisu.</p>
	<p><a href="?logout=1">Logi vÃ¤lja</a></p>
	<p><a href="main.php">Pealeht</a></p>
</body>
</html>
