<!DOCTYPE html>
<html lang="en">
<?PHP
session_start(); session_regenerate_id();
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

include("PHP-Files/anmeldung.php");
 ?>

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
  <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- https://getbootstrap.com/ -->
  <link rel="stylesheet" href="css/templatemo-style.css"> <!-- Templatemo style -->

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
  <!-- Loader -->
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <div class="container">

    <!-- 1st section -->
    <section class="row tm-section tm-mb-30">
      <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-0">
        <div class="tm-flex-center p-5 tm-bg-color-primary tm-section-min-h">
          <h1 class="tm-text-color-white tm-site-name">WW Events</h1>
          </div>
      </div>
      <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
        <div class="tm-flex-center p-5">
          <p class="tm-quote tm-text-color-gray">
        <li>
            <p style="text-align:center;" class=""><?php if(isset($_SESSION["message"])){ echo $_SESSION["message"]; } ?> </p>
            <?php
            if(isset($_SESSION["loggedin"])){
              if($_SESSION["loggedin"]==true){
                  print '<form action="" method="POST" style="text-align:center;margin-bottom:10px;"><input type="submit" class="btn btn-primary tm-md-align-center" name="logoutAction" value="LOGOUT" /></form>';
              if($_SESSION["rechte"]==1){
                  print '<a style="color:white;" class="btn btn-primary tm-md-align-center" href="newevent.php">new Event</a>';
              }
                }}else{
                  echo '<a style="color:white;" class="btn btn-primary float-lg-right tm-md-align-center" id="myBtn">Login</a>';
                }
                if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logoutAction'])){
                  if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']==true){
                  $_SESSION = [];
                  $_SESSION = array();
                  session_destroy();
                  ?><script> for (i = 0; i < 1; i++){location.reload();} </script><?php
                }
              }?>
          </p>
        </div>
      </div>
    </section>

<?php
    $queryevents = "SELECT tbl_events.ID AS eID, `title`, `date`, `info`, pic, ID_user FROM `tbl_events`LEFT JOIN tbl_user_event ON tbl_events.ID = ID_event ORDER BY date";
    $stmtevents = $mysqli->prepare($queryevents);
    $bool = $stmtevents->execute();
    $resultevents = $stmtevents->get_result();

    while($row = $resultevents->fetch_assoc()){
      if($row["ID_user"]==$_SESSION["ID"]){
        echo '
        <section class="row tm-section">
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="tm-flex-center p-5">
              <div class="tm-flex-center tm-flex-col">
                <h2 class="tm-align-left">'.$row["title"].'</h2>
                <p>'.$row["date"].'</p>
                <p>'.$row["info"].'</p>';

          echo'</div>
            </div>
          </div>
          <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-0 text-center containerimg">
            <img src="'.$row["pic"].'" alt="Image" class="img-fluid">
            <div class="centered">';
          echo'</div>
            </div>
        </section>';
      }else{
      echo '
      <section class="row tm-section">
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
          <div class="tm-flex-center p-5">
            <div class="tm-flex-center tm-flex-col">
              <h2 class="tm-align-left">'.$row["title"].'</h2>
              <p>'.$row["date"].'</p>
              <p>'.$row["info"].'</p>';

        echo'</div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 p-0 text-center containerimg">
          <img src="'.$row["pic"].'" alt="Image" class="img-fluid">
          <div class="centered">';
      if(isset($_SESSION["paied"])&&$_SESSION["paied"]==1){
        echo'

        <form action="PHP-files/signup.php" method="post">
        <input type="hidden" name="signupEID" value="'.$row["eID"].'">
        <input type="hidden" name="signupID" value="'.$_SESSION["ID"].'"><br><br>
        <input class="btn btn-primary" name="signupsubmit" type="submit" value="sign up">
        </form>';

      }echo'</div>
          </div>
      </section>';
    }}
?>


    <!-- The Modal -->
    <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <span style="float:right;" class="close">&times;</span>
        <p style="justify-content:center;margin:auto;">
          <form method="post">
          <label for="uname"><b>Email:</b></label><br>
          <input class="form-control" type="text" placeholder="Enter Username" name="uname" required>
          <br>
          <label for="psw"><b>Password:</b></label><br>
          <input class="form-control" type="password" placeholder="Enter Password" name="psw" required>
          <br>
          <button class="btn btn-primary" type="submit">Login</button>
          <br>
        </form>
          <span class="psw">Forgot <a href="#">password?</a></span></p>
      </div>

    </div>

  </div>
  <!-- 6th Section -->
  <section class="row">
    <div class="col-lg-12 tm-form-header pl-5 pr-5">
      <h2 class="tm-container-inner tm-text-color-white">Registration Form</h2>
    </div>
    <div class="col-lg-12 pl-2 pl-sm-3 pl-md-5 pr-2 pr-sm-3 pr-md-5">
      <form action="PHP-Files/register.php" method="post" class="row tm-container-inner tm-contact-form">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group">
            <input type="text" id="register_name" name="register_name" class="form-control" placeholder="Full Name" required />
          </div>
          <div class="form-group">
            <input type="email" id="register_email" name="register_email" class="form-control" placeholder="Your Email" required />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group">
            <input type="number" id="register_year" name="register_year" class="form-control" placeholder="Your school year" required />
          </div>
          <div class="form-group">
            <input type="password" id="register_password" name="register_password" class="form-control" placeholder="new Password"
            placeholder="Gross- und Kleinbuchstaben, Zahlen, Sonderzeichen, min. 8 Zeichen, keine Umlaute"
            pattern="(?=^.{8,}$)((?=.*\d+)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"
            title="mindestens einen Gross-, einen Kleinbuchstaben, eine Zahl und ein Sonderzeichen, mindestens 8 Zeichen lang,keine Umlaute."
            required />
          </div>
        </div>

        <div class="col-xs-12 mt-4 tm-center">
          <button type="submit" class="btn btn-primary" name="register_submit">register</button>
        </div>
      </form>
    </div>
    <div class="col-lg-12 tm-bg-color-gray tm-text-color-white tm-font-thin tm-form-footer">
      <div class="row tm-container-inner">
      </div>
    </div>
  </section>

  <!-- Footer -->
  <div class="row">
    <div class="col-lg-12">
      <p class="text-center small tm-copyright-text mb-0">Copyright &copy; <span class="tm-current-year">2021</span> WW Ereignisse | Designed by Niklas Ennser</p>
    </div>
  </div>
  </div>
  <!-- load JS -->
  <script src="js/jquery-3.2.1.slim.min.js"></script> <!-- https://jquery.com/ -->
  <script>
    /* DOM is ready
  ------------------------------------------------*/
    $(function() {

      if (renderPage) {
        $('body').addClass('loaded');
      }

      $('.tm-current-year').text(new Date().getFullYear()); // Update year in copyright
    });
  </script>
  <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
      modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>

</body>

</html>
