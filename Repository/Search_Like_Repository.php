<?php
require_once('Repository.php');
class Search_Like_Repository extends Repository{

  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }

  /**
   * 検索バー
   * @param String $bookname
   */

  public function search(string $bookname){
    $sql = "SELECT pu.id,pu.name,pu.price,pu.evaluation_avg,au.name as author_name FROM product pu, author au WHERE pu.author_id = au.id and pu.name LIKE '%$bookname%'";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * 本の情報取得
   * @param array $user 本のID
   */

  public function book_find($book_id){
    $sql = "SELECT * from product WHERE id = $book_id";
    $result = parent::find($sql);
    return $result;
  }
}
