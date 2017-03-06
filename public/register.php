<?php
    /**
     * Created by IntelliJ IDEA.
     * User: kinbald
     * Date: 08/01/17
     * Time: 18:06
     */

    $title = "Inscription - Stud'Yncréa - Le site de partage de sujets et de corrections";
    include '../Vues/header.php';
?>
    <div class="container">
        <div class="section">
            <h1>S'inscrire :</h1>

            <p class="flow-text">Déjà inscrit ? Accède directement au site <a href="connect.php">ici</a></p>
            <?php

                die('Ce die() est normal ! Pensez à insérer les informations SMTP de votre wamp dans /public/register.php:86');

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
                // Variable lancement initialisation script pour les select (cf footer.php)
                $select = true;

                if ($_POST)
                {
                    $datas = [
                            'email'    => $_POST['email'],
                            'password' => $_POST['password']
                    ];

                    $input = new \App\Input($datas);

                    $infos = $input->check_email('email', 'email');
                    $password = $input->text('password');
                    if (!isset($_POST['prom']))
                    {
                        $errors['classe'] = 'Vous n\'avez pas choisi de classe';
                    }
                    $input->check_pseudo_password('password', 5, 'password');

                    if ($input->isValid())
                    {
                        if ($user->checkUserExist($_POST['email']))
                        {
                            $errors['user'] = 'L\'utilisateur existe déjà';
                        }
                    }
                    else
                    {
                        $errors = $input->getErrors();
                    }

                    /** Affichage des erreurs */
                    if (!empty($errors))
                    { ?>
                        <div class="card red">
                            <div class="card-content white-text">
                                <?php foreach ($errors as $error)
                                {
                                    echo $error . "<br/>";
                                } ?>
                            </div>
                        </div>
                        <?php
                    }
                    else
                    {

                        $role = -1;
                        $token = $user->registerUser($_POST['email'], $password, $infos['prenom'], $infos['nom'], $role, $_POST['prom']);
                        if ($token !== -1)
                        {
                            $mail = new PHPMailer();

                            $mail->isSMTP();                                      // Set mailer to use SMTP
                            $mail->Host = '';       ///-----> ICI                                            // Specify main and backup SMTP servers
                            $mail->SMTPAuth = true;      ///-----> ICI                         // Enable SMTP authentication
                            $mail->Username = '';    ///-----> ICI             // SMTP username
                            $mail->Password = ''; ///-----> ICI                          // SMTP password
                            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                            $mail->Port = 465;                                    // TCP port to connect to

                            $mail->setFrom('', 'StudYncrea No-reply'); ///-----> ICI
                            $mail->addAddress($_POST['email']);
                            //$mail->addAddress($_POST['email']);     // Add a recipient
                            $mail->isHTML(true);                                  // Set email format to HTML

                            $mail->Subject = 'Valider son compte sur StudYncrea';
                            $id = $user->getIdBy('id_user', 'email', [$_POST['email']]);
                            $mail->Body = "Bienvenue sur StudYncrea <br> Validez votre email en cliquant <a href=\"http://localhost/Devlab/StudYncreaV1/public/check_email.php?u=$id&t=$token\">ici</a>";

                            if (!$mail->send())
                            {
                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                                die('ERROR');
                            }
                            else
                            {
                                echo 'Message has been sent';
                            }
                            App::redirect('connect.php');
                        }
                    }
                }
            ?>
        </div>
        <div class="section">
            <form class="col s12" method="post">
                <div class="row">
                    <?php
                        $form->input('email', 'email', 'Votre email', true);
                    ?>
                </div>
                <div class="row">
                    <?php
                        $form->input('password', 'password', 'Votre mot de passe (min 5 caractères)', true);
                    ?>
                </div>
                <div class="row">
                    <?php
                        $form->selectInput('prom', 'Votre classe', $options, true)
                    ?>
                </div>
                <div class="row">
                    <?php
                        $form->submit("S'inscrire", null, 'perm_identity');
                    ?>
                </div>
            </form>
        </div>
    </div>
<?php
    include '../Vues/footer.php';
