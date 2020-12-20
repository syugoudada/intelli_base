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

    // print "SELECT books.title, books.author_id, books.genre_id FROM books, purchases WHERE books.id = purchases.book_id AND purchases.account_id = $id AND purchases.id > $alreadyGet <br>";

    $value = $db->select(
        'SELECT books.id, books.title, books.author_id, books.genre_id FROM books, purchases WHERE books.id = purchases.book_id AND purchases.account_id = ? AND purchases.id > ?',
        array($id, $alreadyGet)
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
