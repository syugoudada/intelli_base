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
  if (rename(PDF_PATH . $name, PDF_PATH . "pdf$id.pdf")) {
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
  if (rename(IMAGE_PATH . $name, IMAGE_PATH . "image$id.png")) {
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
  $image = (IMAGE_PATH."image$id.png");
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
imagepng($img,IMAGE_PATH."image$id.png");
}

?>