<?php
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
  <title>intelli_base</title>
</head>

<body>
  <header>
    <div class="header_contents">
      <div class="serach_bar">
        <input type="text" id="search_bar" placeholder="入力してください">
        <input type="submit" id="submit" name="submit" value="ボタン">
      </div>
      <div class="user_tag">
        <div class="login_tag">
          <a href="../Login/login_form.php">こんにちは、ログイン</a></form>
        </div>
        <div id="cart_tag">
          <a href="#">カート</a>
        </div>
      </div>
    </div>
    </div>
  </header>

  <div class="contents">
    <div class="main_contents">
      <div class="genre">
        <ul>
        <?php
          foreach($genre as $value){
            print("<li value='$value[id]'><a href='#'>$value[name]</a></li>");
          }
        ?>
        </ul>
      </div>
      <div class="book_contents">
          
      </div>
    </div>
  </div>

  <footer>
    <div class="footer_contents">

    </div>
  </footer>

</body>

</html>