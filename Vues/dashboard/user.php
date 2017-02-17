<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 17/02/17
 * Time: 16:00
 */
?>
<div class="card-panel">
    <h3>Vos posts :</h3>
    <table class="highlight">
        <thead>
        <tr>
            <th data-field="title">Titre</th>
            <th data-field="description">Description</th>
            <th data-field="date">Date</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($blogAll as $blog) {
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
