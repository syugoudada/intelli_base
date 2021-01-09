<?php
session_start();
require_once('../Repository/Cart_Repository.php');
require_once('../Repository/db_config.php');
$myself = new Cart_Repository(DB_USER,DB_PASS);
$myself->login();
if(empty($_SESSION['account']['id'])){
    $book_ids = $_SESSION["cart"];
    $cart = $myself->NoUsergetsBooksData($book_ids);
}else{
    $account_id = $_SESSION['account']['id'];
    $cart = $myself->getBooksDataInCart($account_id);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <header>

    </header>

    <main>
        <div class="main_contents">
            
        </div>
    </main>

    <footer>

    </footer>
    
</body>
</html>