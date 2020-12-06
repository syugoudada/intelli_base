<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->getCategory();
    $response['error'] = false;
    $response['message'] = '承認';
    $response['content'] = $value;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
