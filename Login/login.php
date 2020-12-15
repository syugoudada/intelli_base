<?php
  session_start();
  require_once("../Repository/Account_Repository.php");
  header('charset=UTF-8');
  require_once('../Repository/db_config.php');
  $myself = new Account(DB_USER,DB_PASS);
  $myself-> login();
  $user = $_POST['user_id'];
  if($myself->exist($user)){
    if($myself->password_resach($_POST)){
      $account = $myself->find($user);
      $_SESSION["account"]["id"] = $account[0]["id"];
      $_SESSION["account"]["user"] = $account[0]['user_name'];
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