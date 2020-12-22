<?php
/**
 * pdfの登録
 * @param stirng $id
 * @param array $file ['pdf_name'],['pdf_tmp']
 * @return boolean 
 */

function pdf_register(string $id,array $file){
  $name = $file['pdf_name'];
  $tmp_file = $file['pdf_tmp'];
  move_uploaded_file($tmp_file,PDF_PATH.$name);
  if (rename(PDF_PATH . $name, PDF_PATH . "book$id.pdf")) {
    return true;
  } else {
    return false;
  }
}

/**
 * 画像の登録
 * @param stirng $id
 * @param array $file ['image_name'],['image_tmp']
 * @return boolean 
 */

function image_register(string $id,array $file){
  $name = $file['image_name'];
  $tmp_file = $file['image_tmp'];
  move_uploaded_file($tmp_file,IMAGE_PATH.$name);
  if (rename(IMAGE_PATH . $name, IMAGE_PATH . "thumbnail$id.png")) {
    image_extension($id);
    return true;
  } else {
    return false;
  }
}

  /**
 * 画像の拡張子変更
 * @param string $id product_id
 */

function image_extension($id){
  $image = (IMAGE_PATH."thumbnail$id.png");
switch(exif_imagetype($image)){
  case IMAGETYPE_JPEG :
    $img = imagecreatefromjpeg($image);
    break;
  case IMAGETYPE_GIF :
    $img = imagecreatefromgif($image);
    break;
  case IMAGETYPE_PNG :
    $img = imagecreatefrompng($image);
    break;
}
image_resize($img,$id);
}

/**
 * 画像サイズの変更
 * @param $id product_id
 * @param $img 元の画像
 */

function image_resize($img,$id){
  list($width, $height) = getimagesize(IMAGE_PATH."thumbnail$id.png");
  $new_width = 150;
  $new_height = 200;

  //新しい画像のサイズ
  $image_r = imagecreatetruecolor($new_width, $new_height);

  imagecopyresampled($image_r, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

  imagepng($image_r, IMAGE_PATH."thumbnail$id.png");

  //一時領域の画像を削除
  imagedestroy($image_r);
  imagedestroy($img);
}

?>