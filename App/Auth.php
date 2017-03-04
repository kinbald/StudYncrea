<?php

/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 05/02/17
 * Time: 19:06
 */

namespace App;

define("USER", 0);
define("PROF", 1);
define("ADMIN", 2);

use App\Model\UsersModel;

class Auth
{
    /**
     * @var Session Instance de session
     */
    private $session;
    /**
     * @var UsersModel Instance d'utilisateur
     */
    private $usersModel;

    /**
     * Auth constructor.
     * @param Session $session
     * @param UsersModel $user
     */
    public function __construct($session, $user)
    {
        $this->session = $session;
        $this->usersModel = $user;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return UsersModel
     */
    public function getUsersModel()
    {
        return $this->usersModel;
    }

    /**
     * Fonction qui connecte un utilisateur dans la session
     * @param $user_email
     */
    public function connect($user)
    {
        $admin = $this->getUsersModel()->getRole($user['email']);
        if($admin == 2)
        {
            $this->getSession()->write('prof', true);
            $this->getSession()->write('admin', false);
        }
        elseif ($admin == 3)
        {
            $this->getSession()->write('admin', true);
            $this->getSession()->write('prof', false);
        }
        else
        {
            $this->getSession()->write('prof', false);
            $this->getSession()->write('admin', false);
        }
        $this->session->write('auth', $user['email']);
        $this->session->write('id_user', $user['id_user']);
    }

    /**
     * Fonction qui déconnecte un utilisateur
     */
    public function logout()
    {
        if($this->getSession()->read('admin'))
        {
            $this->getSession()->delete('admin');
        }
        if($this->getSession()->read('prof'))
        {
            $this->getSession()->delete('prof');
        }
        $this->getSession()->delete('auth');
        $this->getSession()->delete('id_user');
    }

    /**
     * Fonction qui vérifie si l'utilisateur est connecté
     */
    public function restrict()
    {
        if(!$this->getSession()->read('auth'))
        {
            $this->getSession()->setFlash('danger', "Vous n'avez pas le droit d'accéder à cette page");
            \App::redirect("register.php");
            exit();
        }
    }

    /**
     * Fonction qui vérifie si l'utilisateur est déjà connecté
     */
    public function restrictAlreadyConnected()
    {
        if($this->getSession()->read('auth'))
        {
            \App::redirect("dashboard.php");
        }
    }

    /**
     * Retourne l'utilisateur connecte
     * @return array|bool
     */
    public function getUser()
    {
        if(!$this->getSession()->read('auth'))
        {
            return false;
        }
        $session = [
            'email' => $this->getSession()->read('auth'),
            'id_user' => $this->getSession()->read('id_user')
        ];
        return $session;
    }

    public function getRole()
    {
        if($this->getSession()->read('admin'))
        {
            return ADMIN;
        }
        elseif ($this->getSession()->read('prof'))
        {
            return PROF;
        }
        else
        {
            return USER;
        }
    }




}