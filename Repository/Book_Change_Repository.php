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

    /**
     * 登録ジャンルを取得
     * @param string $title
     * @return array $genre
     */

    function book_genre($title){
      $sql = "SELECT genres.name,genres.parent_id FROM genres,books WHERE genres.id = books.genre_id AND books.title LIKE '$title'";
      $sub_genre = parent::find($sql);
      $sql = "SELECT genres.name FROM genres WHERE id = ".$sub_genre[0]['parent_id'];
      $parent_genre = parent::find($sql);
      $genre = ["sub_genre"=>$sub_genre[0]['name'],"genre"=>$parent_genre[0]['name']];
      return $genre;
    }


  /**
   * 著者が登録されているか
   * @param string $author 著者
   * @return boolean 
   */
  function author_exist(string $author){
    $sql = "SELECT COUNT(*) from authors where name = '$author'";
    $result = parent::exist($sql);
    return $result;
  }

  /**
   * 著者追加
   * @param array $author[name] 著者 $author[url] 著者のホームページ
   * @return boolean 
   */
  function register_author(array $author){
    //同じ著者登録されている場合
    if($this->author_exist($author['name'])){
      $this->author_update($author);
      return true;
    }else{
      if(isset($author['name']) && $author['name'] != ""){
        if(filter_var($author['url'],FILTER_VALIDATE_URL)){
          $sql = "insert into authors(name,url,account_id) values('$author[name]','$author[url]',$author[account_id])";
        }else{  
          $sql = "INSERT into authors(name,account_id) values('$author[name]',$author[account_id])";
        }
      }else{
        return false;
      }
      $result = parent::save($sql);
      return $result;
    }
  }

  /**
   * 著者情報の更新
   */
  function author_update($author){
    if(filter_var($author['url'],FILTER_VALIDATE_URL)){
      $sql = "UPDATE authors set url = '$author[url]' where name = '$author[name]'";
      parent::save($sql);
    }
  }

  /**
   * genre登録
   * @param array $genre 
   * @return bool
   */

  function register_genre($genre){
    if(isset($genre['new_genre']) && $genre['sub_genre'] == "add" && $genre['new_genre'] != ""){
      if(!$this->exits_genre($genre['new_genre'])){
        $sql = "Insert into genres(name,parent_id) values('$genre[new_genre]',$genre[genre])";
        $result = parent::save($sql);
        return $result;
      }
    }elseif($genre['sub_genre'] != "" && isset($genre['sub_genre']) || $genre['genre']){
      return true;
    }
  }

  /**
   * genre取得
   * @param string $genre ジャンル名
   */
 function exits_genre($genre){
   $sql = "SELECT COUNT(*) FROM genres where name = '$genre'";
   $result = parent::exist($sql);
   return $result;
 }

 /**
  * 本登録
  * @param array $book_info
  * @return boolean 
  */
 function book_update($book_info){
  if(is_numeric($book_info['price'])){
    $author_sql = "Select id from authors where name = '$book_info[name]'";
    $book['author'] = parent::find($author_sql);
    $author_id = $book['author'][0]['id'];
    $book_id = $this->book_id($book_info['title']);
    //サブジャンル選択状態
    if($book_info['sub_genre'] != 'add'){
      $sql = "UPDATE books SET title = '$book_info[title]',genre_id = '$book_info[sub_genre]',author_id = '$author_id',description = '$book_info[description]',price = $book_info[price] WHERE id = $book_id";
    //新規ジャンル登録した
    }elseif($book_info['sub_genre'] == 'add' && $book_info['new_genre']){
      $genre_sql = "Select id from genres where name = '$book_info[new_genre]'";
      $book['genre'] = parent::find($genre_sql);
      $genre_id = $book['genre'][0]['id'];
      $sql = "UPDATE books SET title = '$book_info[title]',genre_id = '$genre_id',author_id = '$author_id',description = '$book_info[description]',price = $book_info[price] WHERE id = $book_id";
    }else{
      return false;
    }
    $result = parent::save($sql);
    return $result;
  }
  return false;
 }


  /**
   * 本のID取得
   */

   function book_id($title){
    $sql = "SELECT id from books where title = $title";
    $result = parent::find($sql);
    return $result[0];
   }

}