<?php

require_once(CLASSES . 'textile.php');
// SQLITE Active Record class
class Textile_Controller extends Base {
	public $html = '';

    function __construct() {
    }

	function parse($input) {
		$textile = new Textile();
		$this->html = $textile->TextileThis($input);
	}
}
?>