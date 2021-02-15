<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['share_id'])) {
        $share_id = $_POST['share_id'];
    } else if (isset($_GET['share_id'])) {
        $share_id = $_GET['share_id'];
    } else {
        $share_id = "32";
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //IDから書き込みデータのファイルを検索してページ数を取得
    $result = [];
    $command = "find ../../uploadedData/writing -name 'writing{$share_id}_page*' | wc -l";
    exec($command, $result);

    $response['content'][0]['page_count'] = $result[0];
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
