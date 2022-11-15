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
