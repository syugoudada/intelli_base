<?php
require_once("Repository.php");
class Password_Change_Repository extends Repository{
  
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }

  /**
   * @param array $user ユーザーのID
   * @return array $result ユーザーパスワード
   */

  public function find($user,$input_parameters=NULL){
    $account_id = $user["account"]["id"];
    $user['sql'] = "SELECT password from account where id = '$account_id'";
    $result = parent::find($user);
    return $result;
  }

   /**
   * パスワード変更
   * @param array $user 現在の情報
   * @param string $new_password
   * @return boolean 
   */

  function update(array $user,$old,$new_password){
    $old_password = $this->find($user);
    if($this->decryption($old,$old_password[0]['password'])){
      $new_password = $this->encrypt($new_password);
      $account_id = $user["account"]["id"];
      $sql['sql'] = "UPDATE account SET password = '$new_password' where id = '$account_id'";
      $result = parent::save($sql);
      return $result;
    }else{
      return false;
    }
  }
}