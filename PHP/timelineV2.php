<?php
	require("functions2.php");
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
	    echo "<div class='timeline'><div class='container left'>";
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo "<div class='content'>".$row["id"]."<h2>".$row["pcname"]."</h2><h2>".$row["pccpu"]."</h2><h2>".$row["pcgpu"]."</h2><h2>".$row["storage"]."</h2>";
	    }
	    echo "</div>";
	} else {
	    echo "0 results";
	}
	$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="timelineV2.css">
</head>
<body>
  <div class="timeline">
  <div class="container left">
    <div class="content">
      <h2>2017</h2>
      <p>Lorem ipsum..</p>
    </div>
  </div>
</body>
  <div class="container right">
    <div class="content">
      <h2>2016</h2>
      <p>Lorem ipsum..</p>
    </div>
  </div>
</div>
</html>
