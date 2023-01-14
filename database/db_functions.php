<?php
function createLink()
{
    $servername = "localhost";
    $username = 'root';
    $password = "root";
    $database = "swe_tts";
    $link = mysqli_connect($servername, $username, $password, $database);
    if (!$link) {
        echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
        exit();
    }
    return $link;
}

function getQueryResult($link, $sql)
{
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "Fehler während der Abfrage:  ", mysqli_error($link);
        exit();
    }
    return $result;
}

function closeLink($link, $result = null)
{
    if (gettype($result) === "mysqli_result") {
        mysqli_free_result($result);
    }
    mysqli_close($link);
}

function db_select_anst_spiele($link, $userid, $page_anst, $num){
    $query = "SELECT
    spiele.id AS SPIEL,
    t.id, t.land AS LAND1, t.flag AS FLAG1,
    t2.id, t2.land AS LAND2, t2.flag AS FLAG2,
    tore_team1, tore_team2,
    uhrzeit,

    (SELECT tipp_team1
     FROM tipps WHERE spiele.id = SPIEL AND tipper = '$userid') AS TIPP1,
    (SELECT tipp_team2
     FROM tipps WHERE spiele.id = SPIEL AND tipper = '$userid') AS TIPP2,
    (SELECT verdient
     FROM tipps WHERE spiele.id = SPIEL AND tipper = '$userid') AS VERDIENT
FROM spiele
         JOIN teams t on spiele.team_1 = t.id
         JOIN teams t2 on spiele.team_2 = t2.id
WHERE beendet = 0 
ORDER BY uhrzeit ASC 
LIMIT $page_anst, $num;";
    return mysqli_query($link, $query);
}

function db_select_verg_spiele($link ,$userid, $page_verg,$num){

    $query = "SELECT
    spiele.id AS SPIEL,
    t.id, t.land AS LAND1, t.flag AS FLAG1,
    t2.id, t2.land AS LAND2, t2.flag AS FLAG2,
    tore_team1, tore_team2,
    
    (SELECT tipp_team1
     FROM tipps WHERE spiele.id = SPIEL AND tipper = '$userid') AS TIPP1,
    (SELECT tipp_team2
     FROM tipps WHERE spiele.id = SPIEL AND tipper = '$userid') AS TIPP2,
    (SELECT verdient
     FROM tipps WHERE spiele.id = SPIEL AND tipper = '$userid') AS VERDIENT
FROM spiele
         JOIN teams t on spiele.team_1 = t.id
         JOIN teams t2 on spiele.team_2 = t2.id
WHERE beendet = 1
LIMIT $page_verg,$num";
    return mysqli_query($link, $query);
}

function db_scoreboard_punkte($link, $page_scr, $num){
    $query = "SELECT nickname, punktestand FROM benutzer WHERE rolle = 0 ORDER BY punktestand DESC LIMIT $page_scr,$num";
    return mysqli_query($link, $query);
}

function db_scoreboard_ergebniss($link, $userid){
    $query = "SELECT punktestand FROM benutzer WHERE id = '$userid'";
    return mysqli_query($link, $query);
}

function db_tippen($link, $userid, $spiel, $tipp1, $tipp2){
    $query_check = ("SELECT * FROM tipps WHERE tipper LIKE '$userid' AND spiel LIKE '$spiel'");
    $exists = mysqli_fetch_assoc(mysqli_query($link, $query_check));
    if(!$exists){
        $query = "INSERT INTO tipps (tipper,spiel,tipp_team1,tipp_team2,verdient) VALUES ('$userid', '$spiel','$tipp1','$tipp2','0')";
        mysqli_query($link, $query);
        header("Location: http://localhost:63342/tts/Hauptseite/Hauptseite.php");
    }
    else{
        $query = "UPDATE tipps SET tipp_team1 = '$tipp1', tipp_team2 = '$tipp2' WHERE spiel = $spiel AND tipper = $userid";
        mysqli_query($link, $query);
        header("Location: http://localhost:63342/tts/Hauptseite/Hauptseite.php");
    }
}

