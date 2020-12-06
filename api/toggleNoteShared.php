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

    $flg = $db->toggleNoteShared($id, $shared);
    $response['content'] = $flg;
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
