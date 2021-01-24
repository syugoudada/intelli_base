<?php
session_start();
require_once('../Repository/Password_Change_Repository.php');
require_once('../Repository/db_config.php');
$myself = new Password_Change_Repository(DB_USER,DB_PASS);
$myself->login();
$account_id = $_SESSION["account"]["id"];

if ($myself->update($account_id, $_POST['oldpass'], $_POST['newpass'],TODAY)) {
  $_SESSION["message"] = "パスワードを変更しました";
  header("Location:password_change.php");
} else {
  $_SESSION["message"] = "パスワードが違います";
  header("Location:password_change.php");
}

?>
