<?php
require_once 'initialize.php';
header('Content-Type: image/png');

// Create the image
$im = imagecreatetruecolor(100, 30);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 399, 29, $grey);

// The text to draw
$text = $Funcs->rnd(['mix' => 5]);
// Replace path by your own font path
$font = '../style/fonts/IRANSans-Medium-web.ttf';

// Add some shadow to the text
imagettftext($im, 20, 6, 11, 21, $white, $font, $text);

// Add the text
imagettftext($im, 20, -6, 10, 20, $black, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);

?>