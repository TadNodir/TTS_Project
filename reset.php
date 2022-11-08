<?php
# Reset hat bisher nur die Form aufgebaut
# Es findet kein Reset und keine Weiterleitung statt
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <title>TTS - Reset</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>

<body>
<h3>Passwort vergessen ? <br> Kein Problem! Hier zurücksetzen.</h3>

<form method="post">
    <label for="benutzerReset">Benutzername:</label><br>
    <input type="text" name="benutzerReset" id="benutzerReset" required  > <br><br>

    <label for="emailReset">E-Mail</label><br>
    <input type="email" name="emailReset" id="emailReset" required  ><br><br>

    <label for="passwortReset">Passwort:</label><br>
    <input type="password" name="passwortReset" id="passwortReset" required  ><br><br>

    <label for="passwortReset2">Passwort bestätigen:</label><br>
    <input type="password" name="passwortReset2" id="passwortReset2" required  ><br><br><br>

    <input type="submit" value="Zurücksetzen">
</form>


</body>

</html>
