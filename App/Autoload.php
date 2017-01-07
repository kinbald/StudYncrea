<?php
    namespace App;
    /**
     * Created by IntelliJ IDEA.
     * User: Kinbald
     * Date: 14/11/16
     * Time: 16:25
     */
    class Autoload
    {
        /**
         * Enregistre l'autoloader
         */
        static function register()
        {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        }
        /**
         * Charge toutes les classes du dossier courant en fonction du namespace
         */
        static function autoload($class)
        {
            if(strpos($class, __NAMESPACE__ . '\\') === 0)
            {
                $class = str_replace(__NAMESPACE__ . '\\', '', $class);
                $class = str_replace('\\', '/', $class);
                require __DIR__ . '/' . $class . '.php';
            }
        }
    }