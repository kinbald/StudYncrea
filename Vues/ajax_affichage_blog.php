<?php
include "../App/App.php";
App::load();
App::getAuth()->restrict();
$Blog = new \App\Model\BlogModel(App::getDb());
$input = new \App\Input($_POST);

if(isset($_POST['data'])){
    $data = $input->text('data');
}else{
    $data = '';
}
$BlogALL = $Blog->display_blog_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],$_POST['LIMIT']);
$BlogALL = $Blog->display_blog_filtres($_POST['id_CLASSES'],$_POST['id_MATIERES'],$data);


foreach ($BlogALL as $blog) {
    ?>
    <div class="col s12 m6 l6">
        <div class='card'>
            <div class="card-content">
                <img src="<?= $blog['url_avatar'] ?>" width="50" height="50">
                <a class="black-text"><?= $blog['name_user'] ?></a>
                <a class="right black-text"><?= $blog['name_subject'] ?></a><br>
                <a class="flow-text truncate black-text" style=""
                   href="post.php?post=<?= $blog['id_post']; ?>"><?= $blog['title'] ?></a>
                <br>
                <?php 
                $comment = new \App\Model\CommentModel(App::getDb()); 
                $response_number = $comment->number_comment_post($blog['id_post']);
                if ($response_number['response_number'] > 1) { $text = " commentaires"; }
                else { $text = " commentaire"; }
                ?>
                <div class="left grey-text"><?= $blog['name_class'] ?></div>
                <div class="right grey-text"><?= $response_number['response_number']; echo $text."&emsp;"; ?><?= $Blog::display_date($blog['date_post']); ?></div>  
            </div>
            <div class="card-action grey-text text-darken-4">
                <a class="blue-text" href="post.php?post=<?= $blog['id_post']; ?>">Répondre</a>
            </div>
        </div>
    </div>
    <?php
}
?>