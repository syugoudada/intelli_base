<?php
require_once('../Repository/db_config.php');
require_once('../Repository/Product_Display_Repository.php');
$myself = new Product_Display_Repository(DB_USER, DB_PASS);
$myself->login();
$result = $myself->search($_POST['genre_id']);
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

  </header>

  <div class="contents">
    <div class="main_contents">
      <div class="book_contents">
          <div class="sliderArea">
            <div class="regular_3 slider">
              <?php
              foreach($result as $value){
                print("<div><a href='#'><img src='../uploadedData/thumbnail/book$value[id].jpg'></a></div>");
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