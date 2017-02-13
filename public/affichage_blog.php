<?php
include "../App/App.php";
App::load();
$Blog = new \App\Model\BlogModel(App::getDb());
include '../Vues/header.php';

$init = 1;
?>
<h4 class='center-align'>Questions :</h4>
<!-- FILTRES -->
<div class="container">
    <div class="col s12 m12">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                   <img style="display: none;" id="loader" class="right materialboxed" width="30" src="../pictures/Flip_Flop.gif">
                   <h5>Filtres :</h5>
                   <form class="col s12">
                       <div class="row">
                           <div class="col s6 m6 l6">
                               <!-- Select des matières (affichage dynamique) -->
                               <select multiple id="ajax_select_matiere" onchange="ajax(1)">
                                <option disabled>Matières</option>
                                <?php
                                $Sub = $Blog->display_subjects_all();
                                foreach ($Sub as $Subjects) {
                                    ?>
                                    <option value="<?= $Subjects['id_subject']; ?>"><?= $Subjects['name_subject']; ?></option>
                                    <?php
                                }?>
                            </select>
                            <!--  -->
                        </div>
                        <div class="col s6 m6 l6">
                            <!-- Select des classes (affichage dynamique) -->
                            <select multiple id="ajax_select_promo" onchange="ajax(2)">
                                <option disabled>Classes</option>
                                <?php
                                $Proms = $Blog->display_proms_all();
                                foreach ($Proms as $Promos) {
                                    ?>
                                    <option value="<?= $Promos['id_class']; ?>"><?= $Promos['name_class']; ?></option>
                                    <?php
                                }?>
                            </select>
                            <!--  -->
                        </div>
                    </div>
                    <a class="right btn waves-effect waves-light" href="affichage_blog.php" ><i class="material-icons">replay</i></a>
                </form>
            </div>
        </div>
    </div>
</div>
<!--  -->
<!-- MAIN -->
<div class="row" id="hide">
    <?php
    $Blog = new \App\Model\BlogModel(App::getDb());
    $BlogALL = $Blog->display_blog_live();
    foreach ($BlogALL as $blog) {
        ?>
        <div class="col s12 m6 l6">
            <div class='card'>
                <div class="card-content">
                    <img src="<?= $blog['url_avatar'] ?>" width="50" height="50">
                    <a class="black-text"><?= $blog['name_user'] ?></a>
                    <a class="right black-text"><?= $blog['name_subject'] ?></a><br>
                    <a class="flow-text truncate black-text" style="" href="post.php?post=<?= $blog['id_post']; ?>"><?= $blog['title'] ?></a>
                    <br>
                    <a class="left grey-text"><?= $blog['name_class'] ?></a>
                    <a class="right grey-text"> <?= $blog['date_post'] ?></a>
                </div>
                <div class="card-action grey-text text-darken-4">
                    <a class="blue-text" href="post.php?post=<?= $blog['id_post']; ?>">Répondre</a>
                </div>
            </div>
        </div>
        <?php
    } ?>
</div>
<!-- INNER AJAX-->
<div class="row" id="ajax_inner"></div>
<!--  -->
</div>
<script src="js/oXHR.js"></script>
<script src="js/filtres_blog.js"></script>
<?php
include '../Vues/footer.php';