<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 18:01
     */
?>
<div class="card grey lighten-4">
    <div class="card-content">
        <div class="card-title">
            <span>Signalé par <?= $Users->findUserName($reportConcern['id_user']); ?></span>
        </div>
        <p>
        <div class="right thin"><?= App::display_date($reportConcern['date_report']) ?></div>
        <h5>Raison :</h5>
        <div class="medium"><?= $reportConcern['reason']; ?></div>
        <div class="mtop50">Signalement de type <?= $reportConcern['type_report'] ?></div>
        </p>
    </div>
</div>
<div class="card grey lighten-4">
    <div class="card-content">
        <div class="card-title">
            <span>Par <?= $Users->findUserName($comment['id_user']); ?></span>
        </div>
        <p>
        <div class="right thin"><?= App::display_date($comment['date_comment']) ?></div>
        <div class="medium"><?= $comment['content']; ?></div>
        <?php if ($comment['url_photo_comment']): ?>
            <img class="materialboxed" width="200" src="<?php echo $comment['url_photo_comment']; ?>">
        <?php endif; ?>
        </p>

        <div class="card-action right-align">
            <a id="<?= 'comment-' . $comment['id_comment'] . '-' . $reportConcern['id_report'] ?>"
               class="btn orange valid">Valider le signalement</a>
            <a id="<?= $reportConcern['id_report'] ?>" class="btn red delete">Supprimer le signalement</a>
        </div>
    </div>
</div>
