<?php
session_start();
if($_SESSION["message"] != ""){
  print("<script>alert('$_SESSION[message]');</script>");
  unset($_SESSION["message"]);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Css/sign_up.css">
  <link rel="icon" type="image/png" href="../image/icon.png">
  <title>Intelli_Base</title>
</head>

<body>
  <header>
  </header>

  <main>
    <div class="registerForm">
      <h1>アカウントを作成</h1>
      <form action="register.php" method="POST">

        <div>
          <label for="email"><strong>メール</strong><br>
            <input type="text" name="email" class="email input_form" required>
          </label>
        </div>

        <div>
          <label for="name"><strong>名前</strong><br>
            <input type="text" name="name" class="name input_form"required>
          </label>
        </div>

        <div>
          <label for="password"><strong>パスワード</strong><br>
            <input type="password" name="password" class="password input_form" required>
          </label>
        </div>

        <div>
          <label for="confirm"><strong>もう一度パスワードを入力してください</strong><br>
            <input type="password" name="confirm" class="confirm input_form" required>
          </label>
        </div>
        <button type="submit" name="register" class="make-Account">Intelli_Baseアカウントを作成する</button>
      </form>
      <p>既に登録済みの人は<a href="login_form.php">こちら</a></p>
    </div>
  </main>

  <footer>
  </footer>
</body>

</html>