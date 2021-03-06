<?php
session_start();
require_once('../Repository/db_config.php');
require_once('../Repository/Book_Change_Repository.php');
require_once('../File/file.php');
$myself = new Book_Change_Repository(DB_USER, DB_PASS);

$author_info = ['title' => $_POST['title'], 'name' => $_POST['name'],'description'=>$_POST['description'] ,'genre' => $_POST['genre'], 'sub_genre' => $_POST['sub_genre'], 'new_genre' => $_POST['new_genre'], 'price' => $_POST['price'], 'url' => $_POST['url'], 'account_id'=>$_SESSION['account']['id'],'submit' => $_POST['submit']];

$file = ['pdf_name'=>$_FILES['pdf']['name'],'pdf_tmp'=>$_FILES['pdf']['tmp_name'],'image_name'=>$_FILES['image']['name'],'image_tmp'=>$_FILES['image']['tmp_name']];

foreach ($author_info as $key => $value) {
  $author_info[$key] = trim(htmlspecialchars($value,ENT_QUOTES,'UTF-8'));
}

if (isset($author_info['submit']) && $author_info['submit'] != '') {
  $myself->login();
  if($myself->register_author($author_info) && $myself->register_genre($author_info) && $myself->book_update($author_info)){
    $id = $myself->book_id($author_info['title']);
    if(pdf_register($id[0]['id'],$file) && image_register($id[0]['id'],$file)){
      $_SESSION['product']['message'] = "登録成功";
      //元のページに遷移
      header("Location:Register.php");
    }else{
      $_SESSION['product']['message'] = "失敗";
      //元のページに遷移
      header("Location:Register.php");
    }
  }else{
    $_SESSION['product']['message'] = "失敗";
    //元のページに遷移
    header("Location:Register.php");
  }
}
