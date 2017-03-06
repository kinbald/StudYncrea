<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 18:21
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
            <span>Par <?= $Users->findUserName($post['id_user']); ?></span><br>
            <span>Titre : <?= $post['title'] ?></span>
        </div>
        <p>
        <div class="right thin"><?= App::display_date($post['date_post']) ?></div>
        <div class="medium"><?= $post['description']; ?></div>
        <div class="divider"></div>
        <?php if ($post['url_file']): ?>
            <img class="materialboxed" width="200" src="<?php echo $post['url_file']; ?>">
        <?php endif; ?>
        <?php if ($post['url_file_secondary']): ?>
            <div class="divider"></div>
            <img class="materialboxed" width="200" src="<?php echo $post['url_file_secondary']; ?>">
        <?php endif; ?>
        <?php if ($post['url_correction']): ?>
            <div class="divider"></div>
            <div class="flow-text">Correction :</div>
            <img class="materialboxed" width="200" src="<?php echo $post['url_correction']; ?>">
        <?php endif; ?>
        </p>

        <div class="card-action right-align">
            <a id="<?= 'post-' . $post['id_post'] . '-' . $reportConcern['id_report'] ?>" class="btn orange valid">Valider
                le signalement</a>
            <a id="<?= $reportConcern['id_report'] ?>" class="btn red delete">Supprimer
                le signalement</a>
        </div>
    </div>
</div>

