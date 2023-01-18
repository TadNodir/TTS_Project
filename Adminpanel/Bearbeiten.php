<?php
session_start();
include '../database/db_functions.php';

$link = createLink();

if (isset($_POST['create'])) { //Spiel kann überprüft werden
    if ($_POST['team1'] === $_POST['team2']) { //Überprüfe ob Teams gleich sind
        $gleiche_teams = 1;
    } else {
        $time = $_POST['time'] ?? null;
        $time = mysqli_real_escape_string($link, $time);
        $team1 = $_POST['team1'] ?? null;
        $team1 = mysqli_real_escape_string($link, $team1);
        $team2 = $_POST['team2'] ?? null;
        $team2 = mysqli_real_escape_string($link, $team2);
        $check_existence = "SELECT team_1, team_2, uhrzeit FROM spiele WHERE (uhrzeit >= '$time' - 1 and uhrzeit <= '$time' + 1) and team_1 = " . $_POST['team1'] . " and team_2 = " . $_POST['team2'] . ";";
        $result2 = mysqli_query($link, $check_existence);
        $data2 = mysqli_fetch_assoc($result2);
        //Wenn !NULL → Spiel existiert in einem 1-Tage-Window
        if (empty($data2)) {
//            $team1 = $_POST['team1'];
//            $team2 = $_POST['team2'];
            $uhrzeit = $_POST['date'] . " " . $_POST['time'];
            $uhrzeit = mysqli_real_escape_string($link, $uhrzeit);
            $create = $_POST['create'];
            $create = mysqli_real_escape_string($link, $create);
            $sql = "UPDATE swe_tts.spiele SET team_1 = '$team1' WHERE id = '$create'";
            $sql2 = "UPDATE swe_tts.spiele SET team_2 = '$team2' WHERE id = '$create'";
            $sql3 = "UPDATE swe_tts.spiele SET uhrzeit = '$uhrzeit' WHERE id = '$create'";
            mysqli_query($link, $sql);
            mysqli_query($link, $sql2);
            mysqli_query($link, $sql3);
            $_SESSION['ok'] = true;
            header("Location: Adminpanel.php");
            exit;
        } else {
            $existiert = 1;
            //spiel existiert schon
        }

    }
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
                        <label for = "team1">Team 1: </label>
                        <select id = "team1" name = "team1" required>
                            <option value = "9">  Argentinien </option>
                            <option value = "14"> Australien </option>
                            <option value = "21"> Belgien </option>
                            <option value = "25"> Brasilien </option>
                            <option value = "18"> Costa Rica </option>
                            <option value = "15"> Dänemark </option>
                            <option value = "19"> Deutschland </option>
                            <option value = "2">  Ecuador </option>
                            <option value = "5">  England </option>
                            <option value = "13"> Frankreich </option>
                            <option value = "30"> Ghana </option>
                            <option value = "6">  Iran </option>
                            <option value = "20"> Japan </option>
                            <option value = "28"> Kamerun </option>
                            <option value = "22"> Kanada </option>
                            <option value = "1">  Katar </option>
                            <option value = "24"> Kroatien </option>
                            <option value = "23"> Marokko </option>
                            <option value = "11"> Mexiko </option>
                            <option value = "4">  Niederlande </option>
                            <option value = "12"> Polen </option>
                            <option value = "29"> Portugal </option>
                            <option value = "10"> Saudi Arabien </option>
                            <option value = "27"> Schweiz </option>
                            <option value = "3">  Senegal </option>
                            <option value = "26"> Serbien </option>
                            <option value = "17"> Spanien </option>
                            <option value = "32"> Südkorea </option>
                            <option value = "16"> Tunesien </option>
                            <option value = "31"> Uruguay </option>
                            <option value = "7">  USA </option>
                            <option value = "8">  Wales </option>
                        </select> <br>
                    </div>
                    <div class = "user-box">
                        <label for = "team2">Team 2: </label>
                        <select id = "team2" name = "team2" required>
                            <option value = "9">  Argentinien </option>
                            <option value = "14"> Australien </option>
                            <option value = "21"> Belgien </option>
                            <option value = "25"> Brasilien </option>
                            <option value = "18"> Costa Rica </option>
                            <option value = "15"> Dänemark </option>
                            <option value = "19"> Deutschland </option>
                            <option value = "2">  Ecuador </option>
                            <option value = "5">  England </option>
                            <option value = "13"> Frankreich </option>
                            <option value = "30"> Ghana </option>
                            <option value = "6">  Iran </option>
                            <option value = "20"> Japan </option>
                            <option value = "28"> Kamerun </option>
                            <option value = "22"> Kanada </option>
                            <option value = "1">  Katar </option>
                            <option value = "24"> Kroatien </option>
                            <option value = "23"> Marokko </option>
                            <option value = "11"> Mexiko </option>
                            <option value = "4">  Niederlande </option>
                            <option value = "12"> Polen </option>
                            <option value = "29"> Portugal </option>
                            <option value = "10"> Saudi Arabien </option>
                            <option value = "27"> Schweiz </option>
                            <option value = "3">  Senegal </option>
                            <option value = "26"> Serbien </option>
                            <option value = "17"> Spanien </option>
                            <option value = "32"> Südkorea </option>
                            <option value = "16"> Tunesien </option>
                            <option value = "31"> Uruguay </option>
                            <option value = "7">  USA </option>
                            <option value = "8">  Wales </option>
                        </select> <br>
                    </div>
                    <div class = "user-box">
                        <label for = "time">Zeit: </label>
                        <input type = "time" id = "time" name = "time" required> <br>
                    </div>
                    <div class = "user-box">
                        <label for = "date">Datum: </label>
                        <input type = "date" id = "date" name = "date" required> <br>
                    </div><?php
                    if(isset($existiert) == 1){    //selbsterklärend
                    echo "Spiel existierte schon vor einem oder nach einem Tag";
                    $existiert = 0;
                    }
                    if(isset($gleiche_teams) == 1){
                    echo "Die Teams sind identisch";
                    $gleiche_teams = 0;
                    }
                    else{
                        ;
                    }
                    ?>
                    <a href= "#"><?php
                        echo "<label for = 'create'>";
                        $test = $_POST['Bearbeiten'] ?? $_POST['create'];
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