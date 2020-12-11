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

  public function find(string $account_id,$input_parameters = NULL){
    $sql = "SELECT password from account where id = '$account_id'";
    $result = parent::find($sql);
    return $result;
  }

   /**
   * パスワード変更
   * @param stirng $account_id 現在の情報
   * @param string $old 前のパスワード
   * @param string $new_password
   * @return boolean 
   */

  function update(string $account_id,$old_pass,$new_pass){
    $old_password = $this->find($account_id);
    if($this->decryption($old_pass,$old_password[0]['password'])){
      $new_pass = $this->encrypt($new_pass);
      $sql = "UPDATE account SET password = '$new_pass' where id = '$account_id'";
      $result = parent::save($sql);
      return $result;
    }else{
      return false;
    }
  }
}