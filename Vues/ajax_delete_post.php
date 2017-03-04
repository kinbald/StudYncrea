<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 27/02/17
 * Time: 19:21
 */

if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == "http://localhost/StudYncreaV1/public/dashboard.php") {
    include "../App/App.php";
    App::load();
    if($_POST) {
        if ($_POST['token'] === App::getAuth()->getSession()->read('token')) {
            $Topic = new \App\Model\TopicModel(App::getDb());
            $users = new \App\Model\UsersModel(App::getDb());
            $post = $Topic->findBy($Topic->getIdName(), [$_POST['id_post']], 1);
            // Vérification que le post appartient bien à l'utilisateur
            if (App::getAuth()->getUser() == $users->findEmail($post['id_user'])) {
                $Topic->change_view($_POST['id_post'], 0);
                echo true;
            }
            else
            {
                echo 'error';
            }
        }
    }
}
else
{
    echo false;
}