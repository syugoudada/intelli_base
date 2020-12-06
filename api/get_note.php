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
        $id = 0;
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    // DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    // 共有されているか確認
    $share = $db->select('SELECT share FROM note WHERE id = ?', array($id));
    if (!$share) {
        $response['error'] = true;
        $response['message'] = 'Statement error.';
    } else if ($share[0]['share']) {
        $value = $db->select('SELECT id, account_id, book_id FROM note WHERE id = ?', array($id));
        if (!$value) {
            $response['error'] = true;
            $response['message'] = 'Statement error.';
        }
    } else {
        $value = false;
        $response['message'] = 'Enterd noteId does not exist.';
    }
    $response['content'] = $value;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
