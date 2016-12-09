<?php

/**
 * Fichier de configuration où sont stockés les constantes de connexion
 */
require 'Config/config.php';

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
            self::$database = new Database(DB_NAME);
            //self::$database = self::$database->getConnectionMySQL();
        }
        return self::$database;
    }
}