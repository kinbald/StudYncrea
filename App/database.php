<?php
    /**
     * Created by PhpStorm.
     * User: gdesrumaux
     * Date: 16/02/16
     * Time: 18:10
     */
    $dbhost = '172.17.0.2';
    $dbname = 'Stud_yncrea';
    $dbuser = 'root';
    $dbpswd = 'root';

    try{
        $db = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpswd, array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ));
    }catch(PDOException $e){
        die("Erreur de base de donnée des utilisateurs");
    }
    
