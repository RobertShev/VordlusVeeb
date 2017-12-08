<?php
	require("config.php");
	$database = "if17_ttaevik_2";
	
	

	function getUserData($editId){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT pcname, pccpu, pcgpu, storage FROM computers WHERE id=?");
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($pcname, $pccpu, $pcgpu, $storage);
		$stmt->execute();
		$infoObject = new Stdclass();
		if($stmt->fetch()){

			$infoObject->name = $pcname;
			$infoObject->cpu = $pccpu;
			$infoObject->gpu = $pcgpu;
			$infoObject->storage = $storage;
			
		}
		
		$stmt->close();
		$mysqli->close();
		return $infoObject;
		
		
	}
	
	function updateInfo($id, $pcname, $pccpu, $pcgpu, $storage){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE computers SET pcname=?, pccpu=?, pcgpu=?, storage=? WHERE id=?");
		$stmt->bind_param("ssssi", $pcname, $pccpu, $pcgpu, $storage, $id);
		if($stmt->execute()){
			echo "Õnnestus";
		} else {
			echo "Tekkis viga: " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}
	
	function deleteInfo($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE computers SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		$stmt->close();
	$mysqli->close();}
?>