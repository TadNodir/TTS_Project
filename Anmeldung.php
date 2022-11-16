?php
#Überprüfung ob Logindaten korrekt, dann Weiterleitung
#Logo fehlt
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <title>TTS - Login</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>

<body>
<fieldset  >
    <legend>Login</legend>
    <br>
    <form method="post">

        <label for="benutzerLogin">Benutzername:</label><br>
        <input type="text" name="benutzerLogin" id="benutzerLogin" required maxlength="25">
<br><br>
        <label for="passwortLogin">Passwort:</label><br>
        <input type="password" name="passwortLogin" id="passwortLogin" required  >
<br> <br>
        <input type="submit" value="Login">
    </form>
    <br>
    <a href="reset.php">Passwort vergessen?</a>
    <hr>
    <form action="Registrierungsformular.php">
       <p> Neuer Benutzer:</p>
        <input type="submit" value="Jetzt registrieren!">
    </form>
</fieldset>


</body>
</html>


