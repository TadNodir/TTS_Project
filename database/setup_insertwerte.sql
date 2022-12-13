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