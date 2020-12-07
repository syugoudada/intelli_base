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
    function select(String $sql, $input_parameters = null)
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
    function insert(String $sql, $input_parameters = null)
    {
        $stmt = $this->conn->prepare($sql);
        $flag = $stmt->execute($input_parameters);
        return $flag;
    }
}
