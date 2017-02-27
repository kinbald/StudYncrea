<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 18/02/17
 * Time: 17:52
 */
include '../App/App.php';
App::load();
$auth = App::getAuth();
$auth->restrict();
include "../Vues/header.php";
echo '<div class="container">';
$select = 1;
$init = 1;

if ($_GET) {
    $type_post = filter_input(INPUT_GET, 'type');
    if ($type_post == 0 || $type_post == 1) {
        $db = App::getDb();
        $Add = new \App\Model\BlogModel($db);
        $Proms = new \App\Model\PromsModel($db);
        $Chapters = new \App\Model\ChapterModel($db);
        $Subject = new \App\Model\SubjectModel($db);
        $Users = new \App\Model\UsersModel($db);

        $user_id = $Users->getIdBy($Users->getIdName(), 'email', [$auth->getUser()], 1);

        $form = new \App\Form($_POST);
        $input = new \App\Input($_POST);

        if ($_POST) {

            $id_class = $input->check_select('class', 'classe');
            $id_chapter = $input->check_select('chapter', 'chapitre');
            $id_subject = $input->check_select('subject', 'sujet');
            $id_teacher = $input->check_select('teacher', 'professeur');

            $title = $input->text('title');
            $data = $input->text('description');


            $id_post = $Add->lastInsertId('id_post');
            $id_post = $id_post === FALSE ? 1 : $id_post + 1;

            if (!isset($_FILES['url_picture2'])) {
                $extension = array('jpg', 'jpeg', 'png', 'pdf');
                $extension_picture = $input->check_file('url_picture', 1000000, $extension, 'file');
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
                $url_picture = 'pictures/post/' . $id_post . '.' . $extension_picture;
                App::addFile('url_picture', $url_picture);
                $Add->add_post($user_id, $id_class, $id_chapter, $id_subject, $id_teacher, $title, $data, $url_picture, $type_post);
                App::redirect("post.php?post=$id_post");
            }
        }
    }
    ?>

    <div class="section">
        <div class="card-panel">
            <h2>Ajouter <?= $type_post == 0 ? 'une question' : 'des annales' ?></h2>
        </div>
    </div>
    <div class="section">
        <div class="card-panel">
            <form id="modification" action="" method="post" class="col s12" enctype="multipart/form-data">

                <?php
                echo "<div class=\"row\">";
                $form->input('text', 'title', 'Titre', true);
                echo "</div>";

                echo "<div class=\"row\">";
                $form->textArea ('description', 'Description', true);
                echo "</div>";

                echo "<div class=\"row\">";
                $class = $Proms->all();
                $form->selectInput('class', 'Classe', $class, true, "col s6 m6 l6");
               
                $chapter = $Chapters->getAll();
                $form->selectInput('chapter', 'Chapitre', $chapter, true, "col s6 m6 l6");
                
                $subjects = $Subject->getAll();
                $form->selectInput('subject', 'Matière', $subjects, true, "col s6 m6 l6");
                
                $teacher = $Users->getTeacher();
                $form->selectInput('teacher', 'Professeur', $teacher, true, "col s6 m6 l6");
                echo "</div>";

                echo "<div class=\"row\">";
                $form->fileInput('url_picture', 'Ajouter la photo', true);
                echo "</div>";

                echo "<div class=\"row\">";
                $form->submit('Publier', 'right');
                echo "</div>";
                echo "</form></div></div></div>";

                include '../Vues/footer.php';
            } else {
                App::redirect("dashboard.php");
            }
        } else {
            App::redirect("dashboard.php");
        }