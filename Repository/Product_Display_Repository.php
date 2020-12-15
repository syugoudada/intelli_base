<?php
require_once("Repository.php");
class Product_Display_Repository extends Repository{

  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }

  /**
   * category同じの本を取得
   * @param string $id genre_id
   * @return array $result 本の内容
   */

  public function search(string $id){
    $sql = "SELECT book.id,book.title,book.price,book.evaluation_avg,author.name as author_name FROM books book, authors author WHERE book.author_id = author.id and book.genre_id = '$id'";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * 本詳細
   * @param $book_id 本のid
   */

  public function find($book_id, $input_parameters = NULL){
    $sql = "SELECT * from books WHERE id = $book_id";
    $result = parent::find($sql);
    return $result;
  }
}