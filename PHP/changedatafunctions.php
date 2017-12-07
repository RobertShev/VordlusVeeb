<?php
	require("config.php");
	$database = "if17_ttaevik_2";
	
	//loeme toimetamiseks mõyye
	//getSingleIdea
	function getData($editId){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT pcname, pccpu, pcgpu, storage FROM computers WHERE id=?");
		$stmt->bind_param("i", $editId);
		$stmt->bind_result($pcname, $pccpu, $pcgpu, $storage);
		$stmt->execute();
		$ideaObject = new Stdclass();
		if($stmt->fetch()){
			$ideaObject->text = $pcname;
			$ideaObject->text = $pccpu;
			$ideaObject->text = $pcgpu;
			$ideaObject->text = $storage;

		}
		
		$stmt->close();
		$mysqli->close();
		return $ideaObject;
		
	}
	
	function updateIdea($id, $idea, $ideacolor){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("UPDATE vp2userideas SET idea=?, ideacolor=? WHERE id=?");
		$stmt->bind_param("ssi", $idea, $ideacolor, $id);
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
		$stmt = $mysqli->prepare("UPDATE vp2userideas SET deleted=NOW() WHERE id=?");
		$stmt->bind_param("i", $id);
		$stmt->execute();
		
		$stmt->close();
		$mysqli->close();
	}
	
?>
