<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 05/03/17
 * Time: 21:33
 */
include '../App/App.php';
App::load();
$auth = App::getAuth();
$auth->restrict();
include "../Vues/header.php";
if ($_GET) {
    $type_post = filter_input(INPUT_GET, 'type');
    $id_post = filter_input(INPUT_GET, 'post');
    if ($type_post == 1) {
        $db = App::getDb();
        $Topics = new \App\Model\TopicModel($db);

        if ($Topics->getIdBy('type_post', 'id_post', [$id_post], 1) != FALSE) {
            if (empty($Topics->getIdBy('url_correction', 'id_post', [$id_post], 1))) {
                if ($_FILES) {
                    $input = new \App\Input($_POST);

                    $extension = array('jpg', 'jpeg', 'png', 'pdf');
                    if (isset($_FILES['url_correction'])) {
                        $extension_picture = $input->check_file('url_correction', 1000000, $extension, 'file');
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
                            $url_file = 'pictures/topic/' . $id_post . '_correction.' . $extension_picture;
                            App::addFile('url_correction', $url_file);
                            $url_picture = $url_file;
                            $Topics->addCorrection($id_post, $url_picture);
                        }
                        App::redirect("post.php?post=$id_post");
                    }

                }


                $form = new \App\Form();

                ?>
                <div class="container">
                    <div class="section">
                        <h1>Ajouter une correction : </h1>
                        <div class="card-panel">
                            <form id="correction" action="" method="post" class="col s12" enctype="multipart/form-data">

                                <?php

                                $form->fileInput('url_correction', 'Correction du sujet', true);

                                $form->submit('Ajouter');

                                ?>
                            </form>
                        </div>
                    </div>
                </div>
                <?php

                include '../Vues/footer.php';
            } else {
                App::redirect("post.php?post=" . $id_post);
            }
        } else {
            App::redirect("post.php?post=" . $id_post);
        }


    } else {
        App::redirect("post.php?post=" . $id_post);
    }
}