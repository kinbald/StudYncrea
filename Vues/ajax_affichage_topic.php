<?php
include "../App/App.php";
App::load();
App::getAuth()->restrict();
$Topic = new \App\Model\TopicModel(App::getDb());
$input = new \App\Input($_POST);

if (isset($_POST['data'])) {
    $data = $input->text('data');
} else {
    $data = '';
}
$TopicALL = $Topic->display_topic_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],$_POST['id_PROF'],$_POST['id_STYLE'], $_POST['id_CHAP'],$_POST['LIMIT']);

$TopicALL = $Topic->display_topic_filtres($_POST['id_CLASSES'], $_POST['id_MATIERES'], $_POST['id_PROF'], $_POST['id_STYLE'], $_POST['id_CHAP'], $data);

foreach ($TopicALL as $topic) {
    ?>
    <div class="col s12 m6 l6">
        <div class='card'>
            <div class="card-content">
                <img src="<?= $topic['url_avatar'] ?>" width="45" height="45">
                <a class="black-text"><?= $topic['name_user'] ?></a>
                <a class="right black-text"><?= $topic['name_subject'] ?></a><br>
                <a class="flow-text truncate black-text" style=""
                   href="post.php?post=<?= $topic['id_post']; ?>"><?= $topic['title'] ?></a>
                <br>
                <?php 
                $comment = new \App\Model\CommentModel(App::getDb()); 
                $response_number = $comment->number_comment_post($topic['id_post']);
                if ($response_number['response_number'] > 1) { $text = " commentaires"; }
                else { $text = " commentaire"; }
                ?>
                <div class="left grey-text"><?= $topic['name_class'] ?></div>
                <div class="right grey-text"><?= $response_number['response_number']; echo $text."&emsp;"; ?><?= $Topic::display_date($topic['date_post']); ?></div>    
            </div>
        </div>
    </div>
    <?php
}
?>