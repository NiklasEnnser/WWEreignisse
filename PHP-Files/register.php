<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>WW Events</title>
  <!--
Magazee Template
http://www.templatemo.com/tm-514-magazee
-->
  <!-- load CSS -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400"> <!-- Google web font "Open Sans" -->
  <link rel="stylesheet" href="../css/bootstrap.min.css"> <!-- https://getbootstrap.com/ -->
  <link rel="stylesheet" href="../css/templatemo-style.css"> <!-- Templatemo style -->

  <script>
    var renderPage = true;

    if (navigator.userAgent.indexOf('MSIE') !== -1 ||
      navigator.appVersion.indexOf('Trident/') > 0) {
      /* Microsoft Internet Explorer detected in. */
      alert("Please view this in a modern browser such as Chrome or Microsoft Edge.");
      renderPage = false;
    }
  </script>

</head>

<body>


  <section class="row" style="min-height:100%;">
    <div style="max-height:3px;" class="col-lg-12 tm-form-header pl-5 pr-5">
      <h1 style="text-align:center;" class="tm-text-color-white">Scan the code</h1>
    </div>
    <div class="col-lg-12 pl-2 pl-sm-3 pl-md-5 pr-2 pr-sm-3 pr-md-5">
      <div style="text-align:center;"><br>
<?php
require_once '../vendor\phpgangsta\googleauthenticator\PHPGangsta/GoogleAuthenticator.php';
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


      $ga = new PHPGangsta_GoogleAuthenticator();
      $secret = $ga->createSecret();

      $qrCodeUrl = $ga->getQRCodeGoogleUrl('WWEreignisse', $secret);
     "Google Charts URL for the QR-Code: ".$qrCodeUrl."\n\n";

      $oneCode = $ga->getCode($secret);
     "Checking Code '$oneCode' and Secret '$secret':\n";

      $queryte = "INSERT INTO `tbl_user`(`email`, `name`, `password`, `year`,secret) VALUES (?,?,?,?,?)";
      $stmtte = $mysqli->prepare($queryte);
      $stmtte->bind_param("sssis",$register_email, $register_name, $hash_password, $register_year,$secret);
      $bool = $stmtte->execute();
      $stmtte->close();
      $_SESSION["message"] = "you are registered";
      echo '<div><img src="'.$qrCodeUrl.'"/><p>Scan the code</p>';
      $register_name = $secret = $register_email = $hash_password = $register_password = $register_year = $register_password = '';

      ?>

      <button class="btn btn-primary" onclick="window.location.href = '../index.php';">weiter</button>
      <?php

    }
}
 ?>

</div></div></div>
<div class="col-lg-12 tm-bg-color-gray tm-text-color-white tm-font-thin tm-form-footer">
  <div class="row tm-container-inner">
  </div>
</div>
</section>
 <div class="row">
   <div class="col-lg-12">
     <p class="text-center small tm-copyright-text mb-0">Copyright &copy; <span class="tm-current-year">2021</span> WW Ereignisse | Designed by Niklas Ennser</p>
   </div>
 </div>
 </div>
 <!-- load JS -->
 <script src="../js/jquery-3.2.1.slim.min.js"></script> <!-- https://jquery.com/ -->

</body>
