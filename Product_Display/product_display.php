<?php
require_once('../Repository/db_config.php');
require_once('../Repository/Product_Display_Repository.php');
require_once('../Repository/Product_Registration_Repository.php');
$myself = new Product_Display_Repository(DB_USER, DB_PASS);
$genre_self = new Product_Registration_Repository(DB_USER, DB_PASS);
$myself->login();
$genre_id = $_POST['genre_id'];
$result = $myself->search($genre_id);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link href="../Css/slick-theme.css" rel="stylesheet" type="text/css">
  <link href="../Css/slick.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="../Css/book_display.css">
  <script src="../js/slick.min.js"></script>
  <title></title>
</head>

<body>
  <header>
    <div class="header_contents">
      <form action="../Search/search.php" method="POST">
        <div class="serach_bar">
          <input type="text" id="search_bar" name="title" placeholder="入力してください">
          <input type="submit" id="submit" name="submit" value="ボタン">
        </div>
      </form>
    </div>
  </header>

  <main>
    <div class="main_contents">
      <div class="book_contents">
        <div class="genre">
          <div class="sub_genre">
            <?php
            $genre_self->login();
            $genre_id = $_POST["genre_id"];
            $genre = $genre_self->sub_genre($genre_id);
            if(!empty($genre)){
              foreach ($genre as $value) {
                print("<form action='../Product_Display/product_display.php' name='genre" . $value['id'] . "' method='POST'><li value='$value[id]'><a href='#' onclick='document.genre" . $value['id'] . ".submit();'>$value[name]</a></li><input type='text' name = 'genre_id' value='$value[id]' hidden></form>");
              }
            }
            ?>
          </div>
        </div>
        <div class="book_list">
          <ul class="slider multiple-item popular">
            <?php
            foreach ($result as $value) {
              // print("<form action='../Search/product_detail.php' name='product_submit$value[id]' method='POST' target='_blank' rel='noopener noreferrer'><a href='#' onclick='document.product_submit$value[id].submit();'><img src='../uploadedData/thumbnail/thumbnail$value[id].png'></a><input type='text' name = 'book_id' hidden value  = '$value[id]'></form>");

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
      });
    </script>
  </main>
  <footer>

  </footer>
</body>

</html>