<?php
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
    </script>

</head>
<body>
<div class="flex-container">
    <div class="flex-item-left">  <a href="Hauptseite.php"> <img src="logo_200x200.png" alt="TTS-Logo"> </a> </div>

    <div class="flex-item-middle">
        <table>
            <tr>
                <th> Nickname <!-- hier code verknüpfung mit datnebank --> </th>
                <th> Punktestand <!-- hier code verknüpfung mit datnebank --> </th>
            </tr>
            <tr>
                <td> Vorname: </td>
                <td> Nachanme: </td>
            </tr>
            <tr>
                <td> Max <!-- hier code verknüpfung mit datnebank --> </td>
                <td> Mustermann <!-- hier code verknüpfung mit datnebank --> </td>
            </tr>
            <tr>
                <td colspan="2"> E-Mail: </td>
            </tr>
            <tr>
                <td colspan="2"> examples@gmail.com <!-- hier code verknüpfung mit datnebank --> </td>
            </tr>
            <tr>
                <td> Password: </td>
            </tr>
            <tr>
                <td> ******* <!-- hier code verknüpfung mit datenbank --> </td>
                <td>
                    <button class="open-button" onclick="openForm()"> Daten ändern </button>
                </td>
            </tr>
        </table>
    </div>
    <div class="flex-item-right">
        <form name="Abmelden" action="Anmeldung.php">
            <input type="submit" value="Abmelden">
        </form>
        <br>
        <button class="delete-button" onclick="openDelete()"> Konto löschen </button>

        <div class="delete-popup" id="myDelete">

            <form class="delete-conatainer" action="Anmeldung.php">
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

<div class="form-popup" id="myForm">
    <form action="Profile.php" class="form-container">
        <h3> Daten ändern </h3>

        <label for="benutzername"> Benutzername: </label>
        <input type="text" name="benutzer" id="benutzername">
        <br> <br>
        <label for="email"> E-mail: </label>
        <input type="email" name="email" id="email">
        <br> <br>
        <label for="password"> Password: </label>
        <input type="password" name="password" id="password">
        <br> <br>
        <label for="passwordRe"> Password bestätigen: </label>
        <input type="password" name="passwordRe" id="passwordRe">
        <br> <br>
        <button type="submit" class="btn"> Daten ändern </button>
        <button type="button" class="btn cancel" onclick="closeForm()"> Abbrechen </button>
    </form>
</div>

<br> <br> <br>

</body>
</html>