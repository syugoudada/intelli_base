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

    $shared_writing_id = $db->select('SELECT id FROM writings WHERE share_key = ?', [$share_key]);

    if (!$db->insert('DELETE FROM writings WHERE share_key = ?', [$share_key]) && is_bool($shared_writing_id)) {
        $response['error'] = true;
        $response['message'] = 'Statement error on delete';
    } else {
        $response['content'][0] = ['status' => true];

        $fileName = "../../uploadedData/writing/writing{$shared_writing_id[0]['id']}_*";

        //アップロードされたファイルを削除する
        foreach (glob($fileName) as $file) {
            unlink($file);
        }
    }
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
