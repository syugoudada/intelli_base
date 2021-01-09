<?php
    session_start();
    //カートリポジトリを呼び出し
    require_once('../Repository/Cart_Repository.php');
    require_once('../Repository/db_config.php');
    $myself = new Cart_Repository(DB_USER,DB_PASS);
    $myself->login();
    $flag = true;

    //accountが存在するか検証
    if(!empty($_SESSION['account']['id'])){
        $account_id = $_SESSION['account']['id'];
        $cart = $myself->find_cart($account_id);
        $cart_items = array();
        if($cart[0]["cart_json"] != "{}"){
            $book_id = json_decode($cart[0]['cart_json'],true);
            for($i=0;$i < count($book_id); $i++){    
                array_push($cart_items,array("id"=>$book_id[$i]["id"]));
            }
        }
        //cartに同一の値があるか
        foreach($cart_items as $value){
            if($_POST["book_id"] == $value["id"]){
                $flag = false;
            }
        }
        if($flag){
            array_push($cart_items,array("id"=>$_POST["book_id"]));
        }
        $json_cart = json_encode($cart_items);
        //カートに追加
        if($myself->updateCartJson($account_id, $json_cart)){
            header('Location:Cart.php');
        }
    }else{
        //セッションにカートを持たす
        if(empty($_SESSION["cart"])){
            $_SESSION["cart"] = array();
        }
        //同一商品の検証
        if(!in_array($_POST["book_id"],$_SESSION["cart"])){
            array_push($_SESSION["cart"],$_POST["book_id"]);
        }
        header('Location:Cart.php');
    }