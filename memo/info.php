<?php

/**
 * 画像の拡張子変更
 * @param string $id product_id
 */

function image_extension($id){
  $image = ("../uploadedData/thumbnail/image$id.png");
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
imagepng($img,"../uploadedData/thumbnail/image9.png");
}


$pecent = 0.5;

list($width,$height) = getimagesize("../uploadedData/thumbnail/image9.png");
$new_width = $width + $pecent;
$new_height = $height + $pecent;

$img = imagecreatefrompng("../uploadedData/thumbnail/image9.png");

$image_r = imagecreatetruecolor($new_width,$new_height);

imagecopyresampled($image_r,$img,0,0,0,0,$new_width,$new_height,$width,$height);

imagepng($image_r,"../uploadedData/thumbnail/image9.png");

