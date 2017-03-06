<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 05/03/17
 * Time: 12:46
 */
?>
<div class="card grey lighten-4" id="comment-<?= $comment->id_comment; ?>">
    <div class="card-content">
        <div class="card-title">
            <span>Par <?= $users->findUserName($comment->id_user); ?></span>
        </div>
        <p>
        <div class="right thin"><?= App::display_date($comment->date_comment) ?></div>
        <div class="medium"><?= $comment->content; ?></div>
        <?php if ($comment->url_photo_comment): ?>
            <img class="materialboxed" width="200" src="<?php echo $comment->url_photo_comment; ?>">
        <?php endif; ?>
        </p>

        <div class="card-action right-align">
            
            <?php if ($comment->depth <= 0): ?>
                <button class="btn green reply" data-id="<?= $comment->id_comment; ?>">Répondre</button>
            <?php endif; ?>
            <?php if ($comment->id_user == App::getAuth()->getUser()['id_user'] || App::getAuth()->getRole() == ADMIN): ?>
            <a id="<?= $comment->id_comment; ?>" class="btn red delete"><i class="material-icons">delete</i></a>
            <?php else: ?>
            <a class="btn purple"
               href="add_report.php?comment=<?= $comment->id_comment ?>"><i
                        class="material-icons">thumb_down</i></a>
            <?php endif; ?>
            <?php if (App::getAuth()->getRole() == ADMIN): ?>
                <a class="btn purple"
                   href="add_report.php?comment=<?= $comment->id_comment ?>"><i
                            class="material-icons">thumb_down</i></a>
            <?php endif; ?>
        </div>
    </div>
</div>
<div style="margin-left: 40px;">
    <?php if (isset($comment->children)): ?>
        <?php foreach ($comment->children as $comment): ?>
            <?php require('../Vues/comment.php'); ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>