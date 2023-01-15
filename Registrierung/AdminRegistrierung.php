<?php
include("../database/db_functions.php");


$link = createLink();

# Guckt in Datenbank ob es ein Ergebnis zum User gibt
function checkUser($user,$link): bool
{

    /** @noinspection SqlResolve */
    $sql ="SELECT id FROM benutzer 
                   WHERE nickname ='".$user."';";

    $result = mysqli_query($link, $sql);


    if(mysqli_fetch_assoc($result)=== NULL)
        return false;
    else
        return true;

}

# Guckt in Datenbank ob es ein Ergebnis zur E-Mail gibt
function checkEmail($email,$link): bool
{

        /** @noinspection SqlResolve */
        $sql ="SELECT id FROM benutzer 
                   WHERE email ='".$email."';";

        $result = mysqli_query($link, $sql);


        if(mysqli_fetch_assoc($result)=== NULL)
            return false;
        else
            return true;


}
//function, die die eingegeben email auf trash überprüft
function Trashmail($e){

    $BList = ['rcpt.at',
        'damnthespan.at',
        'wegwerfmail.de',
        'trashmail'
    ];

    $parts = explode('@', $e);
    $domain = array_pop($parts);

    if (in_array($domain, $BList))
    {
        return true;
    }
    else
    {
        $parts2 = explode('.', $domain);

        if (in_array($parts2[0], $BList))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

# Array um Nutzerdaten zwischenzuspeichern.
$nutzer = array(
    "vorname"=>"",
    "nachname"=>"",
    "benutzer"=>"",
    "email"=>"",
    "passwort"=>"",
    "passwort2"=>""
);

#Fehler Array. False = Kein Fehler vorhanden. True = Fehler vorhanden
$errors = array(
    "nachnameFalsch"=>false,
    "vornameFalsch"=>false,
    "passwortFalsch"=>false,
    "nicknameExistiert"=>false,
    "emailExistiert"=>false,
    "emailFormat"=>false,
    "trashMail"=>false
);

if(isset($_POST['submit'])){

    # Array mit cleanen Nutzerdaten. Leerzeichen am Anfang und Ende werden entfernt
    $nutzer['vorname'] = trim($_POST['vorname'] ?? "");
    $nutzer['nachname'] =  trim($_POST['nachname'] ?? "");
    $nutzer['benutzer'] =  trim($_POST['username'] ?? "");
    $nutzer['email'] =  trim($_POST['email'] ?? "");
    $nutzer['passwort'] =  trim($_POST['password'] ?? "");
    $nutzer['passwort2'] =  trim($_POST['password2'] ?? "");

    #Kontrolle der möglichen Fehlerquellen.
    #Damit nicht nach jeder Eingabe ein neuer Fehler kommen werden sofort alle Fehler ausgegeben
    if(ctype_alpha($nutzer['vorname']))
        $errors['vornameFalsch']=false;
    else
        $errors['vornameFalsch']=true;

    if(ctype_alpha($nutzer['nachname']))
        $errors['nachnameFalsch']=false;
    else
        $errors['nachnameFalsch']=true;

    if($nutzer['passwort']=== $nutzer['passwort2'])
        $errors['passwortFalsch']=false;
    else
        $errors['passwortFalsch']=true;

    if(filter_var( $nutzer['email'], FILTER_VALIDATE_EMAIL) === false)
        $errors['emailFormat']=true;
    else
        $errors['emailFormat']=false;

    if(Trashmail($nutzer['email']))
        $errors['trashMail']=true;
    else
        $errors['trashMail']=false;


    if(checkUser($nutzer['benutzer'],$link))
        $errors['nicknameExistiert']= true;
    else
        $errors['nicknameExistiert'] = false;

    if(checkEmail($nutzer['email'],$link))
        $errors['emailExistiert']= true;
    else
        $errors['emailExistiert'] = false;


    #Solten keine Fehler im Array sein wird der Benutzer in die Datenbank eingetragen
    if(!in_array(true,$errors)){
        $salt ="";
        for( $i = 0; $i <=5;$i++){
            $salt = $salt.chr(rand(65,90));
        }
        $hash =sha1($salt.$nutzer['passwort']);
        $link = createLink();
        /** @noinspection SqlResolve */
        $sql ="INSERT INTO benutzer (rolle,vorname,nachname,nickname,passwort,salt,email)
                    VALUES ('1','".$nutzer['vorname']."','".$nutzer['nachname']."','".$nutzer['benutzer']."',
                    '".$hash."','".$salt."','".$nutzer['email']."');";

        mysqli_query($link, $sql);
        closeLink($link);
        header("Location: ../Adminpanel/Adminpanel.php");
        exit;
    }
    closeLink($link);
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <!-- This line will set the viewport of your page, which will give the browser instructions on
    how to control the page's dimensions and scaling.-->
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Link to the styling css file-->
    <link rel="stylesheet" href="Register.css" type="text/css" media="screen"/>
</head>
<body>

<button id="dark-mode-toggle" class="dark-mode-toggle">
    <svg width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 496"><path fill="currentColor" d="M8,256C8,393,119,504,256,504S504,393,504,256,393,8,256,8,8,119,8,256ZM256,440V72a184,184,0,0,1,0,368Z" transform="translate(-8 -8)"/></svg>
</button>

<div class="background">
    <img src="../logo.png" alt="logo">
    <div class="formular">
        <form  method="post">
            <h3>Admin Kreation</h3>
            <label for="vorname">Vorname:</label>
            <input type="text" name="vorname" id="vorname" placeholder="Max" required maxlength="20"
                   value="<?php if(isset($_POST['vorname'])) echo $_POST['vorname'];  ?>">
            <?php
            if($errors['vornameFalsch'])
                echo"<p style='color:lightcoral;'>Vorname darf nur aus A-Z und a-z bestehen</p>"?>

            <label for="nachname">Nachname:</label>
            <input type="text" name="nachname" id="nachname" placeholder="Mustermann" required maxlength="20"
                   value="<?php if(isset($_POST['nachname'])) echo $_POST['nachname'];  ?>">
            <?php
            if($errors['nachnameFalsch'])
                echo"<p style='color:lightcoral;'>Nachname darf nur aus A-Z und a-z bestehen</p>"?>

            <label for="username">Benutzername</label>
            <input type="text" placeholder="MusterMax" name="username" id="username" required maxlength="25"
                   value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" >

            <?php
            if($errors['nicknameExistiert'])
                echo"<p style='color:lightcoral;'>Benutzername existiert bereits.</p>"?>

            <label for="email">E-Mail:</label>
            <input type="email" name="email" id="email" placeholder="max.mustermann@gmail.com" required maxlength="50"
                   value="<?php if(isset($_POST['email'])) echo $_POST['email'];  ?>">
            <?php
            if($errors['emailFormat'])
                echo"<p style='color:lightcoral;'>Kein gültiges E-Mail Format.</p>";

            if($errors['emailExistiert'])
                echo"<p style='color:lightcoral;'>E-Mail existiert bereits.</p>";

            if($errors['trashMail'])
                echo"<p style='color:lightcoral;'>E-Mails von diesen Anbietern werden nicht akzeptiert</p>";?>

            <label for="password">Passwort</label>
            <input type="password" placeholder="********" id="password" name="password" required minlength="8">

            <label for="password2">Passwort</label>
            <input type="password" placeholder="********" id="password2" name="password2" required minlength="8">
            <?php
            if($errors['passwortFalsch'])
                echo"<p style='color:lightcoral;'>Die Passwörter stimmen nicht überein.</p>"?>
            <input type="submit" name="submit" value="Hinzufügen" class="register">
            <hr>
        </form>
        <!--
        <div class="anmelden">
            <span>Bereits registriert?</span>
            <a href="../Anmeldung/Anmeldung.php">
                <button class="login">Login</button>
            </a>
        </div>
        -->
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

