<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 20:12
     */
    include '../App/App.php';
    App::load();
    $auth = App::getAuth();
    $auth->restrict();
    include "../Vues/header.php";
    // API Free 
    require "../App/SmsFree.php";
    $sms = new \App\SmsFree();

    if ($_GET)
    {
        if (isset($_GET['comment']))
        {
            $id_comment = filter_input(INPUT_GET, 'comment');
            $Comment = new \App\Model\CommentModel(App::getDb());
            $element = $Comment->findBy('id_comment', [$id_comment], 1);
            if ($element != FALSE) 
            {
                if ($element['is_online'] == 1)
                {
                    if ($_POST)
                    {
                        $Report = new \App\Model\ReportModel(App::getDb());
                        $input = new \App\Input($_POST);

                        $input->text('reason');
                        $errors = $input->getErrors();
                        if (!isset($_POST['type_report']))
                        {
                            $errors['type'] = 'Problème dans le choix du type de signalement';
                        }
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
                        if ($_POST['type_report'] == 'radio-inaprop')
                        {
                            $type_report = 0;
                        }
                        elseif ($_POST['type_report'] == 'radio-discrim')
                        {
                            $type_report = 1;
                        }
                        elseif ($_POST['type_report'] == 'radio-spam')
                        {
                            $type_report = 2;
                        }
                        $Report->addReport($_POST['reason'], $type_report, App::getAuth()->getUser()['id_user'], null, $id_comment);
                        App::getAuth()->getSession()->setFlash('success', 'Votre signalement à bien été pris en compte');
                        
                            // ----------------------------------Envoie Notification Report SMS FREEMOBILE
                            /**
                             * Configure l'ID utilisateur (sur la facture FREEMOBILE) et la clé disponible dans
                             * le compte Free Mobile après avoir activé l'option.
                             */
                            die ("Ce 'die();' est normal il faut Remplir la CLÉ et l'ID utilisateur FREEMOBILE pour gérer l'envoi de SMS dans add_report.php ligne 206 et 73");
                            $sms->setKey("La clé générée")->setUser("Votre id Free Mobile");//--------------ICI

                            try {
                                $lienPost = 'http://localhost/StudYncrea/public/post.php?post='.$element['id_post'];
                                // envoi d'un message
                                $userPost = App::getAuth()->getUser()['email'];
                                $sms->send('Signalement de '.$userPost.' sur un commentaire du post: '. $lienPost);
                            } catch (Exception $e) {
                            // le monde n'est pas parfait, il y aura
                            // peut-être des erreurs.
                                echo "Erreur sur envoi de SMS: (".$e->getCode().") ".$e->getMessage();
                            }
                            // ----------------------------------

                            App::redirect('post.php?post=' . $element['id_post']);
                        }
                    }
                }
                else
                {
                    App::redirect('affichage_blog.php');
                }
            }
            else
            {
                App::redirect('affichage_blog.php');
            }
            $form = new \App\Form();
            ?>
            <div class="container">
                <div class="section">
                    <h1>Signaler le commentaire : </h1>
                    <div class="card-panel">
                        <form id="signaler" action="" method="post" class="col s12" enctype="multipart/form-data">
                            <?php
                            $form->textArea('reason', 'Raison du signalement', true);
                            ?>
                            <p>
                                Nature du signalement :
                            </p>
                            <p>
                                <input name="type_report" type="radio" id="radio-inaprop" value="radio-inaprop"/>
                                <label for="radio-inaprop">Langage inapproprié</label>
                            </p>
                            <p>
                                <input name="type_report" type="radio" id="radio-discrim" value="radio-discrim"/>
                                <label for="radio-discrim">Contenu offensant ou haineux</label>
                            </p>
                            <p>
                                <input name="type_report" type="radio" id="radio-spam" value="radio-spam"/>
                                <label for="radio-spam">Spam</label>
                            </p>
                            <?php
                            $form->submit('Signaler la publication');
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            include '../Vues/footer.php';
        }
        elseif (isset($_GET['post']))
        {

            $id_post = filter_input(INPUT_GET, 'post');
            if (isset($_GET['type']))
            {
                $type = filter_input(INPUT_GET, 'type');
                if ($type == 0)
                {
                    $Blog = new \App\Model\BlogModel(App::getDb());
                    $element = $Blog->findBy('id_post', [$id_post], 1);
                }
                elseif ($type == 1)
                {
                    $Topic = new \App\Model\TopicModel(App::getDb());
                    $element = $Topic->findBy('id_post', [$id_post], 1);
                }
                else
                {
                    App::redirect('post.php?post=' . $id_post);
                }
                if ($element != FALSE)
                {
                    if ($element['is_online'] == 1)
                    {
                        if ($_POST)
                        {
                            $Report = new \App\Model\ReportModel(App::getDb());
                            $input = new \App\Input($_POST);

                            $input->text('reason');
                            $errors = $input->getErrors();
                            if (!isset($_POST['type_report']))
                            {
                                $errors['type'] = 'Problème dans le choix du type de signalement';
                            }
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
                            if ($_POST['type_report'] == 'radio-inaprop')
                            {
                                $type_report = 0;
                            }
                            elseif ($_POST['type_report'] == 'radio-discrim')
                            {
                                $type_report = 1;
                            }
                            elseif ($_POST['type_report'] == 'radio-spam')
                            {
                                $type_report = 2;
                            }
                            $Report->addReport($_POST['reason'], $type_report, App::getAuth()->getUser()['id_user'], $id_post, null);

                            // ----------------------------------Envoie Notification Report SMS FREEMOBILE
                            /**
                             * Configure l'ID utilisateur (sur la facture FREEMOBILE) et la clé disponible dans
                             * le compte Free Mobile après avoir activé l'option.
                             */
                            die ("Ce 'die();' est normal il faut Remplir la CLÉ et l'ID utilisateur FREEMOBILE pour gérer l'envoi de SMS dans add_report.php ligne 206 et 73");
                            $sms->setKey("La clé générée")->setUser("Votre id Free Mobile");//--------------ICI

                            try {
                                $lienPost = 'http://localhost/StudYncrea/public/post.php?post='.$id_post;
                                // envoi d'un message
                                $userPost = App::getAuth()->getUser()['email'];
                                $sms->send('Signalement de '.$userPost.' sur le post: '. $lienPost);
                            } catch (Exception $e) {
                            // le monde n'est pas parfait, il y aura
                            // peut-être des erreurs.
                                echo "Erreur sur envoi de SMS: (".$e->getCode().") ".$e->getMessage();
                            }
                            // ----------------------------------

                            App::redirect('post.php?post=' . $id_post);
                        }

                    }
                }
                else
                {
                    App::redirect('affichage_blog.php');
                }
            }
            else
            {
                App::redirect('affichage_blog.php');
            }
            $form = new \App\Form();
            ?>
            <div class="container">
                <div class="section">
                    <h1>Signaler la publication : </h1>
                    <div class="card-panel">
                        <form id="signaler" action="" method="post" class="col s12" enctype="multipart/form-data">
                            <?php
                            $form->textArea('reason', 'Raison du signalement', true);
                            ?>
                            <p>
                                Nature du signalement :
                            </p>
                            <p>
                                <input name="type_report" type="radio" id="radio-inaprop" value="radio-inaprop"/>
                                <label for="radio-inaprop">Langage inapproprié</label>
                            </p>
                            <p>
                                <input name="type_report" type="radio" id="radio-discrim" value="radio-discrim"/>
                                <label for="radio-discrim">Contenu offensant ou haineux</label>
                            </p>
                            <p>
                                <input name="type_report" type="radio" id="radio-spam" value="radio-spam"/>
                                <label for="radio-spam">Spam</label>
                            </p>
                            <?php
                            $form->submit('Signaler la publication');
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            include '../Vues/footer.php';
        }
        else
        {
            App::redirect('post.php?post=' . $id_post);
        }
    }
    else
    {
        App::redirect('affichage_blog.php');
    }
}
else
{
    App::redirect('affichage_blog.php');
}