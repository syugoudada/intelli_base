<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div>
    <h1>パスワード変更</h1>
    <form action="password_change.php" method="POST">
      旧:<input type="password" name = "oldpass" required><br>
      新:<input type="password" name = "newpass" required>
      <input type="submit" name="submit" value="変更">
    </form>
  </div>
</body>
</html>

