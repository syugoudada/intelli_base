<?php
  session_start();
  require_once("../Repository/Account_Repository.php");
  header('charset=UTF-8');
  require_once('../Repository/db_config.php');
  $myself = new Account(DB_USER,DB_PASS);
  $_SESSION["user"] = $_POST['user'];
  $myself-> login();
  if($myself->exist($_POST)){
    if($myself->password_resach($_POST)){
      header('Location:index.php');
    }else{
      echo "失敗";
    }
  }else{
    echo "失敗";
  }
?>