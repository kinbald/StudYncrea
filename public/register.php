<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 08/01/17
 * Time: 18:06
 */

include '../Vues/header.php';
?>
    <div class="container">
        <h1>S'inscrire :</h1>

        <?php

        /** Classe APP pour lancement */
        require '../App/App.php';
        App::load();
        $db = App::getDb();
        $auth = App::getAuth();

        $auth->restrictAlreadyConnected();

        $user = new \App\Model\UsersModel($db);
        $promsTable = new \App\Model\PromsModel($db);
        $form = new \App\Form($_POST);

        $options = $promsTable->all();
        $select = true;

        if ($_POST) {
            $datas = [
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];

            $valid = new \App\Input($datas);

            $infos = $valid->check_email('email', 'email');
            $password = $valid->text('password');
            if (!isset($_POST['prom'])) {
                $errors['classe'] = 'Vous n\'avez pas choisi de classe';
            }
            $valid->check_pseudo_password('password', 5, 'password');

            if ($valid->isValid()) {
                if ($user->checkUserExist($_POST['email'])) {
                    $errors['user'] = 'L\'utilisateur existe déjà';
                }
            } else {
                $errors = $valid->getErrors();
            }

            /** Affichage des erreurs */
            if (!empty($errors)) { ?>
                <div class="card red">
                    <div class="card-content white-text">
                        <?php foreach ($errors as $error) {
                            echo $error . "<br/>";
                        } ?>
                    </div>
                </div>
                <?php
            } else {
                $token = $user->registerUser($_POST['email'], $password, $infos['prenom'], $infos['nom'], 1, $_POST['prom']);
                if ($token !== -1) {
                    //mail("dev@local.dev", "Inscription", "http://localhost/StudYncreaV1/public/checkmail.php?t=$token" );

                    $auth->connect($_POST['email']);
                    App::redirect('affichage_blog.php');
                }
            }
        }
        ?>
        <div class="row">
            <form class="col s12" method="post">
                <div class="row">
                    <?php
                    $form->input('email', 'email', 'Votre email', true);
                    ?>
                </div>
                <div class="row">
                    <?php
                    $form->input('password', 'password', 'Votre mot de passe', true);
                    ?>
                </div>
                <div class="row">
                    <?php
                    $form->selectInput('prom', 'Votre classe', $options, true)
                    ?>
                </div>
                <div class="row">
                    <?php
                    $form->submit('Envoyer', null, 'perm_identity');
                    ?>
                </div>
            </form>
        </div>
    </div>
<?php
include '../Vues/footer.php';
