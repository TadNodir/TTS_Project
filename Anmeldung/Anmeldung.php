<?php
#Überprüfung ob Logindaten korrekt, dann Weiterleitung
include("../database/db_functions.php");
session_start();
#Konto löschen von Profilseite
if (isset($_POST["del"]) && isset($_SESSION['id']))
{
    //var_dump($_SESSION['id']);

    $s = "DELETE FROM benutzer WHERE id = '".$_SESSION['id']."';";

    $link=createLink();
    mysqli_query($link,$s);
    mysqli_query($link, "SET @num := 0");
    mysqli_query($link, "UPDATE swe_tts.benutzer SET id = @num := (@num + 1)");
    mysqli_query($link, "ALTER TABLE swe_tts.benutzer AUTO_INCREMENT = 1");
    closeLink($link);

}

#Reset der Session Variablen

session_destroy();
session_start();

$_SESSION=array();

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

        $_SESSION['gesperrt'] = $resultRow['nickname'];
        closeLink($link);
        header( "Location: ../Anmeldung/reset.php");
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
            if($_SESSION['rolle']==0)
                 header("Location: ../Hauptseite/Hauptseite.php");
            if($_SESSION['rolle']==1|| $_SESSION['rolle']==2)
                header("Location: ../Adminpanel/Adminpanel.php");
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
           header( "Location: ../Anmeldung/reset.php");
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
    <!-- Link to the styling css file-->
    <link rel="stylesheet" href="Login.css" type="text/css" media="screen"/>
</head>
<body>

<button id="dark-mode-toggle" class="dark-mode-toggle">
    <svg width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 496"><path fill="currentColor" d="M8,256C8,393,119,504,256,504S504,393,504,256,393,8,256,8,8,119,8,256ZM256,440V72a184,184,0,0,1,0,368Z" transform="translate(-8 -8)"/></svg>
</button>

<div class="background">
    <img src="../logo.png" alt="logo">
    <div class="formular">
        <form method="post">
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
<script>
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
