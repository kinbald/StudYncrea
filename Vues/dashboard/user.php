<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 17/02/17
 * Time: 16:00
 */
?>

<section class="section">
    <div class="card-panel">
        <h3>Vos questions :</h3>
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
            foreach ($blogAll as $blog) {
                ?>
                <tr>

                    <td><?= $blog['title'] ?></td>
                    <td><?= $blog['description'] ?></td>
                    <td><?= $blog['date_post'] ?></td>
                    <td>
                        <a href="post.php?post=<?= $blog['id_post'] ?>" class="btn">VOIR</a>
                        <a href="update_post.php?post=<?= $blog['id_post'] ?>" class="btn orange"><i class="material-icons">mode_edit</i></a>
                        <a id="post-<?= $blog['id_post'] ?>" class="btn red delete"><i class="material-icons">not_interested</i></a>
                    </td>
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
        <h3>Vos annales :</h3>
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
            foreach ($annalesAll as $annale) {
                ?>
                <tr>
                    <td><?= $annale['title'] ?></td>
                    <td><?= $annale['description'] ?></td>
                    <td><?= $annale['date_post'] ?></td>
                    <td>
                        <a href="post.php?post=<?= $annale['id_post'] ?>" class="btn">VOIR</a>
                        <a href="update_post.php?post=<?= $annale['id_post'] ?>" class="btn orange"><i class="material-icons">mode_edit</i></a>
                        <a id="topic-<?= $annale['id_post'] ?>" class="btn red delete"><i class="material-icons">not_interested</i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</section>

