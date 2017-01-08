<?php

include '../Vues/header.php';
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 08/01/17
 * Time: 13:58
 */

/** Classe APP pour lancement */
require '../App/App.php';
App::load();
$db = App::getDb();

$user = new \App\Model\UsersModel($db);
$form = new \App\Form($_POST);

/** S'il y a des données postées */
if($_POST) {

    $datas = [
        'email'     => $_POST['email'],
        'password'  => $_POST['password']
    ];

    $valid = new \App\Input($datas);

    $valid->check_email('email', 'email');
    $password = $valid->text('password');

    if($valid->isValid())
    {
        /** Vérification de l'existence de l'utilisateur */
        $exist = $user->connect($_POST['email'], $password);
        if ( $exist === -1)
        {
            $errors['exist'] = "Cet utilisateur n'existe pas";
        }
        elseif ($exist === 0)
        {
            $errors['password'] = "Le couple email/mot de passe est incorrect";
        }
    }
    else
    {
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
        $role = $user->getRole($_POST['email']);
        //TODO SESSION
        //$_SESSION['user'] = $email;
        //header("Location: dashboard.php");
    }
}

?>
    <div class="container">
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
                    $form->submit('Envoyer', null, 'perm_identity');
                    ?>
                </div>
            </form>
        </div>
    </div>
<?php
include '../Vues/footer.php';