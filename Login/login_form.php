<?php
  session_start();
  if(isset($_SESSION['user'])){
    unset($_SESSION);
  }
  //ページ分けで使う
  var_dump($_SERVER['HTTP_REFERER']);
?>

<html lang="ja">
  <head></head>
  <body>
    <h1>ログインページ</h1>
    <form action="login.php" method="POST">
      <div>
        <label for="user">ユーザー
          <input type="text" name="user" value="<?php
            if(isset($_COOKIE['user']) && $_COOKIE['user'] !== ""){
              print($_COOKIE['user']);
            }
          ?>"required>
        </label>
      </div>

      <div>
        <label for="pass">パスワード
          <input type="password" name="password" required>
        </lable>
      </div>

      <p>
        
      </p>
      <div>
        <button type="submit">Login</button>
      </div>

      <a href="sign_up.php">新規登録</a>

    </form>
  </body>
</html>