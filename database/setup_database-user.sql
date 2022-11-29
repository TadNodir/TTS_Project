-- Befehle um als Root die Datenbank einzurichten. In der Reihenfolge ausführen.
--
-- Erstellen des Users für unsere Datenbank
CREATE USER 'dev_tts'@'localhost' IDENTIFIED BY 'QN7ZAqgGY9wZ';

-- Erstellen der Datenbank. Funktioniert so nur, wenn die Datenbank noch nicht
-- erstellt ist.
CREATE DATABASE IF NOT EXISTS swe_tts
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

-- Vergeben von Privelegien für den User
GRANT CREATE, ALTER, DROP, SELECT, INSERT, UPDATE, DELETE
ON swe_tts.* TO 'dev_tts'@'localhost';

-- Login in PHPStorm
-- User: dev_tts
-- Password: QN7ZAqgGY9wZ
-- Database: swe_tts
