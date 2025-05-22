CREATE DATABASE IF NOT EXISTS AURORA;
USE AURORA;

-- Tabel: Gebruiker
CREATE TABLE Gebruiker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(10) DEFAULT NULL,
    Achternaam VARCHAR(50) NOT NULL,
    Gebruikersnaam VARCHAR(100) NOT NULL,
    Wachtwoord VARCHAR(255) NOT NULL,
    IsIngelogd BIT NOT NULL,
    Ingelogd DATETIME,
    Uitgelogd DATETIME,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL
);

-- Tabel: Rol
CREATE TABLE Rol (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL, -- Bezoeker, Medewerker, Administrator
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);


CREATE TABLE Contact (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Mobiel VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);


CREATE TABLE Medewerker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE, 
    Medewerkersoort VARCHAR(20) NOT NULL, 
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

-- Medewerker 1
INSERT INTO Gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES ('Jan', NULL, 'Jansen', 'jan.jansen', 'wachtwoord', 0, 1, NOW(), NOW());
INSERT INTO Medewerker (GebruikerId, Nummer, Medewerkersoort, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 1001, 'Beheerder', 1, NOW(), NOW());
INSERT INTO Rol (GebruikerId, Naam, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 'Administrator', 1, NOW(), NOW());
INSERT INTO Contact (GebruikerId, Email, Mobiel, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 'jan.jansen@example.com', '0612345678', 1, NOW(), NOW());

-- Medewerker 2
INSERT INTO Gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES ('Sanne', 'de', 'Vries', 'sanne.devries', 'wachtwoord', 0, 1, NOW(), NOW());
INSERT INTO Medewerker (GebruikerId, Nummer, Medewerkersoort, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 1002, 'Technicus', 1, NOW(), NOW());
INSERT INTO Rol (GebruikerId, Naam, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 'Medewerker', 1, NOW(), NOW());
INSERT INTO Contact (GebruikerId, Email, Mobiel, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 'sanne.devries@example.com', '0612345679', 1, NOW(), NOW());

-- Medewerker 3
INSERT INTO Gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES ('Fatima', NULL, 'El Amrani', 'fatima.elamrani', 'wachtwoord', 0, 1, NOW(), NOW());
INSERT INTO Medewerker (GebruikerId, Nummer, Medewerkersoort, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 1003, 'Gastvrouw', 1, NOW(), NOW());
INSERT INTO Rol (GebruikerId, Naam, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 'Medewerker', 1, NOW(), NOW());
INSERT INTO Contact (GebruikerId, Email, Mobiel, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 'fatima.elamrani@example.com', '0612345680', 1, NOW(), NOW());


-- Tabel: Bezoeker
CREATE TABLE Bezoeker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Relatienummer MEDIUMINT NOT NULL UNIQUE, -- Uniek bezoekernummer
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

-- Tabel: Prijs
CREATE TABLE Prijs (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Tarief DECIMAL(5,2) NOT NULL, -- Ticketprijs
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL
);

-- Tabel: Voorstelling
CREATE TABLE Voorstelling (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    MedewerkerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL, -- Naam van de voorstelling
    Beschrijving TEXT,
    Datum DATE NOT NULL, -- Speeldatum
    Tijd TIME NOT NULL, -- Tijdstip van de voorstelling
    MaxAantalTickets INT NOT NULL, -- Maximale capaciteit
    Beschikbaarheid VARCHAR(50) NOT NULL, -- Ingepland, Uitverkocht, Geannuleerd
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

-- Tabel: Ticket
CREATE TABLE Ticket (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    BezoekerId INT NOT NULL,
    VoorstellingId INT NOT NULL,
    PrijsId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE, -- Uniek reserveringsnummer
    Barcode VARCHAR(20) NOT NULL UNIQUE, -- Unieke code
    Datum DATE NOT NULL, -- Datum van reservering
    Tijd TIME NOT NULL, -- Tijdstip van reservering
    Status VARCHAR(20) NOT NULL, -- Vrij, Bezet, Gereserveerd, Geannuleerd
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (VoorstellingId) REFERENCES Voorstelling(Id),
    FOREIGN KEY (PrijsId) REFERENCES Prijs(Id)
);
INSERT INTO Ticket (
    BezoekerId, VoorstellingId, PrijsId, Nummer, Barcode, Datum, Tijd, Status, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd
) VALUES (
    1, 1, 1, 12345, 'TESTBARCODE123', '2025-05-21', '20:00:00', 'Vrij', 1, '', NOW(), NOW()
);

-- Tabel: Melding
CREATE TABLE Melding (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    BezoekerId INT,
    MedewerkerId INT,
    Nummer MEDIUMINT NOT NULL UNIQUE, -- Uniek reserveringsnummer
    Type VARCHAR(20) NOT NULL, -- Notificatie, klacht of Review
    Bericht VARCHAR(250) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

-- Voeg een prijs toe
INSERT INTO Prijs (Tarief, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd)
VALUES (25.00, 1, '', NOW(), NOW());

-- Voeg een bezoeker toe
INSERT INTO Gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES ('Piet', NULL, 'Pietersen', 'piet.pietersen', 'wachtwoord', 0, 1, NOW(), NOW());
INSERT INTO Bezoeker (GebruikerId, Relatienummer, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 2001, 1, NOW(), NOW());

-- Voeg een voorstelling toe
INSERT INTO Voorstelling (MedewerkerId, Naam, Beschrijving, Datum, Tijd, MaxAantalTickets, Beschikbaarheid, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (2, 'Musical Night', 'Een geweldige musicalavond', '2025-06-01', '20:00:00', 100, 'Ingepland', 1, NOW(), NOW());

-- Voeg nog een bezoeker toe
INSERT INTO Gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES ('Lisa', NULL, 'de Boer', 'lisa.deboer', 'wachtwoord', 0, 1, NOW(), NOW());
INSERT INTO Bezoeker (GebruikerId, Relatienummer, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (LAST_INSERT_ID(), 2002, 1, NOW(), NOW());

-- Voeg nog een voorstelling toe
INSERT INTO Voorstelling (MedewerkerId, Naam, Beschrijving, Datum, Tijd, MaxAantalTickets, Beschikbaarheid, Isactief, Datumaangemaakt, Datumgewijzigd)
VALUES (3, 'Comedy Night', 'Lachen gegarandeerd', '2025-06-10', '21:00:00', 80, 'Ingepland', 1, NOW(), NOW());

-- Voeg tickets toe
INSERT INTO Ticket (BezoekerId, VoorstellingId, PrijsId, Nummer, Barcode, Datum, Tijd, Status, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd)
VALUES
    (2, 1, 1, 12346, 'BARCODE456', '2025-06-01', '20:00:00', 'Vrij', 1, '', NOW(), NOW()),
    (2, 2, 1, 12347, 'BARCODE789', '2025-06-10', '21:00:00', 'Vrij', 1, '', NOW(), NOW()),
    (3, 2, 1, 12348, 'BARCODE101', '2025-06-10', '21:00:00', 'Vrij', 1, '', NOW(), NOW());