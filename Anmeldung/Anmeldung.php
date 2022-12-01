<?php
#Überprüfung ob Logindaten korrekt, dann Weiterleitung
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
        <form method="post" action="../Hauptseite/Hauptseite.php">
            <h3>Login</h3>

            <label for="username">Benutzername</label>
            <input type="text" placeholder="MusterMax" id="username" required maxlength="25">

            <label for="password">Passwort</label>
            <input type="password" placeholder="********" id="password" required>

            <button class="login">Login</button>
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
