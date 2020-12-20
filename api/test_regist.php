<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['id'];
    $userName = $_POST['user'];
    $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);

    require_once('../includes/DbOperation.php');
    $db = new DbOparation();

    $res = $db->select('SELECT user_id FROM accounts WHERE id = ?', array($userId));
    if (count($res) == 0) {
        $flg = $db->insert('INSERT INTO accounts (user_id, user_name, password) VALUES (?, ?, ?)', array($userId, $userName, $password));
        var_dump(array($userId, $userName, $password));
        if (!$flg) {
            print 'Error at insert.';
        } else {
            print 'success!';
        }
    } else {
        print 'Entered UserID already used.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
</head>

<body>
    <form action="" method="post">
        ID：<input type="text" name="id"><br>
        ユーザ名：<input type="text" name="user"><br>
        パスワード：<input type="password" name="pass"><br>
        <input type="submit" value="登録">
    </form>
</body>

</html>