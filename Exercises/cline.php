<?php
function read() {
    $input= readline('The file exists Y/n?');;
    return str_replace("n", "", $input);
}

read();

?>
