<?php
   $out = parse_ini_file('names.txt');
   foreach($out as $a) {
      var_dump($a);
   }
