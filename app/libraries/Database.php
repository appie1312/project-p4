<?php
/**
 * Dit is de database class die alle communicatie met de database verzorgt
 */

class Database
{
    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;


    private $dbHandler;
    private $statement;

    public function __construct()
    {
        /**
         * Dit is de connectiestring die nodig voor het maken van een
         * nieuw PDO object
         */
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;

        /**
         * We geven nog wat options mee voor het PDO-object om 
         * fouten weer te geven
         */
        $options = array(
            PDO::ATTR_PERSISTENT =>true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        );

        try {
            /**
             * Maken we eenverbinding met de database mysql server
             */
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            /**
             * Wanneer er een error optreed daarbij wordt er een PDOException object 
             * aangemaakt met informatie over de error
             */
            // logger(__LINE__, __METHOD__, __FILE__, $e->getMessage());
            echo "Op dit moment kunnen we u niet helpen... probeer het later nog eens";
            header('Refresh:30; url=' .URLROOT . '/homepages/index');
        }
    }

    public function query($sql)
    {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    public function resultSet()
    {
        $this->statement->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Deze methode bind de waardes aan de parameters in de query
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->statement->bindValue($param, $value, $type); // <-- let op: statement, niet stmt
    }

    /**
     * Deze methode voert de query uit
     */
    public function execute()
    {
        return $this->statement->execute();
    }

    public function single()
    {
        $this->statement->execute();
        $result = $this->statement->fetch(PDO::FETCH_OBJ);
        $this->statement->closecursor();
        return $result;
    }

    public function outQuery($sql) {
        return $this->dbHandler->query($sql);
    }
}