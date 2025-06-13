
<?php

class MeldenModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function bestaatVoorstelling($voorstellingId)
    {
        $sql = "SELECT Id FROM Voorstelling WHERE Id = :id AND Isactief = 1";
        $this->db->query($sql);
        $this->db->bind(':id', $voorstellingId, PDO::PARAM_INT);
        return $this->db->single() !== false;
    }

    public function createMelding($data)
    {
        $sql = "INSERT INTO meldingen 
                    (BezoekerId, MedewerkerId, Nummer, Type, Bericht, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd)
                VALUES 
                    (:bezoekerId, :medewerkerId, :nummer, :type, :bericht, :isactief, :opmerking, SYSDATE(6), SYSDATE(6))";

        $this->db->query($sql);
        $this->db->bind(':bezoekerId', $data['bezoekerId'], PDO::PARAM_INT);
        $this->db->bind(':medewerkerId', $data['medewerkerId'], PDO::PARAM_INT);
        $this->db->bind(':nummer', $data['nummer'], PDO::PARAM_INT);
        $this->db->bind(':type', $data['type'], PDO::PARAM_STR);
        $this->db->bind(':bericht', $data['bericht'], PDO::PARAM_STR);
        $this->db->bind(':isactief', 1, PDO::PARAM_BOOL);
        $this->db->bind(':opmerking', '', PDO::PARAM_STR);
        return $this->db->execute();
    }
}
