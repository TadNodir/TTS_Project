<?php
session_start();
include '../database/db_functions.php';

//Konto löschen
$conn = createLink();
if (isset($_GET["del"]))
{
    mysqli_query($conn, "DELETE FROM swe_tts.benutzer WHERE nickname = '".$_SESSION['del']."'");

    unset($_SESSION);

    mysqli_query($conn, "SET @num := 0");
    mysqli_query($conn, "UPDATE swe_tts.benutzer SET id = @num := (@num + 1)");
    mysqli_query($conn, "ALTER TABLE swe_tts.benutzer AUTO_INCREMENT = 1");
}

const const_filter_user = array(  "aufsteigend" => "SELECT punktestand, nickname FROM benutzer WHERE rolle = 0 ORDER BY nickname ASC",
    "absteigend" => "SELECT punktestand, nickname FROM benutzer WHERE rolle = 0 ORDER BY nickname DESC",
    "punktestand_aufsteigend" => "SELECT punktestand, nickname FROM benutzer WHERE rolle = 0 ORDER BY punktestand ASC",
    "punktestand_absteigend" => "SELECT punktestand, nickname FROM benutzer WHERE rolle = 0 ORDER BY punktestand DESC"
);


const const_filter_admin = array(  "aufsteigend" => "SELECT punktestand, nickname FROM benutzer WHERE rolle = 1 or rolle = 2 ORDER BY nickname ASC",
    "absteigend" => "SELECT punktestand, nickname FROM benutzer WHERE rolle = 1 or rolle = 2 ORDER BY nickname DESC",
    "punktestand_aufsteigend" => "SELECT punktestand, nickname FROM benutzer WHERE rolle = 1 or rolle = 2 ORDER BY punktestand ASC",
    "punktestand_absteigend" => "SELECT punktestand, nickname FROM benutzer WHERE rolle = 1 or rolle = 2 ORDER BY punktestand DESC"
);

$link = mysqli_connect(
    "localhost",
    "root",
    "root",
    "swe_tts"
);

function relax(){ //Diese Funktion macht genau so wenig wie ich.
    ;
}



if($link->connect_error){
    die("Connection failed: " . $link->connect_error);
}

/////////////////////////////////////////////////////////USELESS///////////////////////////////////////////////////////////////
//Daten ändern
//Teams $_POST['create']
if (isset($_POST["create111"])) {
    if ($_POST["team1"] != "" && $_POST["team2"] != "") {
        $sql = "UPDATE swe_tts.spiele SET team_1 = '" . $_POST['team1'] . "' WHERE id = '" . $_POST['id'] . "'";
        mysqli_query($link, $sql);

        $sql = "UPDATE swe_tts.spiele SET team_2 = '" . $_POST['team2'] . "' WHERE id = '" . $_POST['id'] . "'";
        mysqli_query($link, $sql);

        echo "<label class='erfolg'> Erfolgreiche änderung des Spiels </label>";
        echo "<br>";
        echo "<meta http-equiv='refresh' content='3'>";
    }

    if($_POST['date'] != "" && $_POST['time'] != ""){
        $sql = "UPDATE swe_tts.spiele SET uhrzeit = '".$_POST['date']." ".$_POST['time']."'";
        mysqli_query($link, $sql);
    }
}


//////////////////////////////////////////////////SPIEL ERSTELLEN///////////////////////////////////////////////////////////

//echo var_dump($_POST);
$existiert = 0;
$gleiche_teams = 0;
$spiel_erstellt = 0;
$spiel_vergangen = 0;
if(!isset($_POST['create'])){//Kein Spiel muss hinzugefügt werden
    relax();    //chill
}else {
    //check if game already exists
    if($_POST['team1'] === $_POST['team2']){
        $gleiche_teams = 1;
    }else if($_POST['time'] < date("H:i:s") && $_POST['date'] <= date("Y-m-d")){
        $spiel_vergangen = 1;
    }
    else if($_POST['date'] < date("Y-m-d")){
        $spiel_vergangen = 1;
    } else {
        $time = $_POST['time'];
        $check_existence = "SELECT team_1, team_2, uhrzeit FROM spiele WHERE (uhrzeit >= '$time' - 1 and uhrzeit <= '$time' + 1) and team_1 = ".$_POST['team1']." and team_2 = ".$_POST['team2'].";";
        //if not null game exists already in a 1 day timeframe
        $result2 = mysqli_query($link, $check_existence);
        $data2 = mysqli_fetch_assoc($result2);
        var_dump($data2);
        if (empty($data2)) {
            $once = 0;
            $team1 = $_POST['team1'];
            $team2 = $_POST['team2'];
            $uhrzeit = $_POST['date'] . " " . $_POST['time'];
            //game doesn't exist
            /*$get_teamID_sql = "SELECT land FROM teams WHERE id = '$team1' and id = '$team2'";
            $result = mysqli_query($link, $get_teamID_sql);
            $data = mysqli_fetch_all($result, MYSQLI_BOTH);
            foreach ($data as $item) {
                if ($item == $team1 && $once = 0) {
                    $team1 = $item; //unnötig
                    $once = 1;
                } else {
                    $team2 = $item;
                }
            }*/
            $spiel_hinzufuegen_sql = "INSERT INTO spiele(team_1, team_2, tore_team1, tore_team2, uhrzeit, beendet) VALUES ('$team1', '$team2', 0, 0, '$uhrzeit', 0 )";
            mysqli_query($link, $spiel_hinzufuegen_sql);
            $spiel_erstellt = 1;
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            $existiert = 1;
            //spiel existiert schon
        }
    }
}

////////////////////////////////////////////////////////USELESS////////////////////////////////////////////////////////////////////////////

function create_userlist($post, $link){
    if(!isset($post['filter']) || $post['filter'] === "n"){
        return;
    } else {
        !empty($post['search']) ? $name = $post['search'] : $filter = const_filter_user[$post['filter']];
        $userlist_sql = (!empty($name)) ? "SELECT punktestand, nickname FROM benutzer WHERE nickname like '%$name%' and rolle = 0"
            : $filter;
        $result = mysqli_query($link, $userlist_sql);
        $data = mysqli_fetch_all($result, MYSQLI_BOTH);
        foreach($data as $list){
            echo "<tr><td>" . $list['nickname'] . "</td>";
            echo "<td>" . $list['punktestand'] . "</td>";
            echo "<td><input type = 'submit' value = 'Bearbeiten' onclick = 'runPop(this)';</td></tr>";
        }
    }
}

////////////////////////////////////////////////////////USELESS////////////////////////////////////////////////////////////////////////////

function create_adminlist($post, $link){
    if(!isset($post['filter2']) || $post['filter2'] === "n"){
        return;
    } else {
        !empty($post['search2']) ? $name = $post['search2'] : $filter = const_filter_admin[$post['filter2']];
        $adminlist_sql = (isset($name)) ? "SELECT punktestand, nickname FROM benutzer WHERE nickname like '%$name%' and (rolle = 1 or rolle = 2)"
            : $filter;
        $result = mysqli_query($link, $adminlist_sql);
        $data = mysqli_fetch_all($result, MYSQLI_BOTH);
        foreach($data as $list){
            echo "<tr><td colspan = 2>" . $list['nickname'] . "</td>";
            echo "<td>" . $list['punktestand'] . "</td></tr>";
        }
    }
}
?>
<!----------------------------------------------------------HTML ABSCHNITT-------------------- ----------------------------------------->

<!DOCTYPE html>
<html lang = "de">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminpanel</title>
    <link href="Adminpanel.css" rel="stylesheet" type="text/css" media="screen">
    <script src="AdminpanelJS.js" defer>
    </script>
</head>
<header>
    <nav class="navigation" id="navi">
        <div class="nav-links">
            <span>Adminpanel</span>
            <a href = "../Anmeldung/Anmeldung.php"> Abmelden</a>
            <?php if($_SESSION['rolle'] == 2){ ?>           <!-- Nur anzeigen wenn Superadmin-->
                <a href = "../Registrierung/AdminRegistrierung.php"> Admin erstellen </a>
            <?php } ?>
        </div>
    </nav>
</header>
<body>
<br>
<label class="switch">
    <input type="checkbox" onclick="darkL()">
    <span class="slider round"></span>
</label>
<div class = "background">
    <div class = "tabellen">
        <section class = "user-liste">
            <h1 id = "<Userliste">Userliste</h1>
            <?php       //User tabelle erstellen
            echo "<table id = 'user'>";
            echo "<thead><tr>";
            echo "<form method = 'post' id = 'userlist'>";
            echo "<th colspan = '2'>
                        <label for = 'search' ></label>
                        <input type = 'text' id = 'search' name = 'search' value = '' placeholder = 'suchen'></th>";
            $test = isset($_POST['filter2']) ? $_POST['filter2'] : "n";
            echo "<th><label for = 'filter'></label>
                      <input type = 'hidden' id = 'filter2' name = 'filter2' value = '$test'>
                        <select id = 'filter' name = 'filter' form = 'userlist'>
                        <option value = 'aufsteigend'> Namen aufsteigend </option>
                            <option value = 'absteigend'> Namen absteigend </option>
                            <option value = 'punktestand_aufsteigend'> Punktestand aufsteigend </option>
                            <option value = 'punktestand_absteigend'> Punktestand absteigend </option>
                        </select>
                        <label for = 'filtern'></label>
                        <input type = 'hidden' id = 'filtern2' name = 'filtern2' value = 'filtern'>
                        <input type = 'submit' id = 'filtern' name = 'filtern' value = 'filtern'>
                        </form></th>";
            echo "</tr><tr>";
            echo "<th>Name</th>";
            echo "<th>Punktestand</th>";
            echo "<th>Bearbeiten</th>";
            echo "</tr></thead>";
            if(!isset($_POST['filter']) || $_POST['filter'] === "n"){       //Kein filter gesetzt
                relax();
            } else {
                !empty($_POST['search']) ? $name = $_POST['search'] : $filter = const_filter_user[$_POST['filter']];    //Abfrage ob filter oder search gesetzt
                $userlist_sql = (!empty($name)) ? "SELECT nickname, punktestand FROM benutzer WHERE nickname like '%$name%' and rolle = 0"  //sql für USER
                    : $filter;
                $result = mysqli_query($link, $userlist_sql);
                echo "<tbody>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<form action = '../Profile/ProfileUser.php' method = 'post'>";
                    echo "<td> " . $row['nickname'] . "</td>";
                    echo "<td>  " . $row['punktestand'] . "</td>";
                    echo "<td><button type = 'submit' name='nickname' value = ".$row['nickname']."> Bearbeiten </button> </td>";    //Onclick weiterleitung zur Profilbearbeitung
                    echo "</tr>";
                    echo "</form>";
                }
                echo "</tbody>";
            }
            echo "</table>";
            ?>
        </section>
        <?php if($_SESSION['rolle'] == 2){     //nur anzeigen wenn Superadmin
            echo "<section class = 'admin-liste'>";
            echo "<h1 id = 'Adminliste'> Adminliste</h1>";
            echo "<table id = 'admin'>";
            echo "<thead><tr>";
            echo "<form method = 'post' id = 'adminlist'>";
            echo "<th colspan = '2'>
                            <label for = 'search2' ></label>
                            <input type = 'text' id = 'search2' name = 'search2' value = '' placeholder = 'suchen'></th>";
            $test2 = isset($_POST['filter']) ? $_POST['filter'] : "n";
            echo "<th><label for = 'filter'></label>
                            <input type = 'hidden' id = 'filter' name = 'filter' value = '$test2'>
                            <select id = 'filter2' name = 'filter2' form = 'adminlist'>
                                <option value = 'aufsteigend'> Namen aufsteigend </option>
                                <option value = 'absteigend'> Namen absteigend </option>
                                <option value = 'punktestand_aufsteigend'> Punktestand aufsteigend </option>
                                <option value = 'punktestand_absteigend'> Punktestand absteigend </option>
                            </select>
                            <label for = 'filtern2'></label>
                            <input type = 'hidden' id = 'filtern' name = 'filtern' value = 'filtern'>
                            <input type = 'submit' id = 'filtern2' name = 'filtern2' value = 'filtern'>
                    </form></th>";
            echo "</tr><tr>";
            echo "<th>Name</th>";
            echo "<th>Punktestand</th>";
            echo "<th>Bearbeiten</th>";
            echo "</tr></thead>";
            if(!isset($_POST['filter2']) || $_POST['filter2'] === "n"){ //Selbe wie oben (User tabelle)
                relax();
            } else {
                !empty($_POST['search2']) ? $name = $_POST['search2'] : $filter = const_filter_admin[$_POST['filter2']];
                $adminlist_sql = (isset($name)) ? "SELECT punktestand, nickname FROM benutzer WHERE nickname like '%$name%' and (rolle = 1 or rolle = 2)"
                    : $filter;
                $result = mysqli_query($link, $adminlist_sql);
                echo "<tbody>";
                while($row = mysqli_fetch_array($result)){
                    echo "<tr>";
                    echo "<form action = '../Profile/ProfileUser.php' method = 'post'>";
                    echo "<td> " . $row['nickname'] . "</td>";
                    echo "<td>  " . $row['punktestand'] . "</td>";
                    echo "<td><button type = 'submit' name='nickname' value = ".$row['nickname']."> Bearbeiten </button> </td>";
                    echo "</tr>";
                    echo "</form>";
                }
                echo "</tbody>";
            }
            echo "</table>";

            echo "</section>";
        } ?>
    </div>
    <div class = "rest">
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
                        </div>
                        <?php
                        if($existiert == 1){    //selbsterklärend
                            echo "Spiel existierte schon vor einem oder nach einem Tag";
                        }
                        if($gleiche_teams == 1){
                            echo "Die Teams sind identisch";
                        }
                        if($spiel_vergangen == 1){
                            echo "Das Spiel hat schon Stattgefunden";
                        }
                        else{
                            relax();
                        }
                        ?>
                        <a href= "#">
                            <label for = "create"></label>
                            <input type = "submit" id = "create" name = "create" value = "Spiel erstellen">
                        </a>
                    </fieldset>
                </form>
            </section>
        </div>
        <span></span>
        <section class = "spielbearbeiten">
            <h1><?php
                if(isset($_SESSION['ok'])){
                    if($_SESSION['ok']){
                        echo "Spiel wurde erfolgreich geändert";
                        $_SESSION['ok'] = false;
                    }
                }
                ?></h1>

            <table class = "verwaltung">
                <thead>
                <tr>
                    <th colspan = "3"> Anstehende Spiele </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <?php
                    $spiele_sql = "SELECT id, team_1, team_2 FROM spiele WHERE beendet = 0";
                    $result = mysqli_query($link, $spiele_sql);
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<form action = 'Ergebnis.php' method = 'post'>";
                        $land = "SELECT land FROM teams WHERE id = ".$row['team_1']." or id = ".$row['team_2']." ";
                        $result2 = mysqli_query($link, $land);
                        $array = mysqli_fetch_all($result2);
                        echo "<td> " . $array[0][0] . " VS ";
                        echo $array[1][0] . "</td>";
                        echo "<td><button type = 'submit' name = 'Ergebnis' value = ".$row['id']."> Ergebnis eingeben </button></td>";
                        echo "</form>";
                        echo "<form action = 'Bearbeiten.php' method = 'post'>";
                        echo "<td><button type = 'submit' name = 'Bearbeiten' value = ".$row['id']." onclick = openForm()> Bearbeiten </button></td>";
                        echo "</tr>";
                        echo "</form>";
                    } ?>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
</div>
</body>
</html>