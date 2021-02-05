<?php

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_GET['test'])) {

    $response['error'] = false;
    $response['message'] = '承認';

    //値の取得
    if (isset($_POST['account_id']) && isset($_POST['local_writing_id']) && isset($_POST['book_id'])) {
        $account_id = $_POST['account_id'];
        $local_writing_id = $_POST['local_writing_id'];
        $book_id = $_POST['book_id'];
    } else if (isset($_GET['account_id']) && isset($_GET['local_writing_id']) && isset($_GET['book_id'])) {
        $account_id = $_GET['account_id'];
        $local_writing_id = $_GET['local_writing_id'];
        $book_id = $_GET['book_id'];
    } else {
        $account_id = 518;
        $local_writing_id = 1;
        $book_id = 260;
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    //DBファイルの操作
    require_once '../../includes/DbOperation.php';
    $db = new DbOparation();

    $value = $db->select('SELECT id FROM writings WHERE account_id = ? AND book_id = ? AND local_writing_id = ?', [$account_id, $book_id, $local_writing_id]);
    $new_share_key = "";
    if (!$value) {
        // 未登録の書き込みの場合
        // 新規共有キーの生成
        do {
            $new_share_key = uniqid();
        } while (is_array($db->select('SELECT share_key FROM writings WHERE share_key = ?', [$new_share_key])) && count($db->select('SELECT share_key FROM writings WHERE share_key = ?', [$new_share_key])) != 0);
        // 日付
        $dateInt = (new DateTime())->format('YmdHis'); //-> yyyymmddhhiiss
        // Insert
        if (!$db->insert('INSERT INTO writings (`account_id`, `book_id`, `local_writing_id`, `update_date`, `share_key`) VALUES (?, ?, ?, ?, ?)', [$account_id, $book_id, $local_writing_id, $dateInt, $new_share_key])) {
            // insert error
            $response['error'] = true;
            $response['messgae'] = 'Stetement error';
        }
    } else {
        if (count($value) == 1) {
            // 登録済みの場合
            $writing_id = $value[0]['id'];
            // 共有キーの再生成
            do {
                $new_share_key = uniqid();
            } while (is_array($db->select('SELECT share_key FROM writings WHERE share_key = ?', [$new_share_key])) && count($db->select('SELECT share_key FROM writings WHERE share_key = ?', [$new_share_key])) != 0);
            // 日付
            $dateInt = (new DateTime())->format('YmdHis'); //-> yyyymmddhhiiss
            // update
            if (!$db->insert('UPDATE writings SET update_date = ?, share_key = ? WHERE id = ?', [$dateInt, $new_share_key, $writing_id])) {
                // insert error
                $response['error'] = true;
                $response['messgae'] = 'Stetement error';
            }
        } else {
            $response['error'] = true;
            $response['messgae'] = 'writingsテーブルの整合性が保たれていません';
        }
    }
    $response['content'] = ['share_key' => $new_share_key];
} else {
    $response['error'] = true;
    $response['messgae'] = 'あなたは承認されていません';
}

echo json_encode($response);
