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
                    <h5>Filtres :</h5>
                    <form>
                        <button class="right btn waves-effect waves-light" type="reset" name="action">
                            <i class="material-icons">replay</i>
                        </button>
                        <input type="checkbox" id="filled-in-box1">
                        <label for="filled-in-box1">Math</label>&emsp;&emsp;
                        <input type="checkbox" id="filled-in-box2">
                        <label for="filled-in-box2">Physique</label>&emsp;&emsp;
                        <div class="input-field col s12">
                            <select multiple>
                                <option value="" disabled selected>Classes</option>
                                <option value="1">N1</option>
                                <option value="2">N2</option>
                                <option value="3">N3</option>
                                <option value="4">M1</option>
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
    <div class="row">
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
                        <a class="blue-text" href="blog.php?post=<?= $blog['id_post']; ?>">Lire</a>
                    </div>
                </div>
            </div>
            <?php
        } ?>
    </div>
</div>
<!-- TESTS -->
<?php
// 			echo "<div class='divider'></div>";
// 			echo "<br><br>Classes CIR2:<br>";
// 			$BlogALL = $Blog->display_blog_class("CIR2");
// 			foreach ($BlogALL as $blog) {
// 				echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
// 			}
// 			echo "<div class='divider'></div>";
// 			echo "<br><br>Classes M1 et inférieures:<br>";
// $BlogALL = $Blog->display_blog_classbyid(3);//Id classe M1 = 3
// foreach ($BlogALL as $blog) {
// 	echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
// }
// echo "<div class='divider'></div>";
// echo "<br><br>Par Date du blog:<br>";
// $BlogALL = $Blog->display_blog_date_post("1997-06-03 14:30:00");
// foreach ($BlogALL as $blog) {
// 	echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
// }
// echo "<div class='divider'></div>";
// echo "<br><br>Par titre:<br>";
// $BlogALL = $Blog->display_blog_title("Comment trouver ceci ?");//Peutetre que les espaces dans le titre pose problème
// //Si c'est le cas, il faut les remplacer par des underscores
// foreach ($BlogALL as $blog) {
// 	echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
// }
// echo "<div class='divider'></div>";
// echo "<br><br>Par matière:<br>";
// $BlogALL = $Blog->display_blog_subject("Math");
// foreach ($BlogALL as $blog) {
// 	echo"<p>-".$blog['title'].", '".$blog['description']." ', ".$blog['date_post'].", ".$blog['name_class'].", ".$blog['name_subject']."<p>";
// }

//Test INSERT:
/*
$description = "Et prima post Osdroenam quam, ut dictum est, ab hac descriptione discrevimus,
                Commagena, nunc Euphratensis, clementer adsurgit, Hierapoli,
                vetere Nino et Samosata civitatibus amplis inlustris.";

$Blog->write_blog("Test INSERT",$description,"2016-11-29 10:30:00",2,1,1,1,1);
*/

//Test UPDATE:
//$Blog->update_url_file(19,"http/test");
//$Blog->update_title(19,"Test UPDATE");
//$Blog->update_description(19,"Descritpion Update");
//$Blog->update_date_correction(19,"1997-06-03 00:00:00");
//$Blog->update_subject(19,1);
    include '../Vues/footer.php';