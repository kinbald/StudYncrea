<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 11/12/2016
     * Time: 16:51
     */
    namespace Core\Model;
    
    use Core\Database\Database;
    abstract class Model
    {
        private static $db;
        
        public function __construct(Database $db)
        {
            self::$db = $db;
        }
    
        /**
         * Exécute une requête SQL
         *
         * @param string $sql Requête SQL
         * @param array $params Paramètres de la requête
         * @param int $fetchMode Méthode de récupération
         * @return PDOStatement Résultats de la requête
         */
        protected function executeReq($sql, $params = null, $fetchMode = 2)
        {
            $resultat = self::$db->query($sql, $params, $fetchMode);
            return $resultat;
        }

        /**
         * Fonction qui permet de trouver un champ dans une table
         * @param string $column
         * @param array $param
         * @param int $fetch
         * @return PDOStatement
         */
        public function findBy($column, $param, $fetch = 2)
        {
            $sql = "
                SELECT *
                FROM " . static::$table . " 
                WHERE $column=?
                ";
            return $this->executeReq($sql, $param, $fetch);
        }

        /**
         * Fonction qui permet de trouver un identifiant à partir d'un champs de la table
         * @param string $columnid
         * @param string $column
         * @param array $param
         * @param int $fetch
         * @return int
         */
        public function getIdBy($columnid, $column, $param, $fetch = 1)
        {
            $sql = "
                SELECT $columnid 
                FROM " . static::$table . " 
                WHERE $column=?
                ";
            return $this->executeReq($sql, $param, $fetch)[$columnid];
        }
        
        public function all()
        {
            // static::table : Element défini dans chaque modele
            return $this->executeReq("SELECT * FROM " . static::$table);
        }

        /**
         * Fonction permettant de récupérer le dernier id de la table
         * @param string $idName
         * @return int Valeur
         */
        public function lastInsertId($idName)
        {
            $sql = "SELECT $idName FROM " . static::$table ." ORDER BY $idName DESC LIMIT 1";
            $result = $this->executeReq($sql, null, 1);
            if($result)
            {
                return (int)$result[$idName];
            }
            return FALSE;
        }

    }