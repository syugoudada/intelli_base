<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 1;
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->select('SELECT id, name, parent_id FROM genres WHERE id = ?', array($id));
    if (!$value) {
        $response['error'] = true;
        $response['message'] = 'Statement error.';
    }
    $response['content'] = $value;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
