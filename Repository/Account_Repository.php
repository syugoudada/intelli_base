<?php
require_once("Repository.php");
class Account extends Repository{
  
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }
  
  /**
   * アカウント登録
   * @param string $pass
   * @param string $user
   * @return boolean
   */

   public function account_save($pass,$user){
    $password = $this->encrypt($pass);
    $sql = "INSERT INTO account(name,password,point) VALUES ('$user','$password',0)";
    $result = parent::save($sql);
    return $result;
   }

   /**
   * アカウント情報
   * @param array $user_name 
   * @return array $result ユーザ情報
   */

   public function find($user_name,$input_parameters=NULL){
    $sql = "Select id,name,point from account where name = '$user_name'";
    $result = parent::find($sql);
    return $result;
   }

  /**
   * アカウント存在
   * @param array $user ユーザー情報
   * @return boolean 
   */

  public function exist($user_name,$input_parameters = NULL){
    $sql = "SELECT COUNT(*) FROM account where name = '$user_name'"; 
    $result = parent::exist($sql);
    return $result;
  }

   /**
    * パスワ-ド比較
    */

   function password_resach(array $user){
     $sql = "SELECT password from account where name = '$user[user]'";
     $result = parent::find($sql);
     $flag = $this->decryption($user['password'],$result[0]['password']);
     return $flag;
   }
}