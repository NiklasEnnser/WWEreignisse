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

$error = '';
$message = '';

if(isset($_POST["signupEID"])&&isset($_POST["signupID"])&&isset($_POST["signupsubmit"])) {
  $signupID = $_POST["signupID"];
  $signupEID = $_POST["signupEID"];

  $query = "INSERT INTO `tbl_user_event`(ID_user, `ID_event`) VALUES (?,?)";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param("ii",$signupID, $signupEID);
  $bool = $stmt->execute();
  $stmt->close();

  ?><script>
  location.reload(true);
  window.location.href = '../index.php'; </script><?php
}
?>
