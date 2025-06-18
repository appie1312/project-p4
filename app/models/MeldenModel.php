<?php

class meldenModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function create($data)
    {
        $sql = "INSERT INTO melding (
                    nummer, type, bericht, isactief, opmerking, bezoekerId, medewerkerId, datumaangemaakt, datumgewijzigd
                ) VALUES (
                    :nummer, :type, :bericht, :isactief, :opmerking, :bezoekerId, :medewerkerId, NOW(6), NOW(6)
                )";

        $this->db->query($sql);

        $this->db->bind(':nummer', $data['nummer'], PDO::PARAM_INT);
        $this->db->bind(':type', $data['type'], PDO::PARAM_STR);
        $this->db->bind(':bericht', $data['bericht'], PDO::PARAM_STR);
        $this->db->bind(':isactief', $data['isactief'], PDO::PARAM_BOOL);
        $this->db->bind(':opmerking', $data['opmerking'], PDO::PARAM_STR);
        $this->db->bind(':bezoekerId', $data['bezoekerId'], PDO::PARAM_INT);
        $this->db->bind(':medewerkerId', $data['medewerkerId'], PDO::PARAM_INT);

        return $this->db->execute();
    }
}
