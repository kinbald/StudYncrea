<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 10:24
     */
    include '../App/App.php';
    App::load();
    $auth = App::getAuth();
    
    if ($_GET)
    {
        $token = filter_input(INPUT_GET, 't');
        $user = filter_input(INPUT_GET, 'u');
        
        if (!empty($token) && !empty($user))
        {
            $UserModel = new \App\Model\UsersModel(App::getDb());
            $user_email = $UserModel->findEmail($user);
            if ($UserModel->getRole($user_email) == -1)
            {
                if ($UserModel->getIdBy('token', 'token', [$token], 1) == $token)
                {
                    $regex1 = "#^[a-z0-9._-]+@yncrea.fr#";
                    if (preg_match($regex1, $user_email))
                    {
                        $role = 2;
                    }
                    else
                    {
                        $role = 1;
                    }
                    $UserModel->setRole($role, $user);
                    App::redirect('connect.php');
                }
            }
        }
    }
    App::redirect('index.php');