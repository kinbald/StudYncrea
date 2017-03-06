<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 22:51
     */
    include '../App/App.php';
    App::load();
    $auth = App::getAuth();
    $auth->restrict();
    include "../Vues/header.php";

    $user = $auth->getUser()['id_user'];
    $UserModel = new \App\Model\UsersModel(App::getDb());
    $avatar = $UserModel->getIdBy('url_avatar', 'id_user', [$user], 1);

    if ($_POST)
    {
        $input = new \App\Input($_POST);

        $password = $input->text('password');
        if (is_uploaded_file($_FILES['url_avatar']['tmp_name']))
        {
            $extension = array('jpg', 'jpeg', 'png');
            $extension_picture = $input->check_file('url_avatar', 1000000, $extension, 'file');
        }

        if ($input->isValid())
        {
            /** Vérification de l'existence de l'utilisateur */
            $exist = $UserModel->connect($auth->getUser()['email'], $password);
            if ($exist === -1)
            {
                $errors['exist'] = "Cet utilisateur n'existe pas";
            }
            elseif ($exist === 0)
            {
                $errors['password'] = "Le mot de passe est incorrect";
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
            if ($extension_picture != false)
            {
                if ($avatar != '../avatars/default.png' && file_exists($avatar))
                {
                    unlink($avatar);
                }
                $url_picture = '../avatars/' . $user . '.' . $extension_picture;
                App::addFile('url_avatar', $url_picture);
                $UserModel->updateAvatar($user, $url_picture);
            }
            App::redirect("dashboard.php");
        }

    }
?>

    <div class="container">
        <div class="card-panel">
            <h5>Votre avatar : </h5>
            <img src="<?= $avatar ?>" alt="Avatar utilisateur">
        </div>
        <div class="card-panel">
            <h5>Changer d'avatar : </h5>
            <form id="modification" action="" method="post" class="col s12" enctype="multipart/form-data">
                <div class="row">
                    <div class="col s12 m6 l4">
                        <?php
                            $form = new \App\Form($_POST);
                            $form->fileInput('url_avatar', 'Avatar', true);
                        ?>
                    </div>
                    <div class="col s12 m6 l4">
                        <?php
                            $form->input('password', 'password', 'Mot de passe', true);
                        ?>
                    </div>
                    <?php
                        $form->submit('Mettre à jour');
                    ?>
                </div>
            </form>
        </div>
    </div>
<?php
    include "../Vues/footer.php";
    