<?php

do {
$res = readline('Continue (Y/n)?');

if(strtolower($res) == 'n') { die('No going there!'); }

}
while ($res == 'Y');


?>
