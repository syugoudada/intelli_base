<?php
header('Content-type:application/json; charset=utf8');
require_once('../Repository/Search_Like_Repository.php');
require_once('../Repository/db_config.php');

$myself = new Search_Like_Repository(DB_USER,DB_PASS);
$myself->login();
$title = str_replace("\"","",$_POST['title']);
$result = $myself->search($title);
$book["id"] = array();
$book["title"] = array();
$book["price"] = array();
$book["avg"] = array();
$book["name"] = array();
foreach ($result as $value) {
  array_push($book["id"], $value['id']);
  array_push($book["title"], $value['title']);
  array_push($book["price"],$value['price']);
  array_push($book["avg"],$value['evaluation_avg']);
  array_push($book["name"],$value['name']);
}
echo json_encode($book, JSON_UNESCAPED_UNICODE);
?>
