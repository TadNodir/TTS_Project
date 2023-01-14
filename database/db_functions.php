<?php
function createLink($user = "dev_tts")
{
    $servername = "localhost";
    $username = $user;
    $password = "QN7ZAqgGY9wZ";
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
     FROM tipps WHERE spiele.id = id AND tipper = '$userid') AS TIPP1,
    (SELECT tipp_team2
     FROM tipps WHERE spiele.id = id AND tipper = '$userid') AS TIPP2,
    (SELECT verdient
     FROM tipps WHERE spiele.id = id AND tipper = '$userid') AS VERDIENT
FROM spiele
         JOIN teams t on spiele.team_1 = t.id
         JOIN teams t2 on spiele.team_2 = t2.id
WHERE beendet = 0 
LIMIT $page_anst, $num";
    return mysqli_query($link, $query);
}

function db_select_verg_spiele($link ,$userid, $page_verg,$num){
    $query = "SELECT
    spiele.id AS SPIEL,
    t.id, t.land AS LAND1, t.flag AS FLAG1,
    t2.id, t2.land AS LAND2, t2.flag AS FLAG2,
    tore_team1, tore_team2,
    

    (SELECT tipp_team1
     FROM tipps WHERE spiele.id = id AND tipper = '$userid') AS TIPP1,
    (SELECT tipp_team2
     FROM tipps WHERE spiele.id = id AND tipper = '$userid') AS TIPP2,
    (SELECT verdient
     FROM tipps WHERE spiele.id = id AND tipper = '$userid') AS VERDIENT
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
    $query = "INSERT INTO tipps (tipper,spiel,tipp_team1,tipp_team2) VALUES ('$userid', '$spiel','$tipp1','$tipp2')";

}