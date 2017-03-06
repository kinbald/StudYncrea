<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 08/01/17
 * Time: 14:01
 */
?>
    <!DOCTYPE html>
    <html>
    <head>
        <!--Import Google Icon Font-->
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="icon" href="http://yncrea.fr/wp-content/uploads/2016/11/logo-yncrea-favicon.png" sizes="32x32" />

        <title><?= isset($title) ? $title : "Stud'Yncréa - Mise en commun d'annales et de corrections" ?></title>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

<body>
    <!-- NAVBAR -->
    <div class="nav">
        <nav class="teal" role="navigation">
            <div class="nav-wrapper container">
                <a id="logo-container" href="index.php" class="brand-logo right">Stud'<img src="http://yncrea.fr/wp-content/uploads/2016/11/logo-yncrea-favicon.png" class="inline responsive-img" width="22px" alt="Yncrea">ncrea</a>
                <ul id="nav" class="left hide-on-med-and-down">
                    <!-- Dropdown Structure -->
                    <ul id="dropdown1" class="dropdown-content">
                        <li><a href="dashboard.php">Mon compte</a></li>
                        <li class="divider"></li>
                        <li><a href="logout.php">Déconnexion</a></li>
                    </ul>
                    <?php
                    if (isset($_SESSION['auth'])) {
                        ?>
                        <!-- Dropdown Trigger -->
                        <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Espace Perso<i class="material-icons right">arrow_drop_down</i></a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="index.php">Accueil</a></li>
                        <?php
                    }
                    ?>
                    <li><a href="affichage_blog.php">Questions</a></li>
                    <li><a href="affichage_topic.php">Sujets</a></li>
                </ul>
                <ul class="left input-field">
                    <input id="autocomplete-input" type="search" placeholder="Recherchez" onkeyup="ajax(0)" required>
                    <label for="autocomplete-input"><i class="material-icons">search</i></label>
                    <i class="material-icons">close</i>
                </ul>

                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
        </nav>
        <ul class="side-nav" id="nav-mobile">
            <?php
            if (isset($_SESSION['auth'])) {
                $User = new \App\Model\BlogModel(App::getDb());
                $user = $User->find_user($_SESSION['auth'])[0];
                ?>
                <li>
                    <div class="userView">
                      <div class="background">
                          <img src="../public/pictures/back2.jpg">
                      </div>
                      <a href="dashboard.php"><img class="circle" src="<?= $user['url_avatar']; ?>"></a>
                      <a href="dashboard.php"><span class="white-text name"><?= $user['name_user']; ?></span></a>
                      <span class="white-text email"><?= $user['email']; ?></span></a>
                  </div>
              </li>
              <?php } ?>
            <li>
                <a href="#">
                    <input id="search" type="search" onkeyup="ajax(0)" placeholder="Recherchez">
                </a>
            </li>
            <li><a href="affichage_blog.php">Questions</a></li>
            <li><a href="affichage_topic.php">Sujets</a></li>
            <?php
            if (isset($_SESSION['auth'])) {
                ?>
                <li class="divider"></li>
                <li><a href="dashboard.php">Mon compte</a></li>
                <li><a href="logout.php">Déconnexion</a></li>
                <?php
            } else {
                ?>
                <li><a href="index.php">Accueil</a></li>
                <?php
            }
            ?>
        </ul>
    </div>
<?php
if (isset($float)) {
    ?>
    <!--  -->
    <!-- Bouton Flottant -->
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red" href="add.php?type=<?= $type === 0 ? 0 : 1 ?>">
            <i class="material-icons">mode_edit</i>
        </a>
        <!--        <ul>-->
        <!--            <li><a class="btn-floating red" href="add.php?type=--><? //= $type === 0 ? 0 : 1 ?><!--"><i-->
        <!--                            class="material-icons">library_add</i></a>-->
        <!--            </li>-->
        <!--            <li><a class="btn-floating yellow darken-1" href="affichage_blog.php#questions"><i-->
        <!--                            class="material-icons">forum</i></a></li>-->
        <!--        </ul>-->
        <!--  -->
    </div>
    <?php
}