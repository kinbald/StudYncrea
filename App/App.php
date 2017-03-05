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
     * @return \Core\Database\Database Instance retournée
     */
    public static function getDb()
    {
        if (self::$database === null) {
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
        date_default_timezone_set('Europe/Paris');
        require 'Autoload.php';
        App\Autoload::register();
        require '../Core/Autoload.php';
        \Core\Autoload::register();
    }

    /**
     * Fonction qui permet d'ajouter un fichier sur le serveur
     */
    public static function addFile($name, $url)
    {
        $resultat = move_uploaded_file($_FILES[$name]['tmp_name'], $url);
        if (!$resultat) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Factory pour classe Auth
     * @return \App\Auth
     */
    public static function getAuth()
    {
        return new App\Auth(App\Session::getInstance(), new \App\Model\UsersModel(self::getDb()));
    }

    /**
     * Factory pour model
     * @param $table string
     * @return \Core\Model\Model
     */
    public static function getModel($table)
    {
        $class_name = "\\App\\Model\\" . ucfirst($table) . 'Model';
        return new $class_name(self::getDb());
    }

    /**
     * Redirection directe
     * @param $page
     */
    public static function redirect($page)
    {
        header("Location: $page");
        exit();
    }

    /**
     * Fonction qui permet d'afficher le temps écoulé depuis une date
     * @param $date_post
     */
    public static function display_date($date_post)
    {
        $data1 = $date_post;//On récupère la date
        list($date, $time) = explode(" ", $data1);//On la sépare en 2
        //On place dans les bonnes variables chaque attributs
        list($annee, $mois, $jour) = explode("-", $date);
        list($heure, $minute, $seconde) = explode(":", $time);

        $timestamp = mktime($heure, $minute, $seconde, $mois, $jour, $annee);
        $time = time() - $timestamp;

        $seconde = floor($time);
        $minute = floor($seconde / 60);
        $heure = floor($minute / 60);
        $jour = floor($heure / 24);
        $mois = floor($jour / 31);
        $annee = floor($jour / 365.25);

        //Affiche une phrase différente selon la date du post (gére l'orthographe)
        if ($seconde < 59) {
            if ($seconde == 1) echo "Il y a " . $seconde . " seconde";
            else echo "Il y a " . $seconde . " secondes";
        } elseif ($minute < 59) {
            if ($minute == 1) echo "Il y a " . $minute . " minute";
            else echo "Il y a " . $minute . " minutes";
        } elseif ($heure < 23) {
            if ($heure == 1) echo "Il y a " . $heure . " heure";
            else echo "Il y a " . $heure . " heures";
        } elseif ($jour < 30) {
            if ($jour == 1) echo "Il y a " . $jour . " jour";
            else echo "Il y a " . $jour . " jours";
        } elseif ($mois < 12) {
            if ($mois == 1) echo "Il y a " . $mois . " mois";
            else echo "Il y a " . $mois . " mois";
        } else {
            if ($annee == 1) echo "Il y a " . $annee . " an";
            else echo "Il y a " . $annee . " ans";
        }
    }

}