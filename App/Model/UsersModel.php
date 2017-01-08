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
                FROM " . self::$table ." 
                WHERE email=?
            ";
            $user_password = $this->executeReq($sql, array($email), 1);
            /** S'il y n'a pas d'entrée dans le resultat de la requête alors l'utilisateur n'existe pas */
            if($user_password != false)
            {
                /** Vérification du mot de passe */
                if(password_verify($password, $user_password['password_user']))
                {
                    return 1;
                }
                else
                {
                    return 0;
                }
            }
            else
            {
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
                FROM ' . self::$table .' 
                WHERE email=?
            ';
            $role = $this->executeReq($sql, array($email), 1);
            if(count($role) != 0)
            {
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
            if (count($utilisateur) == 1)
                /// Accès à la première ligne de résultat
                return $utilisateur[0];
            else
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
            if(!empty($exist['password_user']))
            {
                /// L'utilisateur est déjà inscrit
                return true;
            }
            else
            {
                return false;
            }
        }

        public function registerUser($email, $password)
        {
            if($this->checkUserExist($email) === FALSE)
            {
                $id = $this->lastInsertId($this->getIdName());
                $id = $id === FALSE ? 1 : $id;
                $sql = "
                    INSERT INTO " . static::$table . " (id_user, email, password_user, name_user, surname_user, role, token, id_class)
                    VALUES (:id, :email, :password_user, :name_user, :surname_user, :)
                ";
            }
            return 0;
        }

        /**
         * @return string
         */
        public function getIdName()
        {
            return $this->_idName;
        }
    }