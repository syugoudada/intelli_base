<?php

class DbConnect
{
    private $conn;

    // function connect()
    // {
    //     require_once 'db_config.php';

    //     //Mysql DataBaseに接続
    //     $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    //     //DB接続時のエラーがないか確認
    //     if (mysqli_connect_errno()) {
    //         echo "データベースに接続されませんでした" . mysqli_connect_errno();
    //     }
    //     //接続リソースの保持
    //     return $this->conn;
    // }

    function connect()
    {
        require_once 'db_config.php';

        //接続
        $dns = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;
        try {
            $this->conn = new PDO($dns, DB_USERNAME, DB_PASSWORD);
        } catch (PDOexception $th) {
            echo $th;
            return;
        }

        return $this->conn;
    }
}
