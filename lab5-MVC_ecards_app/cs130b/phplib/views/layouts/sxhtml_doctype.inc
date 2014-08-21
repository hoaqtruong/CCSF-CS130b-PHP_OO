<?php
if(isset($stylesheet)) {
    $css_stylesheet = $stylesheet;
}
else {
    $css_stylesheet = '/~dputnam/stylesheets/130a.css';
}

if(isset($title)) {
    $doc_title = $title;
}
else {
    $doc_title = 'CS 130A --- CCSF';
}
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title><?php echo $doc_title ?></title>
        <meta http-equiv="content-type"
              content="text/html;charset=utf-8" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $css_stylesheet;?>" />
    </head>
