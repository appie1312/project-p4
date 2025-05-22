<?php
$host = 'localhost';
$db   = 'AURORA';
$user = 'root';
$pass = '';
class Ticket {
    private $pdo;

    public function __construct() {
        // Pas eventueel je gebruikersnaam/wachtwoord aan
        $this->pdo = new PDO("mysql:host=localhost;dbname=AURORA", "root", "");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Valideer ticket op basis van barcode
    public function validateTicket($code) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Ticket WHERE Barcode = ? AND Isactief = 1 AND Status IN ('Vrij','Gereserveerd','Bezet')"
        );
        $stmt->execute([$code]);
        $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ticket !== false;
    }
}