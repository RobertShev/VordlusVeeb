<?php
require("../../../config.php");
$database = "ttaevik_2";
session_start();

function signIn($email, $password){
  $notice = "";

  $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

  $stmt = $mysqli->prepare("SELECT userid, email, password, firstname, lastname,  FROM  WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->bind_result($userid, $emailFromDb, $passwordFromDb, $firstnameFromDb, $lastnameFromDb);
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

function signUp($signupFirstName, $signupFamilyName, $signupEmail, $signupPassword){
  //loome andmebaasiühenduse

  $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
  //valmistame ette käsu andmebaasiserverile
  $stmt = $mysqli->prepare("INSERT INTO userid (email, password, firstname, lastname) VALUES (?, ?, ?, ?)");
  echo $mysqli->error;
  //s - string
  //i - integer
  //d - decimal
  $stmt->bind_param("ssss", $signupEmail, $signupPassword, $signupFirstName, $signupFamilyName);
  //$stmt->execute();
  if ($stmt->execute()){
    echo "\n Õnnestus!";
  } else {
    echo "\n Tekkis viga : " .$stmt->error;
  }
  $stmt->close();
  $mysqli->close();
}

?>
