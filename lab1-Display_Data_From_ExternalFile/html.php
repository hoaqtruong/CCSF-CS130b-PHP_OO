<?php
/**
 *  HTML Class
 *  The HTML class will be an example of the Singleton pattern (p. 97).
 *  This class has a method for each HTML tag. We will implement only a few
 *  to prove how this class will work.
 */

error_reporting(E_ALL);

$html = HTML::getInstance();

class HTML {
    static $html = null;
    static private $instance = null;
	private $doctype = null;
    
    private function __construct() {
    }
    
    static function getInstance() {
        if(is_null(self::$instance)) {
            self::$instance = new HTML();
        }
        return self::$instance;
    }
    
    function html($data) {
        return self::$html.'<html>'.$data.'</html>';
    }
    function render($title=null,$data=null) {
        return self::$html.$this->doctype . 
          $this->html($this->head($title) . 
          $this->body(self::$html . $data));
    }
    function head($title = 'Test Class') {
        return self::$html.'<head><title>'.$title.'</title></head>';
    }

    function body($data) {
        return self::$html.'<body>'.$data.'</body>';
    }
    function h1($id, $data) {
        return self::$html.'<h1 id="'. $id.'" >'.$data.'</h1>';
    }
	function setdoctype($dtype) {
		switch ($dtype) {
			case 'html4transitional':
				 $this->doctype = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
			         "http://www.w3.org/TR/html4/loose.dtd">';
					break;
			case 'html4strict':
				$this->doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
				   "http://www.w3.org/TR/html4/strict.dtd">';
					break;
			case 'xhtml1strict':
				$this->doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
					break;			
			case 'xhtml1transitional':
				$this->doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
					"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
		}		
	}

    function table($data) {
        return self::$html.'<table>'.$data.'</table>';
    }
    function tr($data) {
        return self::$html.'<tr>'.$data.'</tr>';
    }
    function td($data) {
        return self::$html.'<td>'.$data.'</td>';
    }

	function div($id = null, $data=null) {
        return self::$html.'<div id="'.$id .'" >'.$data.'</div>';
    }
	function span($data) {
        return self::$html.'<span>'.$data.'</span>';
    }
	function p($data) {
        return self::$html.'<p>'.$data.'</p>';
    }
	function ul($data) {
        return self::$html.'<ul>'.$data.'</ul>';
    }
	function ol($data) {
        return self::$html.'<ol>'.$data.'</ol>';
    }

	function li($data) {
        return self::$html.'<li>'.$data.'</li>';
    }

	function li_set($data) {
		$list = "";
		for ($i = 0; $i < count($data); $i++) {
			$list .= '<li>'.$data[$i].'</li>';
		}	
        return self::$html.$list;
    }
	function br() {	
        return self::$html.'<br />';
    }
	function hr() {	
        return self::$html.'<hr />';
    }
	function blockquote($data) {	
        return self::$html.'<blockquote>'.$data.'</blockquote>';
    }
}

$h = HTML::getInstance();
$h->setdoctype('xhtml1strict');
print $h->render("test",
		$h->div("wrapper",
			$h->div("header", $h->h1("title", "Class Test Page" . $h->hr()))  .
			$h->div("content", $h->p("Content of the page". $h->ul( $h->li("item1") . $h->li("item2") . $h->li("item3") )
			
			)) .
			$h->div("footer", $h->p("footer of the page")) 
		)

        )
;
