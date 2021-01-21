<?php
session_start();
require_once("../Repository/Search_Like_Repository.php");
require_once("../Repository/db_config.php");
$myself = new Search_Like_Repository(DB_USER, DB_PASS);
$myself->login();
$book_id = $_POST['book_id'];
$book_detail = $myself->book_find($book_id);
?>

<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="../js/jquery.raty.js"></script>
  <link rel="stylesheet" href="../Css/product_detail.css">
  <title>intelli_base</title>
</head>

<body>
  <label class="all_body"></label>
  <header>
    <div class="header_contents">
      <form action="../Search/search.php" method="POST">
        <div class="search">
          <input type="text" id="search_bar" name="title" placeholder="検索">
          <input type="submit" id="submit" name="sub" value="🔍">
        </div>
      </form>
      <nav class="login_tag">
        <a href="../Login/login_form.php">こんにちは、ログイン</a>
        <ul class="userContents">
          <li><a href="../Password_Change/change.php">パスワード変更</a></li>
          <li><a href="../Product_Register/Register.php">商品登録</a></li>
          <li><a href="../Login/logout.php">ログアウト</a></li>
        </ul>
      </nav>
      <div id="cart_tag">
        <a href="../Cart/Cart.php">カート</a>
      </div>
    </div>
  </header>


  <?php
  if ($_SESSION["account"]["name"] != "" && isset($_SESSION["account"]["name"])) {
    $name = $_SESSION["account"]["name"];
    print("<script>$(function(){login_name('$name');});</script>");
  }
  ?>

  <script>
    function login_name(name) {
      $('.login_tag').children('a').html("<a  class='userName' id='userName' href='#'>" + name + "さんようこそ</a>");
    }

    $(function() {
      $('.userName').hover(
        function() {
          $(".userContents").css("top", "65px");
          $(".all_body").css("width", "100%").css("height", "100%");
        },
        function() {
          $(".userContents").css("top", "-250px");
          $(".all_body").css("width", "0%").css("height", "0%");
        },
      )

      $('.userContents').hover(
        function() {
          $(".userContents").css("top", "65px");
          $(".all_body").css("width", "100%").css("height", "100%");
        },
        function() {
          $(".userContents").css("top", "-250px");
          $(".all_body").css("width", "0%").css("height", "0%");
        }
      );
    });
  </script>
  <main>
    <div class="book-part">
      <div class="book-image">
        <img src="../uploadedData/thumbnail/thumbnail<?= $book_detail[0]['id'] ?>.png" width="200" height="250">
      </div>
      <div class="book-info">
        <div class="title">
          <?= $book_detail[0]["title"]; ?>
        </div>
        <div class="price">
          ￥<?= number_format($book_detail[0]["price"]); ?>
        </div>
        <div class="name">
          <?= $book_detail[0]["name"]; ?>
        </div>
        <div class="description">
          <?= $book_detail[0]["description"]; ?>
        </div>
      </div>
      <div class="cart-submit">
        <p class="cart-price cart-form">価格:<span>￥<?= number_format($book_detail[0]["price"]); ?></span>(税込)</p>
        <p class="get-point cart-form">獲得ポイント:<span><?= round($book_detail[0]["price"] / 100); ?>ポイント</span></p>
        <form action="../Cart/Cart_add.php" method="POST">
          <input type="text" name="book_id" value='<?= $book_detail[0]['id'] ?>' hidden>
          <input type="submit" name="cart" class="cart-Button" value="Cartに入れる">
        </form>
      </div>
    </div>
  </main>



  <footer>
    footer
  </footer>
</body>

</html>