<?php

class MeldingenModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Zorg dat je een Database helper hebt in app/libraries/Database.php
    }

    public function getAllMeldingen()
    {
        $this->db->query("SELECT Id, Nummer, Type, Bericht, Datumaangemaakt FROM Melding WHERE Isactief = 1 ORDER BY Datumaangemaakt DESC");
        return $this->db->resultSet();
    }

    public function getMeldingById($id)
    {
        $this->db->query("SELECT * FROM Melding WHERE Id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function create($postData)
    {
        $this->db->query("INSERT INTO Melding (Nummer, Type, Bericht, Isactief, Datumaangemaakt) VALUES (:nummer, :type, :bericht, 1, NOW())");
        $this->db->bind(':nummer', $postData['klantnummer']);
        $this->db->bind(':type', $postData['type']);
        $this->db->bind(':bericht', $postData['bericht']);
        return $this->db->execute();
    }

    public function delete($Id)
    {
    $this->db->query("DELETE FROM Melding WHERE Id = :id");
    $this->db->bind(':id', $Id);
    return $this->db->execute();
    
    }


    public function updateMelding($postData)
    {
        $this->db->query("UPDATE Melding SET Nummer = :nummer, Type = :type, Bericht = :bericht WHERE Id = :id");
        $this->db->bind(':nummer', $postData['klantnummer']);
        $this->db->bind(':type', $postData['type']);
        $this->db->bind(':bericht', $postData['bericht']);
        $this->db->bind(':id', $postData['id']);
        return $this->db->execute();
    }
}
