<?php
include "../App/App.php";
App::load();
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
                 <img style="display: none;" id="loader" class="right responsive-img materialboxed" width="40" src="../pictures/Flip_Flop.gif"><br>
                    <h5>Filtres :</h5><br>
                    <form>
                        <a class="right btn waves-effect waves-light" href="affichage_blog.php" ><i class="material-icons">replay</i></a>
                        <input type="checkbox" id="filled-in-box1" name="check1">
                        <label for="filled-in-box1">Maths</label>&emsp;&emsp;
                        <input type="checkbox" id="filled-in-box2" name="check2">
                        <label for="filled-in-box2">Physique</label>&emsp;&emsp;
                        <div class="input-field col s12">
                            <select multiple id="ajax_select" onchange="ajax(1)">
                                <option disabled>Classes</option>
                                <option value="0">N1</option>
                                <option value="1">N2</option>
                                <option value="2">N3</option>
                                <option value="3">M1</option>
                                <option value="5">M2</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--  -->
    <!-- MAIN -->
    <div class="row" id="hide">
        <?php
        //Simulation d'affichage des blogs :
        $Blog = new \App\Model\BlogModel(App::getDb());
        $BlogALL = $Blog->display_blog_live();
        foreach ($BlogALL as $blog) {
            ?>
            <div class="col s12 m6 l6">
                <div class='card'>
                    <div class="card-content">
                        <img src="<?= $blog['url_avatar'] ?>" width="64" height="64">
                        <a class="black-text"><?= $blog['name_user'] ?></a>
                        <a class="right black-text"><?= $blog['name_subject'] ?></a><br>
                        <a class="flow-text truncate black-text" style="" href="blog.php?post=<?= $blog['id_post']; ?>"><?= $blog['title'] ?></a>
                        <br>
                        <a class="left grey-text"><?= $blog['name_class'] ?></a>
                        <a class="right grey-text"> <?= $blog['date_post'] ?></a>
                    </div>
                    <div class="card-action grey-text text-darken-4">
                        <a class="blue-text" href="blog.php?post=<?= $blog['id_post']; ?>">Voir</a>
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
<script src="js/actualise.js"></script>
<?php
include '../Vues/footer.php';