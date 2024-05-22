DROP DATABASE IF EXISTS progetto_fiorentina;
CREATE DATABASE IF NOT EXISTS progetto_fiorentina;
USE progetto_fiorentina;

CREATE TABLE Password_Utente(
Id_password INT AUTO_INCREMENT PRIMARY KEY,
password_hash CHAR(128) NOT NULL,
salt VARCHAR(32) NOT NULL,
iterations INT NOT NULL
);

CREATE TABLE Utente(
Id_utente INT AUTO_INCREMENT PRIMARY KEY,
CF CHAR(16) NOT NULL,
nome VARCHAR(25) NOT NULL, 
cognome VARCHAR(40) NOT NULL,
telefono CHAR(14) NOT NULL,
data_nascita DATE NOT NULL,
email VARCHAR(50) NOT NULL,
Id_password INT,
FOREIGN KEY (Id_password) REFERENCES Password_Utente(Id_password)
ON DELETE SET NULL ON UPDATE CASCADE
);