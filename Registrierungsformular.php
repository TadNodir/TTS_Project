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
    <meta charset="UTF-8" />
    <title>TTS - Registrierung</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>

<body>
<fieldset>
    <form action="Anmeldung.php" method="post">
        <label for="vorname">Vorname:</label>
        <input type="text" name="vorname" id="vorname" required maxlength="10">
        <br>
        <br>
        <label for="nachname">Nachname:</label>
        <input type="text" name="nachname" id="nachname" required maxlength="20">
        <br>
        <br>
        <label for="benutzer">Benutzername:</label><br>
        <input type="text" name="benutzer" id="benutzer" required maxlength="20">
        <br><br>
        <label for="email">E-Mail:</label><br>
        <input type="email" name="email" id="email" required maxlength="25">
        <br><br>
        <label for="passwort">Passwort</label>
        <input type="passwort" name="passwort" id="passwort" required>

        <label for="passwort2">Passwort bestätigen:</label>
        <input type="passwort2" name="passwort2" id="passwort2" required>
        <br><br><br>
        <input type="submit" value="Registrieren">
    </form>
</fieldset>
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
