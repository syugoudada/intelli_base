<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規会員登録</title>
</head>

<body>
  <h1>新規会員登録</h1>
  <form action="register.php" method="POST">

    <div>
      <label for="email">mail
        <input type="text" name="email" required>
      </label>
    </div>


    <div>
      <label for="name">name
        <input type="text" name="name" required>
      </label>
    </div>

    <div>
      <label for="password">パスワード
        <input type="password" name="password" required>
      </label>
    </div>

    <div>
      <label for="confirm">再確認
        <input type="password" name="confirm" required>
      </label>
    </div>

    </div>
    <button type="submit" name="register">新規登録</button>
  </form>
  <p>既に登録済みの人は<a href="login_form.php">こちら</a></p>
</body>

</html>