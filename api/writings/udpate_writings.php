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
        $share_key = 518;
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../../includes/DbOperation.php';
    $db = new DbOparation();

    // 日付
    $dateInt = (new DateTime())->format('YmdHis'); //-> yyyymmddhhiiss
    // var_dump([$dateInt, $writing_id]);
    if (!$db->insert('UPDATE writings SET update_date = ? WHERE share_key = ?', [$dateInt, $share_key])) {
        $response['error'] = true;
        $response['message'] = 'Statement error on update';
    }

    $response['content'][0] = ['status' => !$response['error']];
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
