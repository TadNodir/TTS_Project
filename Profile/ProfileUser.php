<?php

session_start();

include '../database/db_functions.php';
$conn = createLink();

if (!empty($_POST['nickname']))
{
    //echo "eeee";
    $_SESSION['nick'] = $_POST['nickname'];
}
$n = $_SESSION['nick'];


$_SESSION['del'] = $n;

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
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Profile</title>
    <link href="Profile.css" rel="stylesheet" type="text/css" media="screen">
    <script src="Profile.js"></script>

</head>
<body>
<div class="flex-container">
    <div class="flex-item-left">
        <a href="../Adminpanel/Adminpanel.php"> <img src="../logo_200x200.png" alt="TTS-Logo"> </a>
        <br>
        <label class="switch">
            <input type="checkbox" onclick="darkL()">
            <span class="slider round"></span>
        </label>
    </div>

    <div class="flex-item-middle">
        <table id="infoTable" class="infoT">
            <tr>
                <th>
                    <?php
                    if (isset($n))
                    {
                        echo $n;
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </th>
                <th>
                    <?php
                    if (isset($n))
                    {
                        echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT punktestand FROM benutzer WHERE nickname = '$n'"))['punktestand'];
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </th>
            </tr>
            <tr>
                <td> Vorname: </td>
                <td> Nachname: </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if (isset($n))
                    {
                        echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT vorname FROM benutzer WHERE nickname = '$n'"))['vorname'];
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if (isset($n))
                    {
                        echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT nachname FROM benutzer WHERE nickname = '$n'"))['nachname'];
                    }
                    else
                    {
                        echo "Fehler";
                    }

                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"> E-Mail: </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                    if (isset($n))
                    {
                        echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT email FROM benutzer WHERE nickname = '$n'"))['email'];
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td> Password: </td>
            </tr>
            <tr>
                <td>
                    <?php
                    if (isset($n))
                    {
                        echo mysqli_fetch_assoc(mysqli_query($conn,"SELECT passwort FROM benutzer WHERE nickname = '$n'"))['passwort'];
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </td>
                <td>
                    <button class="open-button" onclick="openForm()"> Daten ändern </button>
                </td>
            </tr>
        </table>

        <br> <br>

        <div class="form-popup" id="myForm">
            <form method="post" action="ProfileUser.php" class="form-container">
                <h3> Daten ändern </h3>

                <label for="benutzername"> Benutzername: </label>
                <input type="text" name="benutzer" id="benutzername">

                <br> <br>

                <label for="email"> E-mail: </label>
                <input type="email" name="email" id="email">

                <br> <br>

                <label for="password"> Password: </label>
                <input type="password" name="password" id="password">
                <label> <input type="checkbox" onclick="myPassword()"> Show Password </label>

                <br> <br>

                <label for="passwordRe"> Password bestätigen: </label>
                <input type="password" name="passwordRe" id="passwordRe">
                <label> <input type="checkbox" onclick="myPasswordRe()"> Show Password </label>

                <br> <br>

                <button type="submit" class="btn"> Daten ändern </button>
                <button type="button" class="btn cancel" onclick="closeForm()"> Abbrechen </button>
            </form>
        </div>

        <?php //Daten ändern

        if (isset($_POST["email"]))
        {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
            {
                if (!Trashmail($_POST["email"]))
                {
                    $salt ="";
                    for( $i = 0; $i <=5;$i++){
                        $salt = $salt.chr(rand(65,90));
                    }
                    $hash =sha1($salt.$_POST["password"]);

                    $sql = "UPDATE swe_tts.benutzer SET email = '".$hash."' WHERE nickname = '".$n."'";
                    mysqli_query($conn, $sql);

                    echo "<label class='erfolg'> Erfolgreiche änderung der E-mail adresse </label>";
                    echo "<br>";
                    echo "<meta http-equiv='refresh' content='3'>";
                }
                else
                {
                    echo "<label class='fehlermeldung'> Die eingegebene E-mail wird nicht akzeptiert! </label>";
                }
            }
            elseif($_POST["email"] == "")
            {
            }
            else
            {
                echo "<label class='fehlermeldung'> Bitte geben Sie eine existierende E-mail ein! </label>";
            }
        }

        if (isset($_POST["password"]) && isset($_POST["passwordRe"]))
        {
            if ($_POST["password"] != "" && $_POST["passwordRe"] != "")
            {
                if ($_POST["password"] == $_POST["passwordRe"])
                {
                    $sql = "UPDATE swe_tts.benutzer SET passwort = '".$_POST["password"]."' WHERE nickname = '".$n."'";
                    mysqli_query($conn, $sql);
                    echo "<label class='erfolg'> Erfolgreiche änderung des Passwortes </label>";
                    echo "<br>";
                    echo "<meta http-equiv='refresh' content='3'>";
                }
                else
                {
                    echo "<label class='fehlermeldung'> Passwörter stimmen nicht überein </label>";
                }
            }
        }

        if (isset($_POST["benutzer"]))
        {
            if ($_POST["benutzer"] != "")
            {
                $g = "SELECT id FROM swe_tts.benutzer WHERE nickname = '".$_POST["benutzer"]."';";

                if (mysqli_fetch_assoc(mysqli_query($conn, $g)) === NULL)
                {
                    $sql = "UPDATE swe_tts.benutzer SET nickname = '".$_POST["benutzer"]."' WHERE nickname = '".$n."'";
                    mysqli_query($conn, $sql);
                    $_SESSION['nick'] = $_POST['benutzer'];
                    echo "<label class='erfolg'> Erfolgreiche änderung des Benutzernamens </label>";
                    echo "<br>";
                    echo "<meta http-equiv='refresh' content='3'>";
                }
                else
                {
                    echo "<label class='fehlermeldung'> Der gewünschte Benutzername existiert bereits! </label>";
                }
            }
        }
        ?>

    </div>
    <br> <br>
    <div class="flex-item-right">
        <form name="Abmelden" action="../Anmeldung/Anmeldung.php">
            <input type="submit" class="logout" value="Abmelden">
        </form>
        <br>
        <button class="delete-button" onclick="openDelete()"> Konto löschen </button>

        <div class="delete-popup" id="myDelete">

            <form method="get" class="delete-conatainer" action="../Adminpanel/Adminpanel.php">
                <h3> Konto löschen </h3>

                <label> Wollen Sie ihr </label> <br>
                <label> Konto wirklich </label> <br>
                <label> löschen ? </label> <br>
                <button type="Button" class="btn-del cancel" onclick="closeDelete()"> Abbrechen </button>
                <button type="submit" name="del" class="btn-del"     > OK </button>
            </form>

        </div>

        <?php //Konto löschen
        /*  Muss in Anmeldung.php
        if (isset($_GET["del"]))
        {
            mysqli_query($conn, "DELETE FROM swe_tts.benutzer WHERE id = 1");

            mysqli_query($conn, "SET @num := 0");
            mysqli_query($conn, "UPDATE swe_tts.benutzer SET id = @num := (@num + 1)");
            mysqli_query($conn, "ALTER TABLE swe_tts.benutzer AUTO_INCREMENT = 1");
        }
        */
        ?>
    </div>
</div>

<?php closeLink($conn,null); ?>

</body>
</html>
