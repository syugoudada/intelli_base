<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['share_key'])) {
        $share_key = $_POST['share_key'];
    } else if (isset($_GET['share_key'])) {
        $share_key = $_GET['share_key'];
    } else {
        $share_key = "601d15c7a4998";
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->select('SELECT id, account_id, book_id, local_writing_id, local_writing_title FROM writings WHERE share_key = ?', [$share_key]);
    if (!$value) {
        $response['error'] = true;
        $response['message'] = 'Statement error on select';
        $response['content'] = [];
    } else {
        $response['content'][0] = [
            'writing_id' => $value[0]['id'],
            'account_id' => $value[0]['account_id'],
            'book_id' => $value[0]['book_id'],
            'local_writing_id' => $value[0]['local_writing_id'],
            'local_writing_title' => $value[0]['local_writing_title'],
        ];
    }
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
