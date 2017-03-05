<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 05/02/17
 * Time: 19:37
 */
require "../App/App.php";
App::load();
$auth = App::getAuth();
if($auth->getUser())
{
    $auth->logout();
}
App::redirect("index.php");
