<?php
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
  <header>
    header
  </header>
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
        <p class="get-point cart-form">獲得ポイント:<span><?= round($book_detail[0]["price"]/100); ?>ポイント</span></p>
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