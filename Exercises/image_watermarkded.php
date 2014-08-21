<?php
   $paying_customer = true;
   $images = '/users/dputnam/phplib/images/wallpapers/';

   if($paying_customer) {
      header('Content-type: image/jpeg');
      $img = file_get_contents($images . 'water021.jpg');
      print $img . 'my watermark is secret';
  }
  else {
     print "You have to be a registered user to view that image.";
  }
?>
