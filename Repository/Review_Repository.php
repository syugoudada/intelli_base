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

    public function save(array $user, $input_parameters=NULL){
        $user['sql'] = "INSERT INTO `review` (`account_id`, `product_id`, `evaluation`, `title`, `description`) VALUES ('$user[id]', '$user[book_id]', '$user[star]', '$user[title]', '$user[description]');";
        $result = parent::save($user);
        return $result;
    }




    

    
}
