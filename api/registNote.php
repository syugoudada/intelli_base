<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['account_id']) && isset($_POST['local_id']) && isset($_POST['book_id']) && isset($_POST['title'])) {
        $accountId = $_POST['account_id'];
        $localId = $_POST['local_id'];
        $bookId = $_POST['book_id'];
        $title = $_POST['title'];
    } else if (isset($_GET['account_id']) && isset($_GET['local_id']) && isset($_GET['book_id']) && isset($_GET['title'])) {
        $accountId = $_GET['account_id'];
        $localId = $_GET['local_id'];
        $bookId = $_GET['book_id'];
        $title = $_GET['title'];
    } else {
        $accountId = 0;
        $localId = 0;
        $bookId = 0;
        $title = 'sample title';
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    $noteId = $db->registNote($accountId, $localId, $bookId, $title);
    $response['content'] = $noteId;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
