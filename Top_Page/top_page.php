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
  <link rel="stylesheet" href="../Css/top.css">
  <script src="../js/slick.min.js"></script>
  <title>intelli_base</title>
</head>

<body>
  <header>
    <div class="header_contents">
      <form action="../Search/search.php" method="POST">
        <div class="serach_bar">
          <input type="text" id="search_bar" name="title" placeholder="入力してください">
          <input type="submit" id="search" name="search" value="ボタン">
        </div>
      </form>
      <div class="user_tag">
        <div class="login_tag">
          <a href="../Login/login_form.php">こんにちは、ログイン</a></form>
        </div>
        <script>
          function login_name(name) {
            $('.login_tag').children('a').html("<a href='../Product_Display/user_detail.php'>" + name + "さんようこそ</a>");
          }
        </script>

        <?php
        if ($_SESSION["account"]["name"] != "" && isset($_SESSION["account"]["name"])) {
          $name = $_SESSION["account"]["name"];
          print("<script>$(function(){login_name('$name');});</script>");
        }
        ?>

        <div id="cart_tag">
          <a href="#">カート</a>
        </div>
      </div>
    </div>
    </div>
  </header>

  <main>
    <div class="contents">
      <div class="main_contents">
        <div class="genre">
          <ul name="genre_list" class="genre_list">
            <?php
            foreach ($genre as $value) {
              print("<form action='../Product_Display/product_display.php' name='genre" . $value['id'] . "' method='POST'><li value='$value[id]'><a href='#' onclick='document.genre" . $value['id'] . ".submit();'>$value[name]</a></li><input type='text' name = 'genre_id' value='$value[id]' hidden></form>");
            }
            ?>
          </ul>
        </div>
        <div class="book_contents">
          <p>人気タイトル</p>
          <ul class="slider multiple-item popular">
           
          </ul>

          <p>ランキング</p>
          <ul class="slider multiple-item rank">
            
          </ul>

          <p>おすすめ</p>
          <ul class="slider multiple-item recommended">
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
            <li><a href="#"><img src="../uploadedData/thumbnail/thumbnail1.png"></a></li>
          </ul>

          <script>
            $(function() {
              make_booklist();

              $('.multiple-item').slick({
                infinite: true,
                dots: true,
                slidesToShow: 6,
                slidesToScroll: 6,
                // responsive: [{
                //   breakpoint: 768,
                //   settings: {
                //     slidesToShow: 3,
                //     slidesToScroll: 3,
                //   }
                // }, {
                //   breakpoint: 480,
                //   settings: {
                //     slidesToShow: 2,
                //     slidesToScroll: 2,
                //   }
                // }]
              });

              function make_booklist(){
                let i = 1;
                for(i; i <= 10; i++){
                  $('.popular').append('<li><form action="../Search/product_detail.php" name="product' + i + '" method="POST" target="_blank" rel="noopener noreferrer"><input type ="image" src="../uploadedData/thumbnail/thumbnail' + i + '.png" width="120" ><p></p><p></p><input type="text" name = book_id hidden value  = "' + i + '"></form></li>');  
                }

                for(i; i <= 20; i++){
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
    <div class="footer_contents">
    <!-- <form action="../Search/product_detail.php" name="product" method="POST" target="_blank" rel="noopener noreferrer"><input type ="image" src="../uploadedData/thumbnail/thumbnail1.png" ><input type="text" name = product_id hidden value  = "1"></form> -->
    </div>
  </footer>
</body>

</html>