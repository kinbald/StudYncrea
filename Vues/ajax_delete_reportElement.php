<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 19:02
     */
    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_HOST'] == "localhost")
    {
        include "../App/App.php";
        App::load();
        App::getAuth()->restrictAdmin();
        if ($_POST && isset($_POST['type']) && isset($_POST['id_type']))
        {
            if ($_POST['token'] === App::getAuth()->getSession()->read('token'))
            {
                $users = new \App\Model\UsersModel(App::getDb());
                $Report = new \App\Model\ReportModel(App::getDb());
                $report = $Report->findBy($Report->getIdName(), [$_POST['id_report']], 1);
                
                
                if ($_POST['type'] == 'comment')
                {
                    $Comment = new \App\Model\CommentModel(App::getDb());
                    $element = $Comment->findBy($Comment->getIdName(), [$_POST['id_type']], 1);
                    // Vérification que le post appartient bien à l'utilisateur
                    $user = App::getAuth()->getUser()['id_user'];
                    if ($user == $report['id_user'] || App::getAuth()->getRole() == ADMIN)
                    {
                        if ($element != false)
                        {
                            $warn = (int)$users->getWarning($element['id_user']);
                            $warn += 1;
                            $users->setWarning($element['id_user'], $warn);
                            $Comment->deleteWithChildren($_POST['id_type']);
                            $Report->deleteReport($_POST['id_report']);
                        }
                    }
                }
                elseif ($_POST['type'] == 'post')
                {
                    
                    $Topic = new \App\Model\TopicModel(App::getDb());
                    $element = $Topic->findBy($Topic->getIdName(), [$_POST['id_type']], 1);
                    // Vérification que le post appartient bien à l'utilisateur
                    $user = App::getAuth()->getUser()['id_user'];
                    if ($user == $report['id_user'] || App::getAuth()->getRole() == ADMIN)
                    {
                        if ($element != false)
                        {
                            $warn = (int)$users->getWarning($element['id_user']);
                            $warn += 1;
                            $users->setWarning($element['id_user'], $warn);
                            $Topic->change_view($_POST['id_type'], 0);
                            $Report->deleteReport($_POST['id_report']);
                        }
                    }
                }
            }
        }
    }
    else
    {
        echo 'false';
    }