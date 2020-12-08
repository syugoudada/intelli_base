<?php
require_once("Repository.php");
class Account extends Repository{
  
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }
  
  /**
   * アカウント登録
   * @param array $user 新規
   * @return boolean
   */

   public function save(array $user,$input_parameters=NULL){
    $password = $this->encrypt($user['password']);
    $sql['sql'] = "INSERT INTO account(name,password,point) VALUES ('$user[user]','$password',0)";
    $result = parent::save($sql);
    return $result;
   }

   /**
   * アカウント情報
   * @param array $user 
   * @return array $result ユーザ情報
   */

   public function find(array $user,$input_parameters=NULL){
    $sql['sql'] = "Select id,name,point from account where name = '$user[user]'";
    $result = parent::find($sql);
    return $result;
   }

  /**
   * アカウント存在
   * @param array $user ユーザー情報
   * @return boolean 
   */

  public function exist(array $user,$input_parameters = NULL){
    $sql['sql'] = "SELECT COUNT(*) FROM account where name = '$user[user]'"; 
    $result = parent::exist($sql);
    return $result;
  }

   /**
    * パスワ-ド比較
    */

   function password_resach(array $user){
     $sql['sql'] = "SELECT password from account where name = '$user[user]'";
     $result = parent::find($sql);
     $flag = $this->decryption($user['password'],$result[0]['password']);
     return $flag;
   }
}