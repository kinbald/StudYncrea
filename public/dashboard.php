<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 05/02/17
 * Time: 19:15
 */
require "../App/App.php";
App::load();
$auth = App::getAuth();
$auth->restrict();
$db = App::getDb();
include '../Vues/header.php';

$role = $auth->getRole();
$user = $auth->getUser();
?>

    <div class="container">
        <div class="section">
            <br>
            <a class="btn" href="logout.php">Déconnexion</a>
        </div>
        <div class="section">
            <?php
            $blog = new \App\Model\BlogModel($db);
            $topic = new \App\Model\TopicModel($db);
            $userModel = new \App\Model\UsersModel($db);
            $user_id = $userModel->getIdBy('id_user', 'email', [$user], 1);
            switch ($role) {
                case USER:
                    $blogAll = $blog->getAllByUserId($user_id);
                    include "../Vues/dashboard/user.php";
                    break;
                case PROF:
                    include "../Vues/dashboard/prof.php";
                    break;
                case ADMIN:
                    include "../Vues/dashboard/admin.php";
                    break;
            }
            ?>
        </div>
    </div>

<?php
include "../Vues/footer.php";
