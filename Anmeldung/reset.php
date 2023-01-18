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
    $nick = $nutzer['nickname'] ?? null;
    $nick = mysqli_real_escape_string($link, $nick);
    $mail = $nutzer['mail'] ?? null;
    $mail = mysqli_real_escape_string($link, $mail);
    $pass1 = $nutzer['passwort'] ?? null;
    $pass1 = mysqli_real_escape_string($link, $pass1);
    $pass2 = $nutzer['passwort2'] ?? null;
    $pass2 = mysqli_real_escape_string($link, $pass2);

    $sql ="SELECT id FROM swe_tts.benutzer 
                   WHERE nickname ='$nick' AND email = '$mail';";

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
                   WHERE nickname ='$nick';";
        $result = mysqli_query($link, $sql);
        $resultRow = mysqli_fetch_assoc($result);

        $hash = sha1($resultRow['salt'].$nutzer['passwort']);
        $hasher=$hash ?? null;;
        $hasher = mysqli_real_escape_string($link, $hasher);
        $sql = "UPDATE swe_tts.benutzer SET passwort = '$hasher' WHERE nickname = '$nick';";
        mysqli_query($link, $sql);
        $sql2 = "UPDATE swe_tts.benutzer SET gesperrt = 0 WHERE nickname = '$nick';";
        mysqli_query($link, $sql2);
        closeLink($link);
        header( "Location: ../Anmeldung/Anmeldung.php");
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

<button id="dark-mode-toggle" class="dark-mode-toggle">
    <svg width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 496"><path fill="currentColor" d="M8,256C8,393,119,504,256,504S504,393,504,256,393,8,256,8,8,119,8,256ZM256,440V72a184,184,0,0,1,0,368Z" transform="translate(-8 -8)"/></svg>
</button>

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
<script>
    function con(){
        console.log("test");
    }
    // check for saved 'darkMode' in localStorage
    let darkMode = localStorage.getItem('darkMode');

    const darkModeToggle = document.querySelector('#dark-mode-toggle');


    const enableDarkMode = () => {
        // 1. Add the class to the body
        document.body.classList.add('darkmode');
        // 2. Update darkMode in localStorage
        localStorage.setItem('darkMode', 'enabled');
    }

    const disableDarkMode = () => {
        // 1. Remove the class from the body
        document.body.classList.remove('darkmode');
        // 2. Update darkMode in localStorage
        localStorage.setItem('darkMode', null);
    }

    // If the user already visited and enabled darkMode
    // start things off with it on
    if (darkMode === 'enabled') {
        enableDarkMode();
    }

    // When someone clicks the button
    darkModeToggle.addEventListener('click', () => {
        // get their darkMode setting
        darkMode = localStorage.getItem('darkMode');

        // if it not current enabled, enable it
        if (darkMode !== 'enabled') {
            enableDarkMode();
            // if it has been enabled, turn it off
        } else {
            disableDarkMode();
        }
    });

</script>
</html>
