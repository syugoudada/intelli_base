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
    <link rel="icon" type="image/png" href="../image/icon.png">
    <link rel="stylesheet" href="../Css/cart.css">
    <title>intelli_base</title>
</head>

<body>
    <label class="all_body"></label>
    <header>
        <div class="header_contents">
            <div class="icon">
                <img src="../image/icon.png" width="50px" height="50px">
                <p class="iconTitle">intelli_base</p>
            </div>
            <form action="../Search/search.php" method="POST">
                <div class="search">
                    <input type="text" id="search_bar" name="title" placeholder="検索">
                    <input type="submit" id="submit" name="sub" value="🔍">
                </div>
            </form>
            <nav class="login_tag">
                <a href="../Login/login_form.php" class="noLog">こんにちは、ログイン</a>
                <ul class="userContents">
                    <li><a href="../Password_Change/change.php">パスワード変更</a></li>
                    <li><a href="../Product_Register/Register.php">商品登録</a></li>
                    <li><a href="../Login/logout.php">ログアウト</a></li>
                </ul>
            </nav>

            <?php
            if ($_SESSION["account"]["name"] != "" && isset($_SESSION["account"]["name"])) {
                $name = $_SESSION["account"]["name"];
                print("<script>$(function(){login_name('$name');});</script>");
            }
            ?>
        </div>
    </header>

    <script>
        function login_name(name) {
            $('.login_tag').children('a').html("<a  class='userName' id='userName' href='#'>" + name + "さんようこそ</a>");
        }
    </script>

    <nav></nav>

    <main>

        <form action="../Purchased/purchased_form.php" method="POST">
            <div class="main_contents">
                <div class="cart_contents">
                    <p>Shoping Cart</p>
                    <hr>
                    <?php
                    if ($_SESSION["account"]["name"] != "" && isset($_SESSION["account"]["name"])) {
                        $name = $_SESSION["account"]["name"];
                        print("<script>$(function(){login_name('$name');});</script>");
                    }

                    $total = 0;
                    if ($cart) {
                        foreach ($cart as $index => $value) {
                            $total = $total + $value["price"];
                            print("<div class='books' id='$value[id]'><span name='check'><input type='checkbox' class='check_box' id='check$value[id]' name='book$index' value='$value[id]' checked></span><img src='../uploadedData/thumbnail/thumbnail$value[id].png' width='100px' height='120px' alt='本'><div class='book_info'><p class='title'>$value[title]</p><p class='price$value[id]'>$value[price]円</p><p class='name'>$value[name]</p><button class='delete' type='button' value='$value[id]'>削除</button></div></div>");
                        }
                        if (isset($_SESSION["total"]) && $_SESSION["total"] != "") {
                            $notsend = $total - $_SESSION["total"];
                            $total = $total - $notsend;
                            unset($_SESSION["total"]);
                        }
                        $count = count($cart);
                        print("<script>let total = $total; let count = $count</script>");
                        $point = round($total / 100);
                        $total = number_format($total);
                        print("<div class='subTotal'><p>小計:￥<span class='undertotal'>$total<span></p><p>獲得ポイント:<span class='subPoint'>$point</span> pt</p></div>");
                    } else {
                        print('<script>let count = 0; $(function(){makeObject();});</script>');
                    }
                    ?>

                </div>
                <div class="subItems">
                    <div class="purchase">
                        <div class="purchase_infomation">
                            <div class="totalPrice">小計:￥<strong><?= $total ?></strong></div>
                            <div class="totalPoint">獲得ポイント:<?= $point ?>pt</div>
                            <input type="submit" name="submit" id="purchaseButton" class="purchaseButton" value="購入">
                        </div>
                    </div>

                    <nav>
                        <ul class="RecommendeBooks">
                            <?php
                            $books = $myself->find_book();
                            foreach ($books as $book) {
                                print("<li class='book'><img src='../uploadedData/thumbnail/thumbnail$book[id].png' width='100px' height='120px' alt='本'><div><p>$book[title]</p><p>$book[name]</p></div></li>");
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </form>
    </main>
    <aside></aside>

    <script>
        const flagTotal = total;
        $(function() {
            if (count == 0) {
                sizeChange();
                $(".subItems").remove();
            } else if (count == 1) {
                sizeChange();
            }

            $('.delete').click(function() {
                const id = $(this).val();
                const flg = $('#check' + id).prop('checked');
                let price = $(".price" + id).text();
                price = price.slice(0, -1);
                if (flg) {
                    total = total - price;
                }
                ajax(id, total);
                if (total == 0) {
                    makeObject();
                    sizeChange();
                } else if (count - 1 == 1) {
                    sizeChange();
                }
            });

            $('.userName').hover(
                function() {
                    $(".userContents").css("top", "70px");
                    $(".all_body").css("width", "100%").css("height", "100%");
                },
                function() {
                    $(".userContents").css("top", "-250px");
                    $(".all_body").css("width", "0%").css("height", "0%");
                },
            )

            $('.userContents').hover(
                function() {
                    $(".userContents").css("top", "70px");
                    $(".all_body").css("width", "100%").css("height", "100%");
                },
                function() {
                    $(".userContents").css("top", "-250px");
                    $(".all_body").css("width", "0%").css("height", "0%");
                }
            );

            $('span[name="check"]').children('input').change(function() {
                let checked = $(this).prop('checked');
                const id = $(this).val();
                if (checked) {
                    let price = $(".price" + id).text();
                    price = price.slice(0, -1);
                    total = total + Number(price);
                    let point = Math.round(total / 100);
                    makeHtml(total);
                } else {
                    let price = $(".price" + id).text();
                    price = price.slice(0, -1);
                    total = total - price;
                    let point = Math.round(total / 100);
                    makeHtml(total);
                }

                const button = document.getElementById("purchaseButton");
                if (total == 0) {
                    button.disabled = true
                    button.value = "商品がありません";
                } else {
                    button.disabled = false
                    button.value = "購入";
                }
            });

        });

        function ajax(id, total) {
            $.ajax({
                type: 'POST',
                url: 'cart_service.php',
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function(msg) {
                    $('#' + id).remove();
                    makeHtml(total);
                }
            });
        }

        function makeObject() {
            $(".subTotal").remove();
            $(".cart_contents").append("<div class='noCart'><img src=\'../image/Clean.png\' width=300px height=250px><div class=\'cart-info\'><p>intelli_baseカートは商品がありません</p></div></div>");
            $(".subItems").remove();
        }

        function sizeChange() {
            $(".cart_contents").css("height", "360px");
        }

        function makeHtml(total) {
            const point = Math.round(total / 100);
            $(".totalPrice").html('<div class="totalPrice">小計:￥<strong>' + total.toLocaleString() + '</strong></div>');
            $(".totalPoint").html('<div class="totalPoint">獲得ポイント:<strong>' + point + '</strong>pt</div>');
            $(".undertotal").text(total.toLocaleString());
            $(".subPoint").text(point);
        }
    </script>

    <footer>
        <a href="#" class="backTop">Back Top</a>
        <div class="footer_contents">
        </div>
    </footer>
</body>

</html>