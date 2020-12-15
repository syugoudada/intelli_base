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
    $sql = "SELECT book.id,book.title,book.price,book.evaluation_avg,author.name as author_name FROM books book, authors author WHERE book.author_id = author.id and (book.title LIKE '%$bookname%' OR author.name LIKE '%$bookname%')";
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
