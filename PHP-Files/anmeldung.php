<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error)&& isset($_POST['uname']) && isset($_POST['psw'])){
  $error = '';


  if(!empty(trim($_POST['uname']))){

    $uname = trim($_POST['uname']);

  } else {
    $error .= "Geben Sie bitte den Benutzername an.<br />";
  }
  // psw

  if(!empty(trim($_POST['psw']))){
    $psw = trim($_POST['psw']);

  }else {
    $error .= "Geben Sie bitte das Passwort an.<br />";
  }

  // kein fehler
  if(empty($error)){
    // query
    $query = "SELECT ID, name, email , password, rechte, paied from tbl_user where email = ?";
    // query vorbereiten
    $stmt = $mysqli->prepare($query);
    if($stmt===false){
      $error .= 'prepare() failed '. $mysqli->error . '<br />';
    }
    // parameter an query binden
    if(!$stmt->bind_param("s", $uname)){
      $error .= 'bind_param() failed '. $mysqli->error . '<br />';
    }
    // query ausführen
    if(!$stmt->execute()){
      $error .= 'execute() failed '. $mysqli->error . '<br />';
    }

    // daten auslesen
    $result = $stmt->get_result();
    // benutzer vorhanden
    if($result->num_rows){
      // userdaten lesen
      $row = $result->fetch_assoc();
      // passwort prüfen


      if(password_verify($psw, $row['password'])&&isset($uname)&&isset($psw)){

        $_SESSION["name"]=$row["name"];
        $_SESSION["rechte"] =$row["rechte"];
        $_SESSION["paied"] =$row["paied"];
        $_SESSION["loggedin"] = true;
        $_SESSION["ID"]=$row["ID"];
        $_SESSION["message"] = "you are logged-in";
        $uname = $psw = '';
    }
  }
}

}
?>
