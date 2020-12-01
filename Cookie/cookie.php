<?php
//cookie登録
if (isset($_COOKIE["search"]) && $_COOKIE["search"] != null) {
  $search = unserialize($_COOKIE["search"]);
  if (!in_array($_POST["search"], $search)) {
    array_unshift($search, $_POST["search"]);
  }
} else {
  $search = array($_POST['search']);
}
//配列をcookieに登録
setcookie("search", serialize($search), time() + 360);
//js形式にエンコード
$js_array_encode = json_encode($search);
?>

<script>
  let array_js = <?php echo $js_array_encode ?>;
  array_js.forEach(element => {
    console.log(element);
  });
</script>