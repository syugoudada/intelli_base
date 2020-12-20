<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['email']) && isset($_POST['pass'])) {
        $email = $_POST['email'];
        $pass = $_POST['pass'];
    } else if (isset($_GET['email']) && isset($_GET['pass'])) {
        $email = $_GET['email'];
        $pass = $_GET['pass'];
    } else {
        $email = 'lavon36@hotmail.com';
        $pass = 'testpass';
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();
    $value = $db->select('SELECT id, password, name FROM accounts WHERE email = ?', array($email));

    if (count($value) != 1) {
        $content = [array('verify' => false)];
    } else {
        $content = [
            array(
                'verify' => password_verify($pass, $value[0]['password']),
                'id' => $value[0]['id'],
                'name' => $value[0]['name']
            )
        ];
    }
    $response['content'] = $content;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
