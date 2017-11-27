<?php
require("../../../config.php");
require("functions.php");
	//echo $serverHost;

	//kui on juba sisseloginud
	if(isset($_SESSION["userId"])){
		header("Location: main.php");
		exit();
	}
	$signupFirstName = "";
	$signupFamilyName = "";
	$signupEmail = "";

	$loginEmail = "";
	$notice="!";
	$signupFirstNameError = "";
	$signupFamilyNameError = "";
	$signupEmailError = "";
	$signupPasswordError = "";

	$loginEmailError ="";

	if(isset($_POST["loginButton"])){
		//kas on kasutajanimi sisestatud
		if (isset ($_POST["loginEmail"])){
			if (empty ($_POST["loginEmail"])){
				$loginEmailError ="NB! Sisselogimiseks on 	vajalik kasutajatunnus (e-posti aadress)!";
			} else {
				$loginEmail = $_POST["loginEmail"];
			}
		}

		if(!empty($loginEmail) and !empty($_POST["loginPassword"])){
			//echo "Alustan sisselogimist!";
			//$hash = hash("sha512", $_POST["loginEmail"]);
			$notice = signIn($loginEmail, $_POST["loginPassword"]);
			//$notice = signIn($loginEmail, $hash);
		}

	}//if loginButton

	//kas klikiti kasutaja loomise nupul
	if(isset($_POST["signupButton"])){

	//kontrollime, kas kirjutati eesnimi
	if (isset ($_POST["signupFirstName"])){
		if (empty($_POST["signupFirstName"])){
			$signupFirstNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFirstName = test_input($_POST["signupFirstName"]);
		}
	}

	//kontrollime, kas kirjutati perekonnanimi
	if (isset ($_POST["signupFamilyName"])){
		if (empty($_POST["signupFamilyName"])){
			$signupFamilyNameError ="NB! Väli on kohustuslik!";
		} else {
			$signupFamilyName = test_input($_POST["signupFamilyName"]);
		}
	}

	//kontrollime, kas kirjutati kasutajanimeks email
	if (isset ($_POST["signupEmail"])){
		if (empty ($_POST["signupEmail"])){
			$signupEmailError ="NB! Väli on kohustuslik!";
		} else {
			$signupEmail = test_input($_POST["signupEmail"]);

			$signupEmail = filter_var($signupEmail, FILTER_SANITIZE_EMAIL);
			$signupEmail = filter_var($signupEmail, FILTER_VALIDATE_EMAIL);
		}
	}

	if (isset ($_POST["signupPassword"])){
		if (empty ($_POST["signupPassword"])){
			$signupPasswordError = "NB! Väli on kohustuslik!";
		} else {
			//polnud tÃ¼hi
			if (strlen($_POST["signupPassword"]) < 8){
				$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}
	//UUE KASUTAJA ANDMEBAASI KIRJUTAMINE, kui kÃµik on olemas
	if (empty($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) and empty($signupPasswordError)){
		echo "Hakkan salvestama!";
		//krÃ¼pteerin parooli
		$signupPassword = hash("sha512", $_POST["signupPassword"]);
		//echo "\n Parooli " .$_POST["signupPassword"] ." rÃ¤si on: " .$signupPassword;
		signUp($signupEmail, $signupPassword, $signupFirstName, $signupFamilyName);
	}

	} //kas vajutati loo kasutaja nuppu


?>
<!DOCTYPE html>
<html>
<head>
</head>
	<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Kasutajanimi (E-post): </label>
		<input name="loginEmail" type="email" value="<?php echo $loginEmail; ?>">
		<br><br>
		<input name="loginPassword" placeholder="Salasõna" type="password"><span></span>
		<br><br>
		<input name="loginButton" type="submit" value="Logi sisse"><span><?php echo $notice; ?></span>
	</form>

	<h2>Loo kasutaja</h2>
	<p>Kui pole veel kasutajat....</p>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Eesnimi </label>
		<input name="signupFirstName" type="text" value="<?php echo $signupFirstName; ?>">
		<span><?php echo $signupFirstNameError; ?></span>
		<br>
		<label>Perekonnanimi </label>
		<input name="signupFamilyName" type="text" value="<?php echo $signupFamilyName; ?>">
		<span><?php echo $signupFamilyNameError; ?></span>
		<br>
		<label>Kasutajanimi (E-post)</label>
		<input name="signupEmail" type="email" value="<?php echo $signupEmail; ?>">
		<span><?php echo $signupEmailError; ?></span>
		<br><br>
		<input name="signupPassword" placeholder="Salasõna" type="password">
		<span><?php echo $signupPasswordError; ?></span>
		<br><br>


		<input name="signupButton" type="submit" value="Loo kasutaja">
	</form>

	</body>
</html>
