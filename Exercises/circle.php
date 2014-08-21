<?php

// create a 200*200 image
$img = imagecreatetruecolor(600, 600);
imagesetthickness($img,15);

// allocate some colors
$white = imagecolorallocate($img, 255, 255, 255);
$red   = imagecolorallocate($img, 255,   0,   0);
$green = imagecolorallocate($img,   0, 255,   0);
$blue  = imagecolorallocate($img,   0,   0, 255);

// draw the head
imagearc($img, 300, 300, 500, 500,  0, 359, $white);
// mouth
imagearc($img, 300, 300, 350, 350, 25, 155, $red);
// left and then the right eye
imagearc($img,  220,  255,  80,  80,  0, 359, $green);
imagearc($img, 380,  255,  80,  80,  0, 359, $blue);

// output image in the browser
header("Content-type: image/png");
imagepng($img);

// free memory
imagedestroy($img);

?>

