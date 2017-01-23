<?php 
include "../App/App.php";
App::load();
$Blog = new \App\Model\BlogModel(App::getDb());

//Selon la variable reçu en POST on execute une fonction différente
if ($_POST['id_CLASSES'] == 12)
{
    $BlogALL = $Blog->display_blog_subject('maths,physique');
}
if ($_POST['id_CLASSES'] == 10)
{
    $BlogALL = $Blog->display_blog_subject('maths');
}
if ($_POST['id_CLASSES'] == 11)
{
    $BlogALL = $Blog->display_blog_subject('physique');
}
if ($_POST['id_CLASSES'] >= 0 && $_POST['id_CLASSES'] < 6)
{
    $BlogALL = $Blog->display_blog_classbyid($_POST['id_CLASSES']);
}
foreach ($BlogALL as $blog) {
    ?>
    <div class="col s12 m6 l6">
        <div class='card'>
            <div class="card-content">
                <img src="<?= $blog['url_avatar'] ?>" width="64" height="64">
                <a class="black-text"><?= $blog['name_user'] ?></a>
                <a class="right black-text"><?= $blog['name_subject'] ?></a><br>
                <a class="flow-text truncate black-text" style="" href="blog.php?post=<?= $blog['id_post']; ?>"><?= $blog['title'] ?></a>
                <br>
                <a class="left grey-text"><?= $blog['name_class'] ?></a>
                <a class="right grey-text"> <?= $blog['date_post'] ?></a>
            </div>
            <div class="card-action grey-text text-darken-4">
                <a class="blue-text" href="blog.php?post=<?= $blog['id_post']; ?>">Voir</a>
            </div>
        </div>
    </div>
    <?php
}
?>