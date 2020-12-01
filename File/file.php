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
    return true;
  } else {
    return false;
  }
}
?>