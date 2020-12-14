<?php
require_once "Repository.php";
date_default_timezone_set('Asia/Tokyo');

class Review extends Repository
{
    public $value;
    function __construct(string $name, string $password)
    {
        parent::__construct($name, $password);
    }

    public function reviewSave(array $reviewAdd){
        $sql = "INSERT INTO `review` (`account_id`, `product_id`, `evaluation`, `title`, `description`) VALUES ('$reviewAdd[id]', '$reviewAdd[book_id]', '$reviewAdd[star]', '$reviewAdd[title]', '$reviewAdd[description]');";
        $result = parent::save($sql);
        return $result;
    }




    

    
}
