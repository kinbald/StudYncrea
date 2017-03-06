<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 06/03/2017
     * Time: 17:42
     */
    include '../App/App.php';
    //Chargement des classes
    App::load();
    //Instance de session
    $auth = App::getAuth();
    //Restriction utilisateur connecté
    $auth->restrictAdmin();

    //Identifiant du post envoyé en méthode GET
    if ($_GET)
    {
        include '../Vues/header.php';
        echo '<div class=\'container\'>';
        $ReportScript = 1;

        $id_report = filter_input(INPUT_GET, 'r');
        $db = App::getDb();
        $Report = new \App\Model\ReportModel($db);
        $Users = new \App\Model\UsersModel($db);

        $reportConcern = $Report->getReport($id_report);

        if ($reportConcern != false)
        {


            if ($reportConcern['id_post'] != NULL)
            {
                $id_post = $reportConcern['id_post'];
                $Topic = new \App\Model\TopicModel($db);
                if ($Topic->getIdBy('type_post', 'id_post', [$id_post], 1) == 0)
                {
                    $Blog = new \App\Model\BlogModel($db);
                    $post = $Blog->findBy($Blog->getIdName(), [$id_post], 1);
                }
                else
                {
                    $post = $Topic->findBy($Topic->getIdName(), [$id_post], 1);
                }
                include '../Vues/report/post.php';

            }
            elseif ($reportConcern['id_comment'] != null)
            {
                $id_comment = $reportConcern['id_comment'];
                $Comment = new \App\Model\CommentModel($db);
                $comment = $Comment->findBy($Comment->getIdName(), [$id_comment], 1);
                include '../Vues/report/report.php';
            }
            ?>
            </div>
            <?php
            include "../Vues/footer.php";
        }
        else
        {
            App::redirect('dashboard.php');
        }
    }
    else
    {
        App::redirect('dashboard.php');
    }


