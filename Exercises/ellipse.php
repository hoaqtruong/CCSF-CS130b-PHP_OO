<?php //>
$ht = 600;
$wd = 600;
if(!$im = imageCreatetruecolor($wd,$ht)) $im = imageCreate($wd,$ht);

// first color become the background color
$white = imageColorAllocate($im, 0xff, 0xff, 0xff);
$black = imageColorAllocate($im, 0x00, 0x00, 0x00);
$red   = imageColorAllocate($im, 0xff, 0x00, 0x00);
$blue  = imageColorAllocate($im, 0x00, 0x00, 0xff);
$green = imageColorAllocate($im, 0x00, 0xff, 0x00);
$lx = 0;
 $ly = 0;
 $bx =$wd;
 $by =$ht;

 $blue = 255;
 $red = 0;
 $green = 128;
 $tmp_ht = $ht;
 $tmp_wd = $wd;
 while($count < 600)
 {
 	$count += 1;
	$blue -= 1;
	if($blue < 0) $blue = 255;
	$red += 2;
	if($red > 255) $red = 0;
	$green += 2;
	if($green > 255) $green = 0;
	$blue = $blue;
	$red = $red;
	$green = $green;
    $rand = imagecolorallocate($im, $red, $green, $blue);
    imagefilledrectangle($im, 0       , 0       , --$bx, --$by, $rand );
 }

	if(isset($_REQUEST['T_W']) && !empty($_REQUEST['T_W']))
    	define('thumbnailWidth', $_REQUEST['T_W']);
	else
    	define('thumbnailWidth', 240);

    $filename = '/users/dputnam/public_html/images/example/xce.jpg';
    $source = imagecreatefromjpeg($filename);
    $thumbX = thumbnailWidth;
    $imageX = imagesx($source);
    $imageY = imagesy($source);
    $thumbY = (int)(($thumbX*$imageY) / $imageX );
    imagecopyresized($im, $source, 180,180, 0,0, $thumbX, $thumbY,
    $imageX/2, $imageY/2);
	header('Content-type: image/png');
	ImagePNG($im);
    exit;
?>

<?php

/**
 **  Version:      $Revision: 1.3 $
 **  CVS Author:   $Author: dputnam $
 **  Last Revised: $Date: 2004/12/17 16:21:39 $
**
**
 // create a blank image
 $image = imagecreate(600, 600);

 // fill the background color
 $bg = imagecolorallocate($image, 0, 0, 0);
 $fg = imagecolorallocate($image, 0, 0, 255);

 // choose a color for the ellipse
 $col_ellipse = imagecolorallocate($image, 255, 255, 255);

 // draw the ellipse
 imageellipse($image, 300, 300, 300, 300, $col_ellipse);
 imagefilltoborder($image, 100,100, $col_ellipse, $fg);

 // output the picture
 header("Content-type: image/png");
 imagepng($image);
 */
 ?>
