
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
        </div>
    </nav>
</header>
<body>
<div class = "background">
    <div class = "tabellen">
        <section class = "user-liste">
            <h1 id = "<Userliste">Userliste</h1>
            <?php
            //$s = "SELECT nickname, punktestand FROM benutzer";
            //$sQ = $link->query($s);
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
            if(!isset($_POST['filter']) || $_POST['filter'] === "n"){
                relax();
            } else {
                !empty($_POST['search']) ? $name = $_POST['search'] : $filter = const_filter_user[$_POST['filter']];
                $userlist_sql = (!empty($name)) ? "SELECT punktestand, nickname FROM benutzer WHERE nickname like '%$name%' and rolle = 0"
                    : $filter;
                $result = mysqli_query($link, $userlist_sql);
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
            ?>
        </section>
        <?php if($_SESSION['rolle'] === 2){
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
                if(!isset($_POST['filter2']) || $_POST['filter2'] === "n"){
                relax();
                } else {
                    !empty($_POST['search2']) ? $name = $_POST['search2'] : $filter = const_filter_admin[$_POST['filter2']];
                    $adminlist_sql = (isset($name)) ? "SELECT punktestand, nickname FROM benutzer WHERE nickname like '%$name%' and (rolle = 1 or rolle = 2)"
                        : $filter;
                    $result = mysqli_query($link, $adminlist_sql);
                echo "<tbody>";
                while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                    echo "<form action = '../Profile/ProfileAdmin.php' method = 'post'>";
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
                        <option value = "19"> Deutschland </option>
                        <option value = "13"> Frankreich </option>
                        <option value = "17"> Spanien </option>
                    </select> <br>
                </div>
                <div class = "user-box">
                    <label for = "team2">Team 2: </label>
                    <select id = "team2" name = "team2" required>
                        <option value = "19"> Deutschland </option>
                        <option value = "13"> Frankreich </option>
                        <option value = "17"> Spanien </option>
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
                    if($existiert == 1){
                        echo "Spiel existierte schon vor einem oder nach einem Tag";
                    }
                    elseif($gleiche_teams == 1){
                        echo "Die Teams sind identisch";
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
        <h1></h1>
        <table class = "verwaltung">
        <thead>
            <tr>
                <th colspan = "3"> Anstehende Spiele </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> DE vs FR </td>
                <form method = "post">
                <td>
                    <label for = "result"></label>
                    <input type = "submit" id = "result" name = "result" value = "Ergebnis">
                </td>
                <td>
                    <label for = "edit"></label>
                    <input type = "submit" id = "edit" name = "edit" value = "bearbeiten">
                </form>
                </td>
            </tr>
        </tbody>
        </table>
        </section>
    </div>
</div>
</body>
</html>