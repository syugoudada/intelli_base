<?php
session_start();
if ($_SESSION['product']['message'] != "") {
  $message = $_SESSION['product']['message'];
  print("<script>alert('$message')</script>");
  unset($_SESSION['product']['message']);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../image/icon.png">
  <link rel="stylesheet" href="../Css/register.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Intelli_Base</title>
</head>

<body>
  <label class="all_body"></label>
  <header>
    <div class="header_contents">
      <div class="icon">
      <a href="../Top_Page/top_page.php" class="topBack">
        <img src="../image/icon.png" width="50px" height="50px">
        <p class="iconTitle">Intelli_Base</p>
      </a>
      </div>
      <form action="../Search/search.php" method="GET">
        <div class="search">
          <input type="text" id="search_bar" name="title" placeholder="検索">
          <input type="submit" id="submit" value="🔍">
        </div>
      </form>
      <nav class="login_tag">
        <a href="../Login/login_form.php">こんにちは、ログイン</a>
        <ul class="userContents">
          <li><a href="../Password_Change/change.php">パスワード変更</a></li>
          <li><a href="../Product_Register/Register.php">商品登録</a></li>
          <li><a href="../Login/logout.php">ログアウト</a></li>
        </ul>
      </nav>
      <script>
        function login_name(name) {
          $('.login_tag').children('a').html("<a  class='userName' id='userName' href='#'>" + name + "さんようこそ</a>");
        }
      </script>

      <?php
      if ($_SESSION["account"]["name"] != "" && isset($_SESSION["account"]["name"])) {
        $name = $_SESSION["account"]["name"];
        print("<script>$(function(){login_name('$name');});</script>");
      }
      ?>

      <div id="cart_tag">
        <a class="cart_a" href="../Cart/Cart.php">カート</a>
      </div>
    </div>
  </header>

  <main>
    <div class="mainContents">
      <h1>
        <商品登録>
      </h1>
      <form method="POST" enctype="multipart/form-data" action="register_service.php">
        タイトル:<input type="text" name="title" required>
        著者名:<input type="text" name="name" required><br>
        <span>説明:</span><textarea style="resize:none" name="description"></textarea>
        <div class="register">
          ジャンル:<select name="genre" id="genre" required>
            <?php
            require_once('../Repository/Product_Registration_Repository.php');
            require_once('../Repository/db_config.php');
            $myself = new Product_Registration_Repository(DB_USER, DB_PASS);
            $myself->login();
            $genre = $myself->genre();
            foreach ($genre as $value) {
              print("<option value='$value[id]'>$value[name]</option>");
            }
            ?>
          </select>
          <script>
            function ajax(sub_genre) {
              $.ajax({
                type: 'POST',
                url: 'sub_genre.php',
                data: sub_genre,
                dataType: 'json',
                success: function(msg) {
                  $('select#sub_genre option').remove();
                  $.each(msg, function(index, value) {
                    $('#sub_genre').append("<option value='" + value['id'] + "'>" + value['name'] + "</option>");
                  });
                  $('#sub_genre').append("<option value='add'>新規追加</option>");
                }
              });
            }

            $(function() {
              //一つ目のジャンル選択後button有効化
              $('#genre').change(function() {
                $(".new_genre").hide().val("");
              });

              $('#sub_genre').change(function() {
                if ($(this).val() == "add") {
                  $('.new_genre').show();
                } else {
                  $('.new_genre').hide();
                }
              });

              $('#genre').change(function() {
                sub_genre = {
                  'sub_id': $('#genre').val()
                };
                ajax(sub_genre);
              });
            });
          </script>
          <select name="sub_genre" id="sub_genre" class="sub_genre">
            <?php
            $genre = $myself->sub_genre(1);
            foreach ($genre as $value) {
              print("<option value='$value[id]'>$value[name]</option>");
            }
            ?>
            <option value='add'>新規追加</option>
          </select>
          <input type="text" class="new_genre" name="new_genre" placeholder="新規登録してください" hidden>
          <br>
        </div>
        価格:<input type="text" name="price" required><br>
        引用:<input type="text" name="url"><br>
        PDF:<input type="file" name="pdf" accept=".pdf" required>
        画像:<input type="file" name="image" accept="image/*" required>
        <input type="submit" name="submit" value="Upload" />
      </form>
    </div>
  </main>

  <footer>
  </footer>
</body>

</html>