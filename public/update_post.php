<?php
/**
 * Created by IntelliJ IDEA.
 * User: Desrumaux
 * Date: 01/02/17
 * Time: 18:54
 */
include '../Vues/header.php';

$postModel = new \App\Model\BlogModel(App::getDb());
$input = new \App\Input($_POST);
$proms = new \App\Model\PromsModel(App::getDb());
$subjects = new \App\Model\SubjectModel(App::getDb());
$chapters = new \App\Model\ChapterModel(App::getDb());
$users = new \App\Model\UsersModel(App::getDb());

$select = true;

$id_post = 2;
$post = $postModel->findBy($postModel->getIdName(), [2], 1);
$form = new \App\Form($post);

//var_dump($post);

echo "<form id=\"modification\" action=\"\" method=\"post\" class=\"container\" enctype=\"multipart/form-data\">";
$form->input('text', 'title', 'Titre');
$form->input('text', 'description', 'Description');

$req = $proms->all();
$name_class = $proms->findClassName($post['id_class']);
$form->selectInputInit('class', 'class', $req, $post['id_class'], $name_class, true);


$req = $chapters->getAll();
$name_chapter = $chapters->findChapterName($post['id_chapter']);
$form->selectInputInit('chapter', 'chapter', $req, $post['id_chapter'], $name_chapter, true);

$req = $subjects->getAll();
$name_subject = $subjects->findSubjectName($post['id_subject']);
$form->selectInputInit('subject', 'subject', $req, $post['id_subject'], $name_subject, true);


$req = $users->getTeacher();
$name_teacher = $users->findUserName($post['id_user_teacher']);
$form->selectInputInit('teacher', 'teacher', $req, $post['id_user_teacher'], $name_teacher, true);


$url_pictrue1 = $post['url_file'];
echo "<img src=\"$url_pictrue1\" alt=\"Image\" />";
$form->fileInput('url_picture2', 'Modifier la photo');

$form->input('hidden', 'id_user', '', 1); //changer la valeur de id_user
$form->input('hidden', 'type_post', '', $post['type_post']); //changer la valeur du type

$form->submit('Envoyer');
echo "</form>";


if (!empty($_POST['title'])
    && !empty($_POST['description'])
    && !empty($_POST['class'])
    && !empty($_POST['chapter'])
    && !empty($_POST['subject'])
    && !empty($_POST['teacher'])
    && !empty($_POST['id_user'])/* //probleme avec Type post
    && !empty($_POST['type_post'])*/
) {

    //Input
    $id_user = $_POST['id_user'];
    $id_class = $_POST['class'];
    $id_chapter = $_POST['chapter'];
    $id_subject = $_POST['subject'];
    $id_teacher = $_POST['teacher'];
    $type_post = $_POST['type_post'];

    $title = $_POST['title'];
    $description = $_POST['description'];

    $extension = array('jpg', 'jpeg', 'png', 'pdf');
    $extension_picture = $input->check_file('url_picture2', 1000000, $extension, 'file');
    if ($extension_picture != null) {
        unlink($url_pictrue1);
        $url_file = 'pictures/post/' . $id_post . '.' . $extension_picture;
        App::addFile('url_picture2', $url_file);
        $url_picture = $url_file;
    }
    else
    {
        $url_picture = $url_pictrue1;
    }
    $postModel->update($id_post, $title, $description, $url_picture, $type_post, $id_subject, $id_class, $id_chapter, $id_teacher);
    header("Location: index.php");
}
$_POST = null;


include "../Vues/footer.php";