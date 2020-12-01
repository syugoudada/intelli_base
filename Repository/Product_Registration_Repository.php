<?php
require_once("Repository.php");
require_once("db_config.php");
class Product_Registration_Repository extends Repository{
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }

  /**
   * 著者が登録されているか
   * @param array $author[name] 著者
   * @return boolean 
   */

  function author_exist(array $author){
    $sql['sql'] = "SELECT COUNT(*) from author where name = '$author[name]'";
    $result = parent::exist($sql);
    return $result;
  }

  /**
   * 著者登録
   * @param array $author[name] 著者 $author[url] 著者のホームページ
   * @return boolean 
   */

  function register_author(array $author){
    if($this->author_exist($author)){
      $this->author_update($author);
      return true;
    }else{
      if(isset($author['name']) && $author['name'] != ""){
        if(filter_var($author['url'],FILTER_VALIDATE_URL)){
          $sql['sql'] = "insert into author(name,url) values('$author[name]','$author[url]')";
        }else{  
          $sql['sql'] = "INSERT into author(name) values('$author[name]')";
        }
      }else{
        return false;
      }
      $result = parent::save($sql);
      return $result;
    }
  }

  /**
   * 著者情報の更新
   */

  function author_update($author){
    if(filter_var($author['url'],FILTER_VALIDATE_URL)){
      $sql['sql'] = "UPDATE author set url = '$author[url]' where name = '$author[name]'";
      $result = parent::save($sql);
      return $result;
    }
  }

  function register_genre($genre){
    if(isset($genre['new_genre']) && $genre['sub_genre'] == "add" && $genre['new_genre'] != ""){
      if(!$this->exits_genre($genre['new_genre'])){
        $sql['sql'] = "Insert into category(name,parent_id) values('$genre[new_genre]',$genre[genre])";
        $result = parent::save($sql);
        return $result;
      }
    }elseif($genre['sub_genre'] != "" && isset($genre['sub_genre']) || $genre['genre']){
      return true;
    }
  }

  /**
   * ジャンル,id取得
   * @return $result ジャンル,id
   */

  function genre(){
    $sql['sql'] = "SELECT id,name from category where id <= 25";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * サブジャンル取得
   * @param $id 親ジャンル
   * @return $result サブジャンル
   */

  function sub_genre($id){
    $sql['sql'] = "SELECT id,name from category where parent_id = $id";
    $result = parent::find($sql);
    return $result;
  }

 function exits_genre($genre){
   $sql['sql'] = "SELECT COUNT(*) FROM category where name = '$genre'";
   $result = parent::exist($sql);
   return $result;
 }

 /**
  * 本登録
  * @param array $book_info
  * @return boolean 
  */

 function book_save($book_info){
  if(is_numeric($book_info['price']) && !$this->find_id($book_info)){
    $author['sql'] = "Select id from author where name = '$book_info[name]'";
    $book['author'] = parent::find($author);
    $author_id = $book['author'][0]['id'];
    //サブジャンル選択状態
    if($book_info['sub_genre'] != 'add'){
      $sql['sql'] = "Insert into product(author_id,name,category_id,description,price)values('$author_id','$book_info[title]',$book_info[sub_genre],'$book_info[description]',$book_info[price])";
    //新規ジャンル登録した
    }elseif($book_info['sub_genre'] == 'add'){
      $genre['sql'] = "Select id from category where name = '$book_info[new_genre]'";
      $book['genre'] = parent::find($genre);
      $genre_id = $book['genre'][0]['id'];
      $sql['sql'] = "Insert into product(author_id,name,category_id,description,price)values('$author_id','$book_info[title]',$genre_id,'$book_info[description]',$book_info[price])";
    }
    $result = parent::save($sql);
    return $result;
  }
 }

 function find_id($book_info){
    $sql['sql'] = "SELECT id from product where name = '$book_info[title]'";
    $result = parent::find($sql);
    return $result;
 }

}