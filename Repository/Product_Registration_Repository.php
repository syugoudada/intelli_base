<?php
require_once("Repository.php");
require_once("db_config.php");
class Product_Registration_Repository extends Repository{
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }

  /**
   * 著者が登録されているか
   * @param string $author 著者
   * @return boolean 
   */
  function author_exist(string $author){
    $sql = "SELECT COUNT(*) from authors where name = '$author'";
    $result = parent::exist($sql);
    return $result;
  }

  /**
   * 著者登録
   * @param array $author[name] 著者 $author[url] 著者のホームページ
   * @return boolean 
   */
  function register_author(array $author){
    //同じ著者登録されている場合
    if($this->author_exist($author['name'])){
      $this->author_update($author);
      return true;
    }else{
      if(isset($author['name']) && $author['name'] != ""){
        if(filter_var($author['url'],FILTER_VALIDATE_URL)){
          $sql = "insert into authors(name,url,account_id) values('$author[name]','$author[url]',$author[account_id])";
        }else{  
          $sql = "INSERT into authors(name,account_id) values('$author[name]',$author[account_id])";
        }
      }else{
        return false;
      }
      var_dump($sql);
      $result = parent::save($sql);
      return $result;
    }
  }

  /**
   * 著者情報の更新
   */
  function author_update($author){
    if(filter_var($author['url'],FILTER_VALIDATE_URL)){
      $sql = "UPDATE authors set url = '$author[url]' where name = '$author[name]'";
      $result = parent::save($sql);
      return $result;
    }
  }

  /**
   * genre登録
   * @param array $genre 
   * @return bool
   */
  function register_genre($genre){
    if(isset($genre['new_genre']) && $genre['sub_genre'] == "add" && $genre['new_genre'] != ""){
      if(!$this->exits_genre($genre['new_genre'])){
        $sql = "Insert into genres(name,parent_id) values('$genre[new_genre]',$genre[genre])";
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
    $sql = "SELECT id,name from genres where id <= 25";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * サブジャンル取得
   * @param $id 親ジャンル
   * @return $result サブジャンル
   */
  function sub_genre($id){
    $sql = "SELECT id,name from genres where parent_id = $id";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * genre取得
   * @param string $genre ジャンル名
   */
 function exits_genre($genre){
   $sql = "SELECT COUNT(*) FROM genres where name = '$genre'";
   $result = parent::exist($sql);
   return $result;
 }

 /**
  * 本登録
  * @param array $book_info
  * @return boolean 
  */
 function book_save($book_info){
  if(is_numeric($book_info['price']) && !$this->find_id($book_info['title'])){
    $author_sql = "Select id from authors where name = '$book_info[name]'";
    $book['author'] = parent::find($author_sql);
    $author_id = $book['author'][0]['id'];
    //サブジャンル選択状態
    if($book_info['sub_genre'] != 'add'){
      $sql = "Insert into books(title,genre_id,author_id,description,price)values('$book_info[title]',$book_info[sub_genre],'$author_id','$book_info[description]',$book_info[price])";
    //新規ジャンル登録した
    }elseif($book_info['sub_genre'] == 'add' && $book_info['new_genre']){
      $genre_sql = "Select id from genres where name = '$book_info[new_genre]'";
      $book['genre'] = parent::find($genre_sql);
      $genre_id = $book['genre'][0]['id'];
      $sql = "Insert into books(title,genre_id,author_id,description,price) values('$book_info[title]',$genre_id,'$author_id','$book_info[description]',$book_info[price])";
    }else{
      return false;
    }
    $result = parent::save($sql);
    return $result;
  }
  return false;
 }

 /**
  * book_id取得
  * @param string $book_title
  */
 function find_id($book_title){
    $sql = "SELECT id from books where title = '$book_title'";
    $result = parent::find($sql);
    return $result;
 }

/**
 * 本の情報取得
 * @param int $id 本のID
 */

 function book_info($id){
    $sql = "SELECT title,name,evaluation_avg from book_infomation where id = $id";
    $result = parent::find($sql);
    return $result;
 }
}