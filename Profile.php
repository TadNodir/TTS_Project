<?php
session_start();
$conn = mysqli_connect(
        "localhost",
    "root",
    "root",
    "swe"
);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <title>Profile</title>
    <style>
        .flex-container{
            display: flex;
            height: 500px;
            flex-direction: row;
            justify-content: space-between;
            margin-inline: 5rem;
        }

        .flex-item-middle{
            align-self: center;
        }

        .form-popup{
            display: none;
        }

        .delete-popup{
            display: none;
        }

        @media (max-width: 800px) {
            .flex-container{
                flex-direction: column;
            }

            .flex-item-right{
                align-self: center;
            }

            .flex-item-left{
                align-self: center;
            }
        }
    </style>

    <script>
        function openForm() {
            document.getElementById("myForm").style.display = "block";
        }

        function closeForm(){
            document.getElementById("myForm").style.display = "none";
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
    <div class="flex-item-left">  <a href="Hauptseite.php"> <img src="logo_200x200.png" alt="TTS-Logo"> </a> </div>

    <div class="flex-item-middle">
        <table>
            <tr>
                <th>
                    <?php
                   # echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT nickname FROM swe.benutzer where id = 1"))["nickname"];
                    if(isset($_SESSION['nickname']))
                        echo $_SESSION['nickname'];
                    else echo "Fehler";
                    ?>
                </th>
                <th>
                    <?php
                    #echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT punktestand FROM swe.benutzer"))["punktestand"];
                    if(isset($_SESSION['punktestand']))
                        echo $_SESSION['punktestand'];
                    else echo "Fehler";
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
                    #echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT vorname FROM swe.benutzer"))["vorname"];
                    if(isset($_SESSION['vorname']))
                        echo $_SESSION['vorname'];
                    else echo "Fehler";
                    ?>
                </td>
                <td>
                    <?php
                    #echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT nachname FROM swe.benutzer"))["nachname"];
                    if(isset($_SESSION['nachname']))
                        echo $_SESSION['nachname'];
                    else echo "Fehler";
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"> E-Mail: </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php

                    ?>
                </td>
            </tr>
            <tr>
                <td> Password: </td>
            </tr>
            <tr>
                <td>
                    <label

                    <?php
                    echo mysqli_fetch_assoc(mysqli_query($conn, "SELECT passwort FROM swe.benutzer"))["passwort"];
                    ?>
                </td>
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
    </div>
    <br> <br>
    <div class="flex-item-right">
        <form name="Abmelden" action="Anmeldung/Anmeldung.php">
            <input type="submit" value="Abmelden">
        </form>
        <br>
        <button class="delete-button" onclick="openDelete()"> Konto löschen </button>

        <div class="delete-popup" id="myDelete">

            <form class="delete-conatainer" action="Anmeldung/Anmeldung.php">
                <h3> Konto löschen </h3>

                <label> Wollen Sie ihr </label> <br>
                <label> Konto wirklich </label> <br>
                <label> löschen ? </label> <br>
                <button type="Button" class="btn-del cancel" onclick="closeDelete()"> Abbrechen </button>
                <button type="submit" class="btn-del"> OK </button>
            </form>

        </div>
    </div>
</div>

</body>
</html>