<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['id']) && isset($_POST['pass'])) {
        $id = $_POST['id'];
        $pass = $_POST['pass'];
    } else if (isset($_GET['id']) && isset($_GET['pass'])) {
        $id = $_GET['id'];
        $pass = $_GET['pass'];
    } else {
        $id = 'test';
        $pass = 'testpass';
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();
    $value = $db->select('SELECT password FROM account WHERE id = ?', array($id));

    if (count($value) != 1) {
        $content = [array('verify' => false)];
    } else {
        $content = [array('verify' => password_verify($pass, $value[0]['password']))];
    }
    $response['content'] = $content;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
