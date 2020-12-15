<?php
session_start();
require_once("../Repository/Purchase_Repository.php");
require_once("../Repository/db_config.php");
$myself = new Purchase_Repository(DB_USER,DB_PASS);
$myself->login();
// $kago = array('この音とまれ!');
// $user = $_SESSION['user'];
// $user = [];
// if (isset($_POST['kago']) and $_POST != "") {
// if (isset($kago) and $kago != "") {
//   #purchase綴り間違い
//   foreach ($kago as $value) {
//     $myself->value = $value;
//     $user = $myself->find($user);
//     if ($myself->save($user)) {
//       print("購入しました");
//     } else {
//       print("失敗");
//     }
//   }

