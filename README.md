# SWE-Projekt: TTS
Eine Fußball-WM Tipp-Website
-------------------------------------------------------------------------------
Diese Webseite wurde von 7 Studenten im Rahmen des SWE-Praktikums erstellt.
Dabei wurden HTML, CSS, PHP8.2, MariaDB und ein bisschen Java-Script verwendet.

Es werden 3 Wege beschrieben, wie diese Website zum Laufen
gebracht werden kann. Zunächst wird das allgemeine Aufsetzten der Datenbank
beschrieben und danach von einfach nach komplizierter die 3 Wege beschrieben.

## Datenbanksetup

Für alle 3 Arten ist es notwendig, die Datenbank bis zu einem gewissen Grad
befüllt zu haben. Dieser Schritt ist für alle drei Methoden gleich, wird darum
als erstes beschrieben.

### Voraussetzungen

Voraussetzung ist es, [MariaDB](https://mariadb.com) installiert zu haben. Die
Installation für unterschiedliche Plattformen kann
[hier](https://mariadb.com/kb/en/getting-installing-and-upgrading-mariadb/)
nachgelesen werden. Getestet und entwickelt wurde mit Version 15.1 Distrib
10.5.15-MariaDB.

### Datenbank und User erstellen 

Sobald installiert und als Root eingeloggt sollte eine Datenbank und ein User
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

### Erstellen der Schema

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

### Erstellen der Teams

Um alle Funktionalitäten der Website benutzen zu können, müssen die Teams der
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

### Erstellen eines Superadmins

Um weitere Admins zu erstellen ist es notwendig otwenig einen Superadmin zu haben. Dieser
kann wie folgt erstellt werden. Dabei sollte `<Random-generated-Salt>` und
`<Super-Sicheres-Am-Besten-Zufälliges-Passwort>` mit jeweils ersetzt werden und
das Passwort in einem Passwortmanager wie [KeePass](https://keepass.info)
gespeichert werde.

``` sql
INSERT INTO benutzer (rolle, vorname, nachname, nickname, email, passwort, salt)
    VALUES (2, 'superadmin', 'superadmin', 'superadmin', 'superadmin@tts.de', SHA1('<Random-generated-Salt><Super-Sicheres-Am-Besten-Zufälliges-Passwort>'), '<Random-generated-Salt>');
```

## Einrichten der Laufzeitumgebung

In diesem Abschnitt wird beschrieben wie diese Website in unterschiedlichen
Laufzeitumgebungen eingerichtet werden kann.

### PHP In-build-Server über die Kommandozeile

> Achtung: Je nach Betriebsystem und dementsprechenden PHP-Version kann es
> notwendig sein die `mysqli`-Extention in der `php.ini` einzuschalten. Dies
> kann mit Hilfe der Funktion `phpinfo();` diagnostiziert werden.

Am einfachsten ist es über den
[PHP In-build-Server](https://www.php.net/manual/en/features.commandline.webserver.php)
die Website zu starten.

``` shell
cd /Wo/Auch/Immer/Dieser/Ordner/Ist
php -S localhost:8000
```

Jetzt kann in einem Browser unter <localhost:8000> die Website besucht werden.

### Inbuild-Server über PHPStorm

> Ggf. muss in PHPSTorm die PHP Version/Interpreter auf 8.2 gestellt werden!

> Achtung: Je nach Betriebsystem und dementsprechenden PHP-Version kann es
> notwendig sein die `mysqli`-Extention in der `php.ini` einzuschalten. Dies
> kann mit Hilfe der Funktion `phpinfo();` diagnostiziert werden.

Wer nicht gerne mit der Kommandozeile arbeitet, kann auch über PHPStorm die
Website über den In-build-Server starten.

Dafür kann über das Auswahlmenü (Doppel Shift) die Funktion `Edit
Configurations` ausgewählt werden und danach muss auf `Add new` oder das Plus
gedrückt werden. Als Nächstes wird `PHP Build-in Webserver` ausgewählt

Es öffnet sich ein Fenster, in dem verschiedene Einstellungen getroffen werden
können. Wenn gewünscht kann hier der Name der `Run Configuration` geändert
werden.

Auf normalen PCs, die nicht dedizierte Server sind, muss wahrscheinlich der Port
auf geändert werden. Port 8000 sollte frei sein.

Jetzt kann auf `Aplly` und `OK` gedrückt werden. Das Fenster sollte sich
schließen.

Sobald auf `Run` geklickt wird, sollte in der Kommandozeile ein klickbarer
Link erscheinen, der auf die Website führt.

Wenn nicht, kann wie im vorherigen Beispiel ein Browser geöffnet werden und in
der URL-Zeile <localhost:8000> eingetippt werden.

### Headless HTTP-Server auf Raspberry Pi 4

> Achtung: Dieser Ansatz besitzt einige Nachteile. Er wird für die Präsentation
> unabhänig vom FH-Netz bei der Abschlusspräsentation präsentierern zu können,
> da dort es nicht möglich ist auf Ports anderer Geräte zuzugreifen.

> Da der PI sowohl als Server als auch als Router fungiert und seine, kann er nicht über
> WLAN an ein weiteres Netz angeschlossen werden und erhält währenddessen keine
> Softwareupdates.

> Darüberhinaus verliert er über diese Zeit auch die Verbinung
> zu Servern der für die Synchronisation der Systemzeit verwendet wird. Dies
> kann allerdings mit dem `date -s <string-der-aktuellen Zeit>` vor einer
> Präsentation wieder angepasst werden.

Voraussetzung für diese Anleitung ist ein [kompatibler
Raspberry Pi](https://github.com/RaspAP/raspap-webgui#prerequisites) mit 32Bit Betriebssystem, in unserem
Fall benutzten wir einen Raspberry Pi. Während der Installation der Software
braucht der Raspberry Pi eine Verbindung zum Internet. 

Es empfiehlt sich, den Raspberry Pi über ein [einzelnes
USB-C-Kabel](https://www.youtube.com/watch?v=3UPaI4Hp66Y) zu betreiben.


Alle weiteren Schritte werden über die Kommandozeile des Raspberry Pi ausgeführt.

#### Updaten des Raspberry Pi

Als allererstes sollte der Raspberry Pi auf die neueste Version upgedatet werden.

``` shell
sudo apt update
sudo apt full-upgrade
sudo reboot now
```

Es empfiehlt sich einen Commandozeileneditor wie `vim`, `emacs` oder `nano` zu
verwenden. Der Commandozeileneditor `nano` sollte bereits installiert sein.

``` shell
sudo apt install neovim
```

#### Apache2-Webserver

Für den Webserver verwenden wir den
[Apache2-Webserver](https://httpd.apache.org). Dieser sollte zwar schon
installiert sein, aber falls nicht, kann dieser wie folgt installiert werden:

``` shell
sudo apt install apache2
```

Da wir zwei Webseiten auf dem Pi hosten wollen (einerseits die `TTS
Tippspielwebseite` und andererseits die Konfigurationsseite des Routers) ändern
wir das `root-directory` des Apache2-Webservers.

``` shell
sudo nvim /etc/apache2/apache2.conf
```

In dieser Datei fügen wir diese Zeilen hinzu.

``` shell
<Directory /home/pi/tts>
    Options Indexes FollowSymLinks
    AllowOverride None
    Require all granted
</Directory>
```

Als Nächstes verändern wir, die Konfiguration der Default-Seite. Es wäre möglich
eine neue `<Seite>.conf` zu erstellen, dies tun wir in diesem Beispiel
allerdings nicht.

``` shell
sudo nvim /etc/apache2/sites-available/000-default.conf
```

An dieser Stelle ist es nur wichtig die `DocumentRoot` zu verändern.
Vorausgesetzt der Benutzer heißt `pi` und wir wollen den Projektordner in
`~/tts/` ablegen ist `/home/pi/tts` der neue Wert für `DocumentRoot`.

#### PHP8.2 

Für unsere Website ist PHP8.2 notwendig. Da es aktuell nicht im
Standardrepository ist, muss ein weiteres Repository hinzugefügt werden.

``` shell
sudo apt-get -y install apt-transport-https lsb-release ca-certificates curl
sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg
sudo sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list'
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/php.list
sudo apt-get update
```

Danach kann PHP8.2 installiert werden.

``` shell
sudo apt install php8.2
```

#### MariaDB und Integration mit PHP

Die Installation von MariaDB kann trivial mit dem folgenden Befehl geschehen.

``` shell
sudo apt install mariadb-server
```

Die Integration von MariaDB und PHP geschieht über zwei Schritte.

Zunächst muss die PHP-Extension `php-mysql` installiert werden.

``` shell
sudo apt install php-mysql
```

Danach muss die Zeile `; extention=mysqli` in der `php.ini` einkommentiert
werden. Dies befindet sich bei unserer Installation auf Zeile 935.

``` shell
sudo nvim /etc/php/php8.2/apache2/php.ini
```

#### Konfiguration des Raspberry Pi als unabhängiger WiFi-Router

> Achtung: Nach diesem Schritt ist der Pi nicht mehr über WLAN mit anderen
> Routern verbunden und kann ohne LAN-Verbinung keine
> Softwareupdates/Installationen durchführen. 

> Achtung: Ohne dauerhafte Verbindung zum Internet kann es passieren, dass die
> Systemuhr des Raspberry Pi nicht mehr mit der Realzeit in sync ist.


Für die Konfiguration als WiFi-Router verwenden wir das opensource Projekt
[RaspAP](https://raspap.com).

Hierfür verwenden wir das Installationsskript.

``` shell
curl -sL https://install.raspap.com | bash
```

Während des Scripts wird mehrfach nachgefragt, ob optionale Schritte ausgeführt
werden sollen. Alle Optionen außer `Wiregard`, `OpenVPN` und `AdBlocking`
sollten bestätigt werden.

Vor dem Reboot sollte nun der [Port für die Konfigurationsseite](https://docs.raspap.com/faq/#can-i-configure-an-alternate-port-for-raspaps-web-service) verändert werden.
Dies kann durch die Anpassung der Konfigurationsdatei von `lighttpd` in Zeile 14 angepasst werden.


``` shell
sudo nvim /etc/lighttpd/lighttpd.conf
```

```
server.port                 = 81
```

Da wir über den Standard HTTP Port bereits die TTS-Website verwenden wollen
müssen wir hier noch einen anderen Port angeben.

Als Letztes starten wir den Raspberry Pi neu. 

``` shell
sudo reboot now
```

Danach konfigurieren das Netzwerk des Raspberry Pi. Vorausgesetzte, dass der
`hostname` des Raspberry Pi _tts_ ist, kann diese unter <tts.local:81> aufgerufen
werden. Die Standard-Konfigurationsdaten lassen sich
[hier](https://docs.raspap.com/#quick-start) nachschlagen. Zum aktuellen
Zeitpunkt sind sie wie folgt:


| Konifuration | Wert                        |
|:-------------|:----------------------------|
| IP address   | 10.3.141.1                  |
| Username     | admin                       |
| Password     | secret                      |
| DHCP range   | 10.3.141.50 to 10.3.141.255 |
| SSID         | raspi-webgui                |
| Password     | ChangeMe                    |
