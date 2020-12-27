<?php
require_once("../Repository/Top_Page_Repository.php");
require_once("../Repository/db_config.php");

$myself = new Top_Page_Repository(DB_USER,DB_PASS);
$myself->login();

$book["rank"] = $myself->rank_book();
$book["popular_count"] = $myself->popular_count();
$book["popular_sort"] = array();
foreach($book["popular_count"] as $value){
  array_push($book["popular_sort"],$myself->popular_book($value['book_id']));
}

echo json_encode($book, JSON_UNESCAPED_UNICODE);
