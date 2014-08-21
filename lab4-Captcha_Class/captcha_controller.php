<?php

require_once(CLASSES . 'captcha.php');

class captchaController extends ApplicationController {	
    function __construct(Request $request) {	
		$this->r = $request;
	    // ConfigArray
	    $this->CAPTCHA_INIT = array(

	            // string: absolute path (with trailing slash!) to a php-writeable tempfolder which is also accessible via HTTP!
	            'tempfolder'     => '../../images/_tmp/',

	            // string: absolute path (in filesystem, with trailing slash!) to folder which contain your TrueType-Fontfiles.
	            'TTF_folder'     => '../cs130b/app/fonts/',

	            // mixed (array or string): basename(s) of TrueType-Fontfiles, OR the string 'AUTO'. AUTO scanns the TTF_folder for files ending with '.ttf' and include them in an Array.
	            // Attention, the names have to be written casesensitive!
	            //'TTF_RANGE'    => 'NewRoman.ttf',
	            //'TTF_RANGE'    => 'AUTO',
	            //'TTF_RANGE'    => array('actionj.ttf','bboron.ttf','epilog.ttf','fresnel.ttf','lexo.ttf','tetanus.ttf','thisprty.ttf','tomnr.ttf'),
	            'TTF_RANGE'    => 'AUTO',

	            'chars'          => 5,       // integer: number of chars to use for ID
	            'minsize'        => 20,      // integer: minimal size of chars
	            'maxsize'        => 30,      // integer: maximal size of chars
	            'maxrotation'    => 25,      // integer: define the maximal angle for char-rotation, good results are between 0 and 30
	            'use_only_md5'   => FALSE,   // boolean: use chars from 0-9 and A-F, or 0-9 and A-Z

	            'noise'          => TRUE,    // boolean: TRUE = noisy chars | FALSE = grid
	            'websafecolors'  => FALSE,   // boolean
	            'refreshlink'    => TRUE,    // boolean
	            'lang'           => 'en',    // string:  ['en'|'de'|'fr'|'it'|'fi']
	            'maxtry'         => 3,       // integer: [1-9]

	            'badguys_url'    => '/',     // string: URL
	            'secretstring'   => 'A very, very secret string which is used to generate a md5-key!',
	            'secretposition' => 9        // integer: [1-32]
	    );
    }
	
	function yield() {
		$captcha = new hn_captcha($this->CAPTCHA_INIT, FALSE);
	    
	    switch($captcha->validate_submit())
	    {
	        // was submitted and has valid keys
	        case 1:
	            // PUT IN ALL YOUR STUFF HERE //
	                    echo "<p><br>Congratulation. You will get the resource now.";
	                    echo "<br><br><a href=\"index.php?_r=captcha\">New DEMO</a></p>";
	            break;


	        // was submitted with no matching keys, but has not reached the maximum try's
	        case 2:
	            echo $captcha->display_form();
	            break;


	        // was submitted, has bad keys and also reached the maximum try's
	        case 3:
	            //if(!headers_sent() && isset($captcha->badguys_url)) header('location: '.$captcha->badguys_url);
	                    echo "<p><br>Reached the maximum try's of ".$captcha->maxtry." without success!";
	                    echo "<br><br><a href=\"index.php?_r=captcha\">New DEMO</a></p>";
	            break;


	        // was not submitted, first entry
	        default:
	            echo $captcha->display_form();
	            break;

	    }
	}
}
?>