<?php
session_start();
?>
<html lang="ja">

<head>
  <title>ログインフォーム</title>
  <link rel="stylesheet" href="../Css/login_form.css">
  <link rel="icon" type="image/png" href="../image/icon.png">
</head>

<body>
  <header>
  
  </header>

  <main>
    <form action="login.php" method="POST">
      <div class="login-Info">
        <div class="loginForm">
          <h1>ログイン</h1>
          <div class="email-form">
            <label for="email"><strong>ユーザー</strong><br>
              <input type="text" name="email" class="user-input input_form" value="<?php
          if (isset($_COOKIE['email']) && $_COOKIE['email'] !== "") {
            print($_COOKIE['email']);
          }
          ?>" style="text-align:left" required>
            </label>
          </div>

          <div class="password">
            <label for="pass"><strong>パスワード</strong><br>
              <input type="password" name="pass" class="pass-input input_form" required>
              </lable>
          </div>

          <?= print("<input type='hidden' name='http' value='$_SERVER[HTTP_REFERER]'"); ?>
          <div>
            <button type="submit" class="login-Button">Login</button>
          </div>

          <div class="a-divider">
            intelli_baseは初めてご利用ですか？
          </div>

          <span class="a-button-inner">
            <a href="sign_up.php" class="createAccountSubmit" role="button">intelli_baseアカウントを作成する</a>
          </span>
        </div>
      </div>
    </form>
  </main>


  <footer>
    
  </footer>
</body>

</html>