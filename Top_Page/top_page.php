<?php
session_start();
require_once('../Repository/Product_Registration_Repository.php');
require_once('../Repository/db_config.php');
$myself = new Product_Registration_Repository(DB_USER, DB_PASS);
$myself->login();
$genre = $myself->genre();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link href="../Css/slick-theme.css" rel="stylesheet" type="text/css">
  <link href="../Css/slick.css" rel="stylesheet" type="text/css">
  <script src="../js/slick.min.js"></script>
  <title>intelli_base</title>
</head>

<body>
  <header>
    <div class="header_contents">
      <form action="../Search/search.php" method="POST">
        <div class="serach_bar">
          <input type="text" id="search_bar" name = "title" placeholder="入力してください">
          <input type="submit" id="submit" name="submit" value="ボタン">
        </div>
      </form>
      <div class="user_tag">
        <div class="login_tag">
          <a href="../Login/login_form.php">こんにちは、ログイン</a></form>
        </div>
        <script>
          function login_user(user) {
            $('.login_tag').children('a').html("<a href='#'>" + user + "さんようこそ</a>");
          }
        </script>

        <?php
        if ($_SESSION['user'] != "" && isset($_SESSION['user'])) {
          $user = $_SESSION['user'];
          print("<script>$(function(){login_user('$user');});</script>");
        }
        ?>

        <div id="cart_tag">
          <a href="#">カート</a>
        </div>
      </div>
    </div>
    </div>
  </header>

  <div class="contents">
    <div class="main_contents">
      <div class="genre">
        <ul name="genre_list">
          <?php
          foreach ($genre as $value) {
            print("<form action='../Product_Display/product_display.php' name='genre" . $value['id'] . "' method='POST'><li value='$value[id]'><a href='#' onclick='document.genre" . $value['id'] . ".submit();'>$value[name]</a></li><input type='text' name = 'genre_id' value='$value[id]' hidden></form>");
          }
          ?>
        </ul>
      </div>
      <div class="book_contents">
        <div class="section">

          <div class="sliderArea">
            <div class="regular_3 slider">
              <div><a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto01.jpg" alt="125naroom"></a></div>
              <div><a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto02.jpg" alt="125naroom"></a></div>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto03.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto04.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
              <a href="#"><img src="https://125naroom.com/demo/img/itukanokotonokoto05.jpg" alt="125naroom"></a>
            </div>
          </div>
        </div>
        <script>
          $(function() {
            $(".regular_3").slick({
              dots: true,
              infinite: true,
              slidesToShow: 5,
              slidesToScroll: 5
            });
          });
        </script>
      </div>
    </div>
  </div>

  <footer>
    <div class="footer_contents">

    </div>
  </footer>

</body>

</html>