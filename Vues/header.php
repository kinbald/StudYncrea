<?php
/**
 * Created by IntelliJ IDEA.
 * User: kinbald
 * Date: 08/01/17
 * Time: 14:01
 */
?>
<!DOCTYPE html>
<html>
<head>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>

<!-- NAVBAR -->
<div class="nav">
    <nav class="teal" role="navigation">
        <div class="nav-wrapper container">
            <a id="logo-container" href="index.php" class="brand-logo right">Stud'Yncrea</a>
            <ul class="left hide-on-med-and-down">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="affichage_blog.php">Questions</a></li>
                <li><a href="#!">Sujets</a></li>
            </ul>
            <ul class="left input-field">
                <input id="search" type="search" placeholder="Cherchez un sujet" required>
                <label for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </ul>

            <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <ul class="side-nav" id="nav-mobile">
        <li>
            <a href="#">
                <input id="search" type="search" placeholder="Cherchez un sujet">
            </a>
        </li>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="affichage_blog.php">Questions</a></li>
        <li><a href="#!">Sujets</a></li>
    </ul>
</div>
<!--  -->