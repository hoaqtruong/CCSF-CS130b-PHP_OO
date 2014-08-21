<?php // >
/******************************************************************************
 ** $Id: pearl.php,v 1.2 2004/05/11 18:49:55 htruong3 Exp $
 ******************************************************************************/
 ?>
<html><body bgcolor=#000000><tt style='font-family: monospace; font-size: 8px;'>
<?php
//$im = imagecreatefromjpeg('/users/htruong3/public_html/images/example/xce.jpg');
//$im = imagecreatefromjpeg('/home/nubio/xce.jpg');
$im = imagecreatefromjpeg('/users/htruong3/public_html/images/example/thumbs/xce.jpg');

$dx = imagesx($im);
$dy = imagesy($im);
for($y = 0; $y < $dy; $y++) {
	for($x=0; $x < $dx; $x++) {
		$col =imagecolorat($im, $x, $y);
		$rgb = imagecolorsforindex($im, $col);
		printf('<font color=#%02x%02x%02x style="font-size: 7px; font-family: sanserif; line-height: 4px;">@</font>',
		$rgb['red'], $rgb['green'], $rgb['blue']);
	}
	echo "<br>\n";
}
imagedestroy($im);
?>
</tt>
</body></html>

