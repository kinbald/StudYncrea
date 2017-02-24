<?php
include "../App/App.php";
App::load();
if(App::getAuth()->getUser() != FALSE)
{
    App::redirect('dashboard.php');
}
include '../Vues/header.php';
$init = 1;
include '../Vues/index.php';
?>

<!-- MAIN HTML CONTENT -->

<?php
include '../Vues/footer.php';