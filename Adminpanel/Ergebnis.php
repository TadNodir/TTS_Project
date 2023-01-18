<?php
include '../database/db_functions.php';


session_start();

$link = createLink();

function setScores($link, $spiel_id, $tore_1, $tore_2){
    $spiel_id = mysqli_real_escape_string($link, $spiel_id);
    $sql = "SELECT tipper, tipp_team1, tipp_team2 from tipps WHERE spiel = '$spiel_id' ";
    $result = mysqli_query($link, $sql);
    //ist tipp vollständig korrekt
    $row = mysqli_fetch_all($result, MYSQLI_BOTH);
    foreach($row as $list){
        if ($list['tipp_team1'] === $tore_1 && $list['tipp_team2'] === $tore_2) {
            $sql = "UPDATE swe_tts.benutzer SET punktestand = punktestand + 3 WHERE id = '".$list['tipper']."'";
            $sql2 = "UPDATE swe_tts.tipps SET verdient = 3 WHERE tipper = '".$list['tipper']."' and spiel = '$spiel_id'";
            mysqli_query($link, $sql);
            mysqli_query($link, $sql2);
        } //ist das ergebniss richtig
        else if ($list['tipp_team1'] === $tore_1 || $list['tipp_team2'] === $tore_2) {
            $sql3 = "UPDATE swe_tts.benutzer SET punktestand = punktestand + 1 WHERE id = '".$list['tipper']."'";
            $sql4 = "UPDATE swe_tts.tipps SET verdient = 1 WHERE tipper = '".$list['tipper']."' and spiel = '$spiel_id'";
            mysqli_query($link, $sql3);
            mysqli_query($link, $sql4);
        }
    }
    //ist das ergebnis falsch

}

if (isset($_POST['create'])) { //Spiel kann überprüft werden

    $create = $_POST['create'] ?? null;
    $create = mysqli_real_escape_string($link, $create);
    $team1 = $_POST['team1'] ?? null;
    $team1 = mysqli_real_escape_string($link, $team1);
    $team2 = $_POST['team2'] ?? null;
    $team2 = mysqli_real_escape_string($link, $team2);
    $sql = "SELECT team_1, team_2 FROM spiele WHERE id = '$create'";
    $result = mysqli_query($link, $sql);
    $data2 = mysqli_fetch_assoc($result);

    $sql1 = "UPDATE swe_tts.spiele SET tore_team1 = '$team1' WHERE id = '$create'";
    $sql2 = "UPDATE swe_tts.spiele SET tore_team2 = '$team2' WHERE id = '$create'";

    $sql3 = "UPDATE swe_tts.spiele SET beendet = 1 WHERE id = '$create'";

    mysqli_query($link, $sql1);
    mysqli_query($link, $sql2);

    mysqli_query($link, $sql3);
    $_SESSION['ergebnis_ok'] = true;

    setScores($link, $_POST['create'], $_POST['team1'], $_POST['team2']);


    header("Location: Adminpanel.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang = "de">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminpanel</title>
    <link href="Bearbeiten.css" rel="stylesheet" type="text/css" media="screen">

</head>
<body>
<button id="dark-mode-toggle" class="dark-mode-toggle">
    <svg width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 496"><path fill="currentColor" d="M8,256C8,393,119,504,256,504S504,393,504,256,393,8,256,8,8,119,8,256ZM256,440V72a184,184,0,0,1,0,368Z" transform="translate(-8 -8)"/></svg>
</button>

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

<script src="AdminpanelJS.js"> </script>
</html>
