<?php
  session_start();
  require_once("../Repository/Account_Repository.php");
  header('charset=UTF-8');
  require_once('../Repository/db_config.php');
  $myself = new Account(DB_USER,DB_PASS);
  $myself-> login();
  if($myself->exist($_POST)){
    if($myself->password_resach($_POST)){
      $_SESSION["account"]["user"] = $_POST['user'];
      $id = $myself->find($_POST);
      $_SESSION["account"]["id"] = $id[0]["id"];
      header('Location:../Top_Page/top_page.php');
    }else{
      echo "失敗";
    }
  }else{
    echo "失敗";
  }
?>