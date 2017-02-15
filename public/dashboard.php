<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 05/02/17
 * Time: 19:15
 */
require "../App/App.php";
App::load();
$auth = App::getAuth();

$auth->restrict();
$role = $auth->getRole();

var_dump($role);
?>

<h1>Hello</h1>
<a href="logout.php">Déconnexion</a>
