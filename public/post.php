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
                            <img src="<?= $post['url_avatar'] ?>" width="59" height="59">
                            <a class="black-text"><?= $post['name_user'] ?></a>
                            <a class="right black-text"><?= $post['name_subject'] ?></a><br>
                            <div class="divider"></div>
                            <a class="flow-text black-text"><?= $post['title'] ?> : </a>
                            <br>
                            <br>
                            <p><?= $post['description'] ?></p>
                            <br> 
                            <div class="row">             
                                <?php
                                if (!empty($post['url_file']))
                                {
                                    ?>
                                    <div class="divider"></div>
                                    <br>
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="col s6 m3 l2">
                                                <img class="left responsive-img materialboxed" width="150" src="<?= $post['url_file'] ?>">
                                            </div>

                                            <?php

                                            if (!empty($post['url_file_secondary']))
                                            {
                                                ?>
                                                <div class="col s6 m3 l2">
                                                    <img class="responsive-img materialboxed" width="150" src="<?= $post['url_file_secondary'] ?>">   
                                                </div>                          
                                                <?php        
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if (!empty($post['url_file']))
                                {
                                    ?>
                                    <div class="card-action">
                                        <div class="col s6 m3 l2">
                                            <a class="waves-effect waves-teal btn-flat black-text" target="_blank" href="<?= $post['url_file'] ?>"><i class="material-icons left">
                                                keyboard_arrow_left</i></a>
                                            </div>
                                            <?php

                                            if (!empty($post['url_file_secondary']))
                                            {
                                                ?>
                                                <div class="col s6 m3 l2">
                                                    <a class="waves-effect waves-teal btn-flat black-text" target="_blank" href="<?= $post['url_file_secondary'] ?>"><i class="material-icons right">keyboard_arrow_right</i></a>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
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