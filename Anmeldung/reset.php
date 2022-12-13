<?php
session_start();
if (isset($_SESSION['gesperrt']))
    echo $_SESSION['gesperrt'];
# Reset hat bisher nur die Form aufgebaut
# Es findet kein Reset und keine Weiterleitung statt
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
    <h2>Passwort vergessen? <br> Kein Problem! Hier zurücksetzen.</h2>
    <div class="formular">
        <form method="post">
            <label for="benutzerReset">Benutzername:</label>
            <input type="text" name="benutzerReset" id="benutzerReset" required>

            <label for="emailReset">E-Mail</label><br>
            <input type="email" name="emailReset" id="emailReset" required>

            <label for="passwortReset">Passwort:</label>
            <input type="password" name="passwortReset" id="passwortReset" required>

            <label for="passwortReset2">Passwort bestätigen:</label>
            <input type="password" name="passwortReset2" id="passwortReset2" required><br>

            <input class="reset" type="submit" value="Zurücksetzen">
        </form>
    </div>
</div>
</body>

</html>
