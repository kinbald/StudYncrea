<?php 
include "../App/App.php";
App::load();
$Topic = new \App\Model\TopicModel(App::getDb());

//Selon la variable reçu en POST on execute une fonction différente
if ($_POST['CAS'] == 1)//Select des matières
{
    $TopicALL = $Topic->display_topic_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],$_POST['id_PROF'],$_POST['id_STYLE'],'subject');
}
if ($_POST['CAS'] == 2)//Select des promos
{
    $TopicALL = $Topic->display_topic_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],$_POST['id_PROF'],$_POST['id_STYLE'],'class');
}
if ($_POST['CAS'] == 3)//Select des prof
{
    $TopicALL = $Topic->display_topic_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],$_POST['id_PROF'],$_POST['id_STYLE'],'teach');
}
if ($_POST['CAS'] == 4)//Select du style
{
    $TopicALL = $Topic->display_topic_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],$_POST['id_PROF'],$_POST['id_STYLE'],'style');
}
//Si $TopicALL = -1 cela veut dire qu'il n'y a plus de séléction.
if ($TopicALL != -1){
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
                    <a class="right grey-text"> <?= $topic['date_post'] ?></a>
                </div>
            </div>
        </div>
        <?php
    }
} ?>