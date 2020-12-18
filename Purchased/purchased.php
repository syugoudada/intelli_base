<?php
session_start();
require_once("../Repository/Purchase_Repository.php");
require_once("../Repository/db_config.php");
$myself = new Purchase_Repository(DB_USER,DB_PASS);
$myself->login();
$account_id = $_SESSION['account']['id'];
$current_point = $myself->point($account_id);
$cart = array();
for($i = 0; $i < count($_POST)-3; $i++){
  array_push($cart,$_POST["id$i"]);
}

$update_point = point_update($_POST['point'],point($_POST['total']),$current_point[0]['point']);

if($_POST['submit'] != ""){
  foreach($cart as $book_id){
    $myself->book_purchase($account_id,$book_id,TODAY,point($_POST['total']),$_POST['point']);
    $myself->change_point($account_id,$update_point);
  }
}

/**
 * ポイント計算
 */

function point($total){
  return round($total / 100);
};

/**
 * 現在のポイント計算
 * @param $use_point 使ったポイント
 * @param $add_point 追加ポイント
 * @param $current_point 現在所持しているポイント
 */

function point_update($use_point,$add_point,$current_point){
  return ($current_point - $use_point) + $add_point;
}


