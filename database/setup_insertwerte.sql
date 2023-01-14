use swe_tts;

-- Füllt Teams mit allen Teams Der Fußball WM 2022 aus ID angepasst an Gruppenreihenfolge
INSERT INTO teams VALUES
                                    (1, 'Katar'),
                                    (2, 'Ecuador'),
                                    (3, 'Senegal'),
                                    (4, 'Niederlande'),

                                    (5, 'England'),
                                    (6, 'Iran'),
                                    (7, 'USA'),
                                    (8, 'Wales'),

                                    (9, 'Argentinien'),
                                    (10, 'Saudi Arabien'),
                                    (11, 'Mexiko'),
                                    (12, 'Polen'),

                                    (13, 'Frankreich'),
                                    (14, 'Australien'),
                                    (15, 'Dänemark'),
                                    (16, 'Tunesien'),

                                    (17, 'Spanien'),
                                    (18, 'Costa Rica'),
                                    (19, 'Deutschland'),
                                    (20, 'Japan'),

                                    (21, 'Belgien'),
                                    (22, 'Kanada'),
                                    (23, 'Marokko'),
                                    (24, 'Kroatien'),

                                    (25, 'Brasilien'),
                                    (26, 'Serbien'),
                                    (27, 'Schweiz'),
                                    (28, 'Kamerun'),

                                    (29, 'Portugal'),
                                    (30, 'Ghana'),
                                    (31, 'Uruguay'),
                                    (32, 'Südkorea')
;

-- Befüllen zweier Beispiel Nutzer
-- 0 = benutzer, 1 = Admin, und 2 = Superadmin.
INSERT INTO benutzer(rolle, vorname, nachname, nickname, email, passwort, salt, punktestand, gesperrt) VALUES
                         (0, 'Testvorname', 'Testnachname', 'Testnickname','prov@em.com' , 'Passwort', 'Salt', 42069, false),
                         (1, 'Adminalfred', 'Adminhansmann', 'Gigachad','egal@88.com', 'Tripper', 'Adminsalt', 69420, false),
                         (2, 'Sadminhans', 'Sadminvnstark', 'enjoyer','der@führer.de', 'Megaturtok', 'Sadminsalt', 2, false);

-- Befüllen einse Spiels
INSERT INTO spiele VALUES
                       (1, 1, 2, 7, 1, NOW(), true);

-- Befüllen eines Tipps
INSERT INTO tipps VALUES
                      (1, 1, 1, 3, 0, 69);

-- ////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////
-- ////////////////////////////////////////////////////////////////


-- Disabled und enabled forgenkeys fals man eine Table Löschen möchte
SET FOREIGN_KEY_CHECKS=0; -- to disable them
SET FOREIGN_KEY_CHECKS=1; -- to re-enable them

ALTER TABLE teams ADD flag varchar(200);

UPDATE teams SET flag = '&#127478&#127462' WHERE id = 1;
UPDATE teams SET flag = '&#127466&#127464' WHERE id = 2;
UPDATE teams SET flag = '&#127480&#127475' WHERE id = 3;
UPDATE teams SET flag = '&#127475&#127473' WHERE id = 4;

UPDATE teams SET flag = '&#127988 &#917607&#917602&#917605&#917614&#917607&#917631' WHERE id = 5;
UPDATE teams SET flag = '&#127470&#127479' WHERE id = 6;
UPDATE teams SET flag = '&#127482&#127480' WHERE id = 7;
UPDATE teams SET flag = '&#127988;&#917607;&#917602;&#917623;&#917612;&#917619;&#917631;' WHERE id = 8;

UPDATE teams SET flag = '&#127462&#127479' WHERE id = 9;
UPDATE teams SET flag = '&#127480&#127462' WHERE id = 10;
UPDATE teams SET flag = '&#127474&#127485' WHERE id = 11;
UPDATE teams SET flag = '&#127477&#127473' WHERE id = 12;

UPDATE teams SET flag = '&#127467&#127479' WHERE id = 13;
UPDATE teams SET flag = '&#127462&#127482' WHERE id = 14;
UPDATE teams SET flag = '&#127465&#127472' WHERE id = 15;
UPDATE teams SET flag = '&#127481&#127475' WHERE id = 16;

UPDATE teams SET flag = '&#127466&#127480' WHERE id = 17;
UPDATE teams SET flag = '&#127464&#127479' WHERE id = 18;
UPDATE teams SET flag = '&#127465&#127466' WHERE id = 19;
UPDATE teams SET flag = '&#127471&#127477' WHERE id = 20;

UPDATE teams SET flag = '&#127463&#127466' WHERE id = 21;
UPDATE teams SET flag = '&#127464&#127462' WHERE id = 22;
UPDATE teams SET flag = '&#127474&#127462' WHERE id = 23;
UPDATE teams SET flag = '&#127469&#127479' WHERE id = 24;

UPDATE teams SET flag = '&#127463&#127479' WHERE id = 25;
UPDATE teams SET flag = '&#127479&#127480' WHERE id = 26;
UPDATE teams SET flag = '&#127464&#127469' WHERE id = 27;
UPDATE teams SET flag = '&#127464&#127474' WHERE id = 28;

UPDATE teams SET flag = '&#127477&#127481' WHERE id = 29;
UPDATE teams SET flag = '&#127468&#127469' WHERE id = 30;
UPDATE teams SET flag = '&#127482&#127486' WHERE id = 31;
UPDATE teams SET flag = '&#127472&#127479' WHERE id = 32;
