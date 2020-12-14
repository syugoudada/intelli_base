<?php
    if(!isset($_POST)){
        print "ポストされてない";
    }

    require_once '../Repository/Review_Repository.php';
    session_start();
    $myself = new Review('root','rootpass');
    $myself->login();
    //var_dump($_SESSION);
    $myself->reviewSave($_POST);

    header('Location:../cart/test.php');
?>

