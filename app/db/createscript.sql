CREATE DATABASE IF NOT EXISTS aurora;

USE aurora;

CREATE TABLE Gebruiker (
    Id INT NOT NULL PRIMARY KEY,
    Voornaam VARCHAR(50) NOT NULL,
    Tussenvoegsel VARCHAR(10),
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

CREATE TABLE Rol (
    Id INT NOT NULL PRIMARY KEY,
    GebruikerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

CREATE TABLE Contact (
    Id INT NOT NULL PRIMARY KEY,
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
    Id INT NOT NULL PRIMARY KEY,
    GebruikerId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Medewerkersoort VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

CREATE TABLE Bezoeker (
    Id INT NOT NULL PRIMARY KEY,
    GebruikerId INT NOT NULL,
    Relatienummer MEDIUMINT NOT NULL UNIQUE,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (GebruikerId) REFERENCES Gebruiker(Id)
);

CREATE TABLE Prijs (
    Id INT NOT NULL PRIMARY KEY,
    Tarief DECIMAL(5, 2) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL
);

CREATE TABLE Voorstelling (
    Id INT NOT NULL PRIMARY KEY,
    MedewerkerId INT NOT NULL,
    Naam VARCHAR(100) NOT NULL,
    Beschrijving TEXT,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    MaxAantalTickets INT NOT NULL,
    Beschikbaarheid VARCHAR(50) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (MedewerkerId) REFERENCES Medewerker(Id)
);

CREATE TABLE Ticket (
    Id INT NOT NULL PRIMARY KEY,
    BezoekerId INT NOT NULL,
    VoorstellingId INT NOT NULL,
    PrijsId INT NOT NULL,
    Nummer MEDIUMINT NOT NULL UNIQUE,
    Barcode VARCHAR(20) NOT NULL,
    Datum DATE NOT NULL,
    Tijd TIME NOT NULL,
    Status VARCHAR(20) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (VoorstellingId) REFERENCES Voorstelling(Id),
    FOREIGN KEY (PrijsId) REFERENCES Prijs(Id)
);

CREATE TABLE Melding (
    Id INT NOT NULL PRIMARY KEY,
    BezoekerId INT,
    VoorstellingId INT,
    Nummer MEDIUMINT NOT NULL,
    Type VARCHAR(20) NOT NULL,
    Bericht VARCHAR(250) NOT NULL,
    Isactief BIT NOT NULL,
    Opmerking VARCHAR(250),
    Datumaangemaakt DATETIME(6) NOT NULL,
    Datumgewijzigd DATETIME(6) NOT NULL,
    FOREIGN KEY (BezoekerId) REFERENCES Bezoeker(Id),
    FOREIGN KEY (VoorstellingId) REFERENCES Voorstelling(Id)
);


INSERT INTO meldingen (naam, email, onderwerp, bericht, datum) VALUES
('Sophie Jansen', 'sophie.jansen@example.com', 'Probleem met bestelling', 'Mijn bestelling is nooit aangekomen. Kunnen jullie dit nakijken?', '2025-05-20 10:15:00'),
('Mohamed El Amrani', 'mohamed.amrani@example.com', 'Vraag over product', 'Ik wil graag meer informatie over het product X123.', '2025-05-19 14:30:00'),
('Lisa de Vries', 'lisa.vries@example.com', 'Website werkt niet goed', 'De contactpagina laadt niet goed op mobiel.', '2025-05-18 09:42:00'),
('Jeroen Bakker', 'jeroen.bakker@example.com', 'Factuur niet ontvangen', 'Ik heb geen factuur gekregen bij mijn bestelling.', '2025-05-17 17:20:00'),
('Fatima Ait', 'fatima.ait@example.com', 'Retouraanvraag', 'Ik wil graag mijn product retourneren. Wat is de procedure?', '2025-05-16 13:55:00');
