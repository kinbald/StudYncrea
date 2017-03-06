<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 17/02/17
 * Time: 18:45
 */
?>
<section class="section">
    <div class="card-panel">
        <h3>Signalements :</h3>
        <table class="highlight">
            <thead>
            <tr>
                <th data-field="description">Raison</th>
                <th data-field="type">Type</th>
                <th data-field="about">A propos d'un(e)</th>
                <th data-field="date">Date</th>
                <th data-field="button"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($reportAll as $report) {
                ?>
                <tr>
                    <td><?= $report['reason'] ?></td>
                    <td><?= $report['type_report'] ?></td>
                    <td><?= empty($report['id_post']) ? 'commentaire' : 'publication' ?></td>
                    <td><?= $report['date_report'] ?></td>
                    <td>
                        <a href="report.php?r=<?= $report['id_report'] ?>" class="btn">Voir</a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</section>