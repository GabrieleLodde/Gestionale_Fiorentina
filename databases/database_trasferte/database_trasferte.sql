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
Id_utente INT AUTO_INCREMENT PRIMARY KEY,
CF CHAR(16) NOT NULL,
nome VARCHAR(25) NOT NULL, 
cognome VARCHAR(40) NOT NULL,
nazionalita VARCHAR(30) NOT NULL,
data_nascita DATE NOT NULL,
email VARCHAR(50) NOT NULL,
Id_password INT,
FOREIGN KEY (Id_password) REFERENCES Password_Utente(Id_password)
ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Continente(
Id_continente INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(20) NOT NULL);

CREATE TABLE Nazione(
Id_nazione INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(50) NOT NULL,
Id_continente INT,
FOREIGN KEY (Id_continente) REFERENCES Continente(Id_continente)
);

CREATE TABLE Luogo(
Id_luogo INT AUTO_INCREMENT PRIMARY KEY,
citta VARCHAR(50) NOT NULL,
cap VARCHAR(10) NOT NULL,
tipo_via VARCHAR(50),
numero INT,
Id_nazione INT,
FOREIGN KEY (Id_nazione) REFERENCES Nazione(Id_nazione)
ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Categoria(
Id_categoria INT AUTO_INCREMENT PRIMARY KEY,
tipo_tagliando VARCHAR(30) NOT NULL,
costo FLOAT NOT NULL
);

CREATE TABLE Evento(
Id_evento INT AUTO_INCREMENT PRIMARY KEY,
nome_evento VARCHAR(50) NOT NULL,
tipo_evento VARCHAR(50) NOT NULL,
data_evento DATE NOT NULL,
Id_categoria INT,
Id_luogo INT,
FOREIGN KEY (Id_categoria) REFERENCES Categoria(Id_categoria)
ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (Id_luogo) REFERENCES Luogo(Id_luogo)
ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Hotel(
Id_hotel INT AUTO_INCREMENT PRIMARY KEY,
nome_hotel VARCHAR(40) NOT NULL,
valutazione_hotel CHAR(8) NOT NULL,
costo_prenotazione FLOAT NOT NULL,
mezza_pensione BOOL NOT NULL,
pensione_completa BOOL NOT NULL,
Id_luogo INT,
FOREIGN KEY (Id_luogo) REFERENCES Luogo(Id_luogo)
ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Trasporto(
Id_trasporto INT AUTO_INCREMENT PRIMARY KEY,
tipo_trasporto VARCHAR(20) NOT NULL,
costo_trasporto FLOAT NOT NULL,
posti_disponibili INT DEFAULT 200);

CREATE TABLE Fornitore(
Id_fornitore INT AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(25) NOT NULL, 
cognome VARCHAR(40) NOT NULL,
data_nascita DATE NOT NULL,
Id_luogo INT,
FOREIGN KEY (Id_luogo) REFERENCES Luogo(Id_luogo)
ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Cibo_bevanda(
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
Id_utente INT,
FOREIGN KEY (Id_evento) REFERENCES Evento(Id_evento)
ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (Id_hotel) REFERENCES Hotel(Id_hotel)
ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (Id_trasporto) REFERENCES Trasporto(Id_trasporto)
ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (Id_cibo_bevanda) REFERENCES Cibo_bevanda(Id_cibo_bevanda)
ON DELETE SET NULL ON UPDATE CASCADE,
FOREIGN KEY (Id_utente) REFERENCES Utente(Id_utente)
ON DELETE SET NULL ON UPDATE CASCADE);


-- Dump dei dati per i continenti
INSERT
INTO Continente(nome)
VALUES 	("Africa"),
		("Asia"),
        ("Australia"),
        ("Europa"),
        ("Nordamerica"),
        ("Sudamerica");
        

-- Dump dei dati per le nazioni
INSERT 
INTO Nazione(nome, Id_continente)
VALUES 	("Grecia", 4),
		("Italia", 4),
        ("Francia", 4),
        ("Spagna", 4),
        ("Germania", 4),
        ("Inghilterra", 4),
        ("Portogallo", 4),
        ("Svizzera", 4),
        ("Belgio", 4),
        ("Olanda", 4),
        ("Norvegia", 4),
        ("Danimarca", 4),
        ("Argentina", 6),
        ("Brasile", 6),
        ("Nuovo Galles del Sud", 3),
        ("Canada", 5),
        ("Stati Uniti", 5),
        ("Costa d'Avorio", 1),
        ("Senegal", 1),
        ("Cina", 2),
        ("Giappone", 2);

-- Dump dei dati per i luoghi
-- INSERT
-- INTO Luogo(citta, cap, tipo_via, numero, Id_nazione)
-- VALUES ();


-- Dump dei dati per gli eventi
-- INSERT 
-- INTO Evento(nome_evento, tipo_evento, data_evento, Id_categoria, Id_luogo)
-- VALUES ("Trasferta di Atene", "Finale Conference League", "2024-05-29", 1, 1);

-- Dump dei dati per gli hotel
-- INSERT
-- INTO Hotel(nome_hotel, valutazione_hotel, costo_prenotazione, mezza_pensione, pensione_completa, Id_luogo)
-- VALUES ();

-- Dump dei dati per i trasporti
-- INSERT 
-- INTO Trasporto(tipo_trasporto, costo_trasporto, posti_disponibili)
-- VALUES ();

-- Dump dei dati per i fornitori
-- INSERT
-- INTO Fornitore(nome, cognome, data_nascita, Id_luogo)
-- VALUES ();

-- Dump dei dati per i cibi e le bevande
-- INSERT 
-- INTO Cibo_bevanda(tipo_cibo_bevanda, costo_cibo_bevanda, Id_fornitore)
-- VALUES ();

-- Dump dei dati per i metodi di pagamento
-- INSERT
-- INTO Pagamento(metodo, data_pagamento, Id_evento, Id_hotel, Id_trasporto, Id_cibo_bevanda, CF_utente)
-- VALUES ();