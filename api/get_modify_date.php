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
        $id = 1;
        $type = "password";
        $response['error'] = true;
        $response['message'] = 'post parameter error';
    }

    // switch ($type) {
    //     case 'book':
    //         $table = "books";
    //         $columnName = "book_data_modification_datetime";
    //         break;

    //     case 'thumbnail':
    //         $table = "books";
    //         $columnName = "thumbnail_data_modification_datetime";
    //         break;

    //     case 'note':
    //         $table = "notes";
    //         $columnName = "data_modification_datetime";
    //         break;

    //     case 'password':
    //         $table = "accounts";
    //         $columnName = "password_modification_datetime";
    //         break;

    //     default:
    //         $table = "books";
    //         $columnName = "book_data_modification_datetime";
    //         break;
    // }

    //DBファイルの操作
    require_once '../includes/DbOperation.php';
    $db = new DbOparation();

    // print "SELECT DATE_FORMAT($columnName, '%Y%m%d%h%m%s') as datetime FROM $table WHERE id = $id";
    // print '<br>';

    switch ($type) {
        case 'book':
            $value = $db->select(
                "SELECT DATE_FORMAT(book_data_modification_datetime, '%Y%m%d%h%m%s') as datetime FROM books WHERE id = $id"
            );
            break;

        case 'note':
            $value = $db->select(
                "SELECT DATE_FORMAT(note_modification_datetime, '%Y%m%d%h%m%s') as datetime FROM books WHERE id = $id"
            );
            break;

        case 'thumbnail':
            $value = $db->select(
                "SELECT DATE_FORMAT(thumbnail_data_modification_datetime, '%Y%m%d%h%m%s') as datetime FROM books WHERE id = $id"
            );
            break;

        case 'password':
            $value = $db->select(
                "SELECT DATE_FORMAT(password_modification_datetime, '%Y%m%d%h%m%s') as datetime FROM accounts WHERE id = $id"
            );
            break;

        default:
            $value = $db->select(
                "SELECT DATE_FORMAT(book_data_modification_datetime, '%Y%m%d%h%m%s') as datetime FROM books WHERE id = $id"
            );
            break;
    }

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
