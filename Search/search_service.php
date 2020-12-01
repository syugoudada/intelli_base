<?php
header('Content-type:application/json; charset=utf8');
require_once('../Repository/Search_Like.php');
require_once('../Repository/db_config.php');

$myself = new Search_Like_Repository(DB_USER,DB_PASS);
$myself->login();
$result = $myself->search($_POST['title']);
$book["id"] = array();
$book["name"] = array();
$book["price"] = array();
$book["avg"] = array();
$book["author_name"] = array();
foreach ($result as $value) {
  array_push($book["id"], $value['id']);
  array_push($book["name"], $value['name']);
  array_push($book["price"],$value['price']);
  array_push($book["avg"],$value['evaluation_avg']);
  array_push($book["author_name"],$value['author_name']);
}
echo json_encode($book, JSON_UNESCAPED_UNICODE);
// $product_id = json_encode($book_id, JSON_UNESCAPED_UNICODE);
?>
