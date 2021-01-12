<?php
require_once "Repository.php";
date_default_timezone_set('Asia/Tokyo');

class Cart_Repository extends Repository
{
    public $value;
    function __construct(string $name, string $password)
    {
        parent::__construct($name, $password);
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

    public function NoUsergetsBooksData($book_ids){
        $result = array();
        foreach($book_ids as $id){
            $sql = "select id, title, price from books where id = '$id'";
            $book = parent::find($sql);
            array_push($result, $book[0]);
        }
        return $result;
    }

    /**
     * getBooksDataInCart
     * 
     * 引数に指定されたユーザIDからカートのJSONを取得してJSONに含まれるIDから本の情報を取得する
     * @param string $user ユーザID
     * @return array 配列
     */
    public function getBooksDataInCart(string $account_id){
        $json = $this->find_cart($account_id);
        $book_ids = json_decode($json[0]["cart_json"],true);
        $result = array();
        foreach($book_ids as $id){
            $sql = "select id, title, price from books where id = '$id[id]'";
            $book = parent::find($sql);
            array_push($result, $book[0]);
        }
        return $result;
    }
}
