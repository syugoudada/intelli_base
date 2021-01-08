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

  // public function search(string $id){
  //   $parent_id = $this->parent_id($id);
  //   $sql = "SELECT id,title,price,evaluation_avg,name from book_infomation where genre_id = '$id' || genre_id = '$parent_id'";
  //   $result = parent::find($sql);
  //   return $result;
  // }

  public function search(string $id){
    $parent_id = $this->parent_id($id);
    $sql = "SELECT id,title,price,evaluation_avg,name from book_infomation where genre_id = '$id'";
    if($parent_id){
      foreach($parent_id as $value){
         $sql .= "|| genre_id = '$value[id]' ";
      }
    }
    $sql .= "LIMIT 20";
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

  /**
   * 親ID取得
   * @param $id 
   */

  // function parent_id($id){
  //   $sql = "SELECT id from genres where parent_id = '$id'";
  //   $result = parent::find($sql);
  //   if(!$result){
  //     return 0;
  //   }else{
  //     return $result[0]['id'];
  //   }
  // }

  function parent_id($id){
    $sql = "SELECT id from genres where parent_id = '$id'";
    $result = parent::find($sql);
    if(!$result){
      return false;
    }else{
      return $result;
    }
  }
}