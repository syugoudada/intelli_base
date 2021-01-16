<?php
session_start();
require_once("../Repository/db_config.php");
require_once("../Repository/Purchase_Repository.php");

if(!isset($_SESSION['account']['id']) && $_SESSION['account']['id'] == ""){
  header('Location:../Login/login_form.php');
}

//cart情報を受け取る
$cart_items = array();
foreach($_POST as $value){
  array_push($cart_items,$value);
}
array_pop($cart_items);

$total = 0;
$myself = new Purchase_Repository(DB_USER, DB_PASS);
$myself->login();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Css/reset.css">
  <link rel="stylesheet" href="../Css/purchase.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>購入</title>
</head>

<body>
  <div class="all_contents">
    <header>
      <div class="header_contents">

      </div>
    </header>

    <div class="contents">
      <form action="purchased.php" method="POST">
        <div class="book_contents">
          <div class='book_items'>
            <?php
            foreach ($cart_items as $index => $value) {
              $item = $myself->book_find($value);
              foreach ($item as $value) {
                $total += $value['price'];
                print("<div class='book_list'><img src='../uploadedData/thumbnail/thumbnail1.png' width='100px' height='120px'><div><p>$value[title]</p><p>$value[price]円</p></div><input type='text' name='id$index' value = '$value[id]' hidden></div>");
              }
            }

            ?>
          </div>
          <div class="total_price">
            <input type="submit" name="submit" value="Place Your purchase">
            <?php
            print("<p>Items:$total 円</p><p id='chose_point'>Point:0</p><p id='total'>Total:$total 円</p><input type='text' name='total' value = '$total' id='hid_total' hidden>");
            ?>
          </div>
        </div>

        <div class="purchase_method">
          <?php
          $point = $myself->point($_SESSION['account']['id']);
          $point = $point[0]['point'];
          print("<p>現在のポイント:$point</p>");
          ?>
          point<input type="number" id="point" name="point" value="0">
        </div>
      </form>

      <script>
        $(function() {
          $('#point').change(function() {
            let point = $('#point').val();
            if (isFinite(point) && point >= 0 && point <= <?= $point ?>) {
              $('#chose_point').html('<p>Point:' + point + '</p>');
              $('#total').html('<p>Total:' + (<?=$total ?> - point) + '円</p>');
              $('#hid_total').attr('value',<?=$total ?> - point);
            } else {
              if(point >= 0){
                alert("pointが足りません");
              }else{
                alert("正しく入力してください");
              }
              $('#point').val(0);
            }
          });
        });
      </script>

    </div>

    <footer>

    </footer>
  </div>
</body>

</html>