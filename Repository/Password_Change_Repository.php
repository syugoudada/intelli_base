<?php
require_once("Repository.php");
class Password_Change_Repository extends Repository{
  
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }

  /**
   * @param array $user_id アカウントID
   * @return array $result アカウントパスワード
   */

  public function find(string $id,$input_parameters = NULL){
    $sql = "SELECT password from accounts where id = '$id'";
    $result = parent::find($sql);
    return $result;
  }

   /**
   * パスワード変更
   * @param stirng $id  アカウントid
   * @param string $old_pass 前のパスワード
   * @param string $new_pass
   * @return boolean 
   */

  function update(string $id,$old_pass,$new_pass,$today){
    $old_password = $this->find($id);
    if($this->decryption($old_pass,$old_password[0]['password'])){
      $new_pass = $this->encrypt($new_pass);
      $sql = "UPDATE accounts SET password = '$new_pass', password_modification_datetime = '$today' where id = '$id'";
      var_dump($sql);
      $result = parent::save($sql);
      return $result;
    }else{
      return false;
    }
  }
}