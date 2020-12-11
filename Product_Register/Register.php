<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
  <title>Document</title>
</head>

<body>
  <div>
    <form method="POST" enctype="multipart/form-data" action="register_service.php">
      タイトル:<input type="text" name="title" required>
      著者名:<input type="text" name="name" required><br>
      説明:<textarea style="resize:none" name="description"></textarea>
      <div class="register">
        ジャンル:<select name="genre" id="genre" required>
          <?php
          require_once('../Repository/Product_Registration_Repository.php');
          require_once('../Repository/db_config.php');
          $myself = new Product_Registration_Repository(DB_USER, DB_PASS);
          $myself->login();
          $genre = $myself->genre();
          foreach ($genre as $value) {
            print("<option value='$value[id]'>$value[name]</option>");
          }
          ?>
        </select>
        <script>
          function ajax(sub_genre){
              $.ajax({
                  type: 'POST',
                  url: 'sub_genre.php',
                  data: sub_genre,
                  dataType: 'json',
                  success: function(msg) {
                    $('select#sub_genre option').remove();
                    $.each(msg,function(index,value){
                      $('#sub_genre').append("<option value='" + value['id'] + "'>" + value['name'] + "</option>");
                    });
                    $('#sub_genre').append("<option value='add'>新規追加</option>");
                  }
                });
              }

          $(function() {
            //一つ目のジャンル選択後button有効化
            $('#genre').change(function(){
              // $("#plusbutton").prop("disabled",false);
              $(".new_genre").hide().val("");
            });

            $('#sub_genre').change(function(){  
              if($(this).val() == "add"){
                $('.new_genre').show();
              }else{
                $('.new_genre').hide();
              }
            });

            $('#genre').change(function() {
              sub_genre = {'sub_id': $('#genre').val()};
              ajax(sub_genre);
            });
          });
        </script>
        <select name="sub_genre" id="sub_genre" class="sub_genre">
          <?php
            $genre = $myself->sub_genre(1);
            foreach ($genre as $value) {
              print("<option value='$value[id]'>$value[name]</option>");
            }
          ?>
            <option value='add'>新規追加</option>
        </select>
        <input type="text" class="new_genre" name="new_genre" placeholder="新規登録してください" hidden>
        <br>
      </div>
      価格:<input type="text" name="price" required><br>
      引用:<input type="text" name="url"><br>
      PDF:<input type="file" name="pdf" accept=".pdf" required>
      画像:<input type="file" name="image" accept="image/*" required>
      <input type="submit" name="submit" value="Upload"/>
    </form>
  </div>
</body>
</html>
