<?php

session_start();

include '../database/db_functions.php';
$conn = createLink();

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
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Profile.css" rel="stylesheet" type="text/css" media="screen">
    <title>Profile</title>
    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
            document.getElementById("infoTable").style.display = "none";
        }

        function closeForm(){
            document.getElementById("myForm").style.display = "none";
            document.getElementById("infoTable").style.display = "block";
        }

        function openDelete() {
            document.getElementById("myDelete").style.display = "block";
        }

        function closeDelete() {
            document.getElementById("myDelete").style.display = "none";
        }

        function myPassword(){
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        function myPasswordRe(){
            var x = document.getElementById("passwordRe");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</head>
<body>

<div class="flex-container">

    <div class="flex-item-left">  <a href="../Hauptseite/Hauptseite.php"> <img src="../logo_200x200.png" alt="TTS-Logo"> </a> </div>

    <div class="flex-item-middle">
        <h2>Benutzerinfo</h2>
        <table id="infoTable">
            <tr>
                <th class="tbl">
                    <?php
                    //echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT nickname FROM swe_tts.benutzer where id=1"))["nickname"];

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
                    //echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT punktestand FROM swe_tts.benutzer where id=1"))["punktestand"];

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
                    //echo mysqli_fetch_assoc(getQueryResult($conn, "SELECT vorname FROM swe_tts.benutzer where id=1"))["vorname"];

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
                    //echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT nachname FROM swe_tts.benutzer where id=1"))["nachname"];

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
                    //$emaol = getQueryResult($conn,"SELECT email FROM swe_tts.benutzer");
                    //echo mysqli_fetch_assoc($emaol)["email"];
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
            <tr>
                <td> Password: </td>
                <td class="tbl">
                    <?php
                    //echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT passwort FROM swe_tts.benutzer where id=1"))["passwort"];

                    if (isset($_SESSION['passwort']))
                    {
                        echo $_SESSION['passwort'];
                    }
                    else
                    {
                        echo "Fehler";
                    }
                    ?>
                </td>
            </tr>
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
                <input type="password" name="password" id="password">
                <label> <input type="checkbox" onclick="myPassword()"> Show Password </label>

                <label for="passwordRe"> Password bestätigen: </label>
                <input type="password" name="passwordRe" id="passwordRe">
                <label> <input type="checkbox" onclick="myPasswordRe()"> Show Password </label>

                <button type="submit" class="btn"> Daten ändern </button>
                <button type="button" class="btn cancel" onclick="closeForm()"> Abbrechen </button>
            </form>
        </div>

        <?php //Daten ändern

        if (isset($_POST["benutzer"]))
        {
            if ($_POST["benutzer"] != "")
            {
                $g = "SELECT id FROM swe_tts.benutzer WHERE nickname = '".$_POST["benutzer"]."';";

                if (mysqli_fetch_assoc(mysqli_query($conn, $g)) === NULL)
                {
                    $sql = "UPDATE swe_tts.benutzer SET nickname = '".$_POST["benutzer"]."' WHERE id = 1";
                    mysqli_query($conn, $sql);

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

        if (isset($_POST["email"]))
        {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
            {
                if (!Trashmail($_POST["email"]))
                {
                    $sql = "UPDATE swe_tts.benutzer SET email = '".$_POST["email"]."' WHERE id = 1";
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
                    $sql = "UPDATE swe_tts.benutzer SET passwort = '".$_POST["password"]."' WHERE id = 1";
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
        ?>

    </div>
    <div class="flex-item-right">
        <form name="Abmelden" action="../Anmeldung/Anmeldung.php">
            <input type="submit" class="logout" value="Abmelden">
        </form>
        <br>
        <button class="delete-button" onclick="openDelete()"> Konto löschen </button>

        <div class="delete-popup" id="myDelete">

            <form method="get" class="delete-conatainer" action="../Anmeldung/Anmeldung.php">
                <h3> Konto löschen </h3>

                <label> Wollen Sie ihr </label> <br>
                <label> Konto wirklich </label> <br>
                <label> löschen ? </label> <br>
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