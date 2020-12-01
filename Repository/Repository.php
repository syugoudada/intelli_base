<?php
interface Login_Process{
  public function login();
  public function logout();
  public function encrypt(string $password);
  public function decryption(string $password,string $hash);
}

interface IuserRepository extends Login_Process{
  public function save(array $user);
  public function find(array $user);
  public function exist(array $user);
  public function delete(array $user);
}

class Repository implements IuserRepository{
  
  private $name;
  private $password;
  private $dns;
  public  $dbh;

  function __construct(string $name,string $password){
    $this -> name = $name;
    $this -> password = $password;
    $this -> dns = "mysql:host=127.0.0.1;dbname=intelli_base;dbport=3306;charset=utf8";
  }

  public function login(){
    try{
      $this->dbh = new PDO($this->dns, $this ->name, $this ->password);
    }catch (PDOException $e) {
      // echo "接続失敗: " . $e->getMessage() . "\n";
      exit();
    }
  }

  public function logout(){
    $this-> dbh = null;
      echo "データベースを閉じます";
  }

  /**
   * パスワードハッシュ化
   */
  
  public function encrypt(string $password){
    $hash_password = password_hash($password,PASSWORD_DEFAULT);
    return $hash_password;
  }

  /**
   * パスワード認証
   * @return boolean
   */

  public function decryption(string $password,string $hash){
    $verity_password = password_verify($password,$hash);
    return $verity_password;
  }

  public function save(array $user,$input_parameters = NULL){
    $stmt = $this->dbh->prepare($user['sql']); 
    $result = $stmt->execute($input_parameters);
    return $result;
  }

  public function find(array $user,$input_parameters = NULL){
    $stmt = $this->dbh->prepare($user['sql']); 
    $flag = $stmt->execute($input_parameters);
    if(!$flag){
      return false;
    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function exist(array $user,$input_parameters = NULL){
    $stmt = $this->dbh->prepare($user['sql']); 
    $flag = $stmt->execute($input_parameters);
    if(!$flag){
      return false;
    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if($result[0]["COUNT(*)"] == 1){
      return true;
    }else{
      return false;
    }
  }   

  public function delete(array $user,$input_parameters=NULL){
    $stmt = $this->dbh->prepare($user['sql']); 
    $result = $stmt->execute($input_parameters);
    return $result;
  }
}