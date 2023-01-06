<?php
#Überprüfung ob Logindaten korrekt, dann Weiterleitung
#test
include("../database/db_functions.php");
if (isset($_SESSION)) {
    session_destroy();
}
session_start();
#email oder benutzername
function checkAccount($user,$password): int
{
    $link = createLink();


    # Suche die ID der zugehörigen email oder des Benutzernamens
    /** @noinspection SqlResolve */
    $sql ="SELECT id,gesperrt,nickname,salt FROM benutzer 
                   WHERE nickname ='".$user."';";

    $result = mysqli_query($link, $sql);
    $resultRow = mysqli_fetch_assoc($result);

    if($resultRow=== NULL){

        /** @noinspection SqlResolve */
        $sql ="SELECT id,gesperrt,nickname,salt FROM benutzer 
                   WHERE email ='".$user."';";
        $result = mysqli_query($link, $sql);
        $resultRow = mysqli_fetch_assoc($result);
    }

    #Sollte keine ID zum Namen gefunden werden gib Fehlercode 3 zurück
    if($resultRow=== NULL){
        return 3;
    }

    $idName=$resultRow['id'];


    if($resultRow['gesperrt']>=5){

        $_SESSION['gesperrt'] = "Der Benutzer".$resultRow['nickname']." wurde gesperrt. Bitte setzen Sie ihr Passwort zurück.";
        closeLink($link);
        header( "Location: http://localhost:63342/tts/Anmeldung/reset.php");
        exit;

    }
    $hash = sha1($resultRow['salt'].$password);
    # Kontrolliere ob die gefundene ID mit dem Passwort übereinstimmt
    /** @noinspection SqlResolve */
    $sql ="SELECT id FROM benutzer 
                   WHERE id ='".$idName."' AND passwort = '".$hash."';";

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
if (isset($_POST["del"]))
{
    $link=createLink();
    mysqli_query($link,"DELETE FROM swe_tts.benutzer WHERE id = ".$_SESSION['id']);
    mysqli_query($link, "SET @num := 0");
    mysqli_query($link, "UPDATE swe_tts.benutzer SET id = @num := (@num + 1)");
    mysqli_query($link, "ALTER TABLE swe_tts.benutzer AUTO_INCREMENT = 1");
    closeLink($link);

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
//    echo $fehlerCode;
    $link = createLink();
    if($fehlerCode == 1){

            $sql ="UPDATE benutzer
                SET gesperrt = 0
                   WHERE nickname ='".$nutzer['benutzer']."';";
            mysqli_query($link, $sql);

            $sql ="SELECT rolle,id,vorname,nachname,punktestand,email,salt FROM benutzer WHERE nickname ='".$nutzer['benutzer']."';";

            $result = mysqli_query($link, $sql);
            $resultArray = mysqli_fetch_assoc($result);

            $_SESSION['salt']= $resultArray['salt'];
            $_SESSION['id']= $resultArray['id'];
            $_SESSION['nickname']= $nutzer['benutzer'];
            $_SESSION['vorname']= $resultArray['vorname'];
            $_SESSION['nachname']= $resultArray['nachname'];
            $_SESSION['punktestand']= $resultArray['punktestand'];
            $_SESSION['email']= $resultArray['email'];
            $_SESSION['rolle']= $resultArray['rolle'];

            closeLink($link);
            header("Location: http://localhost:63342/tts/Hauptseite/Hauptseite.php");
            exit();


    }else if($fehlerCode == 2){


        $sql ="UPDATE benutzer
                SET gesperrt = gesperrt+1 
                   WHERE nickname ='".$nutzer['benutzer']."';";
        mysqli_query($link, $sql);

        $sql= "SELECT gesperrt 
                FROM benutzer 
                WHERE nickname ='".$nutzer['benutzer']."';";
        $result=mysqli_query($link, $sql);
        $resultArray = mysqli_fetch_assoc($result);

       if($resultArray['gesperrt']>=5){
           $_SESSION['gesperrt'] = "Der Benutzer ".$nutzer['benutzer']." wurde gesperrt. Bitte setzen Sie ihr Passwort zurück.";
           header( "Location: http://localhost:63342/tts/reset.php");
           exit;
       }



    }
    closeLink($link);
    unset($_POST["submit"]);
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
    <script>
        function myPassword(){
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
    <!-- Link to the styling css file-->
    <link rel="stylesheet" href="Login.css" type="text/css" media="screen"/>
</head>
<body>
<div class="background">
    <img src="../logo.png" alt="logo">
    <div class="formular">
        <form method="post"  >
            <h3>Login</h3>

            <label for="username">Benutzername</label>
            <input type="text" placeholder="MusterMax" name="username" id="username" required maxlength="25"
                   value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>">
            <?php
            if($fehlerCode===3)
                echo"<p style='color:lightcoral;'>Benutzername falsch eingegeben.</p>";?>


            <label for="password">Passwort</label>
            <input type="password" placeholder="********" name="password" id="password" required>
            <label> <input type="checkbox" onclick="myPassword()"> Show Password </label>
            <?php
            if($fehlerCode===2)
                echo"<p style='color:lightcoral;'>Passwort falsch eingegeben.</p>";?>


            <input type="submit" name="submit" value="Login" class="login">
            <div class="forgotPassword"><a href="reset.php">Passwort vergessen?</a></div>
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
