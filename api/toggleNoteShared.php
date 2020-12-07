<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $shared = null;
        if (isset($_POST['shared'])) {
            $shared = $_POST['shared'];
        }
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $shared = null;
        if (isset($_GET['shared'])) {
            $shared = $_GET['shared'];
        }
    } else {
        $id = 0;
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    // 公開設定の指定があるかどうか
    if ($shared != null) {
        // 指定された設定に変更
        $flg = $this->insert('UPDATE note SET shared = ? WHERE id = ?', array($shared, $noteId));
    } else {
        // 指定がなければトグル
        $flg = $this->insert('UPDATE note SET shared = !shared WHERE id = ?', array($noteId));
    }
    if (!$flg) {
        $response['error'] = true;
        $response['message'] = 'Statement error.';
    }
    $response['content'] = $flg;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
