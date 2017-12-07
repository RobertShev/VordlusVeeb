<?php
	require("config.php");
	$database = "if17_ttaevik_2";
	
	//loeme toimetamiseks mõyye

	function getUserData($editId){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT pcname, pccpu, pcgpu, storage FROM computers WHERE id=?");
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($pcname, $pccpu, $pcgpu, $storage);
		$stmt->execute();
		$ideaObject = new Stdclass();
		if($stmt->fetch()){

			$ideaObject->name = $pcname;
			$ideaObject->cpu = $pccpu;
			$ideaObject->gpu = $pcgpu;
			$ideaObject->storage = $storage;
			
		}
		
		$stmt->close();
		$mysqli->close();
		return $ideaObject;
		
		
	}
	
	function updateIdea($id, $pcname, $pccpu, $pcgpu, $storage){
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
	
	function deleteIdea($id){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE computers SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		$stmt->close();
	$mysqli->close();}
?>