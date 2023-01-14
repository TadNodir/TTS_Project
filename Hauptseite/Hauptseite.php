<?php
include("../database/db_functions.php");
session_start();

$link = createLink();
if(isset($_SESSION['id'])) $eingellogt = $_SESSION['id'];

$num_per_page = 5;

if(isset($_GET['pagescr'])){
    $pagescr = $_GET['pagescr'];
}
else{
    $pagescr = 1;
}
$start_from_scr = ($pagescr-1)*$num_per_page;


if(isset($_GET['pageanst'])){
    $pageanst = $_GET['pageanst'];
}
else{
    $pageanst = 1;
}
$start_from_anst = ($pageanst-1)*$num_per_page;


if(isset($_GET['pagevrg'])){
    $pagevrg = $_GET['pagevrg'];
}
else{
    $pagevrg = 1;
}
$start_from_verg = ($pagevrg-1)*$num_per_page;

$result_scoreboard_ergebniss = db_scoreboard_ergebniss($link, $eingellogt);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hauptseite</title>
    <link href="Homepage.css" rel="stylesheet" type="text/css" media="screen">
    <script src="HomepageJS.js" defer></script>
</head>

<body>
<header>
    <nav class="navigation" id="navi">
        <div class="nav-links">
            <span>Hauptseite</span>
            <a href="#Scoreboard">Scoreboard</a>
            <a href="#News">News</a>
            <a href="#Anstehende">Anstehende</a>
            <a href="#Vergangene">Vergangene</a>
            <a href="../Profile/Profile.php">Profil</a>
            <a href="../Anmeldung/Anmeldung.php">Abmelden</a>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>
    </nav>
</header>
<br>
<label class="switch">
    <input type="checkbox" onclick="darkL()">
    <span class="slider round"></span>
</label>
<div class="background">
    <div class="main_page">
        <section class="scoreboard">
            <h1 id="Scoreboard">Scoreboard</h1>
            <table id="scr">
                <thead>
                <tr>
                    <th>Platz</th>
                    <th>Name</th>
                    <th>Punktestand</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $result_scoreboard_punkte = db_scoreboard_punkte($link,  $start_from_scr, $num_per_page);
                $rowcount = 1 * $start_from_scr + 1;
                while ($row = mysqli_fetch_assoc($result_scoreboard_punkte)) {
                    echo "<tr>" .
                        "<td> $rowcount </td>" .
                        "<td>".$row['nickname'] ."</td>".
                        "<td>".$row['punktestand'] ."</td>".
                    "</tr>";
                    $rowcount++;
                }
                ?>
                </tbody>
                <?php
                    echo "<td>". "Mein Ergebnis: " . mysqli_fetch_assoc($result_scoreboard_ergebniss)['punktestand'] ."</td>"
                ?>
               <!-- <td style="border-top: 2px solid">Mein Ergebnis: 50</td>-->
                <td style="border-top: 2px solid"></td>
                <td style="border-top: 2px solid"></td>
            </table>
            <?php
            $pr_query_scr = "SELECT * FROM swe_tts.benutzer WHERE rolle = 0";
            $pr_result_scr = mysqli_query($link, $pr_query_scr);
            $total_record_scr = mysqli_num_rows($pr_result_scr);
            $total_pages_scr = ceil($total_record_scr/$num_per_page);

            if($pagescr > 1)
            {
                echo "<a href =  'Hauptseite.php?pagescr=".($pagescr-1)." #Scoreboard ' > Perv </a>" ;

            }
            if($pagescr < $total_pages_scr)
            {
                echo "<a href = 'Hauptseite.php?pagescr=".($pagescr+1)." #Scoreboard'> Next </a>" ;

            }
            ?>
        </section>

        <section class="a_spiele">
            <h1 id="Anstehende">Anstehende Spiele</h1>
            <table id="anst">
                <thead>
                <tr>
                    <th>Team 1</th>
                    <th>Uhrzeit</th>
                    <th>Team 2</th>
                    <th>Tipp</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $result_ans_spiele = db_select_anst_spiele($link, $eingellogt, $start_from_anst, $num_per_page);
                    while ($row = mysqli_fetch_assoc($result_ans_spiele))
                    {
                        $spiel = $row['SPIEL'];

                        $divID = "pop-" . $spiel;
                        $closeBtn = "cls-" . $spiel;

                        echo "<tr>".
                            "<td>".$row['FLAG1'].$row['LAND1']."</td>".
                            "<td>".$row['uhrzeit']."</td>".
                            "<td>".$row['FLAG2'].$row['LAND2']."</td>";
                        if($_SESSION['rolle'] == '0')
                        {

                         echo "<td>".
                               "<button type='button' class='tipp-but' name='tip-b' id='$spiel'> Tippen </button>" .
                                "<br>" . "<br>".
                                "<div class= 'tipp-popup' id='$divID'>".
                                   " <form method='post'>" .
                                       " <input placeholder='Team 1' name='spiel1' id='spiel1'>" .
                                       " <br>" . "<br>".
                                       " <input placeholder='Team 2' name='spiel2' id='spiel2'>" .
                                        "<br>"  . "<br>" .
                                        "<Button type='submit' name='submit' value='Tipp'> Tipp </Button>" .
                                        "<Button type='button' id='$closeBtn' onclick='closeTipp()' > Abbrechen </Button>" .
                                    "</form>" .
                                "</div>" .

                            "</td>";

                        }
                    }
                    ?>
                </tbody>
            </table>
            <?php
            $pr_query_anst = "SELECT * FROM spiele WHERE beendet = 0";
            $pr_result_anst = mysqli_query($link, $pr_query_anst);
            $total_record_anst = mysqli_num_rows($pr_result_anst);
            $total_pages_anst = ceil($total_record_anst/$num_per_page);

            if($pageanst > 1)
            {
                echo "<a href =  'Hauptseite.php?pageanst=".($pageanst-1)." .#Anstehende ' > Perv </a>" ;

            }
            if($pageanst < $total_pages_anst)
            {
                echo "<a href = 'Hauptseite.php?pageanst=".($pageanst+1)." #Anstehende'> Next </a>" ;
            }
            ?>
        </section>

        <section class="v_spiele">
            <h1 id="Vergangene">Vergangene Spiele</h1>
            <table id="vergng">
                <thead>
                <tr>
                    <th>Team 1</th>
                    <th>Ergebnis</th>
                    <th>Team 2</th>
                    <th>Tipp</th>
                    <th>Punktzahl</th>
                </tr>
                </thead>
                <tbody>

                <?php

                $result_verg_spiele = db_select_verg_spiele($link, $eingellogt, $start_from_verg ,$num_per_page);
                    while ($row = mysqli_fetch_assoc($result_verg_spiele)) {
                    echo "<tr>" .
                        "<td>" .$row['FLAG1'] . $row['LAND1'] . "</td>" .
                        "<td>" . $row['tore_team1'] . ":" . $row['tore_team2'] . "</td>" .
                        "<td>" .$row['FLAG2'] . $row['LAND2'] . "</td>";
                    if($row['TIPP1']) echo "<td>"  . $row['TIPP1'] .":". $row['TIPP2'] . "</td>".
                        "<td>"  . $row['VERDIENT'] . "</td>";
                    else echo "<td>"  . "Nicht Gettipt" . "</td>" .
                    "<td>" . "Keine Punkte" ." </td>";
                    echo    "</tr>";
                }

                ?>
                </tbody>
            </table>
            <?php
                $pr_query_verg = "SELECT * FROM spiele WHERE beendet = 1";
                $pr_result_verg = mysqli_query($link, $pr_query_verg);
                $total_record_verg = mysqli_num_rows($pr_result_verg);
                $total_pages_verg = ceil($total_record_verg/$num_per_page);

                if($pagevrg > 1)
                {
                    echo "<a href =  'Hauptseite.php?pagevrg=".($pagevrg-1)." #Vergangene ' > Perv </a>" ;

                }
                if($pagevrg < $total_pages_verg)
                {
                    echo "<a href = 'Hauptseite.php?pagevrg=".($pagevrg+1)." #Vergangene'> Next </a>" ;

                }
            ?>
        </section>
    </div>
    <div class="rest">
        <img src="../logo.png" alt="logo">
        <section class="news">
            <h1 id="news">Newsfeed</h1>
            <p>
            <ul>
                <?php
                //holen der Daten aus der Datenbank
                $link = mysqli_connect("localhost", // Host der Datenbank
                    "dev_tts",                 // Benutzername zur Anmeldung
                    "QN7ZAqgGY9wZ",    // Passwort
                    "swe_tts"    // Auswahl der Datenbanken (bzw. des Schemas)
                // optional port der Datenbank
                );

                if (!$link) {
                    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
                    exit();
                }

                //fragt alle Spiele Ab die entweder noch ausstehen oder vor weniger als 2 Tagen beendet wurden
                $test = date("Y/m/d");
                $vergleich = $test;
                $sql = "SELECT team_1, team_2 , beendet, uhrzeit FROM spiele
                        WHERE beendet = 0 OR $vergleich=substring(uhrzeit, 0, 10) <= $test";

                $result = mysqli_query($link, $sql);
                if (!$result) {
                    echo "Fehler während der Abfrage:  ", mysqli_error($link);
                    exit();
                }
                $data = mysqli_fetch_all($result, MYSQLI_BOTH);


                //gibt alle spiele der eben sortierten Spiele aus
                foreach ($data as $spiele){

                    $hilfteam_1 = $spiele['team_1'];
                    $hilfteam_2 = $spiele['team_2'];
                    $sql = "SELECT land FROM teams WHERE id = $hilfteam_1 OR id = $hilfteam_2";

                    $result = mysqli_query($link, $sql);
                    if (!$result) {
                        echo "Fehler während der Abfrage:  ", mysqli_error($link);
                        exit();
                    }
                    $teamdata = mysqli_fetch_all($result, MYSQLI_BOTH);
                    $hilf = 0;
                    $text = "";
                    foreach ($teamdata as $namen) {
                        if($hilf == 0){
                            if ($spiele['beendet'] == 1) {
                                $text = $text . '<li>'.'<a href="#Vergangene">' . "Spiel " . $namen['0'] . " gegen ";
                            } else if ($spiele['beendet'] == 0) {
                                $text = $text . '<li>'.'<a href="#Anstehende">' . "Spiel " . $namen['0'] . " gegen ";
                            } else {
                                echo 'Spiel wurde nicht gefunden!';
                            }
                            $hilf++;
                        }
                        else{
                            if($spiele['beendet'] == 1) {
                                $text = $text . $namen['0'] . " ist vorbei" . '</a>' .'</li>'.'<br>';
                            }
                            else if ($spiele['beendet'] == 0){
                                $text = $text . $namen['0'] . " wurde hinzugefügt" . '</a>' .'</li>'. '<br>';
                            }
                            else {
                                echo 'Spiel wurde nicht gefunden!';
                            }
                            $hilf = 0;
                        }
                    }
                    echo $text;
                }
                ?>
            </ul>
            </p>
        </section>
    </div>
</div>
<footer>
    <li>(c) Gruppe D9</li>
</footer>

</body>
</html>