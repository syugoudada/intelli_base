<?php
session_start();
require_once("../Repository/Purchase_Repository.php");
require_once("../Repository/db_config.php");
$myself = new Purchase_Repository(DB_USER,DB_PASS);
$myself->login();
$account_id = $_SESSION['account']['id'];
$current_point = $myself->point($account_id);
$purchase_cart = array();
$cart = array();
$keyArray = array();
$flag = true;

foreach($_POST as $key=>$value){
  array_push($keyArray,$key);
}
array_pop($keyArray);
array_pop($keyArray);
array_shift($keyArray);

foreach($keyArray as $key){
  array_push($purchase_cart,$_POST[$key]);
}

$update_point = point_update($_POST['point'],point($_POST['total']),$current_point[0]['point']);

if($_POST['submit'] != ""){
  foreach($purchase_cart as $book_id){
    $myself->book_purchase($account_id,$book_id,TODAY,point($_POST['total']),$_POST['point']);
  }
  $_SESSION["account"]["purchased"] = $purchase_cart;
  if($myself->change_point($account_id,$update_point)){
    //cart更新
    $cart_now = $myself->find_cart($account_id);
    $cart_now = json_decode($cart_now[0]["cart_json"],true);
    foreach($cart_now as $items){
      foreach($purchase_cart as $value){
        if($items["id"] == $value){
          $flag = false;
        }
      }
      if($flag){
        array_push($cart,array("id"=>$items["id"]));
      }
      $flag = true;
    }
    
    if(empty($cart)){
      $json_cart = json_encode($cart,true);
      $json_cart = str_replace($json_cart,"[]","{}");
    }else{
      $json_cart = json_encode($cart,true);
    }
    $myself->updateCartJson($account_id,$json_cart);
    header('Location:purchased_result.php');
  };
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


