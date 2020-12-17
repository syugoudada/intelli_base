<?php
require_once('Repository.php');
class Search_Like_Repository extends Repository{

  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }

  /**
   * 検索バー
   * @param String $bookname
   * @return array $result 本の情報
   */

  public function search(string $title){
    $sql = "SELECT id,title,price,evaluation_avg,name from book_infomation where title LIKE '%$title%' OR name LIKE '%$title%'";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * 本の情報取得
   * @param string $book_id 本のID
   */

  public function book_find($book_id){
    $sql = "SELECT * from books WHERE id = $book_id";
    $result = parent::find($sql);
    return $result;
  }
}
