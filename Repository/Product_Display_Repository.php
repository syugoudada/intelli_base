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
    $sql = "SELECT pu.id,pu.name,pu.price,pu.evaluation_avg,au.name as author_name FROM product pu, author au WHERE pu.author_id = au.id and pu.category_id = '$id'";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * 本詳細
   * @param $user 本のid
   */

  public function find($product_id, $input_parameters = NULL){
    $sql = "SELECT * from product WHERE id = $product_id";
    $result = parent::find($sql);
    return $result;
  }
}