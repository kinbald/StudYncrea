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
$title = "Mon compte - Stud'Yncréa - Le site de partage de sujets et de corrections";
include '../Vues/header.php';
$init = 1;
$role = $auth->getRole();
$user = $auth->getUser()['email'];
?>
    <div class="container">
        <div class="section center">
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
                    $annalesAll = $topic->getAllByUserId($user_id);
                    include "../Vues/dashboard/user.php";
                    break;
                case PROF:
                    include "../Vues/dashboard/prof.php";
                    break;
                case ADMIN:
                    $blogAll = $blog->display_blog_all();
                    $annalesAll = $topic->display_topic_live();
                    include "../Vues/dashboard/user.php";
                    include "../Vues/dashboard/admin.php";
                    break;
            }
            ?>
        </div>
    </div>
    <script src="js/oXHR.js"></script>
    <script type="text/javascript">

        window.onload = function (){
            var elements = document.getElementsByClassName('delete');
            for (var i = 0; i < elements.length; ++i) {
                elements[i].addEventListener('click', function (event) {
                    var toElement = event.toElement;
                    if(event.toElement.localName == "i")
                    {
                        toElement = event.toElement.parentElement;
                    }
                    id = toElement.id;
                    delete_post(id, toElement);
                }, false);
            }};

        function delete_post(id, element){
            var value_id = id.split("-").pop();

            var xhr = getXMLHttpRequest();

            xhr.onreadystatechange = function(){
                if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                    //"xhr.responseText" Permet de récupérer en text la page ou on à fait le post
                    deleteData(xhr.responseText, element);
                }
            };

            xhr.open("POST", "../Vues/ajax_delete_post.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            //On protège les variables que l'on transportes, meme en POST
            var id_post = encodeURIComponent(value_id);
            var token = encodeURIComponent('<?= App::getAuth()->getSession()->read('token'); ?>');
            xhr.send("id_post=" + id_post + "&token=" + token); //J'envoie mon tableau d'éléments en POST à ../Vues/ajax_affichage_blog.php
        }

        function deleteData(data, element)
        {
            if(data == '1')
            {
                var td = element.parentElement.parentElement;
                console.log(td);
                td.style.display = "none";
            }
        }

    </script>
<?php
include "../Vues/footer.php";
?>