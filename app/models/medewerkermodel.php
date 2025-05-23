<?php
class MedewerkerModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=aurora", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            file_put_contents(__DIR__ . '/pdo_error.txt', $e->getMessage());
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getAllMedewerkers() {
        try {
            $sql = "SELECT m.*, g.Voornaam, g.Tussenvoegsel, g.Achternaam, 
                           c.Email, c.Mobiel,
                           (SELECT r.Naam FROM Rol r WHERE r.GebruikerId = g.Id AND r.Isactief = 1 LIMIT 1) as RolNaam
                    FROM Medewerker m
                    JOIN Gebruiker g ON m.GebruikerId = g.Id
                    LEFT JOIN Contact c ON g.Id = c.GebruikerId
                    WHERE m.Isactief = 1 AND g.Isactief = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            die("Error fetching medewerkers: " . $e->getMessage());
        }
    }

    public function getMedewerkerById($id) {
        try {
            $sql = "SELECT * FROM Medewerker WHERE Id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            file_put_contents(__DIR__ . '/pdo_error.txt', $e->getMessage());
            die("Error fetching medewerker: " . $e->getMessage());
        }
    }
}