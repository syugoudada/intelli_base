<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['update_date']) && isset($_POST['share_key'])) {
        $update_date = $_POST['update_date'];
        $share_key = $_POST['share_key'];
    } else if (isset($_GET['update_date']) && isset($_GET['share_key'])) {
        $update_date = $_GET['update_date'];
        $share_key = $_GET['share_key'];
    } else {
        $update_date = 20210205095937;
        $share_key = "601d15c7a4998";
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->select('SELECT update_date FROM writings WHERE share_key = ?', [$share_key]);
    if (!$value) {
        $response['error'] = true;
        $response['message'] = 'Statement error on select';
    } else {
        if ($update_date < $value[0]['update_date']) {
            $response['content'][0] = ['updated' => true];
        } else {
            $response['content'][0] = ['updated' => false];
        }
    }
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
