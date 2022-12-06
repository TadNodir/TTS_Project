use swe_tts;

CREATE TABLE IF NOT EXISTS benutzer (
                                        id          INT8 auto_increment,
                                        rolle       TINYINT unsigned not null,
                                        vorname     VARCHAR(50) not null,
                                        nachname    VARCHAR(50) not null,
                                        nickname    VARCHAR(50) not null unique,
                                        email       VARCHAR(50) not null,
                                        passwort    VARCHAR(255) not null,
                                        salt        VARCHAR(255) not null,
    -- speichern wir den Salt hier ab oder benutzten wir die ID gehashed?
                                        punktestand INT8 unsigned default 0,
    -- nicht sicher ob der Default nicht null sein sollte?
    -- Wenn Admin würde ich es wahrscheinlich auf null setzten...
                                        gesperrt    INT8 unsigned default 0,

    -- 0 = User; 1 = Admin; 2 = Superadmin
                                        CONSTRAINT rolle_zwischen_0_und_2 CHECK (0 <=rolle AND rolle < 3),
                                        PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS teams (
                                     id          INT8 auto_increment,
                                     land        VARCHAR(50) unique not null,  -- Theoretisch würde der Ländername auch als Key reichen
                                     PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS spiele (
                                      id          INT8 auto_increment,
                                      team_1      INT8,
                                      team_2      INT8,
                                      tore_team1  TINYINT unsigned default null, -- null bedeutet, dass das Ergebnis noch nicht da ist
                                      tore_team2  TINYINT unsigned default null,
                                      uhrzeit     TIMESTAMP not null,
    -- https://dev.mysql.com/doc/refman/8.0/en/date-and-time-functions.html#function_timediff
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
