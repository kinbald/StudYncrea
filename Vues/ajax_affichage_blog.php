<?php 
include "../App/App.php";
App::load();
$Blog = new \App\Model\BlogModel(App::getDb());

//Selon la variable reçu en POST on execute une fonction différente
if ($_POST['CAS'] == 1)//Select des matières
{
    $BlogALL = $Blog->display_blog_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],'subject');
}
if ($_POST['CAS'] == 2)//Select des promos
{
    $BlogALL = $Blog->display_blog_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],'class');
}

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
                <a class="right grey-text"><?= $blog['date_post'] ?></a>
            </div>
            <div class="card-action grey-text text-darken-4">
                <a class="blue-text" href="post.php?post=<?= $blog['id_post']; ?>">Répondre</a>
            </div>
        </div>
    </div>
    <?php
}
?>