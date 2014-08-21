<?php // >


 // create a 300*200 image
 $img = imagecreatetruecolor(300, 200);

 // allocate some colors
 //                                  R    G    B
 $white  = imagecolorallocate($img, 255, 255, 255);
 $red    = imagecolorallocate($img, 255, 0, 0);
 $yellow = imagecolorallocate($img, 255, 255, 0);
 $black  = imagecolorallocate($img, 0, 0, 0);

 // draw a black rectangle
 imagefilledrectangle($img, 0, 0, 299, 199, $white);
 //imagefilledrectangle($img, 350, 350, 650, 650, $red);

 // draw a red circle
 // bool imagearc(resource $image,  int $cx, int $cy, int $width, int $height, int $start, int $end, int $color  )
 $cx = 150;
 $cy = 100;
 $width = 150;
 $height = 150;
 $start = 0;
 $end = 359;
 imagesetthickness($img,10);
 imagearc($img, $cx, $cy, $width, $height, $start, $end, $red);

 // prototype: imagefilltoborder(image, start_x, start_y, border_color, fill_color)
 imagefilltoborder($img, 100, 100, $red, $);

 // print a few strings
 imagestring($img, 5, 80,5, "A circular ellipse", $yellow);
 // the date
 $date = date("M j, Y g:i a");
 ImageString($img, 3, 78, 177, "$date", $red);
 ImageRectangle($img, 0, 0, 299,199, $black);
 // output image in the browser
 // header("Content-type: text/html");
 header("Content-type: image/png");
 imagepng($img);

 // free memory
 imagedestroy($img);

 // more code
 ?>
