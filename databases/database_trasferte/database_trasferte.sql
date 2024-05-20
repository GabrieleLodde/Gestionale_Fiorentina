DROP DATABASE IF EXISTS progetto_trasferte;
CREATE DATABASE IF NOT EXISTS progetto_trasferte;
USE progetto_trasferte;

CREATE TABLE Password_Utente(
Id_password INT AUTO_INCREMENT PRIMARY KEY,
password_hash CHAR(128) NOT NULL,
salt VARCHAR(32) NOT NULL,
iterations INT NOT NULL
);

CREATE TABLE Utente(
CF CHAR(16) NOT NULL PRIMARY KEY,
nome VARCHAR(25) NOT NULL, 
cognome VARCHAR(40) NOT NULL,
nazionalita VARCHAR(30) NOT NULL,
data_nascita DATE NOT NULL,
email VARCHAR(50) NOT NULL,
Id_password INT,
FOREIGN KEY (Id_password) REFERENCES Password_Utente(Id_password)
ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Evento(
Id_evento INT AUTO_INCREMENT PRIMARY KEY,
nome_evento VARCHAR(50) NOT NULL,
tipo_evento VARCHAR(20) NOT NULL,
indirizzo_evento VARCHAR(50) NOT NULL,
data_evento DATE NOT NULL,
costo_biglietto FLOAT NOT NULL);

CREATE TABLE Hotel(
Id_hotel INT AUTO_INCREMENT PRIMARY KEY,
nome_hotel VARCHAR(40) NOT NULL,
valutazione_hotel CHAR(8) NOT NULL,
indirizzo_hotel VARCHAR(50) NOT NULL,
costo_prenotazione FLOAT NOT NULL,
mezza_pensione BOOL NOT NULL,
pensione_completa BOOL NOT NULL);

CREATE TABLE Trasporto(
Id_trasporto INT AUTO_INCREMENT PRIMARY KEY,
tipo_trasporto VARCHAR(20) NOT NULL,
costo_trasporto FLOAT NOT NULL,
posti_disponibili INT DEFAULT 200);

CREATE TABLE Fornitore(
Id_fornitore INT AUTO_INCREMENT PRIMARY KEY,
CF_fornitore CHAR(16) NOT NULL,
nome_fornitore VARCHAR(25) NOT NULL, 
cognome_fornitore VARCHAR(40) NOT NULL,
nazionalita_fornitore VARCHAR(30) NOT NULL,
data_nascita_fornitore DATE NOT NULL,
sede_fornitore VARCHAR(30) NOT NULL
);

CREATE TABLE Cibo_bevande(
Id_cibo_bevanda INT AUTO_INCREMENT PRIMARY KEY,
tipo_cibo_bevanda VARCHAR(40) NOT NULL,
costo_cibo_bevanda FLOAT NOT NULL,
Id_fornitore INT,
FOREIGN KEY (Id_fornitore) REFERENCES Fornitore(Id_fornitore)
ON DELETE SET NULL ON UPDATE CASCADE);

CREATE TABLE Pagamento(
Id_pagamento INT AUTO_INCREMENT PRIMARY KEY,
metodo VARCHAR(20) NOT NULL,
data_pagamento DATE NOT NULL,
Id_evento INT,
Id_hotel INT,
Id_trasporto INT,
Id_cibo_bevanda INT, 
FOREIGN KEY (Id_evento) REFERENCES Evento(Id_evento)
ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (Id_hotel) REFERENCES Hotel(Id_hotel)
ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (Id_trasporto) REFERENCES Trasporto(Id_trasporto)
ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (Id_cibo_bevanda) REFERENCES Cibo_bevande(Id_cibo_bevanda)
ON DELETE SET NULL ON UPDATE CASCADE);