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
            <a style="color:white;" class="btn btn-primary tm-md-align-center"href="index.php">go back</a>
          </p>
        </div>
      </div>
    </section>


  <!-- 6th Section -->
  <section class="row">
    <div class="col-lg-12 tm-form-header pl-5 pr-5">
      <h2 class="tm-container-inner tm-text-color-white">Registration Form</h2>
    </div>
    <div class="col-lg-12 pl-2 pl-sm-3 pl-md-5 pr-2 pr-sm-3 pr-md-5">
      <form action="PHP-Files/create.php" method="post" class="row tm-container-inner tm-contact-form">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group">
            <input type="text" id="create_name" name="create_title" class="form-control" placeholder="Title" required />
          </div>
          <div class="form-group">
            <input type="date" id="create_date" name="create_date" class="form-control" placeholder="Date" required />
          </div>
          <div class="form-group">
            <input type="text" id="create_pic" name="create_pic" class="form-control" placeholder="Picture-link" required />
          </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
          <div class="form-group">
            <textarea name="create_info"class=" form-control" placeholder="text..."></textarea>    </div>
        </div>

        <div class="col-xs-12 mt-4 tm-center">
          <button type="submit" class="btn btn-primary" name="create_submit">create</button>
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

</body>

</html>
