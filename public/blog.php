<?php
include "../App/App.php";
App::load();
include '../Vues/header.php';
$init = 1;

$get_id_post = filter_input(INPUT_GET, 'post');
if (empty($get_id_post))
{
    header('Location: affichage_blog.php');
}
else
{
    $blog = new \App\Model\BlogModel(App::getDb());
    $post = $blog->display_blog_id($get_id_post);

    if(!empty($post))
    {
        ?>
        <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <div class='card'>
                        <div class="card-content">
                            <img src="<?= $post['url_avatar'] ?>" width="64" height="64">
                            <a class="black-text"><?= $post['name_user'] ?></a>
                            <a class="right black-text"><?= $post['name_subject'] ?></a><br>
                            <div class="divider"></div>
                            <a class="flow-text black-text"><?= $post['title'] ?> : </a>
                            <br>
                            <br>
                            <p><?= $post['description'] ?></p>
                            <br>              
                            <?php
                            if (!empty($post['url_file']))
                            {
                                ?>
                                <div class="divider"></div>
                                <br>
                                <img class="responsive-img materialboxed" width="200" src="<?= $post['url_file'] ?>">
                                <button class="waves-effect waves-light btn right"><a class="white-text" target="_blank" href="<?= $post['url_file'] ?>">Ouvrir l'image</a></button>
                                <br><br>
                                <?php
                            }
                            ?>
                            <a class="left grey-text"><?= $post['name_class'] ?></a>
                            <a class="right grey-text"> <?= $post['date_post'] ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        else
        {
            header('Location: affichage_blog.php');
        }
        ?>
    </div>
    <?php
}


include '../Vues/footer.php';