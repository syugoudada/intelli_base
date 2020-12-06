<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="../js/jquery.raty.js"></script>
  <link rel="stylesheet" href="../Css/search_bar.css">
  <title></title>
</head>

<body>
  <div class="contents">
    <div class="search_bar_content">
      <input type="text" id="search_bar" placeholder="入力してください">
      <input type="submit" id="submit" name="submit" value="ボタン">
    </div>
    <div class="search_display">
      <div id="product_content">
      </div>
    </div>
  </div>
  </div>
  </div>

  <script>
    $(function() {
      $("#submit").click(function() {
        $('.product-part').remove();
        var bar = {
          "title": $('#search_bar').val()
        };
        ajax(bar);
      });

      function ajax(bar) {
        // 非同期通信
        $.ajax({
          type: "POST",
          url: "search_service.php",
          data: bar,
          dataType: "json",
          success: function(msg) {
            if (msg['id'].length > 0) {
              for (var i = 0; i < msg["id"].length; i++) {
                make_obj(msg, i);
              }
            } else {
              $('#product_content').append('<div class="product-part"><div>存在しません</div></div>');
            }
            console.log(msg);
          }
        });
      }


      function make_obj(content, index) {
        $('#product_content').append(' <div class="product-part"><div class="product_image"><form action="product_detail.php" name="product_submit' + index + '" method="POST"><a href="#" onclick="document.product_submit' + index + '.submit();"><img src="../uploadedData/thumbnail/book1.jpg" height="200px" width="200px"></a><input type="text" name = product_id hidden value  = "' + content["id"][index] + '"></form></div><div class="description"><div class="title">' + content["name"][index] + '</div><p id="star' + index + '"></p><div class="price">' + content["price"][index] + '円</div><input type="submit" name="cart" value="Cart"></div></div>');
        star(content, index);
      }

      function star(content, index) {
        $('#star' + index).raty({
          readOnly: true,
          score: content["avg"][index]
        });
      }
    });
  </script>
</body>

</html>