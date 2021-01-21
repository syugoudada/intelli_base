<?php
if ($_POST['title'] == "") {
  print("<script>history.back();</script>");
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="../js/pagination.min.js"></script>
  <script src="../js/jquery.raty.js"></script>
  <link rel="stylesheet" href="../Css/search.css">
  <link rel="stylesheet" href="../Css/pagination.css">
  <title>intelli_base</title>
</head>

<body>

  <header>

  </header>

  <div class="contents">
    <div class="search">
      <input type="text" id="search_bar" name="title" placeholder="検索">
      <input type="submit" id="submit" name="sub" value="🔍">
    </div>
    <div class="search_display">
      <ul style="list-style: none;">
        <div class="product-content">
        </div>
      </ul>
      <div class="pager" id="diary-all-pager" hidden></div>
    </div>
  </div>

  <script>
    $(function() {
      let book_list = [];
      $("#submit").click(function() {
        book_list = [];
        if ($('#search_bar').val() != "") {
          $('.product-part').remove();
          let title = {
            "title": $('#search_bar').val()
          };
          ajax(title);
          $('#diary-all-pager').hide().fadeIn(500);
        }
      });

      <?php if ($_POST['title'] != "") {
        $title = str_replace("\"", "", $_POST['title']);
        $title = str_replace("'", "", $title);
        print("let title = {\"title\":\"$title\"};ajax(title);$('#diary-all-pager').hide().fadeIn(500);");
      } ?>

      function pagenation(book_list) {
        $('#diary-all-pager').pagination({ // diary-all-pagerにページャーを埋め込む
          dataSource: book_list,
          pageSize: 8, // 1ページあたりの表示数
          prevText: '&lt; 前へ',
          nextText: '次へ &gt;',
          // ページがめくられた時に呼ばれる
          callback: function(data, pagination) {
            // dataの中に次に表示すべきデータが入っているので、html要素に変換
            $('.product-content').html(template(data)); // product-contentにコンテンツを埋め込む
          }
        });
      }

      function ajax(title_name) {
        // 非同期通信
        $.ajax({
          type: "POST",
          url: "search_service.php",
          data: title_name,
          dataType: "json",
          success: function(msg) {
            if (msg['id'].length > 0) {
              for (var i = 0; i < msg["id"].length; i++) {
                if (i === 64) {
                  break;
                }
                book_list.push(make_obj(msg, i));
                pagenation(book_list);
              }
            } else {
              book_list.push('<div class="product-part"><div>存在しません</div></div>');
              pagenation(book_list);
            }
          }
        });
      }

      function make_obj(content, index) {
        return ' <div class="product-part"><div class="product_image"><form action="product_detail.php" name="product_submit' + index + '" method="POST"  rel="noopener noreferrer"><a href="#" onclick="document.product_submit' + index + '.submit();"><img src="../uploadedData/thumbnail/book1.jpg" height="200px" width="200px"></a><input type="text" name = book_id hidden value  = "' + content["id"][index] + '"></form></div><div class="description"><div class="title">' + content["title"][index] + '</div><p id="star' + index + '"></p><div class="price">' + content["price"][index] + '円</div><form action="../Cart/Cart_add.php" method="POST"><input type="submit" name="cart" value="Cart"><input type="text" name="book_id" value="' + content["id"][index] + '" hidden></form></div></div>';
        star(content, index);
      }

      function star(content, index) {
        $('#star' + index).raty({
          readOnly: true,
          score: Math.round(content["avg"][index]),
        });
      }

      function template(dataArray) {
        return dataArray.map(function(data) {
          return '<li class="list">' + data + '</li>'
        });
      }
    });
  </script>


  <footer>

  </footer>

</body>

</html>