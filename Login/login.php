<?php
  session_start();
  require_once("../Repository/Account_Repository.php");
  header('charset=UTF-8');
  require_once('../Repository/db_config.php');
  $myself = new Account(DB_USER,DB_PASS);
  $myself-> login();
  $email = $_POST['email'];
  if($myself->exist($email)){
    if($myself->password_resach($_POST)){
      $account = $myself->find($email);
      $_SESSION["account"]["id"] = $account[0]["id"];
      $_SESSION["account"]["name"] = $account[0]['name'];
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