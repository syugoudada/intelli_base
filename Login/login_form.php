<?php
  session_start();
  if(isset($_SESSION['user'])){
    unset($_SESSION);
  }
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
          <input type="password" name="pass" required>
        </lable>
      </div>

      <p>
        <?php 
          if (isset($_SESSION['message']) && $_SESSION['message'] != ""){ 
          echo $_SESSION['message'] ;
        }?>
        </p>
      <div>
        <button type="submit">Login</button>
      </div>
    </form>
  </body>
</html>