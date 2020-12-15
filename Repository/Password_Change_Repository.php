<?php
require_once("Repository.php");
class Password_Change_Repository extends Repository{
  
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }

  /**
   * @param array $user_id ユーザーのID
   * @return array $result ユーザーパスワード
   */

  public function find(string $user_id,$input_parameters = NULL){
    $sql = "SELECT password from accounts where id = '$user_id'";
    $result = parent::find($sql);
    return $result;
  }

   /**
   * パスワード変更
   * @param stirng $user_id 現在の情報
   * @param string $old 前のパスワード
   * @param string $new_password
   * @return boolean 
   */

  function update(string $user_id,$old_pass,$new_pass){
    $old_password = $this->find($user_id);
    if($this->decryption($old_pass,$old_password[0]['password'])){
      $new_pass = $this->encrypt($new_pass);
      $sql = "UPDATE accounts SET password = '$new_pass' where id = '$user_id'";
      $result = parent::save($sql);
      return $result;
    }else{
      return false;
    }
  }
}