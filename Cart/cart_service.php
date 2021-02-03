<?php
session_start();
require_once('../Repository/Cart_Repository.php');
require_once('../Repository/db_config.php');
$myself = new Cart_Repository(DB_USER, DB_PASS);
$myself->login();
$book_id = $_POST["id"];
if(isset($_SESSION["account"]["id"])){
  $account_id = $_SESSION["account"]["id"];
  $cart = array();
  $cart_now = $myself->find_cart($account_id);
  $cart_now = json_decode($cart_now[0]["cart_json"],true);
  foreach($cart_now as $item){
    if($item["id"] != $book_id){
      array_push($cart,array("id"=>$item["id"]));
    }
  }
  $json_cart = json_encode($cart);
  $myself->updateCartJson($account_id,$json_cart);
}else{
  foreach($_SESSION["cart"] as $key => $book){
    if($book == $book_id){
      unset($_SESSION["cart"][$key]);
    }
  }
  array_push($cart,array("message"=>"delete"));
}

echo json_encode($cart, JSON_UNESCAPED_UNICODE);