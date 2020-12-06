<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['already_get'])) {
        $alreadyGet = $_POST['already_get'];
    } else if (isset($_GET['test'])) {
        $alreadyGet = 0;
        if (isset($_GET['already_get'])) {
            $alreadyGet = $_GET['already_get'];
        }
    } else {
        $alreadyGet = 0;
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->getCategories($alreadyGet);
    $response['content'] = $value;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
