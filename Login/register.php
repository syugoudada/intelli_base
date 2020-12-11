<?php
session_start();
define('Cookie_Ticket',time()+3600);
require_once('../Repository/Account_Repository.php');
require_once('../Repository/db_config.php');
$myself = new Account(DB_USER,DB_PASS);
$must_login = array('user' => $_POST['user'], 'password' => $_POST['password'], 'confirm' => $_POST['confirm']);
$myself->login();

if ($must_login['user'] != "" && $must_login['password'] != "" && $must_login['password'] == $must_login['confirm']) {
  if($myself->exist($must_login['user'])){
    $_SESSION['message'] = "既に登録されています";
    setcookie('user',$must_login['user'],Cookie_Ticket);
    header("Location:login_form.php");
  }else{
    if($myself->account_save($must_login['password'],$must_login['user'])){
      print("登録完了");
    }else{
      print("失敗");
    }
  }
} else {
  print '<script type="text/javascript">alert("正しい形式で入力してください");
    history.back();</script>';
}
