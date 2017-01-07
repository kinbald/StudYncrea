<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 11/12/2016
     * Time: 15:25
     */
    
    namespace Core\Database;
    
    
    use PDO;
    use PDOException;
    
    class PostgreSQLDatabase extends Database
    {
        /**
         * Crée une connexion à la base données avec Postgres
         * @return PDO Instance de PDO
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
                    die('Erreur de connexion à la base de données PostgreSQL');
                }
            }
            return $this->pdo;
        }
    }