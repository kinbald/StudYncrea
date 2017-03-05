<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 05/03/17
 * Time: 18:36
 */
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_HOST'] == "localhost") {
    include "../App/App.php";
    App::load();
    App::getAuth()->restrict();
    if ($_POST) {
        if ($_POST['token'] === App::getAuth()->getSession()->read('token')) {
            $Comment = new \App\Model\CommentModel(App::getDb());
            $users = new \App\Model\UsersModel(App::getDb());
            $com = $Comment->findBy($Comment->getIdName(), [$_POST['id_comment']], 1);
            // Vérification que le post appartient bien à l'utilisateur
            $user = App::getAuth()->getUser()['id_user'];
            if ($user == $com['id_user']) {
                $ids = $Comment->deleteWithChildren($_POST['id_comment']);
                echo json_encode($ids);
            } else {
                echo 'error';
            }
        }
    }
} else {
    echo 'false';
}