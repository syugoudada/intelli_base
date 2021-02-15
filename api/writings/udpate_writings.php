<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['account_id']) && isset($_POST['local_writing_id'])) {
        $account_id = $_POST['account_id'];
        $local_writing_id = $_POST['local_writing_id'];
    } else if (isset($_GET['account_id']) && isset($_GET['local_writing_id'])) {
        $account_id = $_GET['account_id'];
        $local_writing_id = $_GET['local_writing_id'];
    } else {
        $account_id = 518;
        $local_writing_id = 1;
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->select('SELECT id FROM writings WHERE account_id = ? AND local_writing_id = ?', [$account_id, $local_writing_id]);
    if (!$value) {
        $response['error'] = true;
        $response['message'] = 'Statement error on select';
    } else {
        // id
        $writing_id = $value[0]['id'];
        // 日付
        $dateInt = (new DateTime())->format('YmdHis'); //-> yyyymmddhhiiss
        var_dump([$dateInt, $writing_id]);
        if (!$db->insert('UPDATE writings SET update_date = ? WHERE id = ?', [$dateInt, $writing_id])) {
            $response['error'] = true;
            $response['message'] = 'Statement error on update';
        }
    }

    $response['content'][0] = ['status' => !$response['error']];
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
