CREATE SCHEMA IF NOT EXISTS main;



CREATE TABLE IF NOT EXISTS tts.BENUTZER (
    id  SERIAL PRIMARY KEY ,
    rolle integer NOT NULL,
    vorname varchar(20),
    nachname varchar(20),
    nickname varchar(20),
    email varchar(25),
    passwort varchar(40),
    punktestand integer,
    gesperrt integer
    );

CREATE TABLE IF NOT EXISTS tts.TIPPS (
    id SERIAL PRIMARY KEY,
    benutzer integer REFERENCES tts.benutzer(id),
    spiel integer REFERENCES tts.spiele(id),
    team1 integer REFERENCES tts.teams(id),
    team2 integer REFERENCES tts.teams(id),
    verdiente_punkte integer
    );

CREATE TABLE IF NOT EXISTS tts.SPIELE(
    id SERIAL PRIMARY KEY,
    team1 integer REFERENCES tts.teams(id),
    team2 integer REFERENCES tts.teams(id),
    ergebnis_team1 integer,
    ergebnis_team2 integer,
    beginn_uhrzeit TIME,
    beginn_datum DATE,
    abgeschlossen boolean
);

CREATE TABLE IF NOT EXISTS tts.TEAMS (
    id SERIAL PRIMARY KEY,
    laendercode varchar(40)
);
