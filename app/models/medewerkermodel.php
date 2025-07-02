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
                    LEFT JOIN Gebruiker g ON m.GebruikerId = g.Id
                    LEFT JOIN Contact c ON g.Id = c.GebruikerId";
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

    public function deleteMedewerker($id) {
        try {
            $sql = "DELETE FROM Medewerker WHERE Id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting medewerker: " . $e->getMessage());
        }
    }

    public function createMedewerker($data) {
    try {
        $sql = "INSERT INTO Medewerker (GebruikerId, Nummer, Medewerkersoort, Isactief, Opmerking)
                VALUES (:gebruikerid, :nummer, :medewerkersoort, :isactief, :opmerking)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':gebruikerid', $data['gebruikerid'], PDO::PARAM_INT);
        $stmt->bindParam(':nummer', $data['nummer'], PDO::PARAM_INT);
        $stmt->bindParam(':medewerkersoort', $data['medewerkersoort']);
        $stmt->bindParam(':isactief', $data['isactief'], PDO::PARAM_BOOL);
        $stmt->bindParam(':opmerking', $data['opmerking']);
        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error creating medewerker: " . $e->getMessage());
    }
}

    public function updateMedewerker($id, $data) {
        try {
            $sql = "UPDATE Medewerker SET 
                        GebruikerId = :gebruikerid, 
                        Nummer = :nummer, 
                        Medewerkersoort = :medewerkersoort, 
                        Isactief = :isactief, 
                        Opmerking = :opmerking 
                    WHERE Id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':gebruikerid', $data['gebruikerid'], PDO::PARAM_INT);
            $stmt->bindParam(':nummer', $data['nummer'], PDO::PARAM_INT);
            $stmt->bindParam(':medewerkersoort', $data['medewerkersoort']);
            $stmt->bindParam(':isactief', $data['isactief'], PDO::PARAM_BOOL);
            $stmt->bindParam(':opmerking', $data['opmerking']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating medewerker: " . $e->getMessage());
        }
    }
}