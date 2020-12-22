<?php
require_once("../Repository/Search_Like_Repository.php");
require_once("../Repository/db_config.php");
$myself = new Search_Like_Repository(DB_USER, DB_PASS);
$myself->login();
$book_id = $_POST['book_id'];
$book_detail = $myself->book_find($book_id);
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="../js/jquery.raty.js"></script>
  <title>本のタイトル</title>
</head>

<body>
  <header>

  </header>
  <main>
    <div>
      <div class="product-part">
        <div class="product_image">
          <img src="../uploadedData/thumbnail/thumbnail<?= $book_detail[0]['id'] ?>.png" width="200" height="250">
        </div>
        <div class="description">
          <div class="title">
            <?= $book_detail[0]["title"]; ?>
          </div>
          <p id="star1">
            
          </p>
          <div class="price">
            <?= $book_detail[0]["price"]; ?>円
          </div>
          <form action="" method="POST">
            <input type="text" id='1' hidden>
        </div>
        <input type="submit" name="cart" value="Cart">
        </form>
      </div>
    </div>
  </main>
  <footer></footer>
</body>

</html>