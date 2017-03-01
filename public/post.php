<?php
include "../App/App.php";
App::load();
App::getAuth()->restrict();
include '../Vues/header.php';
$init = 1;

$get_id_post = filter_input(INPUT_GET, 'post');
if (empty($get_id_post)) {
    App::redirect('affichage_blog.php');
} else {
    $blog = new \App\Model\BlogModel(App::getDb());
    $post = $blog->display_blog_id($get_id_post);

    if (!empty($post)) {
        ?>
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class='card'>
                        <div class="card-content">
                            <img src="<?= $post['url_avatar'] ?>" width="59" height="59">
                            <a class="black-text"><?= $post['name_user'] ?></a>
                            <a class="right black-text"><?= $post['name_subject'] ?></a><br>
                            <div class="divider"></div>
                            <a class="flow-text black-text"><?= $post['title'] ?> : </a>
                            <br>
                            <br>
                            <p><?= $post['description'] ?></p>
                            <div class="row">
                                <?php
                                if (!empty($post['url_file'])) {
                                    ?>
                                    <br>
                                    <div class="row">
                                        <div class="col s12">
                                            <?php
                                            list($dossier, $extension_file) = explode(".", $post['url_file']);

                                            if ($extension_file != "pdf") {
                                                ?>
                                                <div class="col s6 m3 l2">
                                                    <img class="left responsive-img materialboxed" width="150"
                                                    src="<?= $post['url_file'] ?>">
                                                </div>
                                                <?php
                                            }
                                            if (!empty($post['url_file_secondary'])) {
                                                list($dossier, $extension_file_secondary) = explode(".", $post['url_file_secondary']);
                                                if ($extension_file_secondary != "pdf") {
                                                    ?>
                                                    <div class="col s6 m3 l2">
                                                        <img class="responsive-img materialboxed" width="150"
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
                                if (!empty($post['url_file'])) {
                                    ?>
                                    <div class="card-action"><?php
                                        if ($extension_file != "pdf") {
                                            ?>
                                            <div class="col s7 m3 l2">
                                                <a class="waves-effect waves-teal btn-flat black-text tooltipped"
                                                data-position="top" data-delay="50" data-tooltip="Ouvrir l'image"
                                                target="_blank" href="<?= $post['url_file'] ?>"><i
                                                class="material-icons">photo_camera</i></a>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="col s6 m3 l2">
                                                <a class="waves-effect waves-teal btn-flat black-text tooltipped"
                                                data-position="top" data-delay="50" data-tooltip="Ouvrir le PDF"
                                                target="_blank" href="<?= $post['url_file'] ?>"><i
                                                class="material-icons">picture_as_pdf</i></a>
                                            </div>
                                            <?php
                                        }
                                        if (!empty($post['url_file_secondary'])) {
                                            if ($extension_file_secondary != "pdf") {
                                                ?>
                                                <div class="col s5 m3 l2">
                                                    <a class="waves-effect waves-teal btn-flat black-text tooltipped"
                                                    data-position="top" data-delay="50" data-tooltip="Ouvrir l'image"
                                                    target="_blank" href="<?= $post['url_file_secondary'] ?>"><i
                                                    class="material-icons">photo_camera</i></a>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="col s6 m3 l2">
                                                    <a class="waves-effect waves-teal btn-flat black-text tooltipped"
                                                    data-position="top" data-delay="50" data-tooltip="Ouvrir le PDF"
                                                    target="_blank" href="<?= $post['url_file_secondary'] ?>"><i
                                                    class="material-icons">picture_as_pdf</i></a>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php 
                            $comment = new \App\Model\CommentModel(App::getDb()); 
                            $response_number = $comment->number_comment_post($post['id_post']);
                            if ($response_number['response_number'] > 1) { $text = " commentaires"; }
                            else { $text = " commentaire"; }
                            ?>
                            <div class="left grey-text"><?= $post['name_class'] ?></div>
                            <div class="right grey-text"><?= $response_number['response_number']; echo $text."&emsp;"; ?><?= $blog::display_date($post['date_post']); ?></div>  
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            App::redirect('affichage_blog.php');
        }
        ?>
    </div>
    <?php
}


include '../Vues/footer.php';