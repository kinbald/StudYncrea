<?php 
include "../App/App.php";
App::load();
$Topic = new \App\Model\TopicModel(App::getDb());

$TopicALL = $Topic->display_topic_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],$_POST['id_PROF'],$_POST['id_STYLE']);


foreach ($TopicALL as $topic) { 
    ?>
    <div class="col s12 m6 l6">
        <div class='card'>
            <div class="card-content">
                <img src="<?= $topic['url_avatar'] ?>" width="45" height="45">
                <a class="black-text"><?= $topic['name_user'] ?></a>
                <a class="right black-text"><?= $topic['name_subject'] ?></a><br>
                <a class="flow-text truncate black-text" style="" href="post.php?post=<?= $topic['id_post']; ?>"><?= $topic['title'] ?></a>
                <br>
                <a class="left grey-text"><?= $topic['name_class'] ?></a>
                <a class="right grey-text"><?= $Topic::display_date($topic['date_post']); ?></a>
            </div>
        </div>
    </div>
    <?php
}
?>