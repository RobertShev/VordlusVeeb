<?php

require("functions.php");

$database = "if17_ttaevik_2";

	//väljalogimine
	if(isset($_GET["logout"])){
		session_destroy(); //lõpetab sessiooni
		header("Location: main2.php");
	}
	
// Create connection
$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);


	if(isset($_POST["submit"])){
		
		if(isset($_POST["pcname"]) and isset($_POST["pccpu"]) and isset($_POST["pcgpu"]) and isset($_POST["storage"])){
			//echo $_POST["pcname"];
			
			$stmt = $mysqli->prepare("INSERT INTO computers (pcname, pccpu, pcgpu, storage,email) VALUES (?, ?, ?, ? ,?)");
			echo $mysqli->error;
			$stmt->bind_param("sssis", $_POST["pcname"], $_POST["pccpu"],$_POST["pcgpu"],$_POST["storage"], $_POST["email"]);
			$stmt->execute();
			echo $stmt->error;
			echo $_POST["pcname"];		
		}
	
	$stmt->close();
	$mysqli->close();	
	}

	//FOTOUPLOADˇ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ˇ
	

	require("photoupload.class.php");
	$notice = "";
	
	
	//kui pole sisseloginud, siis sisselogimise lehele
	if(!isset($_SESSION["userId"])){
		header("Location: main2.php");
		exit();
	}
	
	//kui logib välja
	if (isset($_GET["logout"])){
		//lõpetame sessiooni
		session_destroy();
		header("Location: main2.php");
	}
	
	//Algab foto laadimise osa
	$target_dir = "../pics/";
	$target_file = "";
	$uploadOk = 1;
	$imageFileType = "";
	$maxWidth = 600;
	$maxHeight = 400;
	$marginVer = 10;
	$marginHor = 10;
	
	//Kas vajutati üleslaadimise nuppu
	if(isset($_POST["uploadsubmit"])) {
		
		if(!empty($_FILES["fileToUpload"]["name"])){
			
			//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			$imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]))["extension"]);
			$timeStamp = microtime(1) *10000;
			//$target_file = $target_dir . pathinfo(basename($_FILES["fileToUpload"]["name"]))["filename"] ."_" .$timeStamp ."." .$imageFileType;
			$target_file = "pic_" .$timeStamp ."." .$imageFileType;
		
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if($check !== false) {
				$notice .= "Fail on pilt - " . $check["mime"] . ". ";
				$uploadOk = 1;
			} else {
				$notice .= "See pole pildifail. ";
				$uploadOk = 0;
			}
		
			//Kas selline pilt on juba üles laetud
			if (file_exists($target_file)) {
				$notice .= "Kahjuks on selle nimega pilt juba olemas. ";
				$uploadOk = 0;
			}
			//Piirame faili suuruse
			/*if ($_FILES["fileToUpload"]["size"] > 1000000) {
				$notice .= "Pilt on liiga suur! ";
				$uploadOk = 0;
			}*/
			
			//Piirame failitüüpe
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$notice .= "Vabandust, vaid jpg, jpeg, png ja gif failid on lubatud! ";
				$uploadOk = 0;
			}
			
			//Kas saab laadida?
			if ($uploadOk == 0) {
				$notice .= "Vabandust, pilti ei laetud üles! ";
			//Kui saab üles laadida
			} else {		
								
				//kasutame klassi
				$myPhoto = new Photoupload($_FILES["fileToUpload"]["tmp_name"], $imageFileType);
				$myPhoto->readExif();
				$myPhoto->resizeImage($maxWidth, $maxHeight);
				$myPhoto->addWatermark($marginHor, $marginVer);
				//$myPhoto->addTextWatermark($myPhoto->exifToImage);
				$myPhoto->addTextWatermark("Heade mõtete veeb");
				$notice = $myPhoto->savePhoto($target_dir, $target_file);
				if($notice == "true"){
					$notice = "Pilt laeti üles!";
				} else {
					$notice = "Pildi üleslaadimine ebaõnnestus!";
				}
				//$myPhoto->saveOriginal(kataloog, failinimi);
				$myPhoto->clearImages();
				unset($myPhoto);
				
			}
		
		} else {
			$notice = "Palun valige kõigepealt pildifail!";
		}//kas faili nimi on olemas lõppeb
	}//kas üles laadida lõppeb


?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Kuulutuse lisamine</title>
</head>
<body>


	<p><a href="?logout=1">Logi välja</a></p>
	<p><a href="changedata.php">Muuda kuulutust</a></p>
	<p><a href="timeline2.php">Vaata kuulutusi</a></p>
	<hr>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<center>
	<p><strong>Sisesta müüdava arvuti andmed: </strong></p>
		<label>Nimetus</label> 
		<input type="text" name= "pcname">
		<br><br>
		<label>Protsessor</label> 
		<input type="text" name= "pccpu">
		<br><br>
		<label>Graafikakaart</label> 
		<input type="text" name= "pcgpu">
		<br><br>
		<label>Kõvaketta maht(GB)</label> 
		<input type="text" name= "storage">
		<br><br>
		<label>Email</label> 
		<input type="text" name= "email">
		<br><br>
		<input name="submit" type="submit" value="Sisesta">
		<br><br>
		<br><br>
		<label>Valige pildifail:</label>
		<input type="file" name="fileToUpload" id="fileToUpload">
		<input type="submit" value="Lae üles" name="uploadsubmit" id="photoSubmit"><span id="fileSizeError"></span>
				
		

	
<span><?php echo $notice; ?></span>
		
		
	</center>	
	</form>
	
	
	</body>