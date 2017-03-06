<?php
/**
 * Created by PhpStorm.
 * User: gdesrumaux
 * Date: 11/12/2016
 * Time: 17:03
 */

namespace App\Model;

use Core\Model\Model;

class UsersModel extends Model
{

    /**
     * @var string Nom de la table
     */
    public static $table = 'USERS';
    private $_idName = 'id_user';

    /**
     * Vérifie qu'un utilisateur existe dans la BD
     *
     * @param string $email Le login
     * @param string $password Le mot de passe
     * @return int 1 si l'utilisateur existe, 0 sinon
     */
    public function connect($email, $password)
    {
        $sql = /** @lang MySQL */
            "
                SELECT password_user
                FROM " . self::$table . " 
                WHERE email=?
            ";
        $user_password = $this->executeReq($sql, array($email), 1);
        /** S'il y n'a pas d'entrée dans le resultat de la requête alors l'utilisateur n'existe pas */
        if ($user_password != false) {
            /** Vérification du mot de passe */
            if (password_verify($password, $user_password['password_user'])) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return -1;
        }
    }

    /**
     * Fonction qui permet de connaître le statut d'un utilisateur
     *
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe de l'utilisateur
     * @return int Statut de l'utilisateur
     */
    public function getRole($email)
    {
        $sql = /** @lang MySQL */
            '
                SELECT role
                FROM ' . self::$table . ' 
                WHERE email=?
            ';
        $role = $this->executeReq($sql, array($email), 1);
        if (count($role) != 0) {
            return $role['role'];
        }
        echo '<br>Problème dans la base de données <br>';
    }

    /**
     * Renvoie un utilisateur existant dans la BD
     *
     * @param string $email Le login
     * @param string $password Le mot de passe
     * @return mixed L'utilisateur
     * @throws Exception Si aucun utilisateur ne correspond aux paramètres
     */
    public function getUtilisateur($email, $password)
    {
        $sql = /** @lang MySQL */
            "
                SELECT id_user, is_admin, is_teacher
                FROM users
                WHERE email=? AND password=?
            ";
        //TODO Add form validation and encrypt password
        $utilisateur = $this->executeReq($sql, array($email, password_hash($password, PASSWORD_DEFAULT), 2));
        if (count($utilisateur) == 1) /// Accès à la première ligne de résultat
            return $utilisateur[0]; else
            throw new Exception("Aucun utilisateur ne correspond aux identifiants fournis");
    }

    /**
     * Fonction permettant de vérifier si un utilisateur existe déjà sur la plateforme
     * @param string $email Email du compte à vérifier
     * @return bool
     */
    public function checkUserExist($email)
    {
        /// Recherche existence dans la base de données
        $exist = $this->findBy('email', array($email), 1);
        /// Si l'utilisateur existe sur la plateforme il a un mot de passe renseigné
        if (!empty($exist['password_user'])) {
            /// L'utilisateur est déjà inscrit
            return true;
        } else {
            return false;
        }
    }

    public function generateToken($length)
    {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

    public function registerUser($email, $password, $name, $surname, $role, $class)
    {
        if ($this->checkUserExist($email) === FALSE) {
            $id = $this->lastInsertId($this->getIdName());
            $id = $id === FALSE ? 1 : $id + 1;
            $sql = "
                    INSERT INTO " . static::$table . " (id_user, email, password_user, name_user, surname_user, role, token, id_class)
                    VALUES (:id, :email, :password_user, :name_user, :surname_user, :role, :token, :class)
                ";
            $password = password_hash($password, PASSWORD_DEFAULT);
            $token = $this->generateToken(35);
            $param = [':id' => $id, ':email' => $email, ':password_user' => $password, ':name_user' => $name, ':surname_user' => $surname, ':role' => $role, ':token' => $token, ':class' => $class,];
            $add = $this->executeReq($sql, $param, 0);
            return $token;
        }
        return -1;
    }

    /**
     * Fonction qui renvoie un tableau des professeurs
     * @return array
     */
    public function getTeacher()
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE role=2 ORDER BY name_user";
        $result = $this->executeReq($sql);
        $options = [];
        foreach ($result as $donnees) {
            $options[$donnees[$this->getIdName()]] = $donnees["name_user"] . " " . $donnees["surname_user"];
        }
        return $options;
    }

    /**
     * Fonction qui renvoie le nom correspondant à l'id
     * @param $id_user int
     * @return string
     */
    public function findUserName($id_user)
    {
        $sql = "SELECT name_user FROM " . static::$table . " WHERE " . $this->_idName . " = :" . $this->_idName;;
        $param = [":" . $this->getIdName() => $id_user,];
        $result = $this->executeReq($sql, $param, 1);
        $result = $result['name_user'];
        return $result;
    }

    /**
     * Fonction qui renvoie l'email correspondant à l'id
     * @param $id_user int
     * @return string
     */
    public function findEmail($id_user)
    {
        $sql = "SELECT email FROM " . static::$table . " WHERE " . $this->_idName . " = :" . $this->_idName;;
        $param = [":" . $this->getIdName() => $id_user,];
        $result = $this->executeReq($sql, $param, 1);
        $result = $result['email'];
        return $result;
    }
    
    public function setRole($role, $id_user)
    {
        $date = date('y-m-d H:i:s');
        $sql = "UPDATE " . static::$table . " SET role=" . $role . ", confirmed_at='" . $date ."' WHERE " . $this->getIdName() . "=?";
        return $this->executeReq($sql, [$id_user], 0);
    }
    
    public function setWarning($id_user, $warning)
    {
        $sql = "UPDATE " . static::$table . " SET warnings_user=" . $warning . " WHERE " . $this->getIdName() . "=?";
        return $this->executeReq($sql, [$id_user], 0);
    }
    
    public function getWarning($id_user)
    {
        $sql = "SELECT warnings_user FROM " . static::$table . " WHERE " . $this->getIdName() . "=?";
        return $this->executeReq($sql, [$id_user], 1);
    }

    /**
     * @return string
     */
    public function getIdName()
    {
        return $this->_idName;
    }
}