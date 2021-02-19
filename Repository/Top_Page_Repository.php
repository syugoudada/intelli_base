<?php
require_once("db_config.php");
require_once("Repository.php");

class Top_Page_Repository extends Repository
{

  function __construct(string $name, string $password)
  {
    parent::__construct($name, $password);
  }

  /**
   * 評価の高い本取得
   * @return $result
   */
  function rank_book()
  {
    $sql = "SELECT id,title,name,price,evaluation_avg from book_infomation WHERE evaluation_avg > 3.5 LIMIT 10";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * 購入数が多い本を取得
   */

  function popular_count()
  {
    // $sql = "SELECT book_id from purchases GROUP By book_id HAVING (COUNT(*) >= 5) ORDER BY COUNT(*) DESC LIMIT 10";
    $sql = "SELECT id from books where id BETWEEN 260 AND 269";
    $result = parent::find($sql);
    return $result;
  }

  /**
   * 人気のタイトルを取得
   *@param String $id book_id
   *@return array $result 本の情報
   */

  function  popular_book()
  {
    $sql = "SELECT id,title,name,price,evaluation_avg from book_infomation where id BETWEEN 260 AND 269";
    $result = parent::find($sql);
    return $result;
  }


  /**
   * ジャンル,id取得
   * @return $result ジャンル,id
   */
  function genre()
  {
    $sql = "SELECT id,name from genres where id <= 25";
    $result = parent::find($sql);
    return $result;
  }
}
