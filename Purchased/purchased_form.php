<?php
session_start();
require_once("../Repository/db_config.php");
require_once("../Repository/Purchase_Repository.php");

if (!isset($_SESSION['account']['id']) && $_SESSION['account']['id'] == "") {
  header('Location:../Login/login_form.php');
}

//cart情報を受け取る
$cart_items = array();
foreach ($_POST as $value) {
  array_push($cart_items, $value);
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
  <link rel="icon" type="image/png" href="../image/icon.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>intelli_base</title>
</head>

<body>
  <header>
    <div class="header_contents">
      <div class="icon">
        <img src="../image/method.png" width="700px" height="120px">
      </div>
    </div>
  </header>

  <main>
    <form action="purchased.php" method="POST">
      <div class="paymentForm">
        <div class="">
          <p>お支払方法</p>
          <img src="../image/payment.jpg" width="30px" height="30px">1075で終わる
          <p>請求先</p>
          <p>登録されたメールに案内</p>
        </div>
        <div class="purchase_method">
          <?php
          $point = $myself->point($_SESSION['account']['id']);
          $point = $point[0]['point'];
          print("<p>現在のポイント:$point</p>");
          ?>
          ポイント:<input type="number" id="point" name="point" value="0">
        </div>
      </div>
      <div class="book_contents">
        <div class='book_items'>
          <?php
          foreach ($cart_items as $index => $value) {
            $item = $myself->book_find($value);
            foreach ($item as $value) {
              $total += $value['price'];
              print("<div class='book_list'><img src='../uploadedData/thumbnail/thumbnail$value[id].png' width='100px' height='120px'><div class='bookInfo'><p>$value[title]</p><p>$value[price]円</p></div><input type='text' name='id$index' value = '$value[id]' hidden></div>");
            }
          }
          
          ?>
        </div>
        <div class="total_price">
          <input type="submit" name="submit" class="purchaseButton" value="購入します">
          <?php
          print("<p>小計:$total 円</p><p id='chose_point'>消費ポイント:0pt</p><p id='total'>合計:$total 円</p><input type='text' name='total' value = '$total' id='hid_total' hidden>");
          if(isset($_SESSION['account']['id']) && $_SESSION['account']['id'] != ""){
            $_SESSION["sendTotal"] = $total;
          }
          ?>
          <aside>
            intelli_baseの利用規約、プライバシーに関するお知らせ、商品の詳細ページとキャンペーンページに記載されているその他の販売条件、同意した上で商品を注文できます。料金と注文の合計。
          </aside>
        </div>
      </div>
    </form>
  </main>

  <script>
    $(function() {
      $('#point').change(function() {
        let point = $('#point').val();
        if (isFinite(point) && point >= 0 && point <= <?= $point ?>) {
          $('#chose_point').html('<p>消費ポイント:' + point + 'pt</p>');
          $('#total').html('<p>合計:' + (<?= $total ?> - point) + '円</p>');
          $('#hid_total').attr('value', <?= $total ?> - point);
        } else {
          if (point >= 0) {
            alert("pointが足りません");
          } else {
            alert("正しく入力してください");
          }
          $('#point').val(0);
        }
      });
    });
  </script>
  <footer>

  </footer>
</body>

</html>