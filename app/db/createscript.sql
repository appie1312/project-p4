-- Drop de database als die al bestaat
DROP DATABASE IF EXISTS aurora;

-- Maak de database aan
CREATE DATABASE aurora;
USE aurora;

-- Tabel: Gebruiker
CREATE TABLE Gebruiker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(10),
    Achternaam VARCHAR(50) NOT NULL,
    Gebruikersnaam VARCHAR(100) NOT NULL,
    Wachtwoord VARCHAR(255) NOT NULL,
    IsIngelogd BIT NOT NULL DEFAULT 0,
    Ingelogd DATETIME NULL,
    Uitgelogd DATETIME NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Tabel: Rol
CREATE TABLE Rol (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

-- Tabel: Contact
CREATE TABLE Contact (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Mobiel VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

-- Tabel: Medewerker
CREATE TABLE Medewerker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Medewerkersoort VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

-- Tabel: Bezoeker
CREATE TABLE Bezoeker (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    GebruikerId INT NOT NULL,
    Relatienummer MEDIUMINT NOT NULL UNIQUE,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

-- Tabel: Prijs
CREATE TABLE Prijs (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Tarief DECIMAL(5,2) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
);

-- Tabel: Voorstelling
CREATE TABLE Voorstelling (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    MedewerkerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Beschrijving TEXT,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    MaxAantalTickets INT NOT NULL,
    Beschikbaarheid VARCHAR(50) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

-- Tabel: Ticket
CREATE TABLE Ticket (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    BezoekerId INT NOT NULL,
    VoorstellingId INT NOT NULL,
    PrijsId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Barcode VARCHAR(20) NOT NULL UNIQUE,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    Status VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (VoorstellingId) REFERENCES Voorstelling(Id),
    FOREIGN KEY (PrijsId) REFERENCES Prijs(Id)
);

-- Tabel: Melding
CREATE TABLE Melding (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    BezoekerId INT NULL,
    MedewerkerId INT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Type VARCHAR(20) NOT NULL,
    Bericht VARCHAR(250) NOT NULL,
    Isactief BIT NOT NULL DEFAULT 1,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    Datumgewijzigd DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

-- Voorbeelddata invoegen

-- Gebruikers
INSERT INTO Gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord, IsIngelogd, Isactief, Opmerking)
VALUES 
('Abdulkadir', '', 'Abdalla', 'abdulkadir.a', 'encrypted_password_123', 0, 1, 'Eerste gebruiker'),
('Sophie', 'van', 'Dijk', 'sophie.vd', 'encrypted_password_456', 0, 1, NULL);

-- Rollen
INSERT INTO Rol (GebruikerId, Naam, Isactief)
VALUES 
(1, 'Administrator', 1),
(2, 'Bezoeker', 1);

-- Contacten
INSERT INTO Contact (GebruikerId, Email, Mobiel, Isactief)
VALUES 
(1, 'abdulkadir@example.com', '0612345678', 1),
(2, 'sophie@example.com', '0687654321', 1);

-- Medewerkers
INSERT INTO Medewerker (GebruikerId, Nummer, Medewerkersoort, Isactief)
VALUES
(1, 1001, 'Beheerder', 1);

-- Bezoekers
INSERT INTO Bezoeker (GebruikerId, Relatienummer, Isactief)
VALUES
(2, 5001, 1);

-- Prijzen
INSERT INTO Prijs (Tarief, Isactief)
VALUES
(15.00, 1),
(20.00, 1);

-- Voorstellingen
INSERT INTO Voorstelling (MedewerkerId, Naam, Beschrijving, Datum, Tijd, MaxAantalTickets, Beschikbaarheid, Isactief)
VALUES
(1, 'Romeo en Julia', 'Klassiek theaterstuk', '2025-07-01', '19:30:00', 100, 'Ingepland', 1);

-- Tickets
INSERT INTO Ticket (BezoekerId, VoorstellingId, PrijsId, Nummer, Barcode, Datum, Tijd, Status, Isactief)
VALUES
(1, 1, 1, 1234, 'ABC123456789', '2025-06-01', '10:00:00', 'Gereserveerd', 1);

-- Meldingen
INSERT INTO Melding (BezoekerId, MedewerkerId, Nummer, Type, Bericht, Isactief)
VALUES
(1, NULL, 9001, 'Notificatie', 'Uw reservering is bevestigd.', 1),
(NULL, 1, 9002, 'Klacht', 'Er is een probleem met het ticket.', 1);
