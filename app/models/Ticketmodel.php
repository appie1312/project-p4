<?php
$host = 'localhost';
$db   = 'AURORA';
$user = 'root';
$pass = '';
class TicketModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=AURORA", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public function getAllTickets($filters = []) {
        try {
            $sql = "SELECT t.*, v.Naam as VoorstellingNaam, 
                           CONCAT(g.Voornaam, ' ', g.Tussenvoegsel, ' ', g.Achternaam) as BezoekerNaam,
                           p.Tarief
                    FROM Ticket t
                    LEFT JOIN Voorstelling v ON t.VoorstellingId = v.Id
                    LEFT JOIN Bezoeker b ON t.BezoekerId = b.Id
                    LEFT JOIN Gebruiker g ON b.GebruikerId = g.Id
                    LEFT JOIN Prijs p ON t.PrijsId = p.Id
                    WHERE 1=1";

            $params = [];

            if (!empty($filters['status'])) {
                $sql .= " AND t.Status = :status";
                $params[':status'] = $filters['status'];
            }

            if (!empty($filters['voorstelling'])) {
                $sql .= " AND t.VoorstellingId = :voorstellingId";
                $params[':voorstellingId'] = $filters['voorstelling'];
            }

            if (!empty($filters['datum'])) {
                $sql .= " AND DATE(t.Datum) = :datum";
                $params[':datum'] = $filters['datum'];
            }

            $sql .= " ORDER BY t.Datum DESC, t.Tijd DESC";

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            throw new Exception("Error fetching tickets: " . $e->getMessage());
        }
    }

    public function getVoorstellingen() {
        try {
            $sql = "SELECT Id, Naam FROM Voorstelling WHERE Isactief = 1 ORDER BY Datum DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching voorstellingen: " . $e->getMessage());
        }
    }
}