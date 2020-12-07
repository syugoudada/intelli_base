<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $alreadyGet = 0;
        if (isset($_POST['already_get'])) {
            $alreadyGet = $_POST['already_get'];
        }
    } else if (isset($_GET['id'])) {
        $response['mode'] = 'debug';
        $id = $_GET['id'];
        $alreadyGet = 0;
        if (isset($_GET['already_get'])) {
            $alreadyGet = $_GET['already_get'];
        }
    } else {
        $id = 0;
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->select(
        'SELECT purchase.id, book.id, book.name, author.id, author.name FROM purchase, product book, author 
        WHERE product_id = book.id AND author.id = author_id AND account_id = ? AND purchase.id > ?',
        array($userId, $already_get)
    );
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
