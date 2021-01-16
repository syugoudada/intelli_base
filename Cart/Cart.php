<?php
session_start();
require_once('../Repository/Cart_Repository.php');
require_once('../Repository/db_config.php');
$myself = new Cart_Repository(DB_USER, DB_PASS);
$myself->login();
if (empty($_SESSION['account']['id'])) {
    if (empty($_SESSION["cart"])) {
        $cart = 0;
    } else {
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
    <link rel="stylesheet" href="../Css/cart.css">
    <title>intelli_base</title>
</head>

<body>
    <header>header</header>

    <nav>left</nav>

    <main>
    <p>Shoping Cart</p><hr> 
        <form action="../Purchased/purchased_form.php" method="POST">
            <div class="main_contents">
                <div class="cart_contents">
                    <?php
                    $total = 0;
                    if ($cart) {
                        foreach ($cart as $index => $value) {
                            $total = $total + $value["price"];
                            print("<div class='books' id='$value[id]'><input type='checkbox' class='check_box' name='book$index' value='$value[id]' checked><img src='../uploadedData/thumbnail/thumbnail1.png' width='100px' height='120px' alt='本'><div class='book_info'><p class='title'>$value[title]</p><p class='price$value[id]'>$value[price]円</p><button class='delete' type='button' value='$value[id]'>削除</button></div></div>");
                        }
                    } else {
                        print("<p>intelli_baseカートは商品がありません</p>");
                    }
                    ?>
                </div>
                <div class="purchase">
                    <div class="totalPrice">total:￥<strong><?= $total ?></strong></div>
                    <div class="totalPoint">price:<?= round($total/10) ?>pt</div>
                    <input type="submit" name="submit" value="購入">
                </div>
            </div>
        </form>
    </main>
    <aside>right</aside>

    <script>
        $(function() {
            $('.delete').click(function() {
                let id = $(this).val();
                let price = $(".price" + id).text();     
                price = price.slice(0,-1);  
                price = <?= $total?> - price;  
                ajax(id,price);
            });

        });

        function ajax(id,price) {
            $.ajax({
                type: 'POST',
                url: 'cart_service.php',
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function(msg) {
                    $('#' + id).remove();
                    $(".totalPrice").html('<div class="totalPrice">total:￥<strong>' + price + '</strong></div>');
                }
            });
        }
    </script>

    <footer>
        footer
    </footer>

</body>

</html>