CREATE TABLE IF NOT EXISTS tts_user (
    id          INT8 auto_increment,
    rolle       TINYINT unsigned not null,
    vorname     VARCHAR(50) not null,
    nachname    VARCHAR(50) not null,
    nickname    VARCHAR(50) not null unique,
    passwort    VARCHAR(255) not null,
    -- speichern wir den Salt hier ab oder benutzten wir die ID gehashed?
    punktestand INT8 unsigned default 0,
    -- nicht sicher ob der Default nicht null sein sollte?
    -- Wenn Admin würde ich es wahrscheinlich auf null setzten...
    gespeert    BOOLEAN default false,

    -- 0 = User; 1 = Admin; 2 = Superadmin
    CONSTRAINT rolle_zwischen_0_und_2 CHECK (0 <=rolle AND rolle < 3),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tts_team(
    id          INT8 auto_increment,
    land        VARCHAR(50) unique not null  -- Theoretisch würde der Ländername auch als Key reichen
);

CREATE TABLE IF NOT EXISTS tts_spiel (
    id          INT8 auto_increment,
    team_1      INT8,
    team_2      INT8,
    tore_team1  TINYINT unsigned default null, -- null bedeutet, dass das Ergebnis noch nicht da ist
    tore_team2  TINYINT unsigned default null,
    uhrzeit     TIMESTAMP not null,
    -- https://dev.mysql.com/doc/refman/8.0/en/date-and-time-functions.html#function_timediff
    beendet     BOOLEAN default false,
    FOREIGN KEY (team_1) REFERENCES tts_team(id),
    FOREIGN KEY (team_2) REFERENCES tts_team(id),
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS tts_tipps (
    id          INT8 auto_increment,
    tipper      INT8,
    spiel       INT8,
    tipp_team1  TINYINT unsigned not null,
    tipp_team2  TINYINT unsigned not null,
    verdient    TINYINT unsigned not null,
    FOREIGN KEY (tipper) REFERENCES  tts_user(id),
    FOREIGN KEY (spiel) REFERENCES tts_team(id),
    PRIMARY KEY (id)
);
