<?php
include "../App/App.php";
App::load();
App::getAuth()->restrict();
$Blog = new \App\Model\BlogModel(App::getDb());
$float = 1;
$init = 1;
// Type du post pour les boutons flottants
$type = 0;
$title = "Questions - Stud'Yncréa - Le site de partage de sujets et de corrections";
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
                             <select multiple id="ajax_select_matiere" onchange="ajax()">
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
                            <select multiple id="ajax_select_promo" onchange="ajax()">
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
<!-- INNER AJAX-->
<div class="row" id="ajax_inner"></div>
<!--  -->
</div>
<script src="js/oXHR.js"></script>
<script src="js/filtres_blog.js"></script>
<?php
include '../Vues/footer.php';