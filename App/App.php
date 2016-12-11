<?php
    /**
     * Fichier de configuration où sont stockés les constantes de connexion
     */
    use Core\Database\MysqlDatabase;
    
    require '../Config/config.php';
    
    /**
     * @author Guillaume Desrumaux
     * @date 29/11/16
     */
    class App
    {
        /**
         * @var Database Instance de base de donnnées
         */
        private static $database;
        
        /**
         * Fonction qui retourne une instance de base de données
         * @return Database Instance retournée
         */
        public static function getDb()
        {
            if(self::$database === null)
            {
                self::$database = new MysqlDatabase(DB_NAME);
            }
            return self::$database;
        }
        
        /**
         * Fonction permettant de charger toutes les classes
         */
        public static function load()
        {
            //TODO Add Session Start
            require 'Autoload.php';
            App\Autoload::register();
            require '../Core/Autoload.php';
            \Core\Autoload::register();
        }
    }