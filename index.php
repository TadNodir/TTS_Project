<?php

?>

<!DOCTYPE html>
<html lang="de">

    <head>
        <meta charset="UTF-8">
        <title>TTS - Hauptseite</title>
        <link href="index.css" rel="stylesheet">
        <script src="script.js" defer></script>
    </head>

    <body>
        <header>
            <nav class="navigation">
                <label> TTS </label>
                <a href="#" class="toggle-button"
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
                </a>
                <div class="nav-links">
                <ul>
                    < <a href="#Scoreboard">  Scoreboard </a> </li>
                    <li>> <a href="#Scoreboard">  News </a> </li>
                    <li> <a href="#Scoreboard">  Anstehende Spiele </a> </li>
                    <li> <a href="#Scoreboard">  Vergangene Spiele </a> </li>
                    <li> <a href="#Scoreboard">  Profil </a> </li>
                    <li> <a href="#Scoreboard">  Abmelden </a> </li>
                </ul>
                </div>
            </nav>
        </header>

        <main class="flexbox-container">
            <section class="flexbox-item scoreboard">
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
                         <td>Birne</td>
                         <td>42</td>
                     </tr>
                     <tr>
                         <td>2</td>
                         <td>Banana</td>
                         <td>99</td>
                     </tr>

                    </tbody>
                    <td>Eigenerscore: 4</td>
                </table>
            </section>

            <section class="flexbox-item news">
                <h1 id="News">Newsfeed</h1>
                <p>
                Hier werden new angeziegt <br>
                Spiel X wurde hinzugefügt <br>
                Ergebnis für Spiel Y ist raus <br>
                </p>
            </section>


            <section class="flexbox-item a_spiele">
                <h1 id="Anstehende">Anstehende Spiele</h1>
                <table id="anst">
                    <thead>
                    <tr>
                        <th>Teams 1</th>
                        <th>vs</th>
                        <th>Team 2</th>
                        <th>Tipp</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Deutschland</td>
                        <td></td>
                        <td>England</td>
                        <td>7 : 0</td>
                    </tr>
                    <tr>
                        <td>Spanien</td>
                        <td></td>
                        <td>Italien</td>
                        <td>2 : 3</td>
                    </tr>
                    </tbody>
                </table>
            </section>

            <section class="flexbox-item v_spiele">
                <h1 id="Vergangene">Vergangene Spiele</h1>
                <table id="vergng">
                    <thead>
                    <tr>
                        <th>Team 1</th>
                        <th> - : - </th>
                        <th>Team 2</th>
                        <th>Tipp</th>
                        <th>Punktzahl</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Frankreich</td>
                        <td> 1 : 3 </td>
                        <td>Norwegien</td>
                        <td>1 : 2</td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td>Polen</td>
                        <td> 3 : 2 </td>
                        <td>Greichenland</td>
                        <td>3 : 2</td>
                        <td>3</td>
                    </tr>
                    </tbody>
                </table>
            </section>
        </main>

        <footer>
            <li>(c) Gruppe D9</li>
        </footer>

    </body>
</html>