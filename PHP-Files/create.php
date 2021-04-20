<?php
$usertitle = '';
$host     = 'localhost'; // host
$usertitleAnmeldung = 'root'; // usertitle
$anmeldungpic = ''; // pic
$database = 'events'; // database

// mit Datenbank verbinden
$mysqli = new mysqli($host, $usertitleAnmeldung,$anmeldungpic, $database);

// fehlermeldung, falls die Verbindung fehl schlägt.
if ($mysqli->connect_error) {
die('Connect Error (' . $mysqli->connect_error . ') '. $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)&& isset($_POST['create_submit'])&& isset($_POST['create_title']) && isset($_POST['create_date'])&& isset($_POST['create_pic'])&& isset($_POST['create_info'])){
  $error = '';

  if(!empty(trim($_POST['create_title']))){
    $create_title = $_POST['create_title'];
  } else {$error .= "bad request!";}

  if(!empty(trim($_POST['create_date']))){
    $create_date = $_POST['create_date'];
  } else {$error .= "bad request!";}

  if(!empty(trim($_POST['create_info']))){
    $create_info = $_POST['create_info'];
  } else {$error .= "bad request!";}

  if(!empty(trim($_POST['create_pic']))){
    $create_pic = trim($_POST['create_pic']);
  } else {$error .= "bad request!";}

  if(empty($error)){

      $queryte = "INSERT INTO `tbl_events`(`title`, `date`, `info`, `pic`) VALUES (?,?,?,?)";
      $stmtte = $mysqli->prepare($queryte);
      $stmtte->bind_param("ssss",$create_title, $create_date, $create_info, $create_pic);
      $bool = $stmtte->execute();
      $stmtte->close();
      $create_title = $create_info = $hash_pic = $create_pic = $create_date = $create_pic = '';
      ?>
      <script>window.location.href = '../index.php';</script>
      <?php

    }
}
 ?>
