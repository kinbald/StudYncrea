<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 18:43
     */
    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_HOST'] == "localhost")
    {
        include "../App/App.php";
        App::load();
        App::getAuth()->restrictAdmin();
        if ($_POST)
        {
            if ($_POST['token'] === App::getAuth()->getSession()->read('token'))
            {
                $users = new \App\Model\UsersModel(App::getDb());
                $Report = new \App\Model\ReportModel(App::getDb());
                $report = $Report->findBy($Report->getIdName(), [$_POST['id_report']], 1);
                
                // Vérification que le post appartient bien à l'utilisateur
                $user = App::getAuth()->getUser()['id_user'];
                if ($user == $report['id_user'] || App::getAuth()->getRole() == ADMIN)
                {
                    $Report->deleteReport($_POST['id_report']);
                }
            }
        }
    }
    else
    {
        echo 'false';
    }