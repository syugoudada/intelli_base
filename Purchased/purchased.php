<?php
session_start();
require_once("../Repository/Purchase_Repository.php");
require_once("../Repository/db_config.php");
$myself = new Purchase_Repository(DB_USER,DB_PASS);
$myself->login();
$cart = array();
for($i = 0; $i < count($_POST)-3; $i++){
  array_push($cart,$_POST["id$i"]);
}

if($_POST['submit'] != ""){
  foreach($cart as $book_id){
    $myself->book_purchase($account_id,$book_id,TODAY,$point($_POST['total']),$_POST['point']);
    $myself->change_point($account_id,$_POST['point']);
  }
}

/**
 * ポイント計算
 */

$point = function ($total){
  return round($total / 100);
};


