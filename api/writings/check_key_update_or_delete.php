<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['account_id']) && isset($_POST['local_writing_id']) && isset($_POST['book_id']) && isset($_POST['share_key'])) {
        $account_id = $_POST['account_id'];
        $local_writing_id = $_POST['local_writing_id'];
        $book_id = $_POST['book_id'];
        $share_key = $_POST['share_key'];
    } else if (isset($_GET['account_id']) && isset($_GET['local_writing_id']) && isset($_GET['book_id']) && isset($_GET['share_key'])) {
        $account_id = $_GET['account_id'];
        $local_writing_id = $_GET['local_writing_id'];
        $book_id = $_GET['book_id'];
        $share_key = $_GET['share_key'];
    } else {
        $account_id = 518;
        $local_writing_id = 1;
        $book_id = 260;
        $share_key = '';
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->select('SELECT id, account_id, local_writing_id, book_id FROM writings WHERE share_key = ?', [$share_key]);
    if (!$value) {
        // 一致する共有キーがなかった場合
        if (!$db->select('SELECT id FROM writings WHERE account_id = ? AND local_writing_id = ? AND book_id = ?', [$account_id, $local_writing_id, $book_id])) {
            // 共有キーと日付情報意外が一致するデータが無い
            $response['content'] = ['status' => 'shareRejected'];
        } else {
            // 共有キーと日付情報意外が一致するデータが有る（共有キーがアップデートされた）
            $response['content'] = ['status' => 'keyChanged'];
        }
    } else {
        // 共有キーが一致するデータの内容が
        if ($value[0]['account_id'] == $account_id && $value[0]['local_writing_id'] == $local_writing_id && $value[0]['book_id'] == $book_id) {
            // 一致
            $response['content'] = ['status' => 'noChange'];
        } else {
            // 不一致
            $response['content'] = ['status' => 'shareRejected'];
        }
    }
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
