<?php
  session_start();
  require_once("../Repository/Account_Repository.php");
  header('charset=UTF-8');
  require_once('../Repository/db_config.php');
  $myself = new Account(DB_USER,DB_PASS);
  $myself-> login();
  $user = $_POST['user'];
  if($myself->exist($user)){
    if($myself->password_resach($_POST)){
      $_SESSION["account"]["user"] = $user;
      $id = $myself->find($user);
      $_SESSION["account"]["id"] = $id[0]["id"];
      header('Location:../Top_Page/top_page.php');
    }else{
      $_SESSION['message'] = "失敗";
      print("<script>history.back();</script>");
    }
  }else{
    $_SESSION['message'] = "失敗";
    print("<script>history.back();</script>");
  }
?>