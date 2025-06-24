<?php

class MeldingenModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
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


    public function delete($Id)
    {
        $this->db->query("DELETE FROM Melding WHERE Id = $Id");
        return $this->db->execute();
    }
    
    public function updateMelding($postData)
    {
        $this->db->query("UPDATE Melding 
            SET Nummer = :nummer, 
                Type = :type, 
                Bericht = :bericht, 
                Opmerking = :opmerking, 
                Isactief = :isactief, 
                Datumgewijzigd = NOW(6)
            WHERE Id = :id");
    
        $this->db->bind(':nummer', $postData['nummer']);
        $this->db->bind(':type', $postData['type']);
        $this->db->bind(':bericht', $postData['bericht']);
        $this->db->bind(':opmerking', $postData['opmerking'] ?? null);
        $this->db->bind(':isactief', $postData['isactief'] ?? 1);
        $this->db->bind(':id', $postData['id']);
    
        return $this->db->execute();
    }
}
