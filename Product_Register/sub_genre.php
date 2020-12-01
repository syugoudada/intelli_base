<?php
  session_start();
  require_once('../Repository/Product_Registration_Repository.php');
  require_once('../Repository/db_config.php');
  $myself = new Product_Registration_Repository(DB_USER,DB_PASS);
  $sub_id = $_POST['sub_id'];
  $myself->login();
  $result = $myself->sub_genre($sub_id);
  echo json_encode($result, JSON_UNESCAPED_UNICODE);
?>