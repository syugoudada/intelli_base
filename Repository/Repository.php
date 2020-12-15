<?php
interface Login_Process{
  public function login();
  public function logout();
  public function encrypt(string $password);
  public function decryption(string $password,string $hash);
}

interface IuserRepository extends Login_Process{
  public function save(string $sql);
  public function find(string $sql);
  public function exist(string $sql);
  public function delete(string $sql);
}

class Repository implements IuserRepository{
  
  private $name;
  private $password;
  private $dns;
  public  $dbh;

  function __construct(string $name,string $password){
    $this -> name = $name;
    $this -> password = $password;
    $this -> dns = "mysql:host=127.0.0.1;dbname=intelli_base_version2;dbport=3306;charset=utf8";
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
    $hash_password = password_hash($password,PASSWORD_BCRYPT);
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

  public function save(string $sql,$input_parameters = NULL){
    $stmt = $this->dbh->prepare($sql); 
    $result = $stmt->execute($input_parameters);
    return $result;
  }

  public function find(string $sql,$input_parameters = NULL){
    $stmt = $this->dbh->prepare($sql); 
    $flag = $stmt->execute($input_parameters);
    if(!$flag){
      return false;
    }
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function exist(string $sql,$input_parameters = NULL){
    $stmt = $this->dbh->prepare($sql); 
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

  public function delete(string $sql,$input_parameters=NULL){
    $stmt = $this->dbh->prepare($sql); 
    $result = $stmt->execute($input_parameters);
    return $result;
  }
}