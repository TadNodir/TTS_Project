<?php
include("../database/db_functions.php");
session_start();

$link = createLink();
function timestampVergleich($timestamp){
    #return true = darf tippen ; false = ist zu spät
    date_default_timezone_set('Europe/Berlin');

    $date= strtotime(date('Y/m/d H:i:s',time()));
    $dateTimestamp= strtotime($timestamp);


    if(($dateTimestamp-$date)>300)
        return true;
    else
        return false;


}
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
        <div class="nav-links" id="navLinks">
            <a href="../Hauptseite/Hauptseite.php" onclick="closeIcon()">Hauptseite</a>
            <a href="#Scoreboard" onclick="closeIcon()">Scoreboard</a>
            <a href="#news" onclick="closeIcon()">News</a>
            <a href="#Anstehende" onclick="closeIcon()">Anstehende</a>
            <a href="#Vergangene" onclick="closeIcon()">Vergangene</a>
            <a href="../Profile/Profile.php">Profil</a>
            <a href="../Anmeldung/Anmeldung.php" onclick="closeIcon()">Abmelden</a>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" id="icon" onclick="myFunction()">&#9776;</a>
        </div>
    </nav>
</header>
<br>

<button id="dark-mode-toggle" class="dark-mode-toggle">
    <svg width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 496"><path fill="currentColor" d="M8,256C8,393,119,504,256,504S504,393,504,256,393,8,256,8,8,119,8,256ZM256,440V72a184,184,0,0,1,0,368Z" transform="translate(-8 -8)"/></svg>
</button>


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
                        "<td> $rowcount </td>".
                        "<td>".$row['nickname'] ."</td>".
                        "<td>".$row['punktestand'] ."</td>".
                    "</tr>";
                    $rowcount++;
                }
                ?>
                </tbody>
                <?php
//                style="border-top: 2px solid"
//                style="text-decoration: none; color: black"

                $pr_query_scr = "SELECT * FROM swe_tts.benutzer WHERE rolle = 0";
                $pr_result_scr = mysqli_query($link, $pr_query_scr);
                $total_record_scr = mysqli_num_rows($pr_result_scr);
                $total_pages_scr = ceil($total_record_scr/$num_per_page);
                $i = 1;
                $continue = 0;
                //                $row_arr = db_scoreboard_punkte($link,

                for ($p = 0; $p <= $total_pages_scr; $p = $p + 5) {
                    $result = db_scoreboard_punkte($link, $p, 5);
                    $data = mysqli_fetch_all($result, MYSQLI_BOTH);
                    foreach($data as $list){
                        if($list['nickname'] == $_SESSION['nickname']){
                            $continue = 1;
                            break;
                        }
                    }
                    if($continue == 1){
                        break;
                    }
                    $i++;
                }

                echo "<td>" . "Mein Ergebnis: " . mysqli_fetch_assoc($result_scoreboard_ergebniss)['punktestand'] ."</td>".
                    "<td>" . "</td>".
                    "<td>"."<button>" . "<a href='Hauptseite.php?pagescr=".($i)."#Scoreboard' . >Eigener Score</a>" . "</button>"."</td>";
                ?>



            </table>
            <?php
            $pr_query_scr = "SELECT * FROM swe_tts.benutzer WHERE rolle = 0";
            $pr_result_scr = mysqli_query($link, $pr_query_scr);
            $total_record_scr = mysqli_num_rows($pr_result_scr);
            $total_pages_scr = ceil($total_record_scr/$num_per_page);

            if($pagescr > 1)
            {
                echo "<p class='prevNext'><a href =  'Hauptseite.php?pagescr=".($pagescr-1)." #Scoreboard ' > Prev </a></p>" ;

            }
            if($pagescr < $total_pages_scr)
            {
                echo "<p class='prevNext'><a href = 'Hauptseite.php?pagescr=".($pagescr+1)." #Scoreboard'> Next </a></p>" ;

            }
            ?>
        </section>

        <section class="a_spiele">
            <h1 id="Anstehende">Anstehende Spiele</h1>
            <table id="anst" class="darkT">
                <thead>
                <tr>
                    <th>Team 1</th>
                    <th>Uhrzeit</th>
                    <th>Team 2</th>
                    <th></th>
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
                        if($_SESSION['rolle'] == '0') {
                            if(timestampVergleich($row['uhrzeit'])){
                                if ($row['TIPP1']) {
                                    echo "<td>" . $row['TIPP1'] . ":" . $row['TIPP2'] . "</td>";
                                    echo "<td>" .
                                        "<button type='button' class='tipp-but' name='tip-b' id='$spiel'> Bearbeiten </button>" .
                                        "<br>" . "<br>" .
                                        "<div class= 'tipp-popup' id='$divID'>" .
                                        " <form method='post'>" .
                                        " <input type='number' placeholder='$row[TIPP1]'  name='spiel1' id='spiel1' required>" .
                                        " <br>" . "<br>" .
                                        " <input type='number' placeholder='$row[TIPP2]' name='spiel2' id='spiel2' required>" .
                                        "<br>" . "<br>" .
                                        "<Button type='submit' name='$divID' value='Tipp' > Speichern </Button>" .
                                        "<Button type='button' id='$closeBtn' onclick='closeTipp()' > Abbrechen </Button>" .
                                        "</form>" .
                                        "</div>" .
                                        "</td>";
                                } else {
                                    echo "<td>" . "/:/" . "</td>";
                                    echo "<td>" .
                                        "<button type='button' class='tipp-but' name='tip-b' id='$spiel'> Tippen </button>" .
                                        "<br>" . "<br>" .
                                        "<div class= 'tipp-popup' id='$divID'>" .
                                        " <form method='post'>" .
                                        " <input type='number' name='spiel1' id='spiel1' required>" .
                                        " <br>" . "<br>" .
                                        " <input type='number' name='spiel2' id='spiel2' required>" .
                                        "<br>" . "<br>" .
                                        "<Button type='submit' name='$divID' value='Tipp' > Tipp </Button>" .
                                        "<Button type='button' id='$closeBtn' onclick='closeTipp()' > Abbrechen </Button>" .
                                        "</form>" .
                                        "</div>" .
                                        "</td>";
                                }
                            }
                           else {
                               if ($row['TIPP1']) {
                                   echo "<td>" . $row['TIPP1'] . ":" . $row['TIPP2'] . "</td>";}
                               else{
                                   echo "<td>" . "/:/" . "</td>";
                               }
                               echo "<td> <p style='color:lightcoral;'>Tipp zu spät</p></td>";}
                        }
                        if(isset($_POST[$divID])){
                            db_tippen($link, $_SESSION['id'],$spiel,$_POST['spiel1'],$_POST['spiel2']);
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
                echo "<p class='prevNext'><a class='prevNext' href =  'Hauptseite.php?pageanst=".($pageanst-1)."&pagevrg=".$pagevrg." #Anstehende ' > Prev </a></p>" ;

            }
            if($pageanst < $total_pages_anst)
            {
                echo "<p class='prevNext'><a class='prevNext' href = 'Hauptseite.php?pageanst=".($pageanst+1)."&pagevrg=".$pagevrg." #Anstehende'> Next </a></p>" ;
            }
            ?>
        </section>

        <section class="v_spiele">
            <h1 id="Vergangene">Vergangene Spiele</h1>
            <table id="vergng" class="darkT">
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
                    echo "<p class='prevNext'><a href =  'Hauptseite.php?pagevrg=".($pagevrg-1)."&pageanst=".$pageanst." #Vergangene ' > Prev </a></p>" ;

                }
                if($pagevrg < $total_pages_verg)
                {
                    echo "<p class='prevNext'><a class='prevNext' href = 'Hauptseite.php?pagevrg=".($pagevrg+1)."&pageanst=".$pageanst." #Vergangene'> Next </a></p>" ;

                }
            ?>
        </section>
    </div>
    <div class="rest">
        <img src="../logo.png" alt="logo">
        <section class="news">
            <div class="darkT">
            <h1 id="news">Newsfeed</h1>
                <ul>
                <?php
                //holen der Daten aus der Datenbank
                $link = createLink();
                // optional port der Datenbank


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

                //$pagecounteranst = 0;
                //$pagecountervrg = 0;
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
                                #$text = $text . '<li>'.'<a href="#Vergangene">' . "Spiel " . $namen['0'] . " gegen ";
                                $text = $text . '<li>' . "Spiel " . $namen['0'] . " gegen ";
                            } else if ($spiele['beendet'] == 0) {
                                #$text = $text . '<li>'.'<a href="#Anstehende">' . "Spiel " . $namen['0'] . " gegen ";
                                $text = $text . '<li>'. "Spiel " . $namen['0'] . " gegen ";
                            } else {
                                echo 'Spiel wurde nicht gefunden!';
                            }
                            $hilf++;
                        }
                        else{
                            if($spiele['beendet'] == 1) {
                                /*
                                if($pagevrg != $pagecountervrg/5){
                                    $newPage = $pagecountervrg/5;
                                    header("Hauptseite.php?pagevrg="."$newPage");
                                }
                                */
                                $text = $text . $namen['0'] . " ist vorbei" . '</a>' .'</li>'.'<br>';
//                                $pagecountervrg++;
                            }
                            else if ($spiele['beendet'] == 0){
                                /*
                                if($pageanst != $pagecounteranst/5){
                                    $newPage = $pagecounteranst/5;
                                    header("Hauptseite.php?pageanst="."$newPage");
                                }
                                */
                                $text = $text . $namen['0'] . " wurde hinzugefügt" . '</a>' .'</li>'. '<br>';
//                                $pagecounteranst++;
                            }
                            else {
                                echo 'Spiel wurde nicht gefunden!';
                            }
                            $hilf = 0;
                        }
                    }
                    echo $text;
                    //Ivan Pageverlinkung
                    /*
                    if($pageanst > 1)
                    {
                        echo "<a href =  'Hauptseite.php?pageanst=".($pageanst-1)." #Anstehende ' > Prev </a>" ;

                    }
                    if($pageanst < $total_pages_anst)
                    {
                        echo "<a href = 'Hauptseite.php?pageanst=".($pageanst+1)." #Anstehende'> Next </a>" ;
                    }
                    */
                }
                ?>
                </ul>
            </div>
        </section>
    </div>
</div>
<footer>
    <li>(c) Gruppe D9</li>
</footer>

</body>
</html>