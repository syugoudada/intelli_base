<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../Css/passwordChange.css">
  <link rel="icon" type="image/png" href="../image/icon.png">
  <title>Document</title>
</head>

<body>

  <header>
    header
  </header>

  <main>
    <div class="passwordChangeForm">
      <form action="password_change.php" method="POST">
        <h1>パスワード変更</h1>
        <span><strong>古いパスワード</strong></span><br><input type="password" name="oldpass" class="input_form" required><br>
        <span><strong>新しいパスワード</strong></span><br><input type="password" name="newpass" class="input_form" required><br>
        <input type="submit" name="submit" class="changeButton" value="変更">
      </form>
    </div>
  </main>

  <footer>
    footer
  </footer>
</body>

</html>