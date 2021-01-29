<?php
session_start();
require_once('../Repository/db_config.php');
require_once('../Repository/Product_Display_Repository.php');
require_once('../Repository/Product_Registration_Repository.php');
$myself = new Product_Display_Repository(DB_USER, DB_PASS);
$genre_self = new Product_Registration_Repository(DB_USER, DB_PASS);
$myself->login();
$genre_id = $_POST['genre_id'];
$result = $myself->search($genre_id);
$genreName = $myself->genreName($genre_id);
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
  <link rel="stylesheet" href="../Css/book_display.css">
  <script src="../js/slick.min.js"></script>
  <title>Intelli_Base</title>
</head>

<body>
  <label class="all_body"></label>
  <header>
    <div class="header_contents">
      <div class="icon">
        <img src="../image/icon.png" width="50px" height="50px">
        <p class="iconTitle">Intelli_Base</p>
      </div>
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
    <div class="main_contents">
      <div class="book_contents">
        <div class="genre">
          <h2>ジャンル</h2>
          <ul class="sub_genre">
            <?php
            $genre_self->login();
            $genre_id = $_POST["genre_id"];
            $genre = $genre_self->sub_genre($genre_id);
            if (!empty($genre)) {
              foreach ($genre as $value) {
                print("<form action='../Product_Display/product_display.php' name='genre" . $value['id'] . "' method='POST'><li class='subList' value='$value[id]'><a href='#' class='genreList' onclick='document.genre" . $value['id'] . ".submit();'>$value[name]</a></li><input type='text' name = 'genre_id' value='$value[id]' hidden></form>");
              }
            }
            ?>
        </div>
        </ul>
        <div class="book_list">
          <p class="genreTitle"><?= $genreName[0]["name"]; ?></p>
          <ul class="slider multiple-item popular">
            <?php
            foreach ($result as $value) {
              print("<li><form action='../Search/product_detail.php' name='product$value[id]' method='POST' target='_blank' rel='noopener noreferrer'><input type ='image' src='../uploadedData/thumbnail/thumbnail$value[id].png' width='120'><p>$value[title]</p><p>$value[name]</p><input type='text' name = book_id hidden value = $value[id]></form></li>");
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
    <script>
      $(function() {
        $(".multiple-item").slick({
          dots: true,
          infinite: true,
          slidesToShow: 5,
          slidesToScroll: 5
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
      });
    </script>
  </main>
  <footer>

  </footer>
</body>

</html>