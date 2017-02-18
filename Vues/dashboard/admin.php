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
        <h3>Commentaires :</h3>
        <table class="highlight">
            <thead>
            <tr>
                <th data-field="title">Titre</th>
                <th data-field="description">Description</th>
                <th data-field="date">Date</th>
                <th data-field="button">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($comments as $blog) {
                ?>
                <tr>

                    <td><?= $blog['title'] ?></td>
                    <td><?= $blog['description'] ?></td>
                    <td><?= $blog['date_post'] ?></td>
                </tr>
                <?php
            }
            ?>
</tbody>
</table>
</div>
</section>
<section class="section">
    <div class="card-panel">
        <h3>Singalements :</h3>
        <table class="highlight">
            <thead>
            <tr>
                <th data-field="title">Titre</th>
                <th data-field="description">Description</th>
                <th data-field="date">Date</th>
                <th data-field="button"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($reportAll as $report) {
                ?>
                <tr>
                    <td><?= $report['title'] ?></td>
                    <td><?= $report['description'] ?></td>
                    <td><?= $report['date_post'] ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</section>