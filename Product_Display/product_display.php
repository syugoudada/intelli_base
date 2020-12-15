<?php
require_once('../Repository/db_config.php');
require_once('../Repository/Product_Display_Repository.php');
require_once('../Repository/Product_Registration_Repository.php');
$myself = new Product_Display_Repository(DB_USER, DB_PASS);
$genre_self = new Product_Registration_Repository(DB_USER,DB_PASS);
$myself->login();
$genre_id = $_POST['genre_id'];
$result = $myself->search($genre_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link href="../Css/slick-theme.css" rel="stylesheet" type="text/css">
  <link href="../Css/slick.css" rel="stylesheet" type="text/css">
  <link href="../Css/product_display.css" rel="stylesheet" type="text/css">
  <script src="../js/slick.min.js"></script>
  <title></title>
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
    </div>
  </header>

  <div class="contents">
    <div class="main_contents">
      <div class="genre">
        <div class="sub_genre">
          <?php
            $genre_self->login();
            $genre_id = $_POST["genre_id"];
            $genre = $genre_self -> sub_genre($genre_id);
            foreach ($genre as $value) {
              print("<form action='../Product_Display/product_display.php' name='genre" . $value['id'] . "' method='POST'><li value='$value[id]'><a href='#' onclick='document.genre" . $value['id'] . ".submit();'>$value[name]</a></li><input type='text' name = 'genre_id' value='$value[id]' hidden></form>");
            }
          ?>
        </div>
      </div>
      <div class="book_contents">
      <!-- <form action='../Search/product_detail.php' name='product_submit11' method='POST'><a href='#' onclick='document.product_submit11.submit();'><img src='../uploadedData/thumbnail/thumbnail11.png'></a><input type='text' name = 'product_id' hidden value  = '11'></form> -->
          <div class="sliderArea">
            <div class="regular_3 slider">
              <?php
              foreach($result as $value){
                print("<form action='../Search/product_detail.php' name='product_submit$value[id]' method='POST' target='_blank' rel='noopener noreferrer'><a href='#' onclick='document.product_submit$value[id].submit();'><img src='../uploadedData/thumbnail/thumbnail$value[id].png'></a><input type='text' name = 'product_id' hidden value  = '$value[id]'></form>");
              }
              ?>
              
            </div>
          </div>
          <div class="index-btn-wrapper">
          <div class="index-btn">1</div>
          <div class="index-btn">2</div>
          <div class="index-btn">3</div>
          <div class="index-btn">4</div>
          <div class="index-btn">5</div>
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

  </footer>
</body>

</html>