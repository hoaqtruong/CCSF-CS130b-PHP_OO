<?php
error_reporting(E_ALL);

class Registry {
	
   static $var = null;
   static $obj = null;

   private function __construct() {}
	
	static function set($var, $obj) {
		self::$var = $obj;	
	}
	
	static function get($var) {
		return self::$var;	
	}
	
}

Registry::set('_SERVER', $_SERVER);
$s = Registry::get('_SERVER');
print $s['HTTP_USER_AGENT'];

