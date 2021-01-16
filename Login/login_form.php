<?php
  session_start();
?>
<html lang="ja">
  <head>
    <title>ログインフォーム</title>
  </head>
  <body>
    <h1>ログインページ</h1>
    <form action="login.php" method="POST">
      <div>
        <label for="email">ユーザー
          <input type="text" name="email" value="<?php
            if(isset($_COOKIE['email']) && $_COOKIE['email'] !== ""){
              print($_COOKIE['email']);
            }
          ?>"required>
        </label>
      </div>

      <div>
        <label for="pass">パスワード
          <input type="pass" name="pass" required>
        </lable>
      </div>

      <?= print("<input type='hidden' name='http' value='$_SERVER[HTTP_REFERER]'"); ?>
      <div>
        <button type="submit">Login</button>
      </div>

      <a href="sign_up.php">新規登録</a>
    </form>
  </body>
</html>