<?php
#Überprüfung ob Logindaten korrekt, dann Weiterleitung
include("../database/db_functions.php");
session_start();
#email oder benutzername
function checkAccount($user,$password): bool
{
    $link = createLink();


    # Suche die ID der zugehörigen email oder des Benutzernamens
    /** @noinspection SqlResolve */
    $sql ="SELECT id FROM benutzer 
                   WHERE nickname ='".$user."';";

    $result = mysqli_query($link, $sql);

    if(mysqli_fetch_assoc($result)=== NULL){

        /** @noinspection SqlResolve */
        $sql ="SELECT id FROM benutzer 
                   WHERE email ='".$user."';";

        $result = mysqli_query($link, $sql);
    }

    #Sollte keine ID zum Namen gefunden werden gib Fehlercode 3 zurück
    if(mysqli_fetch_assoc($result)=== NULL){
        return 3;
    }

    $row=mysqli_fetch_assoc($result);
    $idName=$row['id'];


    # Kontrolliere ob die gefundene ID mit dem Passwort übereinstimmt
    /** @noinspection SqlResolve */
    $sql ="SELECT id FROM benutzer 
                   WHERE id ='".$idName."' AND passwort = '".$password."';";

    $result = mysqli_query($link, $sql);
    closeLink($link);
    #Sollte das Passwort mit der ID nicht übereinstimmen gib Fehlercode 2 zurück
    if(mysqli_fetch_assoc($result)=== NULL){
        return 2;
    }
    else {
        #Stimmen die Daten überein gib Code 1 zurück
        return 1;
    }
}

$nutzer = array(
    "benutzer"=>"",
    "passwort"=>""

);

$fehlerCode=0;


if(isset($_POST['submit'])){

    $nutzer['benutzer'] =  trim($_POST['username'] ?? "");
    $nutzer['passwort'] =  trim($_POST['password'] ?? "");

    $fehlerCode = checkAccount($nutzer['benutzer'],$nutzer['passwort']);
    if($fehlerCode==1){

            $link = createLink();
            $sql ="SELECT id,vorname,nachname,punktestand FROM benutzer WHERE nickname ='".$nutzer['benutzer']."';";

            $result = mysqli_query($link, $sql);
            $resultArray = mysqli_fetch_assoc($result);

            $_SESSION['id']= $resultArray['id'];
            $_SESSION['nickname']= $nutzer['benutzer'];
            $_SESSION['vorname']= $resultArray['vorname'];
            $_SESSION['nachname']= $resultArray['nachname'];
            $_SESSION['punktestand']= $resultArray['punktestand'];

            header("Location: http://localhost:63342/tts/Hauptseite/Hauptseite.php");
            exit();

    }
}


#$result = getQueryResult($link, $sql);header("");
#exit();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <!-- This line will set the viewport of your page, which will give the browser instructions on
    how to control the page's dimensions and scaling.-->
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to the styling css file-->
    <link rel="stylesheet" href="Login.css" type="text/css" media="screen"/>
</head>
<body>
<div class="background">
    <img src="../logo.png" alt="logo">
    <div class="formular">
        <form method="post"   >
            <h3>Login</h3>

            <label for="username">Benutzername</label>
            <input type="text" placeholder="MusterMax" name="username" id="username" required maxlength="25"
                   value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>">
            <?php
            if($fehlerCode===3)
                echo"<p style='color:lightcoral;'>Benutzername falsch eingegeben.</p>";?>


            <label for="password">Passwort</label>
            <input type="password" placeholder="********" name="password" id="password" required>
            <?php
            if($fehlerCode===2)
                echo"<p style='color:lightcoral;'>Passwort falsch eingegeben.</p>";?>


            <input type="submit" name="submit" value="Login" class="login">
            <div class="forgotPassword"><a href="../reset.php">Passwort vergessen?</a></div>
            <hr>
        </form>
        <div class="registration">
            <span>Neuer Benutzer:</span>
            <a href="../Registrierung/Registrierungsformular.php">
                <button class="register">Registrieren</button>
            </a>
        </div>
    </div>
</div>
</body>
</html>
