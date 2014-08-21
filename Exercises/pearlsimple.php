<?php //>

$filename = '/users/htruong3/public_html/images/example/xce.jpg';
$text = 'Your Favorite Stars In Action'; 

$ht = 600;
$wd = 600;
$font_size = 24;
$thumbnail_width = 100;

if(isset($_REQUEST))
{
    if (!empty($_REQUEST['T_W'])) {$thumbnail_width = $_REQUEST['T_W'];}
    if (!empty($_REQUEST['F_S'])) {$font_size = $_REQUEST['F_S'];}
    if (!empty($_REQUEST['HT'])) {$ht = $_REQUEST['HT'];}
    if (!empty($_REQUEST['WD'])) {$wd = $_REQUEST['WD'];}
    if (!empty($_REQUEST['TEXT'])) {$text = stripslashes($_REQUEST['TEXT']);}
}


$im = imageCreatetruecolor($wd,$ht);
//$bgcolor   = imagecolorallocate($im, 120, 140, 90);
$bgcolor   = imagecolorallocate($im, 0x88, 0x88, 0xff);
$textcolor = imagecolorallocate($im, 230, 240, 210);
$shadowcolor = imagecolorallocate($im, 63, 63, 63);
imagefill($im, 0,0, $bgcolor);

$fontfile = '/users/htruong3/public_html/php/gd/imagestuff/fonts/vinque.ttf';

$source = imagecreatefromjpeg($filename);
$thumbX = $thumbnail_width;
$imageX = imagesx($source);
$imageY = imagesy($source);
$thumbY = (int)(($thumbX*$imageY) / $imageX );

$pointx = ($wd - $thumbX) / 2;
$pointy = ($ht - $thumbY) / 2;

$box = @ImageTTFBBox($font_size,0,$fontfile,$text) ;

$xcoord = ($wd - ($box[2] - $box[0])) / 2;

imagecopyresized($im, $source, $pointx, $pointy, 0,0, $thumbX, $thumbY, $imageX, $imageY);

// print shadow
ImageTTFText($im,
    $font_size,     // size
    0,              // angle
    $xcoord +3,     // x coord
    ($ht -10) + 3,  // y coord
    $shadowcolor,   // text color
    $fontfile,      // font file on system
    $text) ;        // the text


ImageTTFText($im,
    $font_size,     // size
    0,              // angle
    $xcoord,        // x coord
    $ht - 10,       // y coord
    $textcolor,     // text color
    $fontfile,      // font file on system
    $text) ;        // the text


header('Content-type: image/png');
ImagePNG($im);
exit;
?>
