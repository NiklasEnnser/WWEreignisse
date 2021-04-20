<?php
$username = '';
$host     = 'localhost'; // host
$usernameAnmeldung = 'root'; // username
$anmeldungpassword = ''; // password
$database = 'events'; // database

// mit Datenbank verbinden
$mysqli = new mysqli($host, $usernameAnmeldung,$anmeldungpassword, $database);

// fehlermeldung, falls die Verbindung fehl schlägt.
if ($mysqli->connect_error) {
die('Connect Error (' . $mysqli->connect_error . ') '. $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)&& isset($_POST['register_submit'])&& isset($_POST['register_name']) && isset($_POST['register_year'])&& isset($_POST['register_password'])&& isset($_POST['register_email'])){
  $error = '';

  if(!empty(trim($_POST['register_name']))){
    $register_name = $_POST['register_name'];
  } else {$error .= "bad request!";}

  if(!empty(trim($_POST['register_year']))){
    $register_year = trim($_POST['register_year']);
  } else {$error .= "bad request!";}

  if(!empty(trim($_POST['register_email']))){
    $register_email = trim($_POST['register_email']);
  } else {$error .= "bad request!";}

  if(!empty(trim($_POST['register_password']))){
    $register_password = trim($_POST['register_password']);
    $hash_password = password_hash($register_password, PASSWORD_DEFAULT);
  } else {$error .= "bad request!";}

  if(empty($error)){

      $queryte = "INSERT INTO `tbl_user`(`email`, `name`, `password`, `year`) VALUES (?,?,?,?)";
      $stmtte = $mysqli->prepare($queryte);
      $stmtte->bind_param("sssi",$register_email, $register_name, $hash_password, $register_year);
      $bool = $stmtte->execute();
      $stmtte->close();
      $_SESSION["message"] = "you are registered";
      $register_name = $register_email = $hash_password = $register_password = $register_year = $register_password = '';
      ?>
      <script>window.location.href = '../index.php';</script>
      <?php

    }
}
 ?>
