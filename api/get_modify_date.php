<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['id']) && isset($_POST['type'])) {
        $id = $_POST['id'];
        $type = $_POST['type'];
    } else if (isset($_GET['id']) && isset($_GET['type'])) {
        $id = $_GET['id'];
        $type = $_GET['type'];
    } else {
        $id = 0;
        $type = "book";
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    switch ($type) {
        case 'book':
            $table = "product";
            break;

        case 'thumbnail':
            $table = "product";
            break;

        case 'note':
            $table = "note";
            break;

        default:
            $table = "product";
            break;
    }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->select('SELECT FORMAT(modification_datetime , \'yyyyMMddHHmmss\') as datetime FROM ? WHERE id = ?', array($table, $id));
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
