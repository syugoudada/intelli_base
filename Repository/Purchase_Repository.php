<?php
require_once "Repository.php";

class Purchase_Repository extends Repository{

  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }
  
  /**
   * 商品購入
   * @param string $account_id
   * @param string $book_id
   * @param string $today
   * @param string $add_point
   * @param string $use_point
   * @return boolean
   */

  public function book_purchase($account_id,$book_id,$today,$add_point,$use_point){
    $sql = "INSERT into purchase(account_id,book_id,date,add_point,use_point) values ('$account_id','$book_id','$today','$add_point','$use_point')";
    $result = parent::save($sql);
    return $result;
  }

  /**
   * 所持ポイント
   * @param $id アカウントid
   */

  public function point($id){
    $sql = "SELECT point from accounts where id = '$id'";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * 所持ポイント変更
   * @param $id アカウントid
   * @param $point ポイント
   */

  public function change_point($id,$point){
    $sql = "UPDATE set accouts point = $point where id = $id";
    $result = parent::save($sql);
    return $result;
  }
   
  /**
   * 本の情報
   * @param string $id cartの中のID
   * @return array $result 本の情報
   */

  function book_find(string $id){
    $sql = "SELECT id,title,price,name from book_infomation where id = '$id'";
    $result = parent::find($sql);
    return $result;
  }

}