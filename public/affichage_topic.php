<?php
    include "../App/App.php";
    App::load();
    App::getAuth()->restrict();
    $Topic = new \App\Model\TopicModel(App::getDb());
    $float = 1;
// Type du post pour les boutons flottants
    $type = 1;
    $title = "Annales - Stud'Yncréa - Le site de partage de sujets et de corrections";
    include '../Vues/header.php';

    $select = 1;
?>
    <h4 class='center-align'>Sujets :</h4>
    <!-- FILTRES -->
    <div class="container">
        <div class="col s12 m12">
            <div class="card horizontal">
                <div class="card-stacked">
                    <div class="card-content">
                 <img style="display: none;" id="loader" class="right materialboxed" width="30" src="pictures/Flip_Flop.gif">
                        <h5>Filtres :</h5>
                        <form class="col s12">
                            <div class="row">
                                <div class="col s6 m6 l6">
                                    <!-- Select des styles de sujets (affichage dynamique) -->
                                    <select multiple id="ajax_select_style" onchange="ajax()">
                                        <option disabled>Type (DS...)</option>
                                        <option value="0">DS</option>
                                        <option value="1">DM</option>
                                        <option value="2">IE</option>
                                        <option value="3">TD</option>
                                    </select>
                                    <!--  -->
                                </div>
                                <div class="col s6 m6 l6">
                                    <!-- Select des classes (affichage dynamique) -->
                                    <select multiple id="ajax_select_promo" onchange="ajax()">
                                        <option disabled>Classes</option>
                                        <?php
                                            $Proms = $Topic->display_proms_all();
                                            foreach ($Proms as $Promos)
                                            {
                                                ?>
                                                <option value="<?= $Promos['id_class']; ?>"><?= $Promos['name_class']; ?></option>
                                                <?php
                                            } ?>
                                    </select>
                                    <!--  -->
                                </div>
                            </div>
                            <div id="display_filtres" style="display: none;">
                                <div class="row">
                                    <div class="col s6 m6 l6">
                                        <!-- Select des matières (affichage dynamique) -->
                                        <select multiple id="ajax_select_matiere" onchange="ajax()">
                                            <option disabled>Matières</option>
                                            <?php
                                                $Sub = $Topic->display_subjects_all();
                                                foreach ($Sub as $Subjects)
                                                {
                                                    ?>
                                                    <option value="<?= $Subjects['id_subject']; ?>"><?= $Subjects['name_subject']; ?></option>
                                                    <?php
                                                } ?>
                                        </select>
                                        <!--  -->
                                    </div>
                                    <div class="col s6 m6 l6">
                                        <!-- Select des professeurs (affichage dynamique) -->
                                        <select multiple id="ajax_select_prof" onchange="ajax()">
                                            <option disabled>Professeurs</option>
                                            <?php
                                                $Teach = $Topic->display_topic_teachers();
                                                foreach ($Teach as $Teachers)
                                                {
                                                    ?>
                                                    <option value="<?= $Teachers['id_user']; ?>"><?= $Teachers['name_user']; ?></option>
                                                    <?php
                                                } ?>
                                        </select>
                                        <!--  -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 m6 l6">
                                        <!-- Select des chapitres (affichage dynamique) -->
                                        <select multiple id="ajax_select_chap" onchange="ajax()">
                                            <option disabled>Chapitres</option>
                                            <?php
                                                $Chap = $Topic->display_topic_chapter();
                                                foreach ($Chap as $Chapter)
                                                {
                                                    ?>
                                                    <option value="<?= $Chapter['id_chapter']; ?>"><?= $Chapter['name_chapter']; ?></option>
                                                    <?php
                                                } ?>
                                        </select>
                                        <!--  -->
                                    </div>
                                </div>
                            </div>
                            <a class="left btn waves-effect waves-light" id="button_plus" onclick="display_filtres()"
                               style="display: inline;">Plus</a>
                            <a class="left btn waves-effect waves-light" id="button_moins" onclick="hide_filtres()"
                               style="display: none;">Moins</a>
                            <a class="right btn waves-effect waves-light" href="affichage_topic.php"><i
                                        class="material-icons">replay</i></a>
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
        <a class="btn waves-effect waves-light" onclick="ajax(1);">Voir Plus</a>
        <img style="display: none;" id="loader2" class="right materialboxed" width="30" src="pictures/Flip_Flop.gif">
    </div>
    <script src="js/oXHR.js"></script>
    <script src="js/filtres_topic.js"></script>
<?php
    include '../Vues/footer.php';