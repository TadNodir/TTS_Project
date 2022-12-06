<?php

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
            <a href="../Profile.php">Profil</a>
            <a href="">Abmelden</a>
            <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
        </div>
    </nav>
</header>
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
                <tr>
                    <td>1</td>
                    <td>Max82</td>
                    <td>99</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>4lice</td>
                    <td>97</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>BobbyChad</td>
                    <td>96</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Dr.Cheng77</td>
                    <td>94</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Harambe99</td>
                    <td>90</td>
                </tr>
                </tbody>
                <td style="border-top: 2px solid">Mein Ergebnis: 50</td>
                <td style="border-top: 2px solid"></td>
                <td style="border-top: 2px solid"></td>
            </table>
        </section>

        <section class="a_spiele">
            <h1 id="Anstehende">Anstehende Spiele</h1>
            <table id="anst">
                <thead>
                <tr>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Tipp</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>&#127465&#127466 Deutschland</td>
                    <td>&#127471&#127477 Japan</td>
                    <td>2 : 1</td>
                    <td><button>Bearbeiten</button></td>
                </tr>
                <tr>
                    <td>&#127466&#127480 Spanien</td>
                    <td>&#127464&#127479 Costa Rica</td>
                    <td>7 : 0</td>
                    <td><button>Bearbeiten</button></td>
                </tr>
                <tr>
                    <td>&#127463&#127466 Belgien</td>
                    <td>&#127474&#127462 Morocco</td>
                    <td></td>
                    <td><button>Tippen</button></td>
                </tr>
                </tbody>
            </table>
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
                <tr>
                    <td>&#127467&#127479 Frankreich</td>
                    <td>2 : 1</td>
                    <td>&#127465&#127472 Dänemark</td>
                    <td>3 : 1</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>&#127481&#127475 Tunesien</td>
                    <td>0 : 1</td>
                    <td>&#127462&#127482 Australien</td>
                    <td>0 : 1</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>&#127463&#127479 Brasilien</td>
                    <td>2 : 0</td>
                    <td>&#127479&#127480 Serbien</td>
                    <td>3 : 0</td>
                    <td>1</td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
    <div class="rest">
        <img src="../logo.png" alt="logo">
        <section class="news">
            <h1 id="news">Newsfeed</h1>
            <p>
                <ul>
                  <li>Spiel X wurde hinzugefügt</li><br>
                  <li>Ergebnis für Spiel Y ist raus</li><br>
                  <li>Ergebnis für Spiel Z ist raus</li><br>
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