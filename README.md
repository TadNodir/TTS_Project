# SWE-Projekt: TTS
Eine Fußball-WM Tipp-Website
-------------------------------------------------------------------------------
Diese Webseite wurde von 7 Studenten im Rahmen des SWE-Praktikums erstellt.
Dabei wurden HTML, CSS, PHP8.2, MariaDB und ein bisschen Java-Script verwendet.

## Setup 
In diesem Abschnitt werden 3 Wege beschrieben wie diese Website zum laufen
gebracht werden kann. Zunächst wrid das allgemeine Aufsetzten der Datenbank
beschrieben und danach von einfach nach komplizierter die 3 Wege beschrieben.

### Datenbanksetup

Für alle 3 Arten ist es notwendig die Datenbank bis zu einem gewissen Grad
befüllt zu haben. Dieser Schritt ist für alle drei Methoden gleich wird darum
als erstes beschrieben.

####  Vorrausetzungen

Vorraussetzung ist es [MariaDB](https://mariadb.com) installiert zu haben. Die
Installation für unterschiedliche Plattformen kann
[hier](https://mariadb.com/kb/en/getting-installing-and-upgrading-mariadb/)
nachgelesen werden. Getestet und entwickelt wurde mit Version 15.1 Distrib
10.5.15-MariaDB.

#### Datenbank und User erstellen 

Sobald installiert und als root eingeloggt sollte eine Datenbank und ein User
wie folgt installiert werden:

``` sql
CREATE DATABASE IF NOT EXISTS swe_tts
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

``` sql
CREATE USER 'dev_tts'@'localhost' IDENTIFIED BY 'QN7ZAqgGY9wZ';
```

Das Passwort und der Benutzername kann in `database/db_functions.php` geändert
werden (siehe Methode `createLink()` in den Zeilen 3 bis 7).

Dem Benutzer sollten folgende Rechte gegeben werden:

``` sql
GRANT CREATE, DROP, SELECT, INSERT, UPDATE, DELETE
ON swe_tts.* TO 'dev_tts'@'localhost';
```

#### Erstellen der Schema

Als nächsten sollten die für die Anwendung nötigen Schema erstellt werden.

``` sql
CREATE TABLE IF NOT EXISTS benutzer (
    id          INT8 auto_increment,
    rolle       TINYINT unsigned not null,
    vorname     VARCHAR(50) not null,
    nachname    VARCHAR(50) not null,
    nickname    VARCHAR(50) not null unique,
    email       VARCHAR(50) not null,
    passwort    VARCHAR(255) not null,
    salt        VARCHAR(255) not null,
    punktestand INT8 unsigned default 0,
    gesperrt    INT8 unsigned default 0,
    -- 0 = User; 1 = Admin; 2 = Superadmin
    CONSTRAINT rolle_zwischen_0_und_2 CHECK (0 <=rolle AND rolle < 3),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS teams (
    id          INT8 auto_increment,
    land        VARCHAR(50) unique not null,
    flag        VARCHAR(200),
    PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS spiele (
    id          INT8 auto_increment,
    team_1      INT8,
    team_2      INT8,
    tore_team1  TINYINT unsigned default null, 
    tore_team2  TINYINT unsigned default null,
    uhrzeit     TIMESTAMP not null,
    beendet     BOOLEAN default false,
    CONSTRAINT teams_unterschiedlich CHECK (team_1 != team_2),
    FOREIGN KEY (team_1) REFERENCES teams(id),
    FOREIGN KEY (team_2) REFERENCES teams(id),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tipps (
    id          INT8 auto_increment,
    tipper      INT8,
    spiel       INT8,
    tipp_team1  TINYINT unsigned not null,
    tipp_team2  TINYINT unsigned not null,
    verdient    TINYINT unsigned not null,
    FOREIGN KEY (tipper) REFERENCES  benutzer(id),
    FOREIGN KEY (spiel) REFERENCES spiele(id),
    PRIMARY KEY (id)
);
```

#### Erstellen der Teams

Um alle Funktionalitäten der Website benutzen zu können müssen die Temas der
Weltmeisterschaft und mindestens ein Superadmin hinzugefügt werden.

``` sql
INSERT INTO teams VALUES
    (1, 'Katar' '&#127478&#127462'),
    (2, 'Ecuador' '&#127466&#127464'),
    (3, 'Senegal' '&#127480&#127475'),
    (4, 'Niederlande' '&#127475&#127473'),

    (5, 'England' '&#127988 &#917607&#917602&#917605&#917614&#917607&#917631'),
    (6, 'Iran' '&#127470&#127479'),
    (7, 'USA' '&#127482&#127480'),
    (8, 'Wales' '&#127988;&#917607;&#917602;&#917623;&#917612;&#917619;&#917631;'),

    (9, 'Argentinien' '&#127462&#127479'),
    (10, 'Saudi Arabien' '&#127480&#127462'),
    (11, 'Mexiko' '&#127474&#127485'),
    (12, 'Polen' '&#127477&#127473'),

    (13, 'Frankreich' '&#127467&#127479'),
    (14, 'Australien' '&#127462&#127482'),
    (15, 'Dänemark' '&#127465&#127472'),
    (16, 'Tunesien' '&#127481&#127475'),

    (17, 'Spanien' '&#127466&#127480'),
    (18, 'Costa Rica' '&#127464&#127479'),
    (19, 'Deutschland' '&#127465&#127466'),
    (20, 'Japan' '&#127471&#127477'),

    (21, 'Belgien' '&#127463&#127466'),
    (22, 'Kanada' '&#127464&#127462'),
    (23, 'Marokko' '&#127474&#127462'),
    (24, 'Kroatien' '&#127469&#127479'),

    (25, 'Brasilien' '&#127463&#127479'),
    (26, 'Serbien' '&#127479&#127480'),
    (27, 'Schweiz' '&#127464&#127469'),
    (28, 'Kamerun' '&#127464&#127474'),

    (29, 'Portugal' '&#127477&#127481'),
    (30, 'Ghana' '&#127468&#127469'),
    (31, 'Uruguay' '&#127482&#127486'),
    (32, 'Südkorea' '&#127472&#127479')
;
```

#### Erstellen eines Superadmins

Um weitere Admins zu erstellen ist es notwenig einen Superadmin zu haben. Dieser
kann wie folgt erstellt werden. Dabei sollte `<Random-generated-Salt>` und
`<Super-Sicheres-Am-Besten-Zufälliges-Passwort>` mit jeweils ersetzt werden und
das Passwort in einem Passwortmanager wie [KeePass](https://keepass.info)
gespiechert werde.

``` sql
INSERT INTO benutzer (rolle, vorname, nachname, nickname, email, passwort, salt)
    VALUES (2, 'superadmin', 'superadmin', 'superadmin', 'superadmin@tts.de', SHA1('<Random-generated-Salt><Super-Sicheres-Am-Besten-Zufälliges-Passwort>'), '<Random-generated-Salt>');
```
