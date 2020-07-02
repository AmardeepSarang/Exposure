<?php
function image_fix_orientation(&$image, $filename)
{
    $exif = exif_read_data($filename);

    if (!empty($exif['Orientation'])) {
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;

            case 6:
                $image = imagerotate($image, -90, 0);
                break;

            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
    }
}
function watermark($fileName, $user)
{

    $text = "Original image uploaded to Exposure by user: " . $user;
    
    $fontsize = 20;

    // Name the font to be used (note the lack of the .ttf extension)
    $font = $font = dirname(__FILE__) . '/Lato-Bold.ttf';

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    if ($fileActualExt == 'jpg' || $fileActualExt == 'jpeg') {
        $img = imagecreatefromjpeg($fileName);
    } else {
        $img = imagecreatefrompng($fileName);
    }

    image_fix_orientation($img, $fileName);
    // print watermark text
    $color = imagecolorallocate($img, 47, 53, 125);
    //imagestring($img, $fontsize, 10, 10, $text, $color);
    imagettftext($img, $fontsize, 0, 20, 40, $color, $font, $text);

    //header('Content-type: imag/jpg');

    if ($fileActualExt == 'jpg' || $fileActualExt == 'jpeg') {
        imagejpeg($img, $fileName);
    } else {
        imagepng($img, $fileName);
    }
    imagedestroy($img);
}
  //watermark("../images/test_watermark.jpg","iujhi");
