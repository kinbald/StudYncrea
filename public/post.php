<?php
    include "../App/App.php";
    App::load();
    $auth = App::getAuth();
    $auth->restrict();
    ob_start();
    $ScriptPost = 1;
    $Scriptcomment = 1;
    include '../Vues/header.php';

    $get_id_post = filter_input(INPUT_GET, 'post');
    if (empty($get_id_post))
    {
        App::redirect('affichage_blog.php');
    }
    else
    {
        $blog = new \App\Model\BlogModel(App::getDb());
        $post = $blog->display_blog_id($get_id_post);

        if (!empty($post))
        {
            if ($post['is_online'] == '1')
            {
                ?>
                <div class="container">
                <div class="section">
                    <div class="col s12 m12 l12">
                        <div class='card'>
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s2">
                                        <img src="<?= $post['url_avatar'] ?>" width="59" height="59">
                                        <a class="black-text"><?= $post['name_user'] ?></a>
                                    </div>
                                    <div class="col s2 push-s8">
                                        <div class="right">
                                        <a class="black-text"><?= $post['name_subject'] ?></a><br>
                                        <a class="btn purple"
                                           href="add_report.php?post=<?= $post['id_post'] ?>&type=<?= $post['type_post'] ?>"><i
                                                    class="material-icons">thumb_down</i></a>
                                        <?php
                                            if ($post['type_post'] == 1 && $post['url_correction'] == null)
                                            {
                                                ?>
                                                <a class="btn pink"
                                                   href="add_correction.php?post=<?= $post['id_post'] ?>&type=1"><i
                                                            class="material-icons">add</i></a>
                                                <?php
                                            }
                                        ?>

                                        <?php
                                            if ($auth->getUser()['id_user'] == $post['id_user'] || $auth->getRole() == ADMIN || $auth->getRole() == PROF)
                                            {
                                                ?>
                                                <a class="btn orange"
                                                   href="update_post.php?post=<?= $post['id_post'] ?>"><i
                                                            class="material-icons">mode_edit</i></a>
                                                <?php
                                            }
                                            
                                        ?>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="divider"></div>
                                <a class="flow-text black-text"><?= $post['title'] ?> : </a>
                                <br>
                                <br>
                                <p><?= $post['description'] ?></p>
                                <div class="row">
                                    <?php
                                        if (!empty($post['url_file']))
                                        {
                                            ?>
                                            <br>
                                            <div class="row">
                                                <div class="col s12">
                                                    <?php
                                                        list($dossier, $extension_file) = explode(".", $post['url_file']);

                                                        if ($extension_file != "pdf")
                                                        {
                                                            ?>
                                                            <div class="col s6 m3 l2">
                                                                <img class="left responsive-img materialboxed"
                                                                     width="150"
                                                                     src="<?= $post['url_file'] ?>">
                                                            </div>
                                                            <?php
                                                        }
                                                        if (!empty($post['url_file_secondary']))
                                                        {
                                                            list($dossier, $extension_file_secondary) = explode(".", $post['url_file_secondary']);
                                                            if ($extension_file_secondary != "pdf")
                                                            {
                                                                ?>
                                                                <div class="col s6 m3 l2">
                                                                    <img class="responsive-img materialboxed"
                                                                         width="150"
                                                                         src="<?= $post['url_file_secondary'] ?>">
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        if (!empty($post['url_file']))
                                        {
                                            ?>
                                            <div class="card-action"><?php
                                                    if ($extension_file != "pdf")
                                                    {
                                                        ?>
                                                        <div class="col s7 m3 l2">
                                                            <a class="waves-effect waves-teal btn-flat black-text tooltipped"
                                                               data-position="top" data-delay="50"
                                                               data-tooltip="Ouvrir l'image"
                                                               target="_blank" href="<?= $post['url_file'] ?>"><i
                                                                        class="material-icons">photo_camera</i></a>
                                                        </div>
                                                        <?php
                                                    }
                                                    else
                                                    {
                                                        ?>
                                                        <div class="col s6 m3 l2">
                                                            <a class="waves-effect waves-teal btn-flat black-text tooltipped"
                                                               data-position="top" data-delay="50"
                                                               data-tooltip="Ouvrir le PDF"
                                                               target="_blank" href="<?= $post['url_file'] ?>"><i
                                                                        class="material-icons">picture_as_pdf</i></a>
                                                        </div>
                                                        <?php
                                                    }
                                                    if (!empty($post['url_file_secondary']))
                                                    {
                                                        if ($extension_file_secondary != "pdf")
                                                        {
                                                            ?>
                                                            <div class="col s5 m3 l2">
                                                                <a class="waves-effect waves-teal btn-flat black-text tooltipped"
                                                                   data-position="top" data-delay="50"
                                                                   data-tooltip="Ouvrir l'image"
                                                                   target="_blank"
                                                                   href="<?= $post['url_file_secondary'] ?>"><i
                                                                            class="material-icons">photo_camera</i></a>
                                                            </div>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <div class="col s6 m3 l2">
                                                                <a class="waves-effect waves-teal btn-flat black-text tooltipped"
                                                                   data-position="top" data-delay="50"
                                                                   data-tooltip="Ouvrir le PDF"
                                                                   target="_blank"
                                                                   href="<?= $post['url_file_secondary'] ?>"><i
                                                                            class="material-icons">picture_as_pdf</i></a>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </div>
                                            <?php
                                        }
                                        if (!empty($post['url_correction']))
                                        {
                                            ?>
                                            <div class="col s6 m3 l2">
                                                <a class="waves-effect white-text waves-teal btn" target="_blank"
                                                   href="<?= $post['url_correction'] ?>">Correction</a>
                                            </div>
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="left grey-text"><?= $post['name_class'] ?></div>
                                <div class="right grey-text"><?= App::display_date($post['date_post']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ($post['type_post'] == 0)
                {
                    $users = new \App\Model\UsersModel(App::getDb());
                    ?>
                    <div class="section">
                        <div class="card-panel" id="allcomments">
                            <?php
                                if ($auth->getSession()->hasFlashes())
                                {
                                    $flash = $auth->getSession()->getFlashes();
                                    foreach ($flash as $flashMessage => $message)
                                    {
                                        if ($flashMessage == 'error')
                                        {
                                            ?>
                                            <div class="red white-text card-panel"><?= $message ?></div>
                                            <?php
                                        }
                                        else if ($flashMessage == 'success')
                                        {
                                            ?>
                                            <div class="green white-text card-panel"><?= $message ?></div>
                                            <?php

                                        }
                                    }
                                }
                                $comments = new \App\Model\CommentModel(App::getDb());
                                if ($_POST)
                                {
                                    $input = new \App\Input($_POST);
                                    $comment = $input->text('comment');

                                    $id_comment = $comments->lastInsertId('id_comment');
                                    $id_comment = $id_comment === FALSE ? 1 : $id_comment + 1;
                                    $extension_picture = false;
                                    if (is_uploaded_file($_FILES['url_picture']['tmp_name']))
                                    {
                                        $extension = array('jpg', 'jpeg', 'png', 'pdf');
                                        $extension_picture = $input->check_file('url_picture', 1000000, $extension, 'file');
                                    }

                                    $errors = $input->getErrors();
                                    /** Affichage des erreurs */
                                    if (!empty($errors))
                                    { ?>
                                        <div class="card red">
                                            <div class="card-content white-text">
                                                <?php foreach ($errors as $error)
                                                {
                                                    echo $error . "<br/>";
                                                } ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    else
                                    {
                                        if ($extension_picture != false)
                                        {
                                            $path = 'pictures/comments/' . $post['id_post'] . '/';
                                            $url_picture = $path . $id_comment . '.' . $extension_picture;
                                            if (!file_exists($path))
                                            {
                                                mkdir($path, 0777, true);
                                            }
                                            App::addFile('url_picture', $url_picture);
                                        }
                                        else
                                        {
                                            $url_picture = null;
                                        }
                                        $id_user = $auth->getUser()['id_user'];
                                        if (!empty($_POST['id_comment_father']))
                                        {
                                            $id_comment_father = $_POST['id_comment_father'];
                                        }
                                        else
                                        {
                                            $id_comment_father = null;
                                        }
                                        $control = $comments->add_comment_bdd($post['id_post'], 0, $id_user, $url_picture, $comment, $id_comment, $id_comment_father);
                                        if ($control == 0)
                                        {
                                            $auth->getSession()->setFlash('success', 'Votre commentaire a bien été envoyé');
                                        }
                                        else
                                        {
                                            $auth->getSession()->setFlash('error', 'Vous ne pouvez pas répondre à ce commentaire');
                                        }
                                    }
                                    App::redirect('post.php?post=' . $post['id_post']);
                                }

                                foreach ($comments->findAllWithChildren($post['id_post']) as $comment)
                                {
                                    require('../Vues/comment.php');

                                    ?>
                                    <?php
                                }
                                $form = new \App\Form();
                            ?>
                            <div id="comments" class="card-panel grey lighten-4">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <h5>Répondre à la question :</h5>
                                    <input type="hidden" id="id_comment_father" name="id_comment_father" value="">
                                    <?php
                                        $form->textArea('comment', 'Votre commentaire', true);

                                        $form->fileInput('url_picture', 'Un document pour votre réponse');

                                        $form->submit('Répondre', 'green');
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            else
            {
                App::redirect('affichage_blog.php');
            }
        }
        else
        {
            App::redirect('affichage_blog.php');
        }
        ?>
        </div>
        <?php
    }
    include '../Vues/footer.php';