<?php

class DbOparation
{
    private $conn;

    /**
     * Constructor
     */
    function __construct()
    {
        require_once 'DbConnect.php';
        //DBに接続
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /**
     * Select
     *
     * @param String $sql
     * @param array $input_parameters
     * @return array
     */
    private function select(String $sql, $input_parameters = null)
    {
        $stmt = $this->conn->prepare($sql);

        $flag = $stmt->execute($input_parameters);
        if (!$flag) {
            return false;
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Insert
     *
     * @param String $sql
     * @param array $input_parameters
     * @return bool
     */
    private function insert(String $sql, $input_parameters = null)
    {
        $stmt = $this->conn->prepare($sql);
        $flag = $stmt->execute($input_parameters);
        return $flag;
    }

    /**
     * Get a category or all category
     *
     * @param Int $id
     * @return array|array(array) a category row | all category
     */
    function getCategory(Int $id = null)
    {
        if ($id == null) {
            $res = $this->select('SELECT * FROM category ORDER BY id');
        } else {
            $res = $this->select('SELECT * FROM category WHERE id = ? ORDER BY id desc', array($id));
        }
        return $res;
    }

    /**
     * get categories
     *
     * @param Int $alreadyGet すでに取得してるデータの除外(categoryId)
     * @return array [ { id, name, parentId }.. ]
     */
    function getCategories(Int $alreadyGet = 0)
    {
        $res = $this->select('SELECT * FROM category ORDER BY id AND id > ?', array($alreadyGet));

        return $res;
    }

    /**
     * get purchased books data
     *
     * @param integer $userId accountId
     * @param integer $already_get すでに取得してるデータの除外(purchaseId)
     * @return array [ { purchase.id, book.id, book.name, author.id, author.name }.. ]
     */
    function getPurchasedBooksData(int $userId, int $already_get = 0)
    {
        $res = $this->select(
            'SELECT purchase.id, book.id, book.name, author.id, author.name FROM purchase, product book, author 
            WHERE product_id = book.id AND author.id = author_id AND account_id = ? AND purchase.id > ?',
            array($userId, $already_get)
        );
        return $res;
    }

    /**
     * Get book data
     *
     * @param array $ids
     * @return array [ { book.id, book.name, author.id, author.name } ]
     */
    function getBook(int $bookId)
    {
        $res = $this->select('SELECT book.id, book.name, author.id, author.name, FORMAT(modification_datetime , \'yyyyMMddHHmmss\') FROM product book, author WHERE author.id = book.author_id AND book.id = ?', array($bookId));
        return $res;
    }

    /**
     * get note data
     *
     * @param integer $noteId
     * @return array [ { note.id, account_id, book_id, title, shared, public_shared } ]
     */
    function getNote(int $noteId)
    {
        $res = $this->select('SELECT note.id, account_id, book_id, title, shared, public_shared FROM note, account WHERE account_id = account.id AND id = ?', array($noteId));
        return $res;
    }

    /**
     * regist Note
     *
     * @param integer $accountId
     * @param integer $localId
     * @param integer $bookId
     * @param string $title
     * @return int|false setted noteId
     */
    function registNote(int $accountId, int $localId, int $bookId, string $title)
    {
        $flg = $this->insert('INSERT INTO note (account_id, local_id, book_id, title, shared) values (?,?,?,?,?)', array($accountId, $localId, $bookId, $title, true));
        if (!$flg) {
            return false;
        }

        $noteId = $this->select('SELECT id FORM note WHERE account_id = ? AND local_id = ?', array($accountId, $localId));
        return $noteId;
    }

    /**
     * toggle note shared
     *
     * @param integer $noteId
     * @param boolean $shared if set update in force
     * @return bool
     */
    function toggleNoteShared(int $noteId, bool $shared = null)
    {
        if ($shared == null) {
            $flg = $this->insert('UPDATE note SET shared = !shared WHERE id = ?', array($noteId));
        } else {
            $flg = $this->insert('UPDATE note SET shared = ? WHERE id = ?', array($shared, $noteId));
        }
        return $flg;
    }
}
