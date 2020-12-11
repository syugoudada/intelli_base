<?php

/**
 * 画像の拡張子変更
 * @param string $id product_id
 */

function image_extension()
{
  $image = ("../uploadedData/thumbnail/book2.jpg");
  switch (exif_imagetype($image)) {
    case IMAGETYPE_JPEG:
      $img = imagecreatefromjpeg($image);
      break;
    case IMAGETYPE_GIF:
      $img = imagecreatefromgif($image);
      break;
    case IMAGETYPE_PNG:
      $img = imagecreatefrompng($image);
      break;
  }
  imagepng($img, "../uploadedData/thumbnail/image9.png");
}

// image_extension();

/**
 * 画像サイズの変更
 * @param $id product_id
 */

function image_resize($id){
  list($width, $height) = getimagesize("../uploadedData/thumbnail/book$id.png");
  $new_width = 200;
  $new_height = 250;
  $img = imagecreatefrompng("../uploadedData/thumbnail/image$id.png");

  //新しい画像のサイズ
  $image_r = imagecreatetruecolor($new_width, $new_height);

  imagecopyresampled($image_r, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

  imagepng($image_r, "../uploadedData/thumbnail/image$id.png");

  //一時領域の画像を削除
  imagedestroy($image_r);
  imagedestroy($img);
}

// list($width, $height) = getimagesize("../uploadedData/thumbnail/image9.png");

// $img = imagecreatefrompng("../uploadedData/thumbnail/image9.png");

// $image_r = imagecreatetruecolor(200, 250);

// imagecopyresampled($image_r, $img, 0, 0, 0, 0, 200, 250, $width, $height);

// imagepng($image_r, "../uploadedData/thumbnail/test.png");

// imagedestroy($image_r);
// imagedestroy($img);


// $pecent = 0.5;

// list($width,$height) = getimagesize("../uploadedData/thumbnail/test.png");
// $new_width = $width / $pecent;
// $new_height = $height / $pecent;

// $img = imagecreatefrompng("../uploadedData/thumbnail/test.png");

// $image_r = imagecreatetruecolor($new_width,$new_height);

// imagecopyresampled($image_r,$img,0,0,0,0,$new_width,$new_height,$width,$height);

// imagepng($image_r,"../uploadedData/thumbnail/test.png");
