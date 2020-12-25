<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>内容変更</title>
</head>

<body>
  <header>

  </header>

  <main>
    <div class="contents">
      <form method="POST" enctype="multipart/form-data" action="book_change_service.php">
        タイトル:<input type="text" name="title" id="id" required>
        <div class="register" hidden>
          著者名:<input type="text" name="name" required class="name"><br>
          説明:<textarea style="resize:none" name="description" class="description"></textarea>
          前ジャンル<input type="text" class="before_genre"><input type="text" class="before_subgenre">
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
            function ajax(sub_genre) {
              $.ajax({
                type: 'POST',
                url: '../Product_Register/sub_genre.php',
                data: sub_genre,
                dataType: 'json',
                success: function(msg) {
                  $('select#sub_genre option').remove();
                  $.each(msg, function(index, value) {
                    $('#sub_genre').append("<option value='" + value['id'] + "'>" + value['name'] + "</option>");
                  });
                  $('#sub_genre').append("<option value='add'>新規追加</option>");
                }
              });
            }

            $(function() {
              $('#id').change(function() {
                if ($('#id').val() == "") {
                  $('.register').hide();
                } else {
                  let title = {
                    "title": $('#id').val()
                  };
                  $.ajax({
                    type: 'POST',
                    url: 'book_data.php',
                    data: title,
                    dataType: 'json',
                    success: function(book_info) {
                      switch (book_info['message']) {
                        case 'success':
                          $('.uploadedData').remove();
                          $('.register').fadeIn();
                          $('.before_genre').val(book_info['genre']);
                          $('.before_subgenre').val(book_info['sub_genre']);
                          $('.url').val(book_info['url']);
                          $('.contents').append("<div class='uploadedData'><iframe src='../uploadedData/book/pdf" + book_info['id'] + ".pdf#zoom=30' width='300px' height='300px'></iframe><img src='../uploadedData/thumbnail/thumbnail" + book_info['id'] + ".png'></div>");
                          $('.name').val(book_info['name']);
                          $('.price').val(book_info['price']);
                          $('.description').val(book_info['description']);
                          break;
                        default:
                          $('.register').fadeOut();
                          $('.uploadedData').remove();
                      }
                    }
                  });
                }
              })

              //一つ目のジャンル選択後button有効化
              $('#genre').change(function() {
                $(".new_genre").hide().val("");
              });

              $('#sub_genre').change(function() {
                if ($(this).val() == "add") {
                  $('.new_genre').show();
                } else {
                  $('.new_genre').hide();
                }
              });

              $('#genre').change(function() {
                sub_genre = {
                  'sub_id': $('#genre').val()
                };
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
          価格:<input type="text" name="price" required class="price">円<br>
          引用:<input type="text" name="url" class="url"><br>
          PDF:<input type="file" name="pdf" accept=".pdf" class="pdf" required>
          画像:<input type="file" name="image" accept="image/*" class="image" required>
          <input type="submit" name="submit" value="Upload" />
        </div>
      </form>
    </div>
  </main>

  <footer>

  </footer>
</body>

</html>