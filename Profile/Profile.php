

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

                </th>
                <th class="tbl">

                </th>
            </tr>
            <tr>
                <td> Vorname: </td>
                <td> Nachname: </td>
            </tr>
            <tr>
                <td class="tbl">

                </td>
                <td class="tbl">

                </td>
            </tr>
            <tr>
                <td colspan="2"> E-Mail: </td>
            </tr>
            <tr>
                <td colspan="2" class="tbl">

                </td>
            </tr>
            <tr>
                <td> Password: </td>
                <td class="tbl">

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


    </div>
</div>



</body>
</html>