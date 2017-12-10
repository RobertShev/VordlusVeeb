<?php

	require("functions.php");


	//kui on juba sisseloginud
	if(isset($_SESSION["userId"])){
		header("Location: insert.php");
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

			$notice = signIn($loginEmail, $_POST["loginPassword"]);

		}

	}//if loginButton

	//KAS VAJUTATI signupButton-it
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
			//polnud tühi
			if (strlen($_POST["signupPassword"]) < 8){
				$signupPasswordError = "NB! Liiga lühike salasõna, vaja vähemalt 8 tähemärki!";
			}
		}
	}



	//UUE KASUTAJA ANDMEBAASI KIRJUTAMINE
	if (empty($signupFirstNameError) and empty($signupFamilyNameError) and empty($signupBirthDayError) and empty($signupGenderError) and empty($signupEmailError) and empty($signupPasswordError)){
		echo "Hakkan salvestama!";
		//krüpteerin parooli
		$signupPassword = hash("sha512", $_POST["signupPassword"]);
		//echo "\n Parooli " .$_POST["signupPassword"] ." räsi on: " .$signupPassword;
		signUp($signupFirstName, $signupFamilyName, $signupBirthDate, $gender, $signupEmail, $signupPassword);
	}

	} //kas vajutati loo kasutaja nuppu





?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Vordlusveeb</title>
	<link href="css/style.css" rel='stylesheet' type='text/css'/>
		<link href="//fonts.googleapis.com/css?family=Ropa+Sans:400,400i&amp;subset=latin-ext" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Simple Tab Forms Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<script src="js/jquery.min.js"></script>
				<script type="text/javascript">
					$(document).ready(function () {
						$('#horizontalTab').easyResponsiveTabs({
							type: 'default', //Types: default, vertical, accordion
							width: 'auto', //auto or any width like 600px
							fit: true   // 100% fit in a container
						});
					});
				</script>
</head>
<body>
	<h1>VõrdlusVeeb</h1>
	<div class="main-content">

		<div class="right-w3">
	<div class="sap_tabs">
		<div id="horizontalTab" style="display: block; width: 100%; margin: 0px;">
			<ul>
				<li class="resp-tab-item" aria-controls="tab_item-0" role="tab"><span>Loo konto</span></li>
				<li class="resp-tab-item" aria-controls="tab_item-1" role="tab"><span>Logi sisse</span></li>
				<div class="clear"></div>
			</ul>
			<div class="agile-tb">
				<div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
					<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
						<input placeholder="Eesnimi" name="signupFirstName" value="<?php echo $signupFirstName; ?>" type="text" required="">
						<span><?php echo $signupFirstNameError; ?></span>
						<input placeholder="Perekonnanimi"name="signupFamilyName" type="text" value="<?php echo $signupFamilyName; ?>" required="">
						<span><?php echo $signupFamilyNameError; ?></span>
						<input placeholder="E-mail" name="signupEmail" type="text" value="<?php echo $signupEmail; ?>" required="">
						<span><?php echo $signupEmailError; ?></span>
						<input placeholder="Parool" name="signupPassword" type="password" required="">
						<span><?php echo $signupPasswordError; ?></span>

						<input type="submit" name="signupButton" value="Loo kasutaja"/>
					</form>
				</div>
				<div class="tab-2 resp-tab-content" aria-labelledby="tab_item-1">
					<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" >
						<input placeholder="E-mail" name="loginEmail" class="mail" type="text" required="">
						<input placeholder="Salasõna" name="loginPassword" class="lock" type="password" required="">
						<input  name="loginButton" type="submit" value="Logi sisse"><span><?php echo $notice; ?></span>
					</form>
				 </div>
			 </div>
		</div>
		</div>
		</div>
		</div>

		<div class="footer">
			<p> &copy; 2017 Simple Tab Forms. All Rights Reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
		</div>
			<script src="js/easyResponsiveTabs.js" type="text/javascript"></script>
		</body>
		</html>
