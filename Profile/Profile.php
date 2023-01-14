<?php
session_start();
include '../database/db_functions.php';

#Database connection
$conn = createLink();

//function, die die eingegeben email auf trash überprüft
function Trashmail($e){

    $BList = ['rcpt.at',
        'damnthespan.at',
        'wegwerfmail.de',
        'trashmail',
        'test'
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
        else if (in_array($parts2[1], $BList))
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
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="Profile.css" rel="stylesheet" type="text/css" media="screen">
    <script src="Profile.js" defer> </script>
</head>
<body>

<div class="flex-container">

    <div class="flex-item-left">
        <a href="../Hauptseite/Hauptseite.php"> <img src="../img/logo.png" alt="TTS-Logo"> </a>
        <br>
        <label class="switch">
            <input type="checkbox" onclick="darkL()">
            <span class="slider round"></span>
        </label>
    </div>

    <div class="flex-item-middle">
        <h2>Benutzerinfo</h2>
        <table id="infoTable" class="infoT">
            <tr>
                <th class="tbl">
                    <?php

                    if (isset($_SESSION['nickname']))
                    {
                        echo $_SESSION['nickname'];
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </th>
                <th class="tbl">
                    <?php

                    if (isset($_SESSION['rolle']))
                    {
                        if ($_SESSION['rolle'] == 0)
                        {
                            echo $_SESSION['punktestand'];
                        }
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
                <td class="tbl">
                    <?php

                    if (isset($_SESSION['vorname']))
                    {
                        echo $_SESSION['vorname'];
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </td>
                <td class="tbl">
                    <?php

                    if (isset($_SESSION['nachname']))
                    {
                        echo $_SESSION['nachname'];
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
                <td colspan="2" class="tbl">
                    <?php

                    if (isset($_SESSION['email']))
                    {
                        echo $_SESSION['email'];
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </td>
            </tr>
            <!-- <tr>
                <td> Password: </td>
                <td class="tbl">
                    <?php
                    //echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT passwort FROM swe_tts.benutzer WHERE nickname = '$_SESSION['nickname']'"))["passwort"];
                    ?>
                </td>
            </tr> -->
            <tr>
                <td>
                    <button class="open-button" onclick="openForm()"> Daten ändern </button>
                </td>
            </tr>
        </table>

        <br> <br>

        <div class="form-popup" id="myForm">
            <form method="post" action="Profile.php" class="form-container">
                <h3> Daten ändern </h3>

                <label for="benutzername"> Benutzername: </label>
                <input type="text" name="benutzer" id="benutzername">

                <label for="email"> E-mail: </label>
                <input type="email" name="email" id="email">

                <label for="password"> Password: </label>
                <input type="password" name="password" id="password" minlength="8">
                <label> <input type="checkbox" onclick="myPassword()"> Show Password </label>

                <label for="passwordRe"> Password bestätigen: </label>
                <input type="password" name="passwordRe" id="passwordRe" minlength="8">
                <label> <input type="checkbox" onclick="myPasswordRe()"> Show Password </label>

                <button type="submit" class="btn"> Daten ändern </button>
                <button type="button" class="btn cancel" onclick="closeForm()"> Abbrechen </button>
            </form>
        </div>

        <?php //Daten ändern

        if (isset($_POST["email"]))
        {
            if (($_POST["email"] != ""))
            {
                if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                {
                    if (!Trashmail($_POST["email"]))
                    {
                        $check_email = $conn->query("SELECT email FROM benutzer WHERE email='".$_POST["email"]."';");

                        if (!$check_email)
                        {
                            $sql = "UPDATE swe_tts.benutzer SET email = '".$_POST["email"]."' WHERE nickname = '".$_SESSION['nickname']."';";
                            mysqli_query($conn, $sql);

                            $_SESSION['email'] = $_POST["email"];

                            echo "<label class='erfolg'> Erfolgreiche änderung der E-mail adresse </label>";
                            echo "<meta http-equiv='refresh' content='3'>";
                        }
                        else
                        {
                            echo "<label class='fehlermeldung'> Die eingegebene E-mail Adresse existiert bereits! </label>";
                        }
                    }
                    else
                    {
                        echo "<label class='fehlermeldung'> Die eingegebene E-mail wird nicht akzeptiert! </label>";
                    }
                }
                else
                {
                    echo "<label class='fehlermeldung'> Bitte geben Sie eine existierende E-mail ein! </label>";
                }
            }
        }

        if (isset($_POST["password"]) && isset($_POST["passwordRe"]))
        {
            if ($_POST["password"] != "" && $_POST["passwordRe"] != "")
            {
                if ($_POST["password"] == $_POST["passwordRe"])
                {
                    $saltedPassword = sha1($_SESSION['salt'].$_POST["password"]);
                    $sql = "UPDATE swe_tts.benutzer SET passwort = '".$saltedPassword."' WHERE nickname = '".$_SESSION['nickname']."';";
                    mysqli_query($conn, $sql);

                    echo "<label class='erfolg'> Erfolgreiche änderung des Passwortes </label>";
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
                    $sql = "UPDATE swe_tts.benutzer SET nickname = '".$_POST["benutzer"]."' WHERE nickname = '".$_SESSION['nickname']."';";
                    mysqli_query($conn, $sql);

                    $_SESSION['nickname'] = $_POST["benutzer"];

                    echo "<label class='erfolg'> Erfolgreiche änderung des Benutzernamens </label>";
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
    <div class="flex-item-right">
        <form name="Abmelden" action="../Anmeldung/Anmeldung.php">
            <input type="submit" class="logout" value="Abmelden">
        </form>
        <br>
        <button class="delete-button" id="delButton" onclick="openDelete()"> Konto löschen </button>

        <div class="delete-popup" id="myDelete">
            <form method="post" class="delete-conatainer" action="../Anmeldung/Anmeldung.php">
                <h3 style="text-decoration: underline"> Konto löschen </h3>
                <label>
                    Wollen Sie ihr <br>
                    Konto wirklich <br>
                    löschen ?
                </label> <br>
                <button type="Button" class="btn-del cancel" onclick="closeDelete()"> Abbrechen </button>
                <button type="submit" name="del" class="btn-del"> OK </button>
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