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

    // Check accountId and bookId.
    if (!$db->select('SELECT id FROM accounts WHERE account = ?', [$accountId]) || !$db->select('SELECT id FROM book WHERE id = ?', [$bookId])) {
        // If entered accountId or bookId does not exist.
        $response['error'] = true;
        $response['message'] = 'Invalid accountId entered.';
        $res = false;
    } else {
        $flg = $db->insert('INSERT INTO notes (account_id, local_id, book_id, title, shared) values (?,?,?,?,?)', array($accountId, $localId, $bookId, $title, true));
        if (!$flg) {
            // If cannot execute statement.
            $res = false;
            $response['error'] = true;
            $response['message'] = 'Statement error.';
        }
        $rse = $db->select('SELECT id FORM notes WHERE account_id = ? AND local_id = ?', array($accountId, $localId));
    }

    // inserted noteId | false
    $response['content'] = $res;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
