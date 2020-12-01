<?php
require_once "Repository.php";
date_default_timezone_set('Asia/Tokyo');

class Purchase_Repository extends Repository{

  public $value;
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }
  
  /**
   * 商品購入
   * @param array $user 購入商品
   * @return boolean
   */

  public function save(array $user,$input_parameters=NULL){
    $id = array('product_id' => $user['product_id'][0]['id'],'user_id' => $user['user_id'][0]['id']);
    $purchased_day = date("Y-m-d");
    $sql = "insert into parchase(account_id,product_id,date) values ('$id[product_id]','$id[user_id]','$purchased_day')";
    $user['sql'] = $sql;
    $result = parent::save($user);
    return $result;
   }

   /**
   * 商品ID
   * @param array $user 商品
   * @return array $result 商品ID アカウントID
   */

  public function find(array $user,$input_parameters=NULL){
    $product_sql = "select id from product where name = '$this->value'";
    $user_sql = "select id from account where name = 'user'";
    $user['sql'] = $product_sql;
    $result['product_id'] = parent::find($user);
    $user['sql'] = $user_sql;
    $result['user_id'] = parent::find($user);
    return $result;
   }

}