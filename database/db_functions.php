<?php
function createLink($user = "dev_tts")
{
    $servername = "127.0.0.1";
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
