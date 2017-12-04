<?php
	require("../../../config.php");
	$database = "if17_sevtrobe";

	//alustamse sessiooni
	session_start();

	function signIn($email, $password){
		$notice = "";

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, firstname, lastname, email, password FROM vpusers WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $firstnameFromDb, $lastnameFromDb, $emailFromDb, $passwordFromDb);
		$stmt->execute();

		//kontrollime vastavust
		if ($stmt->fetch()){
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb){
				$notice = "Logisite sisse!";

				//MÃ¤Ã¤ran sessiooni muutujad
				$_SESSION["userId"] = $id;
				$_SESSION["firstname"] = $firstnameFromDb;
				$_SESSION["lastname"] = $lastnameFromDb;
				$_SESSION["userEmail"] = $emailFromDb;
				$_SESSION["gender"] = $genderFromDb;
				$_SESSION["birthday"] = $birthdayFromDb;

				//lÃ¤hen pealehele
				header("Location: main.php");
				exit();

			} else {
				$notice = "Vale salasÃµna!";
			}
		} else {
			$notice = "Sellise e-postiga kasutajat pole!";
		}

		$stmt->close();
		$mysqli->close();
		return $notice;
	}

	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
		//loome andmebaasiÃ¼henduse

		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette kÃ¤su andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthday, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("sssiss", $signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Ã•nnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}

	//hea mÃµtte salvestamise funktsioon
	function saveIdea($idea, $color){
		$notice = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("INSERT INTO vpuserideas (userid, idea, ideacolor) VALUES(?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("iss", $_SESSION["userId"], $idea, $color);
		if($stmt->execute()){
			$notice = "MÃµte on salvestatud!";
		} else {
			$notice = "Salvestamisel tekkis tÃµrge: " .$stmt->error;
		}

		$stmt->close();
		$mysqli->close();
		return $notice;
	}

	function readAllIdeas(){
		$ideas = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas");//absoluutselt kÃµigi mÃµtted
		//$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas WHERE userid = ?");
		$stmt = $mysqli->prepare("SELECT idea, ideacolor FROM vpuserideas WHERE userid = ? ORDER BY id DESC");
		$stmt->bind_param("i", $_SESSION["userId"]);

		$stmt->bind_result($idea, $color);
		$stmt->execute();
		while ($stmt->fetch()){
			$ideas .= '<p style="background-color: ' .$color .'">' .$idea ."</p> \n";
		}

		$stmt->close();
		$mysqli->close();
		return $ideas;
	}


	function readLastIdea(){
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT idea FROM vpuserideas WHERE id = (SELECT MAX(id) FROM vpuserideas)");
		$stmt->bind_result($idea);
		$stmt->execute();
		$stmt->fetch();
		$stmt->close();
		$mysqli->close();
		return $idea;
	}

	//sisestuse kontrollimise funktsioon
	function test_input($data){
		$data = trim($data);//liigsed tÃ¼hikud, TAB, reavahetuse jms
		$data = stripslashes($data);//eemaldab kaldkriipsud "\"
		$data = htmlspecialchars($data);
		return $data;
	}

	/// Kasutaja andme tabel
		function createUsersTable(){

		}
	/*
	$x = 7;
	$y = 4;
	echo "Esimene summa on: " .($x + $y) ."\n";
	addValues();

	function addValues(){
	echo "Teine summa on: " .($GLOBALS["x"] + $GLOBALS["y"]) ."\n";
		$a = 3;
		$b = 2;
		echo "Kolmas summa on: " .($a + $b) ."\n";
		$x = 1;
		$y = 2;
		echo "Hoopis teine summa on: " .($x + $y) ."\n";
	}
	echo "Neljas summa on: " .($a + $b) ."\n";
	*/
?>
