<?php
// Beim Debuggen auskommentieren : Schneller Zugriff auf die Einzelne Seiten
header("Location: ../Anmeldung/Anmeldung.php")
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8" />
    <title>TTS</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>
<body>


<form action="Registrierung/Registrierungsformular.php">
<input type="submit" value="Zur Registrierung"> </br></br>
</form>
<form action="Anmeldung/Anmeldung.php">
<input type="submit" value="Zur Anmeldung"> </br></br>
</form>

<form action="Anmeldung/reset.php">
    <input type="submit" value="Zum Reset"> </br></br>
</form>

<form action="Hauptseite/Hauptseite.php">
    <input type="submit" value="Zur Hauptseite"> </br></br>
</form>
</body>

</html>
