<?php
require_once("Repository.php");
class Account extends Repository{
  
  function __construct(string $name,string $password){
    parent::__construct($name,$password);
  }
  
  /**
   * アカウント登録
   * @param string $email
   * @param string $pass
   * @param string $name  user名
   * @return boolean
   */

   public function account_save($email,$name,$pass){
    $password = $this->encrypt($pass);
    $sql = "INSERT INTO accounts(email,name,password) VALUES ('$email','$name','$password')";
    $result = parent::save($sql);
    return $result;
   }

   /**
   * アカウント情報
   * @param string $email 
   * @return array $result ユーザ情報
   */

   public function find($email,$input_parameters=NULL){
    $sql = "Select id,email,name,point from accounts where email = '$email'";
    $result = parent::find($sql);
    return $result;
   }

  /**
   * アカウント存在
   * @param string $email 
   * @return boolean 
   */

  public function exist($email,$input_parameters = NULL){
    $sql = "SELECT COUNT(*) FROM accounts where email = '$email'"; 
    $result = parent::exist($sql);
    return $result;
  }

   /**
    * パスワ-ド比較
    * @param array $user
    */

   function password_resach(array $user){
     $sql = "SELECT password from accounts where email = '$user[email]'";
     $result = parent::find($sql);
     $flag = $this->decryption($user['pass'],$result[0]['password']);
     return $flag;
   }

    /**
     * カートの配列
     * @param array $user 購入商品
     * @return boolean
     */

    public function updateCartJson(string $account_id, string $json_cart){
      $sql = "UPDATE accounts SET cart_json = '$json_cart' where id = '$account_id'";
      $result = parent::save($sql);
      return $result;
  }

  /**
     * dbのjsonデータ取得
     * 
     * @param integer $string
     * @return array json
     */
    public function find_cart(string $account_id){
      $sql = "select cart_json from accounts where id = '$account_id'";
      $result = parent::find($sql);
      return $result;
  }

}