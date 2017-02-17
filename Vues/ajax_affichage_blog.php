<?php 
include "../App/App.php";
App::load();
$Blog = new \App\Model\BlogModel(App::getDb());

$BlogALL = $Blog->display_blog_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES']);

foreach ($BlogALL as $blog) {
    ?>
    <div class="col s12 m6 l6">
        <div class='card'>
            <div class="card-content">
                <img src="<?= $blog['url_avatar'] ?>" width="50" height="50">
                <a class="black-text"><?= $blog['name_user'] ?></a>
                <a class="right black-text"><?= $blog['name_subject'] ?></a><br>
                <a class="flow-text truncate black-text" style="" href="post.php?post=<?= $blog['id_post']; ?>"><?= $blog['title'] ?></a>
                <br>
                <a class="left grey-text"><?= $blog['name_class'] ?></a>
                <a class="right grey-text"><?= $Blog::display_date($blog['date_post']); ?></a>
            </div>
            <div class="card-action grey-text text-darken-4">
                <a class="blue-text" href="post.php?post=<?= $blog['id_post']; ?>">Répondre</a>
            </div>
        </div>
    </div>
    <?php
}
?>