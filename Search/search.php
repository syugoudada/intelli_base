<?php
header('Content-type:application/json; charset=utf8');
require_once('../Repository/Search_Like_Repository.php');
require_once('../Repository/db_config.php');

$myself = new Search_Like_Repository(DB_USER,DB_PASS);
$myself->login();
$result = $myself->search($_POST['title']);
$book["id"] = array();
$book["title"] = array();
foreach ($result as $value) {
  array_push($book["id"], $value['id']);
  array_push($book["title"], $value['name']);
}
echo json_encode($book, JSON_UNESCAPED_UNICODE);