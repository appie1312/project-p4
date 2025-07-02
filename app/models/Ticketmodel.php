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

public function getTicketById($id) {
    try {
        $sql = "SELECT * FROM Ticket WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching ticket: " . $e->getMessage());
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
                $sql .= " AND t.VoorstellingId = :voorstelling";
                $params[':voorstelling'] = $filters['voorstelling'];
            }
            if (!empty($filters['datum'])) {
                $sql .= " AND t.Datum = :datum";
                $params[':datum'] = $filters['datum'];
            }
    
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

    public function deleteTicket($id) {
        try {
            $sql = "DELETE FROM Ticket WHERE Id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting ticket: " . $e->getMessage());
        }
    }

    public function createTicket($data) {
        try {
            $sql = "INSERT INTO Ticket (BezoekerId, VoorstellingId, PrijsId, Nummer, Barcode, Datum, Tijd, Status)
                    VALUES (:bezoekerid, :voorstellingid, :prijsid, :nummer, :barcode, :datum, :tijd, :status)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':bezoekerid', $data['bezoekerid'], PDO::PARAM_INT);
        $stmt->bindParam(':voorstellingid', $data['voorstellingid'], PDO::PARAM_INT);
        $stmt->bindParam(':prijsid', $data['prijsid'], PDO::PARAM_INT);
        $stmt->bindParam(':nummer', $data['nummer'], PDO::PARAM_INT);
        $stmt->bindParam(':barcode', $data['barcode']);
        $stmt->bindParam(':datum', $data['datum']);
        $stmt->bindParam(':tijd', $data['tijd']);
        $stmt->bindParam(':status', $data['status']);
        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error creating ticket: " . $e->getMessage());
    }
}
    
public function updateTicket($id, $data) {
    try {
        $sql = "UPDATE Ticket SET 
                    Nummer = :Nummer,
                    Barcode = :Barcode,
                    VoorstellingId = :VoorstellingId,
                    Datum = :Datum,
                    Tijd = :Tijd,
                    Status = :Status,
                    BezoekerId = :BezoekerId,
                    PrijsId = :PrijsId,
                    Opmerking = :Opmerking
                WHERE Id = :Id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':Nummer', $data['Nummer']);
        $stmt->bindParam(':Barcode', $data['Barcode']);
        $stmt->bindParam(':VoorstellingId', $data['VoorstellingId']);
        $stmt->bindParam(':Datum', $data['Datum']);
        $stmt->bindParam(':Tijd', $data['Tijd']);
        $stmt->bindParam(':Status', $data['Status']);
        $stmt->bindParam(':BezoekerId', $data['BezoekerId']);
        $stmt->bindParam(':PrijsId', $data['PrijsId']);
        $stmt->bindParam(':Opmerking', $data['Opmerking']);
        $stmt->bindParam(':Id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        die("Error updating ticket: " . $e->getMessage());
    }
}

public function annuleerTicket($id) {
    try {
        $sql = "UPDATE Ticket SET Status = 'Geannuleerd' WHERE Id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        throw new Exception("Error annulleren ticket: " . $e->getMessage());
    }
}
}
