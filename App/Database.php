<?php

require ('Config/config.php');

/**
 * @author Guillaume Desrumaux
 * @date 24/11/16
 *
 * Exemple de fonctionnement :
 * $db = new Database('studyncrea');
 *   $user = [
 *      'name_class' => 'CIR1'
 *   ];
 *  $db->exec('INSERT INTO PROMS(name_class) VALUES (:name_class)', $user);
 *
 */
class Database
{
    /**
     * @var string Hôte de la BDD
     */
    private $db_host;
    /**
     * @var string Utilisateur de la BDD
     */
    private $db_user;
    /**
     * @var string Mot de passe de la BDD
     */
    private $db_password;
    /**
     * @var string Nom de la BDD
     */
    private $db_name;
    /**
     * @var string Port de la BDD
     */
    private $db_port;
    /**
     * @var object Instance de PDO
     */
    private $pdo;

    /**
     * Database constructor.
     * @param string $db_name
     * @param string $db_user
     * @param string $db_password
     * @param string $db_host
     * @param string $db_port
     */
    public function __construct($db_name, $db_host = DB_HOST, $db_port = DB_PORT, $db_user = DB_USER, $db_password = DB_PASSWORD)
    {
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_password = $db_password;
        $this->db_user = $db_user;
        $this->db_port = $db_port;
    }

    /**
     * Crée une connexion à la base données avec Postgres
     * @return PDO
     */
    private function getConnection()
    {
        if($this->pdo === null)
        {
            try
            {
                $dsn = "pgsql:dbname=$this->db_name;user=$this->db_user;password=$this->db_password;host=$this->db_host";
                $pdo = new PDO($dsn, array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                ));
                $this->pdo = $pdo;
            }
            catch (PDOException $e) {
                echo 'Erreur de connexion à la base de données PSQL';
                die();
            }
        }
        return $this->pdo;

    }

    /**
     * Crée une connexion à la base données MySQL
     * @return PDO
     */
    private function getConnectionMySQL()
    {
        if($this->pdo === null)
        {
            try
            {
                $dsn = 'mysql:dbname=' . $this->db_name . ';host=' . $this->db_host . '';
                $pdo = new PDO($dsn, $this->db_user, $this->db_password, array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
                ));
                $this->pdo = $pdo;
            }
            catch (PDOException $e) {
                echo 'Erreur de connexion à la base de données MySQL';
                die();
            }
        }
        return $this->pdo;
    }

    /**
     * Exécute une requête SQL (Selection)
     * @param string $statement
     * @return array
     */
    public function query($statement)
    {
        $req = $this->getConnectionMySQL()->query($statement);
        $datas = $req->fetchAll(PDO::FETCH_OBJ);
        return $datas;
    }

    /**
     * Exécute une requête SQL (Insertion, Mise à jour)
     * @param string $statement
     * @param array $params
     * @return int
     */
    public function exec($statement, $params)
    {
        $req = $this->getConnectionMySQL()->prepare($statement);
        $count = $req->execute($params);
        return $count;
    }
}