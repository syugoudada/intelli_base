<?php
if(!isset($_POST)){
    print "ポストされてない";
}

require_once '../Repository/Review_Repository.php';
session_start();
$myself = new Review('root','rootpass');
$myself->login();

$product_id = $_POST["product_id"];

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>カート</title>
    <link rel="stylesheet" type="text/css" href="Review.css">

</head>
    <body>
        <h1>この本をレビュー</h1>

        <form action="Review_add.php" method="POST">
            <p>評価</p>
            <div type="get" action="#">
                <div class="evaluation">
                    <input id="star1" type="radio" name="star" value="5" />
                    <label for="star1"><span class="text">最高</span>★</label>
                    <input id="star2" type="radio" name="star" value="4" />
                    <label for="star2"><span class="text">良い</span>★</label>
                    <input id="star3" type="radio" name="star" value="3" />
                    <label for="star3"><span class="text">普通</span>★</label>
                    <input id="star4" type="radio" name="star" value="2" />
                    <label for="star4"><span class="text">悪い</span>★</label>
                    <input id="star5" type="radio" name="star" value="1" />
                    <label for="star5"><span class="text">最悪</span>★</label>
                </div>
            </div>
            <p>レビュータイトル</p>
            <input id="title" type="text" name="title">
            <p>レビューを追加</p>
            <input id="descrioption"  type="text" name="description">
            <input type="hidden" name="book_id" value=<?= "$product_id" ?>>
            <button type="submit">送信</button>
        </form>


    
    </body>
</html>