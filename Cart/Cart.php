<?php
session_start();
require_once('../Repository/Cart_Repository.php');
require_once('../Repository/db_config.php');
$myself = new Cart_Repository(DB_USER, DB_PASS);
$myself->login();
if (empty($_SESSION['account']['id'])) {
    if(empty($_SESSION["cart"])){
        $cart = 0;
    }else{
        $book_ids = $_SESSION["cart"];
        $cart = $myself->NoUsergetsBooksData($book_ids);
    }
} else {
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
            <form action="../Purchased/purchased_form.php" method="POST">
                <div class="cart_contents">
                    <div class="cart_info">
                        <div class='books_info'>
                            <?php
                                if($cart){
                                    foreach($cart as $index => $value){
                                        print("<div class='books'><input type='checkbox' name='book$index' value='$value[id]' alt='本'><img src='../uploadedData/thumbnail/thumbnail1.png' width='100px' height='120px'><div><p>$value[title]</p><p>$value[price]円</p></div></div>");
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="purchase">
                        <input type="submit" name="submit" value="購入">
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        $(function(){
            
        });
    </script>

    <footer>

    </footer>

</body>

</html>