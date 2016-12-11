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
    class MysqlDatabase extends Database
    {
        /**
         * Crée une connexion à la base données MySQL
         * @return PDO Instance de PDO
         */
        public function getConnection()
        {
            if($this->pdo === null)
            {
                try
                {
                    $dsn = 'mysql:dbname=' . $this->db_name . ';host=' . $this->db_host . '';
                    $pdo = new PDO($dsn, $this->db_user, $this->db_password, array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ));
                    $this->pdo = $pdo;
                }
                catch (PDOException $e) {
                    die('Erreur de connexion à la base de données MySQL');
                }
            }
            return $this->pdo;
        }
    }