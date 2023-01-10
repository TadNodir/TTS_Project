<?php
session_start();

$link = mysqli_connect(
    "localhost",
    "root",
    "root",
    "swe_tts"
);

if (isset($_POST['create'])) { //Spiel kann überprüft werden

    $sql = "SELECT team_1, team_2 FROM spiele WHERE id = '".$_POST['create']."'";
    $result = mysqli_query($link, $sql);
    $data2 = mysqli_fetch_assoc($result);

    $sql1 = "UPDATE swe_tts.spiele SET tore_team1 = '" . $_POST['team1'] . "' WHERE id = '" . $_POST['create'] . "'";
    $sql2 = "UPDATE swe_tts.spiele SET tore_team2 = '" . $_POST['team2'] . "' WHERE id = '" . $_POST['create'] . "'";

    $sql3 = "UPDATE swe_tts.spiele SET beendet = 1 WHERE id = '" . $_POST['create'] . "'";

    mysqli_query($link, $sql1);
    mysqli_query($link, $sql2);

    mysqli_query($link, $sql3);
    $_SESSION['ergebnis_ok'] = true;
    header("Location: Adminpanel.php");
    exit;
}
?>

<script>
    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }
</script>
<!DOCTYPE html>
<html lang = "de">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminpanel</title>
    <link href="Bearbeiten.css" rel="stylesheet" type="text/css" media="screen">
    <script src="AdminpanelJS.js" defer>
    </script>
</head>
<body>
<div class="flex-item-middle">
    <div class = "login-box">
        <section class = "spielerstellung">
            <form method = "post" id = "spiel_erstellung">
                <fieldset>
                    <legend> Spielerstellen </legend>
                    <div class = "user-box">
                        <label for = "team1">Team 1 Tore: </label>
                        <input type = "number" min = "0" id = "team1" name = "team1" required> <br>
                    </div>
                    <div class = "user-box">
                        <label for = "team2">Team 2 Tore: </label>
                        <input type = "number" min = "0" id = "team2" name = "team2" required> <br>
                    </div>
                    <a href= "#"><?php
                        var_dump($_POST);
                        echo "<label for = 'create'>";
                        $test = $_POST['Ergebnis'] ?? $_POST['create'];
                        echo "<button type = 'submit' name = 'create' value = '$test'> Bearbeiten</button>"
                        ?>
                    </a>
                </fieldset>
            </form>
        </section>
    </div>
    <span></span>
</body>
</html>
