<?php

   function titlecase($str) 
   {
      return ucwords($str);
   }

   function humanize($str) 
   {
      return ucwords(str_replace('_', ' ',$str));
   }

function h($string)
{
  echo htmlentities(stripslashes($string));
}

function pre($sString = null) {
  print '<pre>';
  print $sString;
  print '</pre>';
}

function hr() {
  if(isset($_SERVER) && !empty($_SERVER)) {
    print '<br />';
  }
  else {
    print '----------------------------------------------------';
  }
  print "\n";
}

function br() {
  if(isset($_SERVER)) {
    print '<br />';
  }
  print "\n";
}

function gc($s) {
	if (!isset($_COOKIE)) {
		global $_COOKIE;
		 $_COOKIE = $GLOBALS['HTTP_COOKIE_VARS'];
	}
	if (isset($_COOKIE[$s]))return $_COOKIE[$s];
}
