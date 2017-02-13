<?php
include "../App/App.php";
App::load();
$Topic = new \App\Model\TopicModel(App::getDb());
include '../Vues/header.php';

$init = 1;
?>
<h4 class='center-align'>Sujets :</h4>
<!-- FILTRES -->
<div class="container">
    <div class="col s12 m12">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                   <img style="display: none;" id="loader" class="right materialboxed" width="30" src="../pictures/Flip_Flop.gif">
                   <h5>Filtres :</h5>
                   <form>
                       <!-- Select des styles de sujets (affichage dynamique) -->
                       <select multiple id="ajax_select_style" onchange="ajax(4)">
                        <option disabled>Type de sujet</option>
                        <option value="0">DS</option>
                        <option value="1">DM</option>
                        <option value="2">IE</option>
                        <option value="3">TD</option>
                    </select>
                    <!--  -->
                    <!-- Select des classes (affichage dynamique) -->
                    <select multiple id="ajax_select_promo" onchange="ajax(2)">
                        <option disabled>Classes</option>
                        <?php
                        $Proms = $Topic->display_proms_all();
                        foreach ($Proms as $Promos) {
                            ?>
                            <option value="<?= $Promos['id_class']; ?>"><?= $Promos['name_class']; ?></option>
                            <?php
                        }?>
                    </select>
                    <!--  -->
                    <!-- Select des matières (affichage dynamique) -->
                    <select multiple id="ajax_select_matiere" onchange="ajax(1)">
                        <option disabled>Matières</option>
                        <?php
                        $Sub = $Topic->display_subjects_all();
                        foreach ($Sub as $Subjects) {
                            ?>
                            <option value="<?= $Subjects['id_subject']; ?>"><?= $Subjects['name_subject']; ?></option>
                            <?php
                        }?>
                    </select>
                    <!--  -->
                    <!-- Select des professeurs (affichage dynamique) -->
                    <select multiple id="ajax_select_prof" onchange="ajax(3)">
                        <option disabled>Professeurs</option>
                        <?php
                        $Teach = $Topic->display_topic_teachers();
                        foreach ($Teach as $Teachers) {
                            ?>
                            <option value="<?= $Teachers['id_user']; ?>"><?= $Teachers['name_user']; ?></option>
                            <?php
                        }?>
                    </select>
                    <!--  -->
                    <a class="right btn waves-effect waves-light" href="affichage_topic.php" ><i class="material-icons">replay</i></a>
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
<script src="js/filtres_topic.js"></script>
<?php
include '../Vues/footer.php';