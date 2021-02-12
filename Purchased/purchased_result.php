<?php
session_start();
require_once("../Repository/Purchase_Repository.php");
require_once("../Repository/db_config.php");
$myself = new Purchase_Repository(DB_USER, DB_PASS);
$myself->login();
$purchased_items = array();
foreach ($_SESSION["account"]["purchased"] as $book_id) {
  $book_info = $myself->book_find($book_id);
  array_push($purchased_items, array("book" => $book_info[0]));
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Css/purchased_result.css">
  <link rel="icon" type="image/png" href="../image/icon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Intelli_Base</title>
</head>

<body>
  <label class="all_body"></label>
  <header>
    <div class="header_contents">
      <div class="icon">
      <a href="../Top_Page/top_page.php" class="topBack">
        <img src="../image/icon.png" width="50px" height="50px">
        <p class="iconTitle">Intelli_Base</p>
      </a>
      </div>
      <<form action="../Search/search.php" method="GET">
        <div class="search">
          <input type="text" id="search_bar" name="title" placeholder="検索">
          <input type="submit" id="submit" value="🔍">
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
      <script>
        function login_name(name) {
          $('.login_tag').children('a').html("<a  class='userName' id='userName' href='#'>" + name + "さんようこそ</a>");
        }
      </script>

      <?php
      if ($_SESSION["account"]["name"] != "" && isset($_SESSION["account"]["name"])) {
        $name = $_SESSION["account"]["name"];
        print("<script>$(function(){login_name('$name');});</script>");
      }
      ?>

      <div id="cart_tag">
        <a class="cart_a" href="../Cart/Cart.php">カート</a>
      </div>
    </div>
  </header>

  <script>
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
    <div class="contents">
      <div class="result">
        <p>ありがとうございます。購入しました</p>
        <p>アプリの方で確認してください</p>
        <a href="../Top_Page/top_page.php">HOMEへ</a>
      </div>
    </div>
  </main>

  <footer>

  </footer>
</body>

</html>