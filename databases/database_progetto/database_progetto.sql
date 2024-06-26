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
credito DECIMAL(5, 2) NOT NULL DEFAULT 500,
Id_password INT,
FOREIGN KEY (Id_password) REFERENCES Password_Utente(Id_password)
ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE Sconto(
Id_sconto INT AUTO_INCREMENT PRIMARY KEY,
valore INT NOT NULL
);

CREATE TABLE Taglia(
Id_taglia INT AUTO_INCREMENT PRIMARY KEY,
descrizione_taglia VARCHAR(17) NOT NULL
);

CREATE TABLE CapoAbbigliamento(
Id_capo INT AUTO_INCREMENT PRIMARY KEY,
tipo_capo VARCHAR(20) NOT NULL
);

CREATE TABLE Articolo(
Id_articolo INT AUTO_INCREMENT PRIMARY KEY,
descrizione_articolo VARCHAR(100) NOT NULL,
prezzo_base  DECIMAL(5, 2) NOT NULL,
tipo VARCHAR(10) NOT NULL,
Id_sconto INT NOT NULL,
immagine VARCHAR(60) NOT NULL,
Id_capo INT NOT NULL,
FOREIGN KEY (Id_sconto) REFERENCES Sconto(Id_sconto),
FOREIGN KEY (Id_capo) REFERENCES CapoAbbigliamento(Id_capo)
);

CREATE TABLE ArticoloTaglia (
Id_articolo INT,
Id_taglia INT,
PRIMARY KEY (Id_articolo, Id_taglia),
FOREIGN KEY (Id_articolo) REFERENCES Articolo(Id_articolo),
FOREIGN KEY (Id_taglia) REFERENCES Taglia(Id_taglia)
);


-- Dump dei dati per gli sconti
INSERT
INTO Sconto(valore)
VALUES 	(10),
		(20),
        (30),
        (0);
        
        
-- Dump dei dati per le taglie
INSERT
INTO Taglia(descrizione_taglia)
VALUES 	("XS"),
		("S"),
		("M"),
        ("L"),
        ("XL"),
        ("XXL"),
        ("XXXL");
        
-- Dump dei dati per i tipi di capo
INSERT
INTO CapoAbbigliamento(tipo_capo)
VALUES 	("MAGLIA GARA"),
		("KIT GARA"),
		("PANTALONCINI"),
        ("CALZETTONI");
        
-- Dump dei dati per gli articoli
INSERT
INTO Articolo(descrizione_articolo, prezzo_base, tipo, Id_sconto, immagine, Id_capo)
VALUES 	("FIORENTINA MAGLIA GARA<br>HOME KOMBAT PRO 2024/25", 120.00, "UOMO", 4, "../../images/articoli/maglia_24-25.webp", 1),
		("FIORENTINA MAGLIA GARA<br>HOME KOMBAT 2024/25", 85.00, "UOMO", 2, "../../images/articoli/maglia_normale_24-25.webp", 1),
		("FIORENTINA KIT HOME 2024/25", 59.00, "KIT GARA", 4, "../../images/articoli/kit_24-25.webp", 2),
        ("FIORENTINA PANTALONCINI GARA HOME 2024/25", 49.00, "KIT GARA", 2, "../../images/articoli/pantaloncini_24-25.webp", 3),
        ("FIORENTINA CALZETTONI GARA HOME 2024/25", 15.00, "KIT GARA", 1, "../../images/articoli/calzettoni_24-25.webp", 4),
        ("FIORENTINA MAGLIA GARA HOME DONNA<br>KOMBAT PRO 2024/25", 120.00, "DONNA", 2, "../../images/articoli/maglia_donna_24-25.webp", 1),
        
        ("FIORENTINA MAGLIA GARA<br>HOME KOMBAT PRO 2023/24", 69.00, "UOMO", 3, "../../images/articoli/maglia_23-24.webp", 1),
        ("FIORENTINA MAGLIA GARA<br>HOME KOMBAT EXTRA 2023/24", 49.00, "UOMO", 1, "../../images/articoli/maglia_normale_23-24.webp", 1),
        ("FIORENTINA KIT HOME 2023/24", 49.00, "KIT GARA", 4, "../../images/articoli/kit_23-24.webp", 2),
        ("FIORENTINA PANTALONCINI GARA HOME 2023/24", 49.00, "KIT GARA", 3, "../../images/articoli/pantaloncini_23-24.webp", 3),
        ("FIORENTINA CALZETTONI GARA HOME 2023/24", 15.00, "KIT GARA", 3, "../../images/articoli/calzettoni_23-24.webp", 4),
        ("FIORENTINA MAGLIA GARA HOME DONNA<br>KOMBAT PRO 2023/24", 99.00, "DONNA", 3, "../../images/articoli/maglia_donna_23-24.webp", 1),
        
        ("FIORENTINA MAGLIA GARA<br>AWAY KOMBAT PRO <br>- EDIZIONE LIMITATA - FINALE ATENE 24", 115.00, "UOMO", 1, "../../images/articoli/maglia_atene_23-24.webp", 1),
        ("FIORENTINA MAGLIA GARA<br>AWAY KOMBAT PRO 23/24", 99.00, "UOMO", 4, "../../images/articoli/maglia_away_23-24.webp", 1),
        ("FIORENTINA MINIKIT<br>AWAY KOMBAT BAMBINO 23/24", 49.00, "KIT GARA", 3, "../../images/articoli/kit_away_23-24.webp", 2),
        ("FIORENTINA PANTALONCINI GARA AWAY 2023/24", 49.00, "KIT GARA", 3, "../../images/articoli/pantaloncini_away_23-24.webp", 3),
        ("FIORENTINA CALZETTONI GARA AWAY 2023/24", 15.00, "KIT GARA", 3, "../../images/articoli/calzettoni_away_23-24.webp", 4),
        ("FIORENTINA MAGLIA GARA<br>AWAY KOMBAT PRO BAMBINO 23/24", 99.00, "BAMBINO", 4, "../../images/articoli/maglia_away_bambino_23-24.webp", 1),
        
         ("FIORENTINA MAGLIA GARA<br>THIRD KOMBAT PRO 23/24", 99.00, "UOMO", 3, "../../images/articoli/maglia_third_23-24.webp", 1),
         ("FIORENTINA MAGLIA GARA<br>THIRD KOMBAT EXTRA 23/24", 49.00, "UOMO", 4, "../../images/articoli/maglia_third_normale_23-24.webp", 1),
         ("FIORENTINA MINIKIT<br>THIRD KOMBAT BAMBINO 23/24", 49.00, "KIT GARA", 4, "../../images/articoli/kit_third_23-24.webp", 2),
         ("FIORENTINA PANTALONCINI GARA THIRD 2023/24", 49.00, "KIT GARA", 3, "../../images/articoli/pantaloncini_third_23-24.webp", 3),
         ("FIORENTINA CALZETTONI GARA THIRD 2023/24", 15.00, "KIT GARA", 3, "../../images/articoli/calzettoni_third_23-24.webp", 4),
         ("FIORENTINA MAGLIA GARA<br>THIRD KOMBAT PRO BAMBINO 23/24", 99.00, "BAMBINO", 4, "../../images/articoli/maglia_third_bambino_23-24.webp", 1),
        
        ("FIORENTINA MAGLIA GARA<br>FOURTH KOMBAT PRO 2023/24", 99.00, "UOMO", 3, "../../images/articoli/maglia_fourth_23-24.webp", 1),
        ("FIORENTINA MAGLIA GARA<br>FOURTH KOMBAT EXTRA 2023/24", 49.00, "UOMO", 4, "../../images/articoli/maglia_fourth_normale_23-24.webp", 1),
        ("FIORENTINA MINIKIT<br>FOURTH KOMBAT 2023/24", 49.00, "KIT GARA", 4, "../../images/articoli/kit_fourth_23-24.webp", 2),
        ("FIORENTINA PANTALONCINI GARA FOURTH 2023/24", 49.00, "KIT GARA", 3, "../../images/articoli/pantaloncini_fourth_23-24.webp", 3),
        ("FIORENTINA MAGLIA GARA<br>FOURTH KOMBAT PRO BAMBINO 2023/24", 99.00, "BAMBINO", 4, "../../images/articoli/maglia_fourth_bambino_23-24.webp", 1),
        ("FIORENTINA PANTALONCINI GARA<br>FOURTH BAMBINO 2023/24", 49.00, "BAMBINO", 3, "../../images/articoli/pantaloncini_fourth_bambino_23-24.webp", 3);
        
	
-- Dump dei dati per le taglie degli articoli
INSERT
INTO ArticoloTaglia(Id_articolo, Id_taglia)
VALUES 	(1, 2),
		(1, 3),
        (1, 4),
        (1, 5),
        (1, 6),
        
        (2, 2),
        (2, 3),
        (2, 4),
        (2, 5),
        (2, 6),
        (2, 7),
        
        (3, 2),
        (3, 3),
        (3, 4),
        (3, 5),
        (3, 6),
        (3, 7),
        
        (4, 2),
        (4, 3),
        (4, 4),
        (4, 5),
        (4, 6),
        (4, 7),
        
        (5, 2),
        (5, 3),
        (5, 4),
        
        (6, 1),
        (6, 2),
        (6, 3),
        (6, 4),
        (6, 5),
        (6, 6),
        
        (7, 2),
        (7, 3),
        (7, 4),
        (7, 5),
        (7, 6),
        (7, 7),
        
        (8, 3),
        (8, 5),
        (8, 6),
        (8, 7),
        
        (9, 2),
        (9, 3),
        (9, 4),
        (9, 5),
        (9, 6),
        (9, 7),
        
        
        (10, 2),
        (10, 3),
        (10, 4),
        (10, 5),
        (10, 6),
        (10, 7),
        
        (11, 3),
        (11, 4),
        
        (12, 4),
        (12, 5),
        (12, 6),
        
        (13, 2),
        (13, 3),
        (13, 4),
        (13, 5),
        (13, 6),
        (13, 7),
        
        (14, 2),
        (14, 3),
        (14, 4),
        (14, 5),
        (14, 6),
        (14, 7),
        
        (15, 1),

		(16, 2),
        (16, 3),
        (16, 4),
        (16, 5),
        (16, 6),
        (16, 7),

		(17, 2),
        
        (18, 1),
        
		(19, 2),
		(19, 3),
        (19, 4),
		(19, 5),
        (19, 6),
        (19, 7),
        
        (20, 7),
        
        (21, 1),
		
		(22, 2),
		(22, 3),
		(22, 4),
		(22, 5),
		(22, 6),

		(23, 2),
        (23, 3),
        (23, 4),
        
        (24, 1),
        
        (25, 2),
		(25, 3),
        (25, 4),
        (25, 5),
        (25, 6),
        (25, 7),

		(26, 3),
        (26, 4),
        (26, 5),
        (26, 6),
        
        (27, 1),
		
        (28, 2),
        (28, 3),
        (28, 4),
        (28, 5),
        (28, 6),
		(28, 7),
        
        (29, 1),
        (30, 1);