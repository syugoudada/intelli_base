<?php
  require_once('Repository.php');
  class Book_Change_Repository extends Repository{

    function __construct(string $name,string $password){
      parent::__construct($name,$password);
    }

    /**
     * 本の情報取得
     * @param string $title
     */

    function book_info($title){
      $sql = "SELECT id,title,price,description,name,url from book_infomation where title LIKE '$title'";
      $result = parent::find($sql);
      return $result;
    }
  }
?>