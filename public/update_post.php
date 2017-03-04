<?php
/**
 * Created by IntelliJ IDEA.
 * User: Desrumaux
 * Date: 01/02/17
 * Time: 18:54
 */
//Classe application
include '../App/App.php';
//Chargement des classes
App::load();
//Instance de session
$auth = App::getAuth();
//Restriction utilisateur connecté
$auth->restrict();

//Identifiant du post envoyé en méthode GET
if ($_GET) {
    $db = App::getDb();
    $postModel = new \App\Model\BlogModel($db);
    $users = new \App\Model\UsersModel($db);
    $id_post = $_GET['post'];
    $post = $postModel->findBy($postModel->getIdName(), [$id_post], 1);

    // Vérification que le post appartient bien à l'utilisateur
    if ($auth->getUser()['email'] != $users->findEmail($post['id_user'])) {
        App::redirect('affichage_blog.php');
    }

    include '../Vues/header.php';

    $proms = new \App\Model\PromsModel($db);
    $subjects = new \App\Model\SubjectModel($db);
    $chapters = new \App\Model\ChapterModel($db);

    $select = true;

    $form = new \App\Form($post);
    $url_pictrue1 = $post['url_file'];

    if ($_POST) {
        $input = new \App\Input($_POST);
        //Input
        $id_class = $input->check_select('class', 'class');
        $id_chapter = $input->check_select('chapter', 'chapter');
        $id_subject = $input->check_select('subject', 'subject');
        $id_teacher = $input->check_select('teacher', 'teacher');
        $type_post = $post['type_post'];

        $title = $input->text('title');
        $description = $input->text('description');
        $extension = array('jpg', 'jpeg', 'png', 'pdf');
        if(!isset($_FILES['url_picture2']))
        {
            $extension_picture = $input->check_file('url_picture2', 1000000, $extension, 'file');
        }
        $errors = $input->getErrors();
        /** Affichage des erreurs */
        if (!empty($errors)) { ?>
            <div class="card red">
                <div class="card-content white-text">
                    <?php foreach ($errors as $error) {
                        echo $error . "<br/>";
                    } ?>
                </div>
            </div>
            <?php
        } else {
            if ($extension_picture != null) {
                unlink($url_pictrue1);
                $url_file = 'pictures/post/' . $id_post . '.' . $extension_picture;
                App::addFile('url_picture2', $url_file);
                $url_picture = $url_file;
            } else {
                $url_picture = $url_pictrue1;
            }
            $postModel->update($id_post, $title, $description, $url_picture, $type_post, $id_subject, $id_class, $id_chapter, $id_teacher);
            App::redirect("post.php?post=$id_post");
        }
    }
    ?>

    <div class="container">
    <div class="section">
        <div class="card-panel">
            <h2>Modifier la demande : <?= $post['title'] ?></h2>
        </div>
    </div>
    <div class="section">
        <div class="card-panel">
            <form id="modification" action="" method="post" class="col s12" enctype="multipart/form-data">
    <?php
    echo "<div class=\"row\">";
    $form->input('text', 'title', 'Titre', true);
    $form->textArea('description', 'Description', true);
    echo "</div>";

    echo "<div class=\"row\">";
    $req = $proms->all();
    $name_class = $proms->findClassName($post['id_class']);
    $form->selectInputInit('class', 'Classe', $req, $post['id_class'], $name_class, true, "col s6 m6 l6");

    $req = $chapters->getAll();
    $name_chapter = $chapters->findChapterName($post['id_chapter']);
    $form->selectInputInit('chapter', 'Chapitre', $req, $post['id_chapter'], $name_chapter, true, "col s6 m6 l6");

    $req = $subjects->getAll();
    $name_subject = $subjects->findSubjectName($post['id_subject']);
    $form->selectInputInit('subject', 'Matière', $req, $post['id_subject'], $name_subject, true, "col s6 m6 l6");

    $req = $users->getTeacher();
    $name_teacher = $users->findUserName($post['id_user_teacher']);
    $form->selectInputInit('teacher', 'Professeur', $req, $post['id_user_teacher'], $name_teacher, true, "col s6 m6 l6");
    echo "</div>";

    echo "<div class=\"row\">";
    echo "<img src=\"$url_pictrue1\" alt=\"Image\" />";
    $form->fileInput('url_picture2', 'Modifier la photo');
    echo "</div>";

    echo "<div class=\"row\">";
    $form->submit('Publier', 'right');
    echo "</div>";

    echo "</form></div></div></div>";

    include "../Vues/footer.php";
} else {
    // Si aucun identifant n'est envoyé à la page
    App::redirect('affichage_blog.php');
}
