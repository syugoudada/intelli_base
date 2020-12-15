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

   public function account_save($mail,$user,$pass){
    $password = $this->encrypt($pass);
    $sql = "INSERT INTO accounts(user_id,user_name,password) VALUES ('$mail','$user','$password')";
    $result = parent::save($sql);
    return $result;
   }

   /**
   * アカウント情報
   * @param string $user_id 
   * @return array $result ユーザ情報
   */

   public function find($user_id,$input_parameters=NULL){
    $sql = "Select id,user_id,user_name,point from accounts where user_id = '$user_id'";
    $result = parent::find($sql);
    return $result;
   }

  /**
   * アカウント存在
   * @param array $user ユーザー情報
   * @return boolean 
   */

  public function exist($user,$input_parameters = NULL){
    $sql = "SELECT COUNT(*) FROM accounts where user_id = '$user'"; 
    $result = parent::exist($sql);
    return $result;
  }

   /**
    * パスワ-ド比較
    */

   function password_resach(array $user){
     $sql = "SELECT password from accounts where user_id = '$user[user_id]'";
     $result = parent::find($sql);
     $flag = $this->decryption($user['pass'],$result[0]['password']);
     return $flag;
   }
}