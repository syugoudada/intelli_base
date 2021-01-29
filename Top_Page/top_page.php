<?php
session_start();
require_once('../Repository/Product_Registration_Repository.php');
require_once('../Repository/Top_Page_Repository.php');
require_once('../Repository/db_config.php');
$myself = new Top_Page_Repository(DB_USER, DB_PASS);
$myself->login();
$genre = $myself->genre();
$book["rank"] = $myself->rank_book();
$book["popular_count"] = $myself->popular_count();
$book["popular"] = array();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link href="../Css/slick-theme.css" rel="stylesheet" type="text/css">
  <link href="../Css/slick.css" rel="stylesheet" type="text/css">
  <link rel="icon" type="image/png" href="../image/icon.png">
  <link rel="stylesheet" href="../Css/top.css">
  <script src="../js/slick.min.js"></script>
  <title>intelli_base</title>
</head>

<body>
  <label class="all_body"></label>
  <header>
    <div class="header_contents">
      <div class="icon">
        <img src="../image/icon.png" class="iconImage" width="50px" height="50px">
        <p class="iconTitle">intelli_base</p>
      </div>
      <form action="../Search/search.php" method="POST">
        <div class="search">
          <input type="text" id="search_bar" name="title" placeholder="検索">
          <input type="submit" id="submit" name="sub" value="🔍">
        </div>
      </form>
      <nav class="login_tag">
        <a class="noLog" href="../Login/login_form.php">こんにちは、ログイン</a>
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

  <main>
    <div class="contents">
      <div class="main_contents">
        <div class="genre">
          <ul name="genre_list" class="genre_list">
            <h1>ジャンル</h1>
            <?php
            foreach ($genre as $value) {
              print("<form action='../Product_Display/product_display.php' name='genre" . $value['id'] . "' method='POST'><li value='$value[id]'><a href='#' class='genre_a' onclick='document.genre" . $value['id'] . ".submit();'>$value[name]</a></li><input type='text' name = 'genre_id' value='$value[id]' hidden></form>");
            }
            ?>
          </ul>
        </div>
        <div class="book_contents">
          <p class="bookTitle" hidden>人気タイトル</p>
          <ul class="slider multiple-item popular">
            <?php
            foreach ($book["popular_count"] as $value) {
              $book["popular"] = $myself->popular_book($value['book_id']);
              foreach ($book["popular"] as $value2) {
                print("<li><form action='../Search/product_detail.php' name='product$value2[id]' method='POST' target='_blank' rel='noopener noreferrer'><input type ='image' src='../uploadedData/thumbnail/thumbnail$value2[id].png' width='131'><p>$value2[title]</p><p>$value2[name]</p><input type='text' name = book_id hidden value = $value2[id]></form></li>");
              }
            }
            ?>
          </ul>

          <p class="bookTitle" hidden>ランキング</p>
          <ul class="slider multiple-item rank">
            <?php
            foreach ($book["rank"] as $value) {
              print("<li><form action='../Search/product_detail.php' name='product$value[id]' method='POST' target='_blank' rel='noopener noreferrer'><input type ='image' src='../uploadedData/thumbnail/thumbnail$value[id].png' width='131'><p>$value[title]</p><p>$value[name]</p><input type='text' name = book_id hidden value = $value[id]></form></li>");
            }
            ?>
          </ul>

          <script>
            $(function() {
              $('.book_contents').find('p').hide().fadeIn(2000);

              $('.multiple-item').slick({
                infinite: true,
                dots: true,
                slidesToShow: 6,
                slidesToScroll: 6,
              });

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

              function make_booklist() {
                let i = 1;
                for (i; i <= 10; i++) {
                  $('.popular').append('<li><form action="../Search/product_detail.php" name="product' + i + '" method="POST" target="_blank" rel="noopener noreferrer"><input type ="image" src="../uploadedData/thumbnail/thumbnail' + i + '.png" width="120" ><input type="text" name = book_id hidden value  = "' + i + '"></form></li>');
                }

                for (i; i <= 20; i++) {
                  $('.rank').append('<li><form action="../Search/product_detail.php" name="product' + i + '" method="POST" target="_blank" rel="noopener noreferrer"><input type ="image" src="../uploadedData/thumbnail/thumbnail' + i + '.png" width="120" ><input type="text" name = book_id hidden value  = "' + i + '"></form></li>');
                }
              }
            });
          </script>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <a href="#" class="backTop">Back Top</a>
    <div class="footer_contents">
    </div>
  </footer>
</body>

</html>