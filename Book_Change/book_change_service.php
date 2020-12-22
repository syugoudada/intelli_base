<?php
header('Content-type:application/json; charset=utf8');
require_once("../Repository/Book_Change_Repository.php");
require_once("../Repository/db_config.php");
$myself = new Book_Change_Repository(DB_USER, DB_PASS);
$myself->login();
$title = trim(htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8'));
$result = $myself->book_info($title);
if ($result) {
  $book["id"] = array();
  $book["title"] = array();
  $book["description"] = array();
  $book["price"] = array();
  $book["url"] = array();
  $book["name"] = array();
  foreach ($result as $value) {
    $book["id"] = $value['id'];
    $book["description"] = $value['description'];
    $book["title"] = $value['title'];
    $book["price"] = $value['price'];
    $book["url"] = $value['url'];
    $book["name"] = $value['name'];
  }
  echo json_encode($book, JSON_UNESCAPED_UNICODE);
}
