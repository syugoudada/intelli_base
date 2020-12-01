<?php
require_once("../Repository/Search_Like.php");
require_once("../Repository/db_config.php");
$myself = new Search_Like_Repository(DB_USER, DB_PASS);
$myself->login();
$product_detail = $myself->find($_POST);
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="jquery.raty.js"></script>
  <title>本のタイトル</title>
</head>

<body>
  <header></header>
  <div class="content">
    <div>
      <div class="product-part">
        <div class="product_image">
          <img src="../images/book1.jpg" height="200px" width="200px">
        </div>
        <div class="description">
          <div class="title">
            <?= $product_detail[0]["name"]; ?>
          </div>
          <p id="star1"></p>
          <div class="price">
            <?= $product_detail[0]["price"]; ?>円
          </div>
          <form action="" method="POST">
            <input type="text" id='1' hidden></div>
            <input type="submit" name="cart" value="Cart">
          </form>
        </div>
      </div>
    </div>
  </div>
  <footer></footer>
</body>

</html>