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
         * @return boolean Vrai si l'utilisateur existe, faux sinon
         */
        public function connect($email, $password)
        {
            $sql = "
                SELECT id_user, role
                FROM " . self::$table ."
                WHERE email=? 
                AND password_user=?
            ";
            //TODO Add validator
            $utilisateur = $this->executeReq($sql, array($email, $password), 2);
            return (count($utilisateur) == 1);
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
            $sql = "
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