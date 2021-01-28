<?php
  session_start();
  require_once("../Repository/Account_Repository.php");
  require_once('../Repository/db_config.php');
  header('charset=UTF-8');
  $myself = new Account(DB_USER,DB_PASS);
  $myself-> login();
  $email = $_POST['email'];
  $flag = false;
  if($myself->exist($email)){
    if($myself->password_resach($_POST)){
      $account = $myself->find($email);
      $_SESSION["account"]["id"] = $account[0]["id"];
      $_SESSION["account"]["name"] = $account[0]['name'];
      //Cartからのログイン
      if($_POST['http'] == "http://localhost/intelli_base/Cart/Cart.php"){
        $cart_json = $myself->find_cart($account[0]["id"]);
        $cart_now = json_decode($cart_json[0]["cart_json"],true); 
        //同一判定(無ければ追加)
        if(!empty($cart_now)){
          foreach($_SESSION["cart"] as $value){
            foreach($cart_now as $item){
              if($value == $item["id"]){
                $flag = true;
              }
            }
            if(!$flag){
              array_push($cart_now,array("id"=>$value));
            }
            $flag = false;
          }
        }else{
          foreach($_SESSION["cart"] as $value){
            array_push($cart_now,array("id"=>$value));
          }
        }
        $json_cart = json_encode($cart_now);
        $myself->updateCartJson($account[0]["id"],$json_cart);
        unset($_SESSION["cart"]);
        header('Location:../Cart/Cart.php');
      }else{
        header('Location:../Top_Page/top_page.php');
      }
    }else{
      $_SESSION['message'] = "パスワードが違います";
      print("<script>history.back();</script>");
    }
  }else{
    $_SESSION['message'] = "ユーザが登録されていません";
    print("<script>history.back();</script>");
  }
?>