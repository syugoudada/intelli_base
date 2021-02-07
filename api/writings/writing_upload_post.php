<?php
// $data['error'] = false;
// $data['content'] = [$_POST];

// echo json_encode($data);

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $response['error'] = false;
    $response['message'] = '承認';

    if (!empty($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {

        // ファイルを指定したパスへ保存する
        if (move_uploaded_file($_FILES['file']['tmp_name'], "../../uploadedData/writing/{$_FILES['file']['name']}")) {
            $response['content'] = 'アップロードされたファイルを保存しました。';
        } else {
            $response['content'] = 'アップロードされたファイルの保存に失敗しました。';
        }
    }
}

echo json_encode($response);
