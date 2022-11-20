<?php
$nutzer = array(
    "vorname"=>"",
    "nachname"=>"",
    "benutzer"=>"",
    "email"=>"",
    "passwort"=>""
)
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
<div class="background">
    <img src="../logo.png" alt="logo">
    <div class="formular">
        <form action="../Anmeldung/Anmeldung.php" method="post">
            <h3>Registrieren</h3>
            <label for="vorname">Vorname:</label>
            <input type="text" name="vorname" id="vorname" placeholder="Max" required maxlength="20">

            <label for="nachname">Nachname:</label>
            <input type="text" name="nachname" id="nachname" placeholder="Mustermann" required maxlength="20">

            <label for="username">Benutzername</label>
            <input type="text" placeholder="MusterMax" id="username" required maxlength="25">

            <label for="email">E-Mail:</label>
            <input type="email" name="email" id="email" placeholder="max.mustermann@gmail.com" required maxlength="25">

            <label for="password">Passwort</label>
            <input type="password" placeholder="********" id="password" required minlength="8">

            <label for="password2">Passwort</label>
            <input type="password" placeholder="********" id="password2" required minlength="8">

            <button class="register">Registrieren</button>
            <hr>
        </form>
        <div class="anmelden">
            <span>Bereits registriert?</span>
            <a href="../Anmeldung/Anmeldung.php">
                <button class="login">Login</button>
            </a>
        </div>
    </div>
</div>

<?php
    # Noch zu implementieren
    # Passwort Übereinstimmung ?
    # einzelne Nutzerdaten schon in DB ?
    # Logo fehlt

    $nutzer['vorname'] = $_POST['vorname'];
    $nutzer['nachname'] = $_POST['nachname'];
    $nutzer['benutzer'] = $_POST['benutzer'];
    $nutzer['email'] = $_POST['email'];
    $nutzer['passwort'] = $_POST['passwort'];

    #echo var_dump($nutzer);


    $myFile = fopen("datenbank.txt","a") or die("Kann nicht geöffnet werden");
    fwrite($myFile,serialize($nutzer));
    fclose($myFile);

?>
</body>

</html>
