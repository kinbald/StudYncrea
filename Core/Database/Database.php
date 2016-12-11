<?php
    namespace Core\Database;
    
    use PDOException;
    use PDO;

    /**
     * @author Guillaume Desrumaux
     * @date 24/11/16
     */
    class Database
    {
        /**
         * @var string Hôte de la BDD
         */
        protected $db_host;
        /**
         * @var string Utilisateur de la BDD
         */
        protected $db_user;
        /**
         * @var string Mot de passe de la BDD
         */
        protected $db_password;
        /**
         * @var string Nom de la BDD
         */
        protected $db_name;
        /**
         * @var string Port de la BDD
         */
        protected $db_port;
        /**
         * @var object Instance de PDO
         */
        protected $pdo;
        
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
         * Exécute une requête SQL (Selection, Insertion, Mise à jour)
         * @param string $statement Requête SQL
         * @param array|null $params Paramètres pour la requête
         * @param int $fetch Fetch mode 1 (one) ou 2 (all)
         * @return array
         */
        public function query($statement, $params = null, $fetch)
        {
            if($params)
            {
                try
                {
                    $requete = $this->getConnection()->prepare($statement);
                    $requete->execute($params);
                }
                catch(PDOException $e)
                {
                    die($e->getMessage());
                }
            }
            else
            {
                $req = $this->getConnection()->query($statement);
            }
            /* Méthode de récupération en objet "tab->0" */
            // $datas = $req->fetchAll(PDO::FETCH_OBJ);
            /* Méthode de récupération de manière associative "tab[0]"*/
            switch($fetch)
            {
                case 1:
                    $datas = $req->fetch(PDO::FETCH_ASSOC);
                    break;
                case 2:
                    $datas = $req->fetchAll(PDO::FETCH_ASSOC);
                    break;
                case null:
                    $datas = $req->fetchAll(PDO::FETCH_ASSOC);
                    break;
            }
            return $datas;
        }
    }