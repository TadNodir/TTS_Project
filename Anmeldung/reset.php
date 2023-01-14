<?php
include("../database/db_functions.php");
session_start();



$nameMail = false;
$pwGleich= false;
if(isset($_POST['reset'])){
    $link = createLink();
    #Trimmen fehlt
    $nutzer['nickname'] = trim($_POST['benutzerReset'] ?? "");
    $nutzer['mail'] =  trim($_POST['emailReset'] ?? "");
    $nutzer['passwort'] =  trim($_POST['passwortReset'] ?? "");
    $nutzer['passwort2'] =  trim($_POST['passwortReset2'] ?? "");

    $sql ="SELECT id FROM swe_tts.benutzer 
                   WHERE nickname ='".$nutzer['nickname']."' AND email = '".$nutzer['mail']."';";

    $result = mysqli_query($link, $sql);
    
    if(mysqli_fetch_assoc($result)=== NULL){
        $nameMail=true;
    }
    else {
        $nameMail = false;
    }
    if ($nutzer['passwort'] == $nutzer['passwort2'] && !$nameMail){
        $pwGleich=false;
        $sql ="SELECT id,salt FROM swe_tts.benutzer 
                   WHERE nickname ='".$nutzer['nickname']."';";
        $result = mysqli_query($link, $sql);
        $resultRow = mysqli_fetch_assoc($result);

        $hash = sha1($resultRow['salt'].$nutzer['passwort']);

        $sql = "UPDATE swe_tts.benutzer SET passwort = '".$hash."' WHERE nickname = '".$nutzer['nickname']."';";
        mysqli_query($link, $sql);
        closeLink($link);
        header( "Location: http://localhost:63342/tts/Anmeldung/Anmeldung.php");
    }
    else
        $pwGleich=true;

    closeLink($link);
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TTS - Reset</title>
    <link rel="stylesheet" href="Reset.css" type="text/css" media="screen"/>
</head>

<body>
<div class="background">
    <?php
    if (isset($_SESSION['gesperrt'])) {
       echo" <h2>Der Benutzer '".$_SESSION['gesperrt']."' wurde gesperrt. <br> Bitte das Passwort zurücksetzen</h2>";

    }else
        echo" <h2>Passwort vergessen ?<br>Kein Problem! Hier zurücksetzen.</h2>";

    ?>

    <div class="formular">

        <form method="post" >
            <label for="benutzerReset">Benutzername:</label>
            <input type="text" name="benutzerReset" id="benutzerReset" required
                   value="<?php if(isset($_POST['benutzerReset'])) echo $_POST['benutzerReset']; ?>">

            <label for="emailReset">E-Mail</label><br>
            <input type="email" name="emailReset" id="emailReset" required
                   value="<?php if(isset($_POST['emailReset'])) echo $_POST['emailReset']; ?>">
            <?php
            if ($nameMail) {
                echo "<p style='color:lightcoral;'>Benutzername und Mail stimmen nicht überein.</p>";

            }?>

            <label for="passwortReset">Passwort:</label>
            <input type="password" name="passwortReset" id="passwortReset" required  minlength="8">

            <label for="passwortReset2">Passwort bestätigen:</label>
            <input type="password" name="passwortReset2" id="passwortReset2" required minlength="8"><br>
            <?php
            if ($pwGleich) {
                echo "<p style='color:lightcoral;'>Die Passwörter stimmen nicht überein.</p>";

            }?>

            <input class="reset" type="submit" name="reset" value="Zurücksetzen">
        </form>
    </div>
</div>
</body>

</html>
