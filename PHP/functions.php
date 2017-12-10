<?php
	require("config.php");
	$database = "if17_ttaevik_2";
	
	//alustamse sessiooni
	session_start();
	
	function signIn($email, $password){
		$notice = "";
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		
		$stmt = $mysqli->prepare("SELECT userid, firstname, lastname, email, password FROM userid WHERE email = ?");
		$stmt->bind_param("s", $email);
		$stmt->bind_result($id, $firstnameFromDb, $lastnameFromDb, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		//kontrollime vastavust
		if ($stmt->fetch()){
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb){
				$notice = "Logisite sisse!";
				
				//Määran sessiooni muutujad
				$_SESSION["userId"] = $id;
				$_SESSION["firstname"] = $firstnameFromDb;
				$_SESSION["lastname"] = $lastnameFromDb;
				$_SESSION["userEmail"] = $emailFromDb;
				
				//lähen pealehele
				header("Location: main.php");
				exit();
				
			} else {
				$notice = "Vale salasõna!";
			}
		} else {
			$notice = "Sellise e-postiga kasutajat pole!";
		}
		
		$stmt->close();
		$mysqli->close();
		return $notice;
	}
	
	function signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword){
		//loome andmebaasiühenduse
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO userid (email, password, firstname, lastname) VALUES (?, ?, ?, ?)");
		echo $mysqli->error;
		//s - string
		//i - integer
		//d - decimal
		$stmt->bind_param("ssss",$signupEmail, $signupPassword, $signupFirstName, $signupFamilyName);
		//$stmt->execute();
		if ($stmt->execute()){
			echo "\n Õnnestus!";
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}
	

	//Changedata.php kuulutuste kuvamine
	function readAllData(){
		$pcdata = "";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt = $mysqli->prepare("SELECT id, pcname, pccpu, pcgpu, storage FROM computers WHERE email = ? AND deleted IS NULL ORDER BY id DESC");
		$stmt->bind_param("s", $_SESSION["userEmail"]);
		
		$stmt->bind_result($id, $pcname, $pccpu, $pcgpu, $storage);
		$stmt->execute();
		while ($stmt->fetch()){
			$pcdata .="Nimi: ". $pcname. "  Protsessor: ". $pccpu. "  Graafikakaart: ". $pcgpu. "  Kõvaketas: ". $storage .' | <a href="editpcdata.php?id=' .$id .'&pcname=' .$pcname .'&pccpu=' .$pccpu .'&pcgpu=' .$pcgpu .'&storage=' .$storage .'">Toimeta</a>' ."</p> \n";
			
		}
		
		$stmt->close();
		$mysqli->close();
		return $pcdata;
	}
	
	//Timeline2.php kõigi kuulutuste kuvamine tabelina
	
		function createDataTable(){
		$table = '<table border="1" style="border: 1px solid black; border-collapse: collapse">' ."\n";
		$table .= "<tr> \n <th>ID</th><th>Nimetus</th><th>Protsessor</th><th>Graafikakaart</th><th>Kõvaketas</th> \n </tr> \n";
		
		
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $mysqli->prepare("SELECT id, pcname, pccpu, pcgpu, storage FROM computers WHERE deleted IS NULL ORDER BY id DESC");
		$stmt->bind_result($id, $pcname, $pccpu, $pcgpu, $storage);
		$stmt->execute();
		
		while($stmt->fetch()){
			$table .= "<tr> \n <td>" .$id ."</td><td>" .$pcname ."</td><td>" .$pccpu ."</td><td>" .$pcgpu ."</td><td>" .$storage ."</td> \n </tr>";
		}
		
		$table .= "</table> \n";
		$stmt->close();
		$mysqli->close();
		return $table;
	}
	
	
	
	//sisestuse kontrollimise funktsioon
	function test_input($data){
		$data = trim($data);//liigsed tühikud, TAB, reavahetuse jms
		$data = stripslashes($data);//eemaldab kaldkriipsud "\"
		$data = htmlspecialchars($data);
		return $data;
	}

?>